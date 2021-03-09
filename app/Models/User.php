<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'avatar',
        'subscribed',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array $hidden
     */
    protected $hidden = [
        'email_verified_at',
        'password',
        'remember_token',
        'api_token',
    ];

    /**
     * The model's default attributes.
     *
     * @var array $attributes
     */
    protected $attributes = [
        'subscribed' => true,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'subscribed'        => 'boolean',
        'email_verified_at' => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];

    /**
     * Get User's full name.
     *
     * @return string
     */
    public function getNameAttribute() : string
    {
        if ($this->last_name) {
            return sprintf('%s %s', $this->first_name, $this->last_name);
        }

        return $this->first_name;
    }

    /**
     * Check admin status.
     *
     * @return bool
     */
    public function isAdmin() : bool
    {
        return false;
    }

    /**
     * Check super admin status.
     *
     * @return bool
     */
    public function isSuperAdmin() : bool
    {
        return false;
    }

    /**
     * Redirect to dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dashboardRedirect()
    {
        return redirect()->route('user.dashboard');
    }

    /**
     * Gravatar image source.
     *
     * @param int $size
     * @param bool $check
     * @return string
     */
    public function gravatar(int $size = 256, bool $check = true) : string
    {
        return \App\Helpers\Gravatar::get($this->email, $size, $check);
    }

    /**
     * Get URL string for user to unsubscribe from emails.
     *
     * @return string
     */
    public function linkUnsubscribe() : string
    {
        $key = sprintf('user.email.unsubscribe.%d', $this->id);

        return Cache::rememberForever($key, function () {
            return URL::signedRoute('emails.subscription.unsubscribe', ['user' => $this->id]);
        });
    }

    /**
     * Get URL string for user to subscribe to emails.
     *
     * @return string
     */
    public function linkSubscribe() : string
    {
        $key = sprintf('user.email.subscribe.%d', $this->id);

        return Cache::rememberForever($key, function () {
            return URL::signedRoute('emails.subscription.subscribe', ['user' => $this->id]);
        });
    }
}
