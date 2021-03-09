<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'role',
        'avatar',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array $hidden
     */
    protected $hidden = [
        'super_admin',
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
        'super_admin' => false,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'super_admin'       => 'boolean',
        'email_verified_at' => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
        'deleted_at'        => 'datetime',
    ];

    /**
     * Get Admin's full name.
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
        return true;
    }

    /**
     * Check super admin status.
     *
     * @return bool
     */
    public function isSuperAdmin() : bool
    {
        return $this->super_admin;
    }

    /**
     * Redirect to dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dashboardRedirect()
    {
        return redirect()->to(config('nova.path') ?? route('admin.dashboard'));
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
}
