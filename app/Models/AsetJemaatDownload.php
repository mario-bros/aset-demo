<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AsetJemaatDownload extends Model
{
    const GET_QUERY_COUNT = 0;
    const GET_QUERY_PAGINATED = 1;
    const GET_QUERY_RESULTS = 2;
    const TO_SQL = 3;

    var $queryResultMethodNames = ['count', 'simplePaginate', 'get', 'toSql'];

    protected $table = 'aset_jemaat';

    public function jemaat()
    {
        return $this->belongsTo('App\Models\JemaatInduk', 'id_jemaat_induk');
    }

    public function userCreatedBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function userUpdatedBy()
    {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }

    public function scopeSemuaAset($query, $getResType = self::GET_QUERY_COUNT, $criteria = [])
    {
        # udah bener
        $query->select('aset_jemaat.kode_aset'
                        , 'aset_jemaat.no_urut_aset'
                        , 'aset_jemaat.jenis_asset'
                        , 'aset_jemaat.alamat_persil_desa_kelurahan'
                        , 'aset_jemaat.kecamatan_persil'
                        , 'aset_jemaat.kabupaten_persil'
                        , 'aset_jemaat.propinsi_persil'
                        , 'aset_jemaat.tanggal_terbit_surat_ukur'
                        , 'aset_jemaat.no_surat_ukur'
                        , 'aset_jemaat.luas_tanah'
                        , 'aset_jemaat.status_kepemilikan'
                        , 'aset_jemaat.tgl_pengeluaran_sertifikat_surat'
                        , 'aset_jemaat.atas_nama'
                        , 'aset_jemaat.asal'
                        , 'aset_jemaat.masa_berlaku'
                        , 'aset_jemaat.masa_berlaku_hgb'
                        , 'aset_jemaat.nama_bangunan'
                        , 'aset_jemaat.luas_bangunan'
                        , 'aset_jemaat.no_tgl_penerbitan_imb'
                        , 'aset_jemaat.njop'
                        , 'aset_jemaat.status_kelola'
                        , 'aset_jemaat.keberadaan_dokumen'
                        , 'aset_jemaat.keterangan'); 
        $this->_joinTableForAggregate($query);

        if ( !empty($criteria)) {
            foreach ($criteria as $k => $v) {
                $query = $query->where($k, $v);
            }
        }

        $query = $query->whereRaw('LOWER(aset_jemaat.atas_nama) != ?', ['x'] );

        $queryResultMethodNames = $this->queryResultMethodNames[$getResType];
        return $query->$queryResultMethodNames();
    }

    private function _joinTableForAggregate(&$query)
    {
        $query->join('jemaat_induk', function($join)
        {
            $join->on('aset_jemaat.id_jemaat_induk', '=', 'jemaat_induk.id');
            $join->on('aset_jemaat.kode_aset', 'NOT LIKE', DB::raw("'%-00'"));
        });    
        $query->leftJoin('mupel', 'jemaat_induk.id_mupel', '=','mupel.id');
    }
}