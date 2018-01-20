<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\AsetJemaat;
use App\Models\JemaatInduk;
use App\Models\Cities;
use App\Models\Mupel;
use App\Exports\AsetJemaatExport;

use Illuminate\Support\Facades\Input;
use Excel;
use App\Providers\Services\AddNewCollectionListService;
use App\Providers\Services\GenerateNewKodeAsetService;
use Validator;
use Auth;
use Gate;

class AsetJemaatController extends Controller
{
    var $data;

    /* Class Constructor */
    function __construct()
    {
        $this->_default_vars();
        $this->viewData = [];

        $this->middleware(function ($request, $next) {
            // $user = Auth::user();
            $this->userSessionLogin = Auth::user();
            $this->userAccessData = $this->userSessionLogin->profile->access_data;

            if ($this->userSessionLogin->pass_prompt == "1") {
                // dd($this->userSessionLogin->pass_prompt);
                // return redirect('/password/reset');
                // return redirect('/reset/password');
                return redirect('/change/password');
            }
    
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->viewData['list_mupel'] = [0 => "Pilih Mupel"];
        $mupel_list = Mupel::FilterByRole($this->userAccessData)->get();
        $this->viewData['list_mupel'] += $mupel_list->pluck('nama', 'id')->all();

        $this->viewData['list_jemaat_induk'] = [0 => "Pilih Jemaat Induk"];

        $this->viewData['chiko1'] = 5;

        $criteria = [];
        $paramsBuild = [];

        $this->viewData['mupel_selected'] = 'undefined';
        $this->viewData['jemaat_selected'] = 'no action';
        
        if ( isset($this->userAccessData['mupel']) ) {

            $criteria += ['mupel.id' => $this->userAccessData['mupel']];
            $paramsBuild += ['mupel_id' => $this->userAccessData['mupel']];
            $this->viewData['mupel_selected'] = $this->userAccessData['mupel'];

        } elseif ( isset($this->userAccessData['jemaat']) ) {

            $criteria += ['jemaat_induk.id' => $this->userAccessData['jemaat']];

            $jemaatInduk = JemaatInduk::findOrFail( $this->userAccessData['jemaat'] );
            $jemaatMupelID = $jemaatInduk->mupel->id;

            $paramsBuild += ['mupel_id' => $jemaatMupelID];
            $paramsBuild += ['jemaat_id' => $this->userAccessData['jemaat']];

            $this->viewData['jemaat_selected'] = $this->userAccessData['jemaat'];

        }

        $this->viewData['queryString'] = http_build_query($paramsBuild);

        $this->viewData['jemaatInduk'] = JemaatInduk::JumlahSemuaJemaatIndukMemilikiAset($criteria);
        $this->viewData['statJumlahJemaatInduk'] = count($this->viewData['jemaatInduk']);

        $this->viewData['statTotalNJOP'] = AsetJemaat::SumOfNJOP($criteria);
        $this->viewData['statJumlahAsetBukanMilikGPIB'] = AsetJemaat::BukanMilikGPIB(AsetJemaat::GET_QUERY_COUNT, $criteria);

        $this->viewData['jemaatYangBelumMenyerahkanAset'] = JemaatInduk::JemaatYangBelumMenyerahkanAset(JemaatInduk::GET_QUERY_RESULTS, $criteria);
        $this->viewData['statJemaatYangBelumMenyerahkanAset'] = count($this->viewData['jemaatYangBelumMenyerahkanAset']);

        $this->viewData['jemaatYangSudahMenyerahkanAset'] = JemaatInduk::JemaatYangSudahMenyerahkanAset(JemaatInduk::GET_QUERY_RESULTS, $criteria);
        // $this->viewData['jemaatYangSudahMenyerahkanAset'] = JemaatInduk::JemaatYangSudahMenyerahkanAset(JemaatInduk::TO_SQL, $criteria);
        // dd($this->viewData['jemaatYangSudahMenyerahkanAset']);
        // dd(count($this->viewData['jemaatYangSudahMenyerahkanAset']));
        $this->viewData['statJemaatYangSudahMenyerahkanAset'] = count($this->viewData['jemaatYangSudahMenyerahkanAset']);
        
        $this->viewData['asetBukanMilikGPIB'] = AsetJemaat::BukanMilikGPIB(AsetJemaat::GET_QUERY_RESULTS, $criteria);
        
        $this->viewData['statJumlahAsetAtasNamaPribadi'] = AsetJemaat::AtasNamaPribadi(AsetJemaat::GET_QUERY_COUNT, $criteria);
        $this->viewData['asetAtasNamaPribadi'] = AsetJemaat::AtasNamaPribadi(AsetJemaat::GET_QUERY_RESULTS, $criteria);

        $this->viewData['statJumlahAsetAtasNamaGPIBSetempat'] = AsetJemaat::AtasNamaGPIBSetempat(AsetJemaat::GET_QUERY_COUNT, $criteria);
        $this->viewData['asetAtasNamaGPIBSetempat'] = AsetJemaat::AtasNamaGPIBSetempat(AsetJemaat::GET_QUERY_RESULTS, $criteria);

        $this->viewData['statJumlahAsetAtasNamaGPIB'] = AsetJemaat::AtasNamaGPIB(AsetJemaat::GET_QUERY_COUNT, $criteria);
        $this->viewData['asetAtasNamaGPIB'] = AsetJemaat::AtasNamaGPIB(AsetJemaat::GET_QUERY_RESULTS, $criteria);

        $this->viewData['statJumlahAsetTanpaStatusKepemilikan'] = AsetJemaat::TanpaStatusKepemilikan(AsetJemaat::GET_QUERY_COUNT, $criteria);
        $this->viewData['asetTanpaStatusKepemilikan'] = AsetJemaat::TanpaStatusKepemilikan(AsetJemaat::GET_QUERY_RESULTS, $criteria);

        $this->viewData['statJumlahAsetPosPelkes'] = AsetJemaat::AsetPosPelkes(AsetJemaat::GET_QUERY_COUNT, $criteria);
        $this->viewData['statJumlahAsetMemilikiIMB'] = AsetJemaat::AsetMemilikiIMB(AsetJemaat::GET_QUERY_COUNT, $criteria);
        $this->viewData['statJumlahAsetTanpaDokumen'] = AsetJemaat::AsetTanpaDokumen(AsetJemaat::GET_QUERY_COUNT, $criteria);
        // $this->viewData['statJumlahAsetTanpaDokumen'] = AsetJemaat::AsetTanpaDokumen(AsetJemaat::TO_SQL, $criteria);

        $this->viewData['statJumlahFisikAset'] = $this->viewData['statJumlahAsetBukanMilikGPIB'] + 
                                                $this->viewData['statJumlahAsetAtasNamaPribadi'] + 
                                                $this->viewData['statJumlahAsetAtasNamaGPIBSetempat'] + 
                                                $this->viewData['statJumlahAsetAtasNamaGPIB'] + 
                                                $this->viewData['statJumlahAsetTanpaStatusKepemilikan'];

        $this->viewData['percentJumlahAsetBukanMilikGPIB'] =
            ($this->viewData['statJumlahFisikAset'] == 0) ? 0
            : number_format($this->viewData['statJumlahAsetBukanMilikGPIB'] / $this->viewData['statJumlahFisikAset'] * 100, 2, '.', '');

        $this->viewData['percentJumlahAsetAtasNamaPribadi'] =
            ($this->viewData['statJumlahFisikAset'] == 0) ? 0
            : number_format($this->viewData['statJumlahAsetAtasNamaPribadi'] / $this->viewData['statJumlahFisikAset'] * 100, 2, '.', '');

        $this->viewData['percentJumlahAsetAtasNamaGPIBSetempat'] =
            ($this->viewData['statJumlahFisikAset'] == 0) ? 0
            : number_format($this->viewData['statJumlahAsetAtasNamaGPIBSetempat'] / $this->viewData['statJumlahFisikAset'] * 100, 2, '.', '');

        $this->viewData['percentJumlahAsetAtasNamaGPIB'] =
            ($this->viewData['statJumlahFisikAset'] == 0) ? 0
            : number_format($this->viewData['statJumlahAsetAtasNamaGPIB'] / $this->viewData['statJumlahFisikAset'] * 100, 2, '.', '');

        $this->viewData['percentTanpaStatusKepemilikan'] =
            ($this->viewData['statJumlahFisikAset'] == 0) ? 0
            : number_format($this->viewData['statJumlahAsetTanpaStatusKepemilikan'] / $this->viewData['statJumlahFisikAset'] * 100, 2, '.', '');

        $this->viewData['percentJumlahAsetTanpaDokumen'] =
            ($this->viewData['statJumlahFisikAset'] == 0) ? 0
            : number_format($this->viewData['statJumlahAsetTanpaDokumen'] / $this->viewData['statJumlahFisikAset'] * 100, 2, '.', '');

        $this->viewData['percentJumlahAsetPosPelkes'] =
            ($this->viewData['statJumlahFisikAset'] == 0) ? 0
            : number_format($this->viewData['statJumlahAsetPosPelkes'] / $this->viewData['statJumlahFisikAset'] * 100, 2, '.', '');

        $this->viewData['percentJumlahAsetMemilikiIMB'] =
            ($this->viewData['statJumlahFisikAset'] == 0) ? 0
            : number_format($this->viewData['statJumlahAsetMemilikiIMB'] / $this->viewData['statJumlahFisikAset'] * 100, 2, '.', '');

        $this->viewData['statistic_caption'] = "Statistik Jumlah Aset GPIB";
        if ( isset($this->userAccessData['mupel']) ) {
            $mupelName = Mupel::where('id', $this->userAccessData['mupel'])->first()->nama;
            $this->viewData['statistic_caption'] = "Statistik Jumlah Aset mupel " . $mupelName;
        } elseif ( isset($this->userAccessData['jemaat']) ) {
            $jemaatName = JemaatInduk::where('id', $this->userAccessData['jemaat'])->first()->nama;
            $this->viewData['statistic_caption'] = "Statistik Jumlah Aset " . $jemaatName;
        }

        return view('aset-jemaat.index', $this->viewData);
    }

    public function listAsetJemaat()
    {
        $models = AsetJemaat::FilterByRole($this->userAccessData)->orderBy('id', 'desc')->get();
        // dd($models[0]->status_kepemilikan); 
        // dd($models[0]->masa_berlaku_hgb); 
        // dd($models[0]->status_kepemilikan_lain_lain); 
        //dd(DB::getQueryLog());

        $result = $this->_paginateCollection($models, 10)->withPath(url()->current());

        $this->viewData['aset_jemaat'] = $result;
        $this->viewData['page_title'] = 'List Aset Jemaat';

        return view('aset-jemaat.list', $this->viewData);
    }

    public function listAsetTanpaDokumen(Request $request)
    {
        $criteria = [];
        $mupelID = $request->query('mupel_id');
        $jemaatID = $request->query('jemaat_id');

        if ( $mupelID != '' ) {
            $criteria += ['mupel.id' => $mupelID];

            if ( $jemaatID != '' ) { 
                $criteria += ['jemaat_induk.id' => $jemaatID];
            }
        }

        $models = AsetJemaat::all();

        $collections = $models->reject(function ($item) {
            return $item->warna_status_pos_pelkes == '00B0F0' || $item->warna_status_kepemilikan_dokumen_imb == '00B050';
        });

        $result = $this->_paginateCollection($collections, 10)->withPath(url()->current());

        $this->viewData['aset_jemaat'] = $result;
        $this->viewData['page_title'] = 'List Aset Jemaat Tanpa Dokumen';

        return view('aset-jemaat.list', $this->viewData);
    }

    public function listAsetPosPelkes(Request $request)
    {
        $criteria = [];
        $mupelID = $request->query('mupel_id');
        $jemaatID = $request->query('jemaat_id');

        if ( $mupelID != '' ) {
            $criteria += ['mupel.id' => $mupelID];

            if ( $jemaatID != '0' ) { 
                $criteria += ['jemaat_induk.id' => $jemaatID];
            }
        }

        $models = AsetJemaat::AsetPosPelkes(AsetJemaat::GET_QUERY_RESULTS, $criteria); 
        $result = $this->_paginateCollection($models, 10)->withPath(url()->current());

        $this->viewData['aset_jemaat'] = $result;
        $this->viewData['page_title'] = 'List Aset Jemaat di Pos Pelkes';

        return view('aset-jemaat.list', $this->viewData);
    }

    public function listAsetMemilikiIMB(Request $request)
    {
        $criteria = [];
        $mupelID = $request->query('mupel_id');
        $jemaatID = $request->query('jemaat_id');

        if ( $mupelID != '' ) {
            $criteria += ['mupel.id' => $mupelID];

            if ( $jemaatID != "0" ) { 
                $criteria += ['jemaat_induk.id' => $jemaatID];
            }
        }
        // dd($criteria);

        $models = AsetJemaat::AsetMemilikiIMB(AsetJemaat::GET_QUERY_RESULTS, $criteria);
        $result = $this->_paginateCollection($models, 10)->withPath(url()->current());

        $this->viewData['aset_jemaat'] = $result;
        $this->viewData['page_title'] = 'List Aset Jemaat memiliki IMB';

        return view('aset-jemaat.list', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( Gate::denies('create-new-aset-jemaat') )
            return abort(401);

        $this->viewData['page_title'] = 'Data Aset Jemaat';

        $jemaatIndukCollection = DB::table('jemaat_induk')
                                    ->select( DB::raw('jemaat_induk.id, CONCAT(jemaat_induk.nama, " ", "( ", mupel.nama, ")") AS nama_lengkap') )
                                    ->join( 'mupel', 'jemaat_induk.id_mupel', '=', 'mupel.id')
                                    ->whereNull('mupel.deleted_at');

        if ( isset($this->userAccessData['jemaat']) ) {
            $jemaatIndukCollection = $jemaatIndukCollection->where('jemaat_induk.id', $this->userAccessData['jemaat'])->get();
        } elseif ( isset($this->userAccessData['mupel']) ) {
            $jemaatIndukCollection = $jemaatIndukCollection->where('mupel.id', $this->userAccessData['mupel'])->get();
        } else {
            $jemaatIndukCollection = $jemaatIndukCollection->get();
        }

        $jenisAsetCollection = DB::table("aset_jemaat")
            ->select( DB::raw("jenis_asset as id, jenis_asset AS display_name") )
            ->where('jenis_asset', '!=', "")
            ->distinct()
            ->get();

        $statusKelolaCollection = DB::table("aset_jemaat")
            ->select( DB::raw("status_kelola as id, status_kelola AS display_name") )
            ->where('status_kelola', '!=', "")
            ->distinct()
            ->get();

        $keberadaanDokumenCollection = DB::table("aset_jemaat")
            ->select( DB::raw("keberadaan_dokumen as id, keberadaan_dokumen AS display_name") )
            ->where('keberadaan_dokumen', '!=', "")
            ->distinct()
            ->get();

        $atasNamaCollection = DB::table("aset_jemaat")
            ->select( DB::raw("atas_nama as id, atas_nama AS display_name") )
            ->where('atas_nama', '!=', "")
            ->distinct()
            ->get();

        $this->viewData['list_jemaat_induk'] = ["" => "Pilih Jemaat Induk"];
        $this->viewData['list_jemaat_induk'] += $jemaatIndukCollection->pluck('nama_lengkap', 'id')->all();

        $this->viewData['list_jenis_aset'] = $jenisAsetCollection->pluck('display_name', 'id')->all();
        $this->viewData['list_status_kelola'] = $statusKelolaCollection->pluck('display_name', 'id')->all();

        $this->viewData['list_keberadaan_dokumen'] = ["" => "Belum diketahui"];
        $this->viewData['list_keberadaan_dokumen'] += $keberadaanDokumenCollection->pluck('display_name', 'id')->all();

        $this->viewData['list_atas_nama'] = $atasNamaCollection->pluck('display_name', 'id')->all();
        $this->viewData['aset_jemaat'] = new AsetJemaat;


		return view('aset-jemaat.create', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( \App\Http\Requests\CreateAsetJemaatRequest $request)
    {
        $request->validated();
        $validatedData = $request->formatInput();

        AsetJemaat::create($validatedData);

		return redirect()->route('aset-jemaat.index')->with('status', 'Data Aset Jemaat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asetJemaat = AsetJemaat::findOrFail($id);

        if ( Gate::denies('edit-aset-jemaat', $asetJemaat) )
            return abort(401);

        $this->viewData['page_title'] = "Aset Jemaat $asetJemaat->nama";
        $this->viewData['aset_jemaat'] = $asetJemaat;

        $this->viewData['status_kepemilikan_variant'] = $asetJemaat->status_kepemilikan;
        if ( $asetJemaat->status_kepemilikan ) {
            $flippedStatusKepemilikanEnums = array_flip($asetJemaat::$statusKepemilikanEnums);
            $this->viewData['status_kepemilikan_variant'] = $flippedStatusKepemilikanEnums[$asetJemaat->status_kepemilikan];
        }

        return view('aset-jemaat.show', $this->viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asetJemaat = AsetJemaat::findOrFail($id);

        if ( Gate::denies('edit-aset-jemaat', $asetJemaat) )
            return abort(401);

        $masa_berlaku_hgb = "";
        if ( strpos($asetJemaat->status_kepemilikan, "HGB") !== false ) {
            $masa_berlaku_hgb = $asetJemaat->masa_berlaku_hgb;
            $asetJemaat->status_kepemilikan = "status_kepemilikan_hgb";
            $asetJemaat->extracted_masa_berlaku_hgb = $masa_berlaku_hgb;
        } else {
            $flipped = array_flip(AsetJemaat::$statusKepemilikanEnums);
            $asetJemaat->status_kepemilikan != "" ? $flipped[$asetJemaat->status_kepemilikan] : "";
        }
        // dd($asetJemaat->extracted_masa_berlaku_hgb);

        $atas_nama_jemaat = "";
        $atas_nama_pribadi = "";
        
        if ( strpos($asetJemaat->atas_nama, "GPIB Setempat") !== false ) {
            $atas_nama_jemaat = $asetJemaat->atas_nama_jemaat;
            $asetJemaat->atas_nama = "gpib_setempat";
            $asetJemaat->extracted_atas_nama_jemaat = $atas_nama_jemaat;
        } elseif ( strpos($asetJemaat->atas_nama, "Pribadi") !== false ) {
            $atas_nama_pribadi = $asetJemaat->atas_nama_pribadi;
            $asetJemaat->atas_nama = "Pribadi";
            $asetJemaat->extracted_atas_nama_pribadi = $atas_nama_pribadi;
        } else {
            $flipped = array_flip(AsetJemaat::$atasNamaEnums);
            $asetJemaat->atas_nama = @$flipped[$asetJemaat->atas_nama];
            // dd($asetJemaat->atas_nama);
        }


        $this->viewData['aset_jemaat'] = $asetJemaat;
        $this->viewData['page_title'] = 'Data Aset Jemaat';

        $jemaatIndukCollection = DB::table('jemaat_induk')
                                    ->select( DB::raw('jemaat_induk.id, CONCAT(jemaat_induk.nama, " ", "( ", mupel.nama, ")") AS nama_lengkap') )
                                    ->join( 'mupel', 'jemaat_induk.id_mupel', '=', 'mupel.id')
                                    ->whereNull('mupel.deleted_at');

        if ( isset($this->userAccessData['jemaat']) ) {
            $jemaatIndukCollection = $jemaatIndukCollection->where('jemaat_induk.id', $this->userAccessData['jemaat'])->get();
        } elseif ( isset($this->userAccessData['mupel']) ) {
            $jemaatIndukCollection = $jemaatIndukCollection->where('mupel.id', $this->userAccessData['mupel'])->get();
        } else {
            $jemaatIndukCollection = $jemaatIndukCollection->get();
        }

        $jenisAsetCollection = DB::table("aset_jemaat")
            ->select( DB::raw("jenis_asset as id, jenis_asset AS display_name") )
            ->where('jenis_asset', '!=', "")
            ->distinct()
            ->get();

        $statusKelolaCollection = DB::table("aset_jemaat")
            ->select( DB::raw("status_kelola as id, status_kelola AS display_name") )
            ->where('status_kelola', '!=', "")
            ->distinct()
            ->get();

        $keberadaanDokumenCollection = DB::table("aset_jemaat")
            ->select( DB::raw("keberadaan_dokumen as id, keberadaan_dokumen AS display_name") )
            ->where('keberadaan_dokumen', '!=', "")
            ->distinct()
            ->get();

        $this->viewData['list_jemaat_induk'] = ["" => "Pilih Jemaat Induk"];
        $this->viewData['list_jemaat_induk'] += $jemaatIndukCollection->pluck('nama_lengkap', 'id')->all();
        
        $this->viewData['list_jenis_aset'] = $jenisAsetCollection->pluck('display_name', 'id')->all();
        $this->viewData['list_status_kelola'] = $statusKelolaCollection->pluck('display_name', 'id')->all();

        $this->viewData['list_keberadaan_dokumen'] = ["" => "Belum diketahui"];
        $this->viewData['list_keberadaan_dokumen'] += $keberadaanDokumenCollection->pluck('display_name', 'id')->all();

		return view('aset-jemaat.edit', $this->viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( \App\Http\Requests\UpdateAsetJemaatRequest $request, $id)
    {   
        $request->validated();
        $validatedData = $request->formatInput();
        // dd($validatedData);

        AsetJemaat::where('id', $id)->update($validatedData);

        return redirect()->route('aset-jemaat.show', ['id' => $id])->with('status', 'Data Aset Jemaat berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asetJemaat = AsetJemaat::findOrFail($id);

        if ( Gate::denies('delete-aset-jemaat', $asetJemaat) )
            return abort(401);

        $asetJemaat->delete();

		return redirect()->back()->with('status', 'Data Aset Jemaat berhasil dihapus.');
    }

    private function _default_vars()
    {
        $site_title = 'GPIB';
        $site_name = 'Admin Panel';
        $site_name_mini = 'Spanel';

        $count_user = 10;
        $count_inst = 11;
        $count_pay_con = 12;

        //share default variable
        view()->share(compact('site_title','site_name','site_name_mini','count_user', 'count_inst', 'count_pay_con'));
    }

    public function importAset(Request $request)
    {
        //$currentUser = current_user();
        //$input = $request->all(); //dd($input);
        $input = $request->only(['file']); //dd($input);

        if ( ! empty($input['file']) ) {

            // import file 1. DATA ASET GPIB - SUMATERA UTARA - NAD (NEW).xlsx
            // dd(Input::file('file'));
            Excel::load(Input::file('file'), function($doc) {
            // Excel::load($input['file'], function($doc) {
            // Excel::load(Input::file('file'), function($doc) use ($currentUser, $languageID) {

                $activeSheet = $doc->getActiveSheet(); //dd($activeSheet);
                $dataRowCount = $activeSheet->getHighestRow();
                $barisMulai = 2;

                DB::beginTransaction(); //DB::rollBack();
                for ($i = $barisMulai; $i <= $dataRowCount; $i++) {

                    $klmKodeAset = trim($activeSheet->getCell('B' . $i)->getValue());

                    if ( empty($klmKodeAset) ) break;

                    $klmNamaMupel = trim($activeSheet->getCell('C' . $i)->getValue());
                    $mupelEntity = Mupel::where(DB::raw("LOWER(nama)"), strtolower($klmNamaMupel))->first(); //dd($mupelEntity);

                    $klmNamaJemaatInduk = trim($activeSheet->getCell('D' . $i)->getValue());
                    // DB::rollBack();
                    $jemaatIndukEntity = JemaatInduk::where("id_mupel", $mupelEntity->id)->where(DB::raw("LOWER(nama)"), strtolower($klmNamaJemaatInduk))->first(); //dd($jemaatIndukEntity);
                    
                    $klmNoUrutAset = (int) trim($activeSheet->getCell('I' . $i)->getValue()); //dd($klmNoUrutAset);
                    $klmJenisAset = trim($activeSheet->getCell('J' . $i)->getValue());
                    $klmAlamatDesaKelurahanPersil = trim($activeSheet->getCell('K' . $i)->getValue());
                    $klmAlamatKecamatanPersil = trim($activeSheet->getCell('L' . $i)->getValue());
                    $klmAlamatKabupatenPersil = trim($activeSheet->getCell('M' . $i)->getValue());
                    $klmAlamatPropinsiPersil = trim($activeSheet->getCell('N' . $i)->getValue());
                    $klmLuasTanah = trim($activeSheet->getCell('O' . $i)->getValue());
                    $klmStatusKepemilikanHM = trim($activeSheet->getCell('P' . $i)->getValue());
                    $klmStatusKepemilikanHGB = trim($activeSheet->getCell('Q' . $i)->getValue());
                    $klmStatusKepemilikanHP = trim($activeSheet->getCell('R' . $i)->getValue());
                    $klmStatusKepemilikanGirik = trim($activeSheet->getCell('S' . $i)->getValue());
                    $klmStatusKepemilikanLain2 = trim($activeSheet->getCell('T' . $i)->getValue());
                    $klmTglPengeluaranSertifikatSurat = trim($activeSheet->getCell('U' . $i)->getValue());

                    $klmAtasNama = trim($activeSheet->getCell('V' . $i)->getValue());
                    $klmAtasNamaBckgrClr = $activeSheet->getStyle('V' . $i)->getFill()->getStartColor()->getRGB(); //dd($klmAtasNamaBckgrClr);

                    $klmAsal = trim($activeSheet->getCell('W' . $i)->getValue());
                    $klmMasaBerlaku = trim($activeSheet->getCell('X' . $i)->getValue());
                    $klmTglTerbitSuratUkur = trim($activeSheet->getCell('Y' . $i)->getValue());
                    $klmNoSuratUkur = trim($activeSheet->getCell('Z' . $i)->getValue());

                    $klmNamaBangunan = trim($activeSheet->getCell('AA' . $i)->getValue());
                    $klmNamaBangunanBckgrClr = $activeSheet->getStyle('AA' . $i)->getFill()->getStartColor()->getRGB(); //dd($klmNamaBangunanBckgrClr);

                    $klmLuasBangunan = trim($activeSheet->getCell('AB' . $i)->getValue());

                    $klmNoTglPenerbitanIMB = trim($activeSheet->getCell('AC' . $i)->getValue());
                    $klmNoTglPenerbitanIMBBckgrClr = $activeSheet->getStyle('AC' . $i)->getFill()->getStartColor()->getRGB(); //dd($klmNoTglPenerbitanIMBBckgrClr);

                    $klmNjop = trim($activeSheet->getCell('AD' . $i)->getValue());
                    $klmStatusKelola = trim($activeSheet->getCell('AE' . $i)->getValue());

                    $klmKeberadaanDokumen = trim($activeSheet->getCell('AF' . $i)->getValue());
                    $klmKeberadaanDokumenBckgrClr = $activeSheet->getStyle('AF' . $i)->getFill()->getStartColor()->getRGB(); //dd($klmKeberadaanDokumenBckgrClr);

                    $klmKeterangan = trim($activeSheet->getCell('AG' . $i)->getValue());



                    if ($jemaatIndukEntity) {
                        AsetJemaat::create([
                            'id_jemaat_induk' => $jemaatIndukEntity->id,
                            'kode_aset' => $klmKodeAset,
                            'no_urut_aset' => $klmNoUrutAset,
                            'jenis_asset' => $klmJenisAset,
                            'alamat_persil_desa_kelurahan' => $klmAlamatDesaKelurahanPersil,
                            'kecamatan_persil' => $klmAlamatKecamatanPersil,
                            'kabupaten_persil' => $klmAlamatKabupatenPersil,
                            'propinsi_persil' => $klmAlamatPropinsiPersil,
                            'tanggal_terbit_surat_ukur' => $klmTglTerbitSuratUkur,
                            'no_surat_ukur' => $klmNoSuratUkur,
                            'luas_tanah' => $klmLuasTanah,
                            'status_kepemilikan_hm' => $klmStatusKepemilikanHM,
                            'status_kepemilikan_hgb' => $klmStatusKepemilikanHGB,
                            'status_kepemilikan_hp' => $klmStatusKepemilikanHP,
                            'status_kepemilikan_girik' => $klmStatusKepemilikanGirik,
                            'status_kepemilikan_lain_lain' => $klmStatusKepemilikanLain2,
                            'tgl_pengeluaran_sertifikat_surat' => $klmTglPengeluaranSertifikatSurat,

                            'atas_nama' => $klmAtasNama,
                            'warna_status_kepemilikan' => $klmAtasNamaBckgrClr,

                            'asal' => $klmAsal,
                            'masa_berlaku' => $klmMasaBerlaku,

                            'nama_bangunan' => $klmNamaBangunan,
                            'warna_status_pos_pelkes' => $klmNamaBangunanBckgrClr,
                            'luas_bangunan' => $klmLuasBangunan,
                            'no_tgl_penerbitan_imb' => $klmNoTglPenerbitanIMB,
                            'warna_status_kepemilikan_dokumen_imb' => $klmNoTglPenerbitanIMBBckgrClr,
                            'njop' => $klmNjop,
                            'status_kelola' => $klmStatusKelola,
                            'keberadaan_dokumen' => $klmKeberadaanDokumen,
                            'warna_keberadaan_dokumen' => $klmKeberadaanDokumenBckgrClr,
                            'keterangan' => $klmKeterangan
                        ]);
                    }
                    
                }

                DB::commit();
            });

            echo "Import success";
        }


        $this->viewData['page_title'] = "Form Import Aset Jemaat";

        return view('aset-jemaat.import', $this->viewData);
    }

    public function importAsetSinode(Request $request)
    {
        $input = $request->only(['file']);

        if ( !empty($input['file']) ) {

            Excel::load(Input::file('file'), function($doc) {

                $activeSheet = $doc->getActiveSheet();
                $dataRowCount = $activeSheet->getHighestRow();
                $barisMulai = 4;

                DB::beginTransaction(); //DB::rollBack();
                for ($i = $barisMulai; $i <= $dataRowCount; $i++) {

                    $klmKodeAset = trim($activeSheet->getCell('B' . $i)->getValue());

                    if ( empty($klmKodeAset) ) break;

                    $klmJenisAset = trim($activeSheet->getCell('C' . $i)->getValue());
                    $klmAlamatDesaKelurahanPersil = trim($activeSheet->getCell('D' . $i)->getValue());
                    $klmAlamatKecamatanPersil = trim($activeSheet->getCell('E' . $i)->getValue());
                    $klmAlamatKabupatenPersil = trim($activeSheet->getCell('F' . $i)->getValue());
                    $klmAlamatPropinsiPersil = trim($activeSheet->getCell('G' . $i)->getValue());
                    $klmLuasTanah = trim($activeSheet->getCell('H' . $i)->getValue());
                    $klmStatusKepemilikanHM = trim($activeSheet->getCell('I' . $i)->getValue());
                    $klmStatusKepemilikanHGB = trim($activeSheet->getCell('J' . $i)->getValue());
                    $klmStatusKepemilikanHP = trim($activeSheet->getCell('K' . $i)->getValue());
                    $klmStatusKepemilikanGirik = trim($activeSheet->getCell('L' . $i)->getValue());
                    $klmStatusKepemilikanLain2 = trim($activeSheet->getCell('M' . $i)->getValue());
                    $klmTglPengeluaranSertifikatSurat = trim($activeSheet->getCell('N' . $i)->getValue());

                    $klmAtasNama = trim($activeSheet->getCell('O' . $i)->getValue());
                    $klmAtasNamaBckgrClr = $activeSheet->getStyle('O' . $i)->getFill()->getStartColor()->getRGB(); //dd($klmAtasNamaBckgrClr);

                    $klmAsal = trim($activeSheet->getCell('P' . $i)->getValue());
                    $klmMasaBerlaku = trim($activeSheet->getCell('Q' . $i)->getValue());
                    $klmTglTerbitSuratUkur = trim($activeSheet->getCell('R' . $i)->getValue());
                    $klmNoSuratUkur = trim($activeSheet->getCell('S' . $i)->getValue());

                    $klmNamaBangunan = trim($activeSheet->getCell('T' . $i)->getValue());
                    $klmNamaBangunanBckgrClr = $activeSheet->getStyle('T' . $i)->getFill()->getStartColor()->getRGB(); //dd($klmNamaBangunanBckgrClr);

                    $klmLuasBangunan = trim($activeSheet->getCell('U' . $i)->getValue());

                    $klmNoTglPenerbitanIMB = trim($activeSheet->getCell('V' . $i)->getValue());
                    $klmNoTglPenerbitanIMBBckgrClr = $activeSheet->getStyle('V' . $i)->getFill()->getStartColor()->getRGB(); //dd($klmNoTglPenerbitanIMBBckgrClr);

                    $klmNjop = trim($activeSheet->getCell('W' . $i)->getValue());
                    $klmStatusKelola = trim($activeSheet->getCell('X' . $i)->getValue());

                    $klmKeberadaanDokumen = trim($activeSheet->getCell('Y' . $i)->getValue());
                    $klmKeberadaanDokumenBckgrClr = $activeSheet->getStyle('Y' . $i)->getFill()->getStartColor()->getRGB(); //dd($klmKeberadaanDokumenBckgrClr);

                    $klmKeterangan = trim($activeSheet->getCell('Z' . $i)->getValue());



                    AsetJemaat::create([
                        'id_jemaat_induk' => 26,
                        'kode_aset' => $klmKodeAset,
                        'no_urut_aset' => $i - 3,
                        'jenis_asset' => $klmJenisAset,
                        'alamat_persil_desa_kelurahan' => $klmAlamatDesaKelurahanPersil,
                        'kecamatan_persil' => $klmAlamatKecamatanPersil,
                        'kabupaten_persil' => $klmAlamatKabupatenPersil,
                        'propinsi_persil' => $klmAlamatPropinsiPersil,
                        'luas_tanah' => $klmLuasTanah,
                        'status_kepemilikan_hm' => $klmStatusKepemilikanHM,
                        'status_kepemilikan_hgb' => $klmStatusKepemilikanHGB,
                        'status_kepemilikan_hp' => $klmStatusKepemilikanHP,
                        'status_kepemilikan_girik' => $klmStatusKepemilikanGirik,
                        'status_kepemilikan_lain_lain' => $klmStatusKepemilikanLain2,
                        'tgl_pengeluaran_sertifikat_surat' => $klmTglPengeluaranSertifikatSurat,
                        'atas_nama' => $klmAtasNama,
                        'warna_status_kepemilikan' => $klmAtasNamaBckgrClr,
                        'asal' => $klmAsal,
                        'masa_berlaku' => $klmMasaBerlaku,
                        'tanggal_terbit_surat_ukur' => $klmTglTerbitSuratUkur,
                        'no_surat_ukur' => $klmNoSuratUkur,
                        'nama_bangunan' => $klmNamaBangunan,
                        'warna_status_pos_pelkes' => $klmNamaBangunanBckgrClr,
                        'luas_bangunan' => $klmLuasBangunan,
                        'no_tgl_penerbitan_imb' => $klmNoTglPenerbitanIMB,
                        'warna_status_kepemilikan_dokumen_imb' => $klmNoTglPenerbitanIMBBckgrClr,
                        'njop' => $klmNjop,
                        'status_kelola' => $klmStatusKelola,
                        'keberadaan_dokumen' => $klmKeberadaanDokumen,
                        'warna_keberadaan_dokumen' => $klmKeberadaanDokumenBckgrClr,
                        'keterangan' => $klmKeterangan
                    ]);
                }

                DB::commit();
            });

            echo "Import success";
        }


        $this->viewData['page_title'] = "Form import aset jemaat yang dikelola sinode";

        return view('aset-jemaat.import.sinode', $this->viewData);
    }

    public function statsByMupel(Request $request)
    {
        $input = $request->only(['mupel', 'jemaat']);
        $criteria = [];
        $paramsBuild = [];

        if ( isset($input['mupel']) ) {
            $criteria = $input['mupel'] == 0 ? [] : ['mupel.id' => $input['mupel']];
            $paramsBuild += ['mupel_id' => $input['mupel']];
        }

        if ( isset($input['jemaat']) ) { 
            $criteria += $input['jemaat'] == 0 ? [] : ['jemaat_induk.id' => $input['jemaat']];
            $paramsBuild += ['jemaat_id' => $input['jemaat']];
        }

        $this->viewData['queryString'] = http_build_query($paramsBuild);

        $mupel_list = Mupel::FilterByRole($this->userAccessData)->get();
        $this->viewData['list_mupel'] = $mupel_list->pluck('nama', 'id')->all();

        $this->viewData['list_jemaat_induk'] = ["no action" => "Pilih"];
        $this->viewData['list_jemaat_induk'] += [0 => "Pilih Semua Jemaat Induk"];
        $jemaat_induk_list = JemaatInduk::where('id_mupel', $input['mupel'])->get();
        $this->viewData['list_jemaat_induk'] += $jemaat_induk_list->pluck('nama', 'id')->all();

        $this->viewData['mupel_selected'] = @$input['mupel'];
        $this->viewData['jemaat_selected'] = @$input['jemaat'];

        $this->viewData['jemaatInduk'] = JemaatInduk::JumlahSemuaJemaatIndukMemilikiAset($criteria);
        $this->viewData['statJumlahJemaatInduk'] = count($this->viewData['jemaatInduk']);

        $this->viewData['statTotalNJOP'] = AsetJemaat::SumOfNJOP($criteria);

        $this->viewData['chiko1'] = 5;

        $this->viewData['statJumlahAsetBukanMilikGPIB'] = AsetJemaat::BukanMilikGPIB(AsetJemaat::GET_QUERY_COUNT, $criteria);

        $this->viewData['jemaatYangBelumMenyerahkanAset'] = JemaatInduk::JemaatYangBelumMenyerahkanAset(JemaatInduk::GET_QUERY_RESULTS, $criteria);
        // $this->viewData['jemaatYangBelumMenyerahkanAset'] = JemaatInduk::JemaatYangBelumMenyerahkanAset(JemaatInduk::TO_SQL, $criteria);
        // dd($this->viewData['jemaatYangBelumMenyerahkanAset']);
        $this->viewData['statJemaatYangBelumMenyerahkanAset'] = count($this->viewData['jemaatYangBelumMenyerahkanAset']);
        
        $this->viewData['jemaatYangSudahMenyerahkanAset'] = JemaatInduk::JemaatYangSudahMenyerahkanAset(JemaatInduk::GET_QUERY_RESULTS, $criteria);
        // $this->viewData['jemaatYangSudahMenyerahkanAset'] = JemaatInduk::JemaatYangSudahMenyerahkanAset(JemaatInduk::TO_SQL, $criteria);
        // dd($this->viewData['jemaatYangSudahMenyerahkanAset']);
        $this->viewData['statJemaatYangSudahMenyerahkanAset'] = count($this->viewData['jemaatYangSudahMenyerahkanAset']);


        $this->viewData['asetBukanMilikGPIB'] = AsetJemaat::BukanMilikGPIB(AsetJemaat::GET_QUERY_RESULTS, $criteria);

        $this->viewData['statJumlahAsetAtasNamaPribadi'] = AsetJemaat::AtasNamaPribadi(AsetJemaat::GET_QUERY_COUNT, $criteria);
        $this->viewData['asetAtasNamaPribadi'] = AsetJemaat::AtasNamaPribadi(AsetJemaat::GET_QUERY_RESULTS, $criteria);

        $this->viewData['statJumlahAsetAtasNamaGPIBSetempat'] = AsetJemaat::AtasNamaGPIBSetempat(AsetJemaat::GET_QUERY_COUNT, $criteria);
        $this->viewData['asetAtasNamaGPIBSetempat'] = AsetJemaat::AtasNamaGPIBSetempat(AsetJemaat::GET_QUERY_RESULTS, $criteria);

        $this->viewData['statJumlahAsetAtasNamaGPIB'] = AsetJemaat::AtasNamaGPIB(AsetJemaat::GET_QUERY_COUNT, $criteria);
        $this->viewData['asetAtasNamaGPIB'] = AsetJemaat::AtasNamaGPIB(AsetJemaat::GET_QUERY_RESULTS, $criteria);
        
        $this->viewData['statJumlahAsetTanpaStatusKepemilikan'] = AsetJemaat::TanpaStatusKepemilikan(AsetJemaat::GET_QUERY_COUNT, $criteria);
        $this->viewData['asetTanpaStatusKepemilikan'] = AsetJemaat::TanpaStatusKepemilikan(AsetJemaat::GET_QUERY_RESULTS, $criteria);

        $this->viewData['statJumlahAsetPosPelkes'] = AsetJemaat::AsetPosPelkes(AsetJemaat::GET_QUERY_COUNT, $criteria);
        $this->viewData['statJumlahAsetMemilikiIMB'] = AsetJemaat::AsetMemilikiIMB(AsetJemaat::GET_QUERY_COUNT, $criteria);
        

        $this->viewData['statJumlahFisikAset'] = $this->viewData['statJumlahAsetBukanMilikGPIB'] + 
                                                $this->viewData['statJumlahAsetAtasNamaPribadi'] + 
                                                $this->viewData['statJumlahAsetAtasNamaGPIBSetempat'] + 
                                                $this->viewData['statJumlahAsetAtasNamaGPIB'] + 
                                                $this->viewData['statJumlahAsetTanpaStatusKepemilikan'];

        $this->viewData['statJumlahAsetTanpaDokumen'] = ($this->viewData['statJumlahFisikAset'] == 0) ? 0 : $this->viewData['statJumlahFisikAset'] - ( $this->viewData['statJumlahAsetPosPelkes'] + $this->viewData['statJumlahAsetMemilikiIMB'] );

        $this->viewData['percentJumlahAsetBukanMilikGPIB'] =
            ($this->viewData['statJumlahFisikAset'] == 0) ? 0
            : number_format($this->viewData['statJumlahAsetBukanMilikGPIB'] / $this->viewData['statJumlahFisikAset'] * 100, 2, '.', '');

        $this->viewData['percentJumlahAsetAtasNamaPribadi'] =
            ($this->viewData['statJumlahFisikAset'] == 0) ? 0
            : number_format($this->viewData['statJumlahAsetAtasNamaPribadi'] / $this->viewData['statJumlahFisikAset'] * 100, 2, '.', '');

        $this->viewData['percentJumlahAsetAtasNamaGPIBSetempat'] =
            ($this->viewData['statJumlahFisikAset'] == 0) ? 0
            : number_format($this->viewData['statJumlahAsetAtasNamaGPIBSetempat'] / $this->viewData['statJumlahFisikAset'] * 100, 2, '.', '');


        $this->viewData['percentJumlahAsetAtasNamaGPIB'] =
            ($this->viewData['statJumlahFisikAset'] == 0) ? 0
            : number_format($this->viewData['statJumlahAsetAtasNamaGPIB'] / $this->viewData['statJumlahFisikAset'] * 100, 2, '.', '');


        $this->viewData['percentTanpaStatusKepemilikan'] =
            ($this->viewData['statJumlahFisikAset'] == 0) ? 0
            : number_format($this->viewData['statJumlahAsetTanpaStatusKepemilikan'] / $this->viewData['statJumlahFisikAset'] * 100, 2, '.', '');

        $this->viewData['percentJumlahAsetTanpaDokumen'] =
            ($this->viewData['statJumlahFisikAset'] == 0) ? 0
            : number_format($this->viewData['statJumlahAsetTanpaDokumen'] / $this->viewData['statJumlahFisikAset'] * 100, 2, '.', '');


        $this->viewData['percentJumlahAsetPosPelkes'] =
            ($this->viewData['statJumlahFisikAset'] == 0) ? 0
            : number_format($this->viewData['statJumlahAsetPosPelkes'] / $this->viewData['statJumlahFisikAset'] * 100, 2, '.', '');

        $this->viewData['percentJumlahAsetMemilikiIMB'] =
            ($this->viewData['statJumlahFisikAset'] == 0) ? 0
            : number_format($this->viewData['statJumlahAsetMemilikiIMB'] / $this->viewData['statJumlahFisikAset'] * 100, 2, '.', '');

        $this->viewData['statistic_caption'] = "Statistik Jumlah Aset GPIB";
        if ( isset($this->userAccessData['mupel']) ) {
            $mupelName = Mupel::where('id', $this->userAccessData['mupel'])->first()->nama;
            $this->viewData['statistic_caption'] = "Statistik Jumlah Aset mupel " . $mupelName;
        } elseif ( isset($this->userAccessData['jemaat']) ) {
            $jemaatName = JemaatInduk::where('id', $this->userAccessData['jemaat'])->first()->nama;
            $this->viewData['statistic_caption'] = "Statistik Jumlah Aset " . $jemaatName;
        }

        return view('aset-jemaat.index', $this->viewData);
    }

    public function addJenisAset(Request $request)
    {
        $input = $request->only(['inputAdditionalVal']);
        $inputVal = $input['inputAdditionalVal'];
        $lookUpField = 'jenis_asset';

        $addNewCollectionList = new AddNewCollectionListService($lookUpField);
        $response = $addNewCollectionList->getResponse($inputVal);

        return response()->json($response);
    }

    public function addStatusKelola(Request $request)
    {
        $input = $request->only(['inputAdditionalVal']);
        $inputVal = $input['inputAdditionalVal'];
        $lookUpField = 'status_kelola';

        $addNewCollectionList = new AddNewCollectionListService($lookUpField);
        $response = $addNewCollectionList->getResponse($inputVal);

        return response()->json($response);
    }

    public function addKeberadaanDokumen(Request $request)
    {
        $input = $request->only(['inputAdditionalVal']);
        $inputVal = $input['inputAdditionalVal'];
        $lookUpField = 'keberadaan_dokumen';

        $addNewCollectionList = new AddNewCollectionListService($lookUpField);
        $response = $addNewCollectionList->getResponse($inputVal);

        return response()->json($response);
    }

    public function addAtasNama(Request $request)
    {
        $input = $request->only(['inputAdditionalVal']);
        $inputVal = $input['inputAdditionalVal'];
        $lookUpField = 'atas_nama';

        $addNewCollectionList = new AddNewCollectionListService($lookUpField);
        $response = $addNewCollectionList->getResponse($inputVal);

        return response()->json($response);
    }

    public function getJemaatByMupel(Request $request)
    {
        $input = $request->only(['inputVal']);
        $inputVal = $input['inputVal'];
        $lookUpField = 'nama';

        $addNewCollectionList = new AddNewCollectionListService($lookUpField);
        $response = $addNewCollectionList->getJemaatByMupel($inputVal);

        return response()->json($response);
    }

    public function generateNewKodeAset(Request $request)
    {
        $input = $request->only(['listJemaatIndukID']);
        $inputVal = $input['listJemaatIndukID'];

        $service = new GenerateNewKodeAsetService();
        $response = $service->getNewKodeAsetByJemaatInduk($inputVal);

        return response()->json($response);
    }

    public function checkMasaExpiredHgb(Request $request)
    {
        $latest_total_data = 0;
        $allExpiredHGB = AsetJemaat::ExpiredHGBQueryBuilder()->get();
        $allExpiredHGBCount = count($allExpiredHGB);

        $msg = [];
        if ($allExpiredHGBCount > $latest_total_data) {
            foreach ($allExpiredHGB as $_item) {
                $msg[] = ["id" => $_item->id, "kode_aset" => $_item->kode_aset, "tgl_expired" => $_item->tgl_expired];
            }

            // dd($msg);
        }

        return json_encode($msg);
    }

    public function exportAset()
    {
        return Excel::download(new AsetJemaatExport, 'aset-jemaat.xlsx');
    }

    private function _paginateCollection($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ? : (\Illuminate\Pagination\Paginator::resolveCurrentPage() ? : 1);
        $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);
        return new \Illuminate\Pagination\LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}