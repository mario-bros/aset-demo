<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JemaatInduk extends Model
{

    use SoftDeletes;

    protected $table = 'jemaat_induk';

    const FIELD_NAMA_MUPEL_FILTER = "nama_mupel";
    const FIELD_NAMA_JEMAAT_FILTER = "nama_jemaat";

    const GET_QUERY_COUNT = 0;
    const GET_QUERY_PAGINATED = 1;
    const GET_QUERY_RESULTS = 2;
    const TO_SQL = 3;

    var $queryResultMethodNames = ['count', 'simplePaginate', 'get', 'toSql'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_mupel', 'email', 'no_telp', 'nama', 'nama_kmj', 'email_kmj', 'no_telp_kmj', 'alamat_desa_kelurahan', 'id_kecamatan', 'id_kabupaten', 'id_propinsi', 
    ];

    // START Relationships
    public function assets()
    {
        return $this->hasMany('App\Models\AsetJemaat', 'id_jemaat');
    }

    public function mupel()
    {
        return $this->belongsTo('App\Models\Mupel', 'id_mupel');
    }
    // END Relationships

    public function scopeSearch($query, $category, $searchKey)
    {
        $query->select('jemaat_induk.*');

        if ($category == self::FIELD_NAMA_MUPEL_FILTER) {

            $query->join('mupel', 'jemaat_induk.id_mupel', '=','mupel.id');
            $query = $query->where('mupel.nama', 'like', '%' . $searchKey . '%');
        } else {

            $query = $query->where('jemaat_induk.nama', 'like', '%' . $searchKey . '%');
        }

        return $query;
    }

    public function scopeFilterByRole($query, $userAccessData, $criteria = [])
    {
        $query->select('jemaat_induk.*');

        foreach ($userAccessData as $roleScope => $entity) {

            if ( $roleScope == "jemaat" ) {
                $query->where('jemaat_induk.id', $entity);
            } elseif ( $roleScope == "mupel" ) {
                $query->join('mupel', 'jemaat_induk.id_mupel', '=','mupel.id')->where('mupel.id', $entity);
            } else {
                $query->join('mupel', 'jemaat_induk.id_mupel', '=','mupel.id');

                if ( !empty($criteria)) {
                    foreach ($criteria as $k => $v) {
                        if ($k != "jemaat_induk.id") $query = $query->where($k, $v);
                    }
                }
            }
        }

        return $query;
    }

    public function scopeJumlahSemuaJemaatIndukMemilikiAset($query, $criteria = [])
    {
        # udah bener
        // $query->distinct()->select('jemaat_induk.id');
        $query->select('jemaat_induk.*');
        $query->join('mupel', 'jemaat_induk.id_mupel', '=', 'mupel.id');
        // $query->join('aset_jemaat', 'aset_jemaat.id_jemaat_induk', '=',  'jemaat_induk.id');

        if ( !empty($criteria)) {
            foreach ($criteria as $k => $v) {
                $query = $query->where($k, $v);
            }
        }

        return $query->get();
        // return $query->toSql();
    }

    public function scopeJemaatYangBelumMenyerahkanAset($query, $getResType = self::GET_QUERY_COUNT, $criteria = [])
    {
        // query yang bener
        // SELECT jemaat_induk.id, jemaat_induk.id_mupel, jemaat_induk.nama, aset_jemaat.id, aset_jemaat.atas_nama 
        // FROM aset.jemaat_induk
        // left join `aset_jemaat` on `jemaat_induk`.`id` = `aset_jemaat`.id_jemaat_induk
        // where aset_jemaat.atas_nama IS NULL
        // ORDER BY jemaat_induk.id;

        $query->select('jemaat_induk.*');
        $query->join('mupel', 'jemaat_induk.id_mupel', '=', 'mupel.id');

        $query->leftJoin('aset_jemaat', 'jemaat_induk.id', '=', 'aset_jemaat.id_jemaat_induk');

        if ( !empty($criteria)) {
            foreach ($criteria as $k => $v) {
                $query = $query->where($k, $v);
            }
        }

        $suffixSign = "-00";
        $query = $query->where('aset_jemaat.kode_aset', 'like',  '%' . $suffixSign);

        $queryResultMethodNames = $this->queryResultMethodNames[$getResType];
        return $query->$queryResultMethodNames();
    }

    public function scopeJemaatYangSudahMenyerahkanAset($query, $getResType = self::GET_QUERY_COUNT, $criteria = [])
    {
        // query yang bener
        // SELECT jemaat_induk.id_mupel, jemaat_induk.id, jemaat_induk.nama
        // FROM aset.jemaat_induk
        // left join `aset_jemaat` on `jemaat_induk`.`id` = `aset_jemaat`.id_jemaat_induk
        // where aset_jemaat.atas_nama IS NOT NULL
        // GROUP BY jemaat_induk.id_mupel, jemaat_induk.id, jemaat_induk.nama
        // ORDER BY jemaat_induk.id;

        $query->select('jemaat_induk.id', 'jemaat_induk.nama', 'mupel.nama as nama_mupel');
        // $query->select('jemaat_induk.id');
        $query->join('mupel', 'jemaat_induk.id_mupel', '=', 'mupel.id');

        $query->leftJoin('aset_jemaat', 'jemaat_induk.id', '=', 'aset_jemaat.id_jemaat_induk');

        if ( !empty($criteria)) {
            foreach ($criteria as $k => $v) {
                $query = $query->where($k, $v);
            }
        }

        // $query = $query->where( function($query) {
        //             $query->whereNotNull('aset_jemaat.atas_nama')
        //                     ->orWhere('aset_jemaat.atas_nama', '!=', '');
        // });

        $suffixSign = "-00";
        $query = $query->where('aset_jemaat.kode_aset', 'not like', '%' . $suffixSign);
        $query = $query->groupBy('jemaat_induk.id', 'jemaat_induk.nama', 'mupel.nama');
        // $query = $query->groupBy('jemaat_induk.id');
        // dd($query);
        // '' OR `aset_jemaat`.`atas_nama` is not null

        $queryResultMethodNames = $this->queryResultMethodNames[$getResType];
        return $query->$queryResultMethodNames();
    }

}