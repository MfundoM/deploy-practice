<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProjectInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string $signature
     */
    protected $signature = 'project:install';

    /**
     * The console command description.
     *
     * @var string $description
     */
    protected $description = 'Configure project and run programs';

    /**
     * @var bool $db_set_up
     */
    private $db_set_up = false;

    /**
     * If this script is being tested.
     *
     * @var bool $testing
     */
    private $testing = false;

    /**
     * Config values.
     *
     * @var object $config
     */
    private $config = [
        'git_repo'     => null,
        'app_name'     => null,
        'app_url'      => null,
        'app_key'      => null,
        'db_database'  => null,
        'db_username'  => null,
        'db_password'  => null,
        'redis_predix' => null,
    ];

    /**
     * Project values.
     *
     * @var array $project
     */
    private $project;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->config = (object) $this->config;
        $this->project = $this->projectVars();

        parent::__construct();
    }

    /**
     * Whether the command should be publicly shown or not.
     *
     * @return bool
     */
    public function isHidden()
    {
        return !App::isLocal();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->setup();

        $this->askRepositoryQuestions();
        $this->askApplicationQuestions();
        $this->askDatabaseQuestions();

        if ($this->db_set_up) {
            $this->askAdminQuestions();
            $this->askUserQuestions();
        }

        $this->cleanup();
    }

    /**
     * Do initial setup.
     */
    private function setup()
    {
        if (env('APP_NAME', false)) {
            if (!App::isLocal()) {
                $this->showError('Can not run this command in a non-local environment!');
            }

            if (!$this->confirm('Project already has .env file, would you like to restart the installation?')) {
                $this->showError('Project setup has been cancelled!');
            }
        }

        copy('.env.example', '.env');

        $key = shell_exec('php artisan key:generate --show');

        $this->config->app_key = str_replace("\n", '', $key);
    }

    /**
     * Ask repository questions.
     */
    private function askRepositoryQuestions()
    {
        $this->alert('Repository Questions:');

        $this->config->git_repo = $this->ask('Git Repository URL?', 'git@github.com:username/repo.git');

        if (!$this->testing) {
            $this->cmd('rm -rf .git');
            $this->cmd('git init');
            $this->cmd(sprintf('git remote add origin %s', $this->config->git_repo));
        }
    }

    /**
     * Ask application questions.
     */
    private function askApplicationQuestions()
    {
        $this->alert('Application Questions:');

        $this->config->app_name = $this->ask('Application name?', $this->project['title']);
        $this->config->app_url = $this->ask('Application URL? (eg. example.local)', $this->project['url']);

        $this->updateEnv();
    }

    /**
     * Ask database questions.
     */
    private function askDatabaseQuestions()
    {
        $this->alert('Database Questions:');

        $this->config->db_username = $this->ask('Current database username?', 'root');
        $this->config->db_password = $this->secret('Current database password?');

        while (!$this->databasePassword()) {
            $this->error('Incorrect password, please try again!');
            $this->config->db_username = $this->ask('Current database username?', 'root');
            $this->config->db_password = $this->secret('Current database password?');
        }

        if ($this->confirm('Create new database?', true)) {
            $database = $this->ask('New database name?', $this->project['database']);
            $this->config->db_database = Str::slug($database, '_');
            $this->config->redis_predix = Str::slug($database, '_');
            $this->db_set_up = $this->createDatabase();

        } else {
            $this->config->db_database = $this->ask('Existing database name? (NOTE: This will drop the database if it exists!)', $this->project['database']);

            while (!$this->databaseExists()) {
                if ($this->confirm('Database doesn\'t exist. Create new database?', true)) {
                    $this->config->db_database = $this->ask('New database name?', $this->project['database']);
                    $this->db_set_up = $this->createDatabase();

                } else {
                    $this->config->db_database = $this->ask('Existing database name?', $this->project['database']);
                }
            }

            $this->config->redis_predix = Str::slug($this->config->db_database, '_');
            $this->db_set_up = true;
        }

        if ($this->db_set_up) {
            $this->updateEnv();
            $this->migrateAndSeed();
        }
    }

    /**
     * Ask Admin questions.
     */
    private function askAdminQuestions()
    {
        if (class_exists(\App\Models\Admin::class)) {
            $this->alert('Create new admin:');

            if ($this->confirm('Create a new Admin user?')) {
                $first_name = $this->ask('Admin first name?');
                $last_name = $this->ask('Admin last name?');
                $email = $this->ask('Admin email?');
                $password = $this->secret('Admin password?');
                $password = Hash::make($password);

                $admin = \App\Models\Admin::create(compact('first_name', 'last_name', 'email', 'password'));
                $this->comment(json_encode($admin->makeVisible(['api_token']), 128));
            }
        }
    }

    /**
     * Ask User questions.
     */
    private function askUserQuestions()
    {
        if (class_exists(\App\Models\User::class)) {
            $this->alert('Create new user:');

            if ($this->confirm('Create a new User?')) {
                $first_name = $this->ask('User first name?');
                $last_name = $this->ask('User last name?');
                $email = $this->ask('User email?');
                $password = $this->secret('User password?');
                $password = Hash::make($password);

                $user = \App\Models\User::create(compact('first_name', 'last_name', 'email', 'password'));
                $this->comment(json_encode($user->makeVisible(['api_token']), 128));

                $user->forceFill(['email_verified_at' => now()->toDateTimeString()]);
            }
        }
    }

    /**
     * Check if database exists.
     *
     * @return bool
     */
    private function databasePassword()
    {
        $cmd = sprintf(
            'mysql -u \'%s\' -p\'%s\' -e "SELECT USER(),CURRENT_USER();"',
            $this->config->db_username, $this->config->db_password
        );

        $status_code = 1; // 0 = no error

        $this->cmd($cmd, true, $status_code);

        return $status_code === 0;
    }

    /**
     * Check if database exists.
     *
     * @return bool
     */
    private function databaseExists()
    {
        $cmd = sprintf(
            'mysql -u \'%s\' -p\'%s\' -e "USE %s;"',
            $this->config->db_username, $this->config->db_password, $this->config->db_database
        );

        $status_code = 1; // 0 = no error

        $this->cmd($cmd, true, $status_code);

        return $status_code === 0;
    }

    /**
     * Create a new database.
     *
     * @return bool
     */
    private function createDatabase()
    {
        $cmd = sprintf(
            'mysql -u \'%s\' -p\'%s\' -e "CREATE DATABASE IF NOT EXISTS %s DEFAULT CHARACTER SET = \'utf8mb4\';"',
            $this->config->db_username, $this->config->db_password, $this->config->db_database
        );

        $status_code = 1; // 0 = no error

        $this->cmd($cmd, true, $status_code);

        return (bool) $status_code ? $this->showError('Error creating database! Incorrect credentials or database exists..', false) : true;
    }

    /**
     * Migrate and seed the database.
     */
    private function migrateAndSeed()
    {
        Artisan::call('config:cache');
        Artisan::call('migrate:fresh --seed --force');
        Artisan::call('config:clear');
    }

    /**
     * Update .env with vars.
     *
     * @return void
     */
    private function updateEnv()
    {
        foreach (['.env', '.env.example', '.env.staging', '.env.production'] as $env) {
            $stub = file_get_contents($env . '.stub');

            foreach ($this->config as $key => $value) {
                $stub = str_replace(sprintf('{{%s}}', $key), $value, $stub);
            }

            file_put_contents($env, $stub);
        }
    }

    /**
     * Get project variables.
     *
     * @return array
     */
    private function projectVars() : array
    {
        $folder = Arr::last(explode('/', base_path()));
        $slug = Str::slug($folder, '-');
        $title = ucwords(implode(' ', explode('-', $slug)));
        $database = Str::slug($folder, '_');
        $url = sprintf('%s.local', $slug);

        return compact('folder', 'slug', 'title', 'database', 'url');
    }

    /**
     * Delete files and create initial commit.
     */
    private function cleanup()
    {
        if (!$this->testing) {
            $read_me = file_get_contents('https://raw.githubusercontent.com/laravel/laravel/master/README.md');
            file_put_contents(base_path('README.md'), $read_me);

            $this->cmd('rm -rf app/Console/Commands');
            $this->cmd('rm -rf .*.stub');
            $this->cmd('git add --all');
            $this->cmd('git commit -m "Initial commit"');
        }

        $this->info('Project installation completed!');
    }

    /**
     * CMD Helper.
     *
     * @param string $command
     * @param bool $mute
     * @param null $return_var
     * @return false|string
     */
    private function cmd(string $command, bool $mute = true, &$return_var = null)
    {
        if ($mute) {
            return @system(sprintf('%s > /dev/null 2>&1', $command), $return_var);
        }

        return @system($command, $return_var);
    }

    /**
     * Error helper.
     *
     * @param string $message
     * @param bool $exit
     * @return bool
     */
    private function showError(string $message, bool $exit = true)
    {
        $this->error($message);

        if ($exit) {
            exit(0);
        }

        return false;
    }
}
