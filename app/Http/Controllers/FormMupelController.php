<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mupel;
use Auth;

class FormMupelController extends Controller
{
    var $data;

    /* Class Constructor */
    function __construct()
    {
        $this->_default_vars();
        $this->viewData = [];

        $this->middleware(function ($request, $next) {
            $user = Auth::user();
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
        $models = Mupel::FilterByRole($this->userAccessData)->simplePaginate(10);

        $this->viewData['mupel'] = $models;
        $this->viewData['page_title'] = 'List Mupel';

        return view('form-mupel.index', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->viewData['page_title'] = 'Data Mupel Baru';

		return view('form-mupel.create', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'nama' => 'required|max:255',
		], [
			'required' => 'Field :attribute diperlukan',
        ]);

        $data = $request->only('nama');

        Mupel::create([
                'nama' => $data['nama'],
                ]);

		return redirect()->route('form-mupel.index')->with('status', 'Data Mupel berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mupel = Mupel::findOrFail($id);
        $this->viewData['page_title'] = "Mupel $mupel->nama";
        $this->viewData['mupel'] = $mupel;

		/*if (Gate::allows('member-of', $classroom)){
			return view('user.classrooms.index', $data);
        }*/

        return view('form-mupel.show', $this->viewData);

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
        $mupel = Mupel::findOrFail($id);
        $this->viewData['page_title'] = "Jemaat $mupel->nama";
        $this->viewData['mupel'] = $mupel;

		return view('form-mupel.edit', $this->viewData);
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
			'nama' => 'required|max:255',
		], [
			'required' => 'Field :attribute diperlukan',
        ]);

        $data = $request->only('nama');

        $mupel = Mupel::findOrFail($id);

		$mupel->update($data);

        return redirect()->route('form-mupel.index')->with('status', 'Data Mupel berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Mupel::findOrFail($id);
        $data->delete();

		return redirect()->back()->with('status', 'Data Mupel berhasil dihapus.');
    }

    private function _default_vars()
    {
        $site_title = 'GPIB';
        $site_name = 'Admin Panel';
        $site_name_mini = 'Spanel';

        //share default variable
        view()->share(compact('site_title','site_name','site_name_mini'));
    }
}
