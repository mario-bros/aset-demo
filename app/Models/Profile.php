<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $table = 'user_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name'
        , 'last_name'
        , 'phone_number'
        , 'picture'
        , 'id_user'
        , 'access_data'
    ];

    protected $casts = [
        'access_data' => "array"
    ];

    // Relationships
    /*public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_roles', 'id_role', 'id_user');
    }*/
}