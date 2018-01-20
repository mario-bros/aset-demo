<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\JemaatInduk;
use App\Models\AsetJemaat;
use App\Models\Cities;
use App\Models\Mupel;
use Auth;

use Illuminate\Support\Facades\Input;
use Excel;
use Gate;

class FormJemaatIndukController extends Controller
{
    var $data;
    var $userAccessData;

    /* Class Constructor */
    function __construct(Auth $auth)
    {
        $this->_default_vars();
        $this->viewData = [];

        $this->middleware(function ($request, $next) {
            $user= Auth::user();

            //dd($request);
            $this->userAccessData = $user->profile->access_data;
    
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
        $models = JemaatInduk::FilterByRole($this->userAccessData)->orderBy('id', 'desc')->simplePaginate(10);

        $this->viewData['jemaat_induk'] = $models;
        $this->viewData['page_title'] = 'List Jemaat Induk';

        return view('form-jemaat-induk.index', $this->viewData);
    }

    public function search(Request $request)
    {
        $qSearchKey = $request->get('search_key');
        $qCategory = $request->get('category');
        //dd($qCategory);

        $this->validate($request, [
			'category' => 'required'
		], [
			'required' => 'Pilih kategori pencarian',
        ]);

        //$searchResult = JemaatInduk::search($qCategory, $qSearchKey)->simplePaginate(10);
        $searchResult = JemaatInduk::search($qCategory, $qSearchKey)->paginate(10);

        $this->viewData['jemaat_induk'] = $searchResult;
        $this->viewData['page_title'] = 'List Jemaat Induk';
        //$this->viewData['category_name'] = 'List Jemaat Induk';

        return view('form-jemaat-induk.index', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( Gate::denies('create-new-jemaat') )
            return abort(401);

        $this->viewData['page_title'] = 'Data Jemaat Induk Baru';

        foreach ($this->userAccessData as $roleScope => $entity) {
            
            if ($roleScope == "jemaat") {

                $jemaatInduk = JemaatInduk::findOrFail($entity);
                $this->viewData['list_mupel'] = Mupel::where('id', $jemaatInduk->mupel->id)->pluck('nama', 'id')->all();
            } elseif ($roleScope == "mupel") {

                $this->viewData['list_mupel'] = Mupel::where('id', $entity)->pluck('nama', 'id')->all();
            } else {

                $this->viewData['list_mupel'] = Mupel::pluck('nama', 'id')->all();
            }

        }

		return view('form-jemaat-induk.create', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( Gate::denies('create-new-jemaat') )
            return abort(401);
            
        $this->validate($request, [
			'nama' => 'required|max:255'
		], [
			'required' => 'Field :attribute diperlukan',
        ]);

        $data = $request->except('file');
        //dd($data);

		/*if($request->hasFile('file')) {
			$data['file'] = $this->upload($request->file('file'));
		}*/

        $jemaatIndukID = JemaatInduk::create([
                'nama' => $data['nama'],
                'id_mupel' => (int) $data['id_mupel'],
                'email' => $data['email'],
                'no_telp' => $data['no_telp'],
                'nama_kmj' => $data['nama_kmj'],
                'email_kmj' => $data['email_kmj'],
                'no_telp_kmj' => $data['no_telp_kmj'],
                'alamat_desa_kelurahan' => $data['alamat_desa_kelurahan'],
                'id_propinsi' => $data['id_propinsi'],
                'id_kabupaten' => $data['id_kabupaten'],
                'id_kecamatan' => $data['id_kecamatan']
        ]);

        $suffixSegment = "00";

        $idMupel = (int) $jemaatIndukID->id_mupel;
        $mupelSegment = str_pad($idMupel, 2, "0", STR_PAD_LEFT);

        $idJemaat = $jemaatIndukID->id;
        $jemaatSegment = str_pad($idJemaat, 2, "0", STR_PAD_LEFT);

        $kodeAset = $mupelSegment . "." . $jemaatSegment . "-" . $suffixSegment;

        AsetJemaat::create([
                'id_jemaat_induk' => $jemaatIndukID->id,
                'kode_aset' => $kodeAset,
                'no_urut_aset' => 0
        ]);

		return redirect()->route('form-jemaat-induk.index')->with('status', 'Data Jemaat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jemaatInduk = JemaatInduk::findOrFail($id);

        if ( Gate::denies('edit-jemaat', $jemaatInduk) )
            return abort(401);

        $this->viewData['page_title'] = "Jemaat $jemaatInduk->nama";
        $this->viewData['jemaat_induk'] = $jemaatInduk;

		/*if (Gate::allows('member-of', $classroom)){
			return view('user.classrooms.index', $data);
        }*/

        return view('form-jemaat-induk.show', $this->viewData);

		//return abort(401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jemaatInduk = JemaatInduk::findOrFail($id);

        if ( Gate::denies('edit-jemaat', $jemaatInduk) )
			return abort(401);

        $this->viewData['page_title'] = "Jemaat $jemaatInduk->nama";
        $this->viewData['jemaat_induk'] = $jemaatInduk;

        foreach ($this->userAccessData as $roleScope => $entity) {
            
            if ($roleScope == "jemaat") {

                $jemaatInduk = JemaatInduk::findOrFail($entity);
                $this->viewData['list_mupel'] = Mupel::where('id', $jemaatInduk->mupel->id)->pluck('nama', 'id')->all();
            } elseif ($roleScope == "mupel") {

                $this->viewData['list_mupel'] = Mupel::where('id', $entity)->pluck('nama', 'id')->all();
            } else {

                $this->viewData['list_mupel'] = Mupel::pluck('nama', 'id')->all();
            }

        }

		return view('form-jemaat-induk.edit', $this->viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
			'nama' => 'required|max:255'
		], [
			'required' => 'Field :attribute diperlukan',
        ]);

        $data = $request->except('file');

        $jemaatInduk = JemaatInduk::findOrFail($id);

		$jemaatInduk->update($data);

        return redirect()->route('form-jemaat-induk.index')->with('status', 'Data Jemaat berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jemaatInduk = JemaatInduk::findOrFail($id);

        if ( Gate::denies('delete-jemaat', $jemaatInduk) )
            return abort(401);

        $jemaatInduk->delete();

		return redirect()->back()->with('status', 'Data Jemaat induk berhasil dihapus.');
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

    public function importJemaatInduk(Request $request)
    {
        $input = $request->only(['file']);

        if ( !empty($input['file']) ) {

            //dd($input['file']);
            //dd($input);

            Excel::load(Input::file('file'), function($doc) {

                $activeSheet = $doc->getActiveSheet(); 
                $dataRowCount = $activeSheet->getHighestRow(); //dd($dataRowCount);
                $barisMulai = 2;

                DB::beginTransaction();
                //DB::rollback();
                for ($i = $barisMulai; $i <= $dataRowCount; $i++) {

                    $klmKodeAset = trim($activeSheet->getCell('B' . $i)->getValue());

                    if ( empty($klmKodeAset) ) break;

                    
                    $klmNamaMupel = trim($activeSheet->getCell('C' . $i)->getValue());
                    $mupelEntity = Mupel::where(DB::raw("LOWER(nama)"), strtolower($klmNamaMupel))->first();

                    $klmNamaJemaatInduk = trim($activeSheet->getCell('D' . $i)->getValue());
                    $klmAlamatDesaKelurahan = trim($activeSheet->getCell('E' . $i)->getValue());
                    $klmKecamatan = trim($activeSheet->getCell('F' . $i)->getValue());
                    $klmKabupaten = trim($activeSheet->getCell('G' . $i)->getValue());
                    $klmPropinsi = trim($activeSheet->getCell('H' . $i)->getValue());

                    $dataJemaatIndukExist = JemaatInduk::where('id_mupel', $mupelEntity->id)->where(DB::raw("LOWER(nama)"), strtolower($klmNamaJemaatInduk))->first();
                    if ( $dataJemaatIndukExist === NULL ) {
                        JemaatInduk::create([
                            'id_mupel' => $mupelEntity->id,
                            'nama' => $klmNamaJemaatInduk,
                            'alamat_desa_kelurahan' => $klmAlamatDesaKelurahan,
                            'id_kecamatan' => $klmKecamatan,
                            'id_kabupaten' => $klmKabupaten,
                            'id_propinsi' => $klmPropinsi
                        ]);
                    }
                }

                DB::commit();
            });

            echo "Import success";
        }

        $this->viewData['page_title'] = "Form Import Data Jemaat Induk";

        return view('form-jemaat-induk.import', $this->viewData);
    }
}