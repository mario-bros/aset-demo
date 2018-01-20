<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisAsset extends Model
{

    use SoftDeletes;
    protected $table = 'jenis_asset';

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
        return $this->hasMany('App\Models\AsetJemaat', 'id_jenis_asset');
    }

}