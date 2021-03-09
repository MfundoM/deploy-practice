<?php

use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('logs:clear', function () {
    exec('rm -rf ' . storage_path('logs/*.log'));
    $this->info('Logs have been cleared!');
})->purpose('Clear your Laravel logs');


Artisan::command('redis:flush', function () {
    exec('redis-cli flushall');
    $this->info('Redis data flushed!');
})->purpose('Flush all Redis data');


Artisan::command('ide', function () {
    Artisan::call('ide-helper:generate --no-interaction --quiet');
    Artisan::call('ide-helper:meta --no-interaction --quiet');
    Artisan::call('ide-helper:models --no-interaction --quiet');
    $this->comment('IDE helper files generated!');
});


Artisan::command('flush', function () {
    if ($this->confirm('Migrate fresh and seed?')) {
        Artisan::call('migrate:fresh --seed');
        $this->info('Migrated fresh and seeded!');
    }

    Artisan::call('redis:flush');
    $this->info('Flushed Redis!');

    Artisan::call('logs:clear');
    $this->info('Flushed logs!');

    Artisan::call('optimize:clear');
    $this->info('Flushed optimization!');
})->purpose('Flush Redis, Logs and clear optimization');


Artisan::command('make:user', function () {
    $first_name = $this->ask('First Name');
    $last_name = $this->ask('Last Name');
    $email = $this->ask('Email Address');
    $password = $this->secret('Password');
    $password = \Illuminate\Support\Facades\Hash::make($password);

    $user = \App\Models\User::create(compact('first_name', 'last_name', 'email', 'password'));

    $this->comment(json_encode($user->makeVisible(['api_token']), 128));
});


Artisan::command('make:admin', function () {
    $first_name = $this->ask('First Name');
    $last_name = $this->ask('Last Name');
    $email = $this->ask('Email Address');
    $password = $this->secret('Password');
    $password = \Illuminate\Support\Facades\Hash::make($password);

    $admin = \App\Models\Admin::create(compact('first_name', 'last_name', 'email', 'password'));

    $this->comment(json_encode($admin, 128));
});
