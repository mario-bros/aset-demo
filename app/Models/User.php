<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;

    const FIELD_NAME_FILTER = "name";
    const FIELD_EMAIL_FILTER = "email";

    public $randomPass;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'pass_prompt'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['random_password'];

    public function getRandomPasswordAttribute()
    {
        return $this->randomPass;
    }

    // Relationships
    public function profile()
    {
        return $this->hasOne('App\Models\Profile', 'id_user');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', /* table name */ 'user_roles', 'id_user', 'id_role');
    }

    public function scopeSearch($query, $searchKey, $criteria)
    {
        $query->select('users.*');

        if ( !empty($criteria)) {
            foreach ($criteria as $k => $v) {
                $query = $query->where($k, $v);
            }
        }

        $query = $query->where('users.name', 'like', '%' . $searchKey . '%');

        return $query;
    }

}