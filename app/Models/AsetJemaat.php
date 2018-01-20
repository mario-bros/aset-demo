<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class AsetJemaat extends Model
{

    use SoftDeletes;

    const GET_QUERY_COUNT = 0;
    const GET_QUERY_PAGINATED = 1;
    const GET_QUERY_RESULTS = 2;
    const TO_SQL = 3;

    var $queryResultMethodNames = ['count', 'simplePaginate', 'get', 'toSql'];

    public static $statusKepemilikanEnums = [
                                        'status_kepemilikan_hm' => "Hak Milik",
                                        'status_kepemilikan_hgb' => "HGB",
                                        'status_kepemilikan_hp' => "Hak Pakai",
                                        'status_kepemilikan_girik' => "Girik",
                                        'status_kepemilikan_lain_lain' => "Lain - lain",
                                    ];

    public static $atasNamaEnums = [
                                        'gpib' => "GPIB",
                                        'gpib_setempat' => "GPIB Setempat",
                                        'pribadi' => "Pribadi",
                                        'bukan_milik_gpib' => "Bukan Milik GPIB",
                                        'tanpa_status_kepemilikan' => "Tanpa Status Kepemilikan",
                                    ];

    protected $table = 'aset_jemaat';

    protected $appends = [
                            'atas_nama_jemaat', 'extracted_atas_nama_jemaat', 
                            'atas_nama_pribadi', 'extracted_atas_nama_pribadi'
                        ];

    
    // public function getMasaBerlakuHgbAttribute()
    // {
    //     $str = $this->status_kepemilikan;
    //     preg_match('/\( (.*?) \)/', $str, $match);
    //     return $match[1];
    // }

    // public function setExtractedMasaBerlakuHgbAttribute($str)
    // {
    //     // dd(explode(' : ', $str));
    //     $content = explode(' : ', $str);
    //     $this->extracted_masa_berlaku_hgb = $content[1];
    // }

    public function getAtasNamaJemaatAttribute()
    {
        $str = $this->atas_nama;
        preg_match('/\( (.*?) \)/', $str, $match);
        return @$match[1];
    }

    public function setExtractedAtasNamaJemaatAttribute($str)
    {
        $content = explode(' : ', $str);
        $this->extracted_atas_nama_jemaat = $content[1];
    }

    public function getAtasNamaPribadiAttribute()
    {
        $str = $this->atas_nama;
        preg_match('/\( (.*?) \)/', $str, $match);
        return $match[1];
    }

    public function setExtractedAtasNamaPribadiAttribute($str)
    {
        $content = explode(' : ', $str);
        $this->extracted_atas_nama_pribadi = $content[1];
    }

    /**
     * 
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_jemaat_induk',
        'kode_aset', 
        'no_urut_aset', 
        'jenis_asset', 
        'alamat_persil_desa_kelurahan', 
        'kecamatan_persil', 
        'kabupaten_persil', 
        'propinsi_persil', 
        'tanggal_terbit_surat_ukur', 
        'no_surat_ukur', 
        'luas_tanah', 
        'status_kepemilikan_hm',
        'status_kepemilikan_hgb',
        'status_kepemilikan_hp', 
        'status_kepemilikan_girik', 
        'status_kepemilikan_lain_lain', 
        'status_kepemilikan',
        'tgl_pengeluaran_sertifikat_surat', 
        'atas_nama', 
        'warna_status_kepemilikan', 
        'asal', 
        'masa_berlaku', 
        'nama_bangunan', 
        'luas_bangunan', 
        'warna_status_pos_pelkes', 
        'no_tgl_penerbitan_imb', 
        'warna_status_kepemilikan_dokumen_imb', 
        'njop',
        'status_kelola',
        'keberadaan_dokumen', 
        'warna_keberadaan_dokumen', 
        'keterangan'
    ];


    public function jemaat()
    {
        //return $this->belongsTo('App\Models\Mupel', 'id_jemaat_induk');
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

    /**
     * Count sum of NJOP.
     *
     * @return decimal
     */
    public function scopeSumOfNJOP($query, $criteria = [])
    {
        $query->select('aset_jemaat.njop');
        $this->_joinTableForAggregate($query);

        if ( !empty($criteria)) {
            foreach ($criteria as $k => $v) {
                $query = $query->where($k, $v);
            }
        }

        $result = $query->get();

        $total = 0;
        foreach ($result as $res) {

            if ( is_numeric($res->njop) && $res->njop > 0 ) {
                $total += $res->njop;
            }
        }

        return number_format($total, 2, ',', '.');
    }

    public function scopePhysicalAssetCount($query, $criteria = [])
    {
        $query->select('aset_jemaat.*');        
        $this->_joinTableForAggregate($query);

        if ( !empty($criteria)) {
            foreach ($criteria as $k => $v) {
                $query = $query->where($k, $v);
            }
        }

        // $query = $query->whereRaw('LOWER(aset_jemaat.atas_nama) != ? AND aset_jemaat.kode_aset NOT LIKE ?', ['x', '-00%'] );
        // $query = $query->whereRaw('aset_jemaat.kode_aset NOT LIKE ?', ['-00%'] );
        
        // dd($query->toSql());
        return $query->count();
        // return $query->toSql();
    }

    public function scopeSemuaAset($query, $getResType = self::GET_QUERY_COUNT, $criteria = [])
    {
        # udah bener
        $query->select('*');
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

    public function scopeBukanMilikGPIB($query, $getResType = self::GET_QUERY_COUNT, $criteria = [])
    {
        # udah bener
        $query->select('aset_jemaat.id', 'aset_jemaat.kode_aset', 'jemaat_induk.nama as nama_jemaat_induk', 'aset_jemaat.nama_bangunan', 'mupel.nama as nama_mupel');
        $this->_joinTableForAggregate($query);

        if ( !empty($criteria)) {
            foreach ($criteria as $k => $v) {
                $query = $query->where($k, $v);
            }
        }

        $queryResultMethodNames = $this->queryResultMethodNames[$getResType];
        $query = $query->where('aset_jemaat.atas_nama', '!=', 'GPIB')
                        ->where('aset_jemaat.atas_nama', '!=', 'X')
                        ->where('aset_jemaat.warna_status_kepemilikan', '000000');
                        /*->where( function($query) {
                            $query->where('aset_jemaat.warna_status_kepemilikan', '7F7F7F')
                                    ->orWhere('aset_jemaat.warna_status_kepemilikan', '000000');
                            
                        });*/
        return $query->$queryResultMethodNames();
    }

    public function scopeAtasNamaPribadi($query, $getResType = self::GET_QUERY_COUNT, $criteria = [])
    {
        # udah bener
        $query->select('aset_jemaat.id', 'aset_jemaat.kode_aset', 'jemaat_induk.nama as nama_jemaat_induk', 'aset_jemaat.nama_bangunan', 'mupel.nama as nama_mupel');
        $this->_joinTableForAggregate($query);

        if ( !empty($criteria)) {
            foreach ($criteria as $k => $v) {
                $query = $query->where($k, $v);
            }
        }

        $queryResultMethodNames = $this->queryResultMethodNames[$getResType];
        $query = $query->where('aset_jemaat.atas_nama', '!=', '')
                        ->where('aset_jemaat.warna_status_kepemilikan', 'FF0000' );
        return $query->$queryResultMethodNames();
    }

    public function scopeAtasNamaGPIBSetempat($query, $getResType = self::GET_QUERY_COUNT, $criteria = [])
    {
        # udah bener
        $query->select('aset_jemaat.id', 'aset_jemaat.kode_aset', 'jemaat_induk.nama as nama_jemaat_induk', 'aset_jemaat.nama_bangunan', 'mupel.nama as nama_mupel');
        $this->_joinTableForAggregate($query);

        if ( !empty($criteria)) {
            foreach ($criteria as $k => $v) {
                $query = $query->where($k, $v);
            }
        }

        $queryResultMethodNames = $this->queryResultMethodNames[$getResType];
        // $query = $query->where('aset_jemaat.atas_nama', 'regexp',"^GPIB")->where('aset_jemaat.warna_status_kepemilikan', 'FFFF00' );
        $query = $query->where('aset_jemaat.warna_status_kepemilikan', 'FFFF00' );
        return $query->$queryResultMethodNames();
    }

    public function scopeAtasNamaGPIB($query, $getResType = self::GET_QUERY_COUNT, $criteria = [])
    {
        # udah bener
        $query->select('aset_jemaat.id', 'aset_jemaat.kode_aset', 'jemaat_induk.nama as nama_jemaat_induk', 'aset_jemaat.nama_bangunan', 'mupel.nama as nama_mupel');
        $this->_joinTableForAggregate($query);

        if ( !empty($criteria)) {
            foreach ($criteria as $k => $v) {
                $query = $query->where($k, $v);
            }
        }

        $queryResultMethodNames = $this->queryResultMethodNames[$getResType];
        // $query = $query->where('aset_jemaat.atas_nama', 'regexp', "GPIB$" )->where('aset_jemaat.warna_status_kepemilikan', 'FFFFFF' );
        $query = $query->where('aset_jemaat.atas_nama', '=', "GPIB" );
        return $query->$queryResultMethodNames();
    }

    public function scopeTanpaStatusKepemilikan($query, $getResType = self::GET_QUERY_COUNT, $criteria = [])
    {
        # udah bener
        $query->select('aset_jemaat.id', 'aset_jemaat.kode_aset', 'jemaat_induk.nama as nama_jemaat_induk', 'aset_jemaat.nama_bangunan', 'mupel.nama as nama_mupel');
        $this->_joinTableForAggregate($query);

        if ( !empty($criteria)) {
            foreach ($criteria as $k => $v) {
                $query = $query->where($k, $v);
            }
        }

        $queryResultMethodNames = $this->queryResultMethodNames[$getResType];

        $query = $query->where('aset_jemaat.warna_status_kepemilikan', '7F7F7F');
        // $query = $query->whereRaw('LOWER(aset_jemaat.atas_nama) = ?', ['x'] );
        return $query->$queryResultMethodNames();
    }

    public function scopeAsetTanpaDokumen($query, $getResType = self::GET_QUERY_COUNT, $criteria = [])
    {
        $query->select('aset_jemaat.*');
        $this->_joinTableForAggregate($query);

        if ( !empty($criteria)) {
            foreach ($criteria as $k => $v) {
                $query = $query->where($k, $v);
            }
        }

        /*$query->whereNotIn('aset_jemaat.warna_status_pos_pelkes', ['00B0F0']);
        $query->whereNotIn('aset_jemaat.warna_status_kepemilikan_dokumen_imb', ['00B050']);*/
        
        //$query->orWhere( DB::raw('LOWER(aset_jemaat.atas_nama)'), 'x' )->where('aset_jemaat.warna_status_kepemilikan', '000000');
        //$query->whereRaw('LOWER(aset_jemaat.atas_nama) = ?', ['x'] )->where('aset_jemaat.warna_status_kepemilikan', '000000');

        // $query->where('aset_jemaat.atas_nama', '<>', 'X');
        // $query->where( function($query) {
        //                     $query->where('aset_jemaat.warna_status_pos_pelkes', '!=', '00B0F0')
        //                             ->orWhere('aset_jemaat.warna_status_kepemilikan_dokumen_imb', '!=', '00B050')
        //                             ->orWhere('aset_jemaat.warna_status_kepemilikan', '000000');
        //                 });

        $query->whereRaw('LOWER(aset_jemaat.atas_nama) != ?', ['x'] )
                ->where('aset_jemaat.keberadaan_dokumen', '');

        $queryResultMethodNames = $this->queryResultMethodNames[$getResType];
        
        return $query->$queryResultMethodNames();
    }

    public function scopeAsetPosPelkes($query, $getResType = self::GET_QUERY_COUNT, $criteria = [])
    {
        # udah bener
        $query->select('aset_jemaat.*');
        $this->_joinTableForAggregate($query);

        if ( !empty($criteria)) {
            foreach ($criteria as $k => $v) {
                $query = $query->where($k, $v);
            }
        }

        $queryResultMethodNames = $this->queryResultMethodNames[$getResType];
        return $query->where('aset_jemaat.warna_status_pos_pelkes', '00B0F0')->$queryResultMethodNames();
    }

    public function scopeAsetMemilikiIMB($query, $getResType = self::GET_QUERY_COUNT, $criteria = [])
    {
        # udah bener
        $query->select('aset_jemaat.*');
        $this->_joinTableForAggregate($query);

        if ( !empty($criteria)) {
            foreach ($criteria as $k => $v) {
                $query = $query->where($k, $v);
            }
        }

        $queryResultMethodNames = $this->queryResultMethodNames[$getResType];
        return $query->where('aset_jemaat.warna_status_kepemilikan_dokumen_imb', '00B050')->$queryResultMethodNames();
    }

    public function scopeExpiredHGBQueryBuilder($query, $criteria = "")
    {
        $query->select(DB::raw("id, kode_aset, masa_berlaku_hgb, DATE_FORMAT(masa_berlaku_hgb , '%Y-%m-%d') + INTERVAL 6 MONTH as tgl_expired"));
        // $query->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') + INTERVAL 28 DAY > CURDATE() $criteria");
        $query->whereRaw("DATE_FORMAT(masa_berlaku_hgb, '%Y-%m-%d') + INTERVAL 6 MONTH > CURDATE() $criteria");

        return $query;
    }

    public function scopeFilterByRole($query, $userAccessData)
    {
        //$query->select('aset_jemaat.*', 'mupel.nama as nama_mupel');
        $query->select('aset_jemaat.*');

        foreach ($userAccessData as $roleScope => $entity) {

            if ( $roleScope == "jemaat" ) {
                $query->where('id_jemaat_induk', $entity);
            } elseif ( $roleScope == "mupel" ) {
                $this->_joinTableForAggregate($query);
                $query->where('mupel.id', $entity);
                //dd($entity);
            }
        }

        //dd(DB::getQueryLog());

        return $query;
    }

    public function scopePerMupel($query, $mupelID)
    {
        // Aset per mupel 
        //$query->select('aset_jemaat.*', 'mupel.nama as nama_mupel');
        $query->select('aset_jemaat.kode_aset'
                        , 'aset_jemaat.no_urut_aset'
                        , 'aset_jemaat.jenis_asset'
                        , 'aset_jemaat.luas_tanah');

        $this->_joinTableForAggregate($query);
        $query->where('mupel.id', $mupelID);

        //dd(DB::getQueryLog());
        return $query->get();

        // return $query;
    }


    private function _joinTableForAggregate(&$query)
    {
        // $query->leftJoin('jemaat_induk', 'aset_jemaat.id_jemaat_induk', '=','jemaat_induk.id');
        // $query->leftJoin('jemaat_induk', function($join)
        $query->join('jemaat_induk', function($join)
        {
            $join->on('aset_jemaat.id_jemaat_induk', '=', 'jemaat_induk.id');
            $join->on('aset_jemaat.kode_aset', 'NOT LIKE', DB::raw("'%-00'"));
            // $join->on('arrival','>=',DB::raw("'2012-05-01'"));
            // $join->on('arrival','<=',DB::raw("'2012-05-10'"));
            // $join->on('departure','>=',DB::raw("'2012-05-01'"));
            // $join->on('departure','<=',DB::raw("'2012-05-10'"));
        });    
        $query->leftJoin('mupel', 'jemaat_induk.id_mupel', '=','mupel.id');

//        $query->join('jemaat_induk', 'aset_jemaat.id_jemaat_induk', '=','jemaat_induk.id');
//        $query->join('mupel', 'jemaat_induk.id_mupel', '=','mupel.id');
    }
}