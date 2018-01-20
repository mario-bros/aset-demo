<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mupel extends Model
{

    use SoftDeletes;
    protected $table = 'mupel';

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama'
    ];

    // Relationships
    public function assets()
    {
        return $this->hasMany('App\Models\AsetJemaat', 'id_mupel');
    }

    public function jemaat()
    {
        return $this->hasMany('App\Models\JemaatInduk', 'id_mupel');
    }

    public function scopeFilterByRole($query, $userAccessData)
    {
        $query->select('mupel.*');

        foreach ($userAccessData as $roleScope => $entity) {

            if ( $roleScope == "mupel" ) {
                $query->where('mupel.id', $entity);
            }
        }

        return $query;
    }

}