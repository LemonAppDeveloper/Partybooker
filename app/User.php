<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Helpers\Helper;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at', 'status', 'provider', 'provider_id','country','location','latitude','	longitude','profile_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'users_roles', 'user_id', 'role_id');
    }
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->count();
    }

    public function getCategory()
    {
        $helper = new Helpers\Helper();
        $sql = 'SELECT id_category FROM vendor WHERE id_users = "' . $this->id . '" ';
        $info = $helper->get_data_with_sql($sql);
        if ($info['row_count'] > 0) {
            return $info['data'][0]->id_category;
        } else {
            return null;
        }
    }

    public function getSubCategory()
    {
        $helper = new Helpers\Helper();
        $sql = 'SELECT id_sub_category FROM vendor WHERE id_users = "' . $this->id . '" ';
        $info = $helper->get_data_with_sql($sql);
        if ($info['row_count'] > 0) {
            // Assuming id_sub_category is a comma-separated string
            $subCategoryString = $info['data'][0]->id_sub_category;
            return explode(',', $subCategoryString);
        } else {
            return [];
        }
    }

    public function getDescription()
    {
        $helper = new Helpers\Helper();
        $sql = 'SELECT description FROM vendor WHERE id_users = "' . $this->id . '" ';
        $info = $helper->get_data_with_sql($sql);
        if ($info['row_count'] > 0) {
            return $info['data'][0]->description;
        } else {
            return '';
        }
    }
}
