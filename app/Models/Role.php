<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ROLE_ADMIN = 1;
    const ROLE_SINODE = 2;
    const ROLE_MUPEL = 3;
    const ROLE_JEMAAT = 4;

    public static $accessDataTypes = [
        self::ROLE_ADMIN => "admin",
        self::ROLE_SINODE => "sinode",
        self::ROLE_MUPEL => "mupel",
        self::ROLE_JEMAAT => "jemaat"
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    // Relationships
    public function users()
    {
        return $this->belongsToMany('App\Models\User', /* table name */ 'user_roles', 'id_role', 'id_user');
    }
}