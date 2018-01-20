<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\JenisAsset;

class JenisAsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$models = DB::table('jenis_asset')->simplePaginate(10);
        //$models = JenisAsset::paginate(10);
        $models = JenisAsset::simplePaginate(10);
        

        $data = [];
        $data['jenis_asset'] = $models;

        $data['page_title'] = 'Data Jemaat Induk';
        return view('jenis-asset.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Data Jenis Aset Baru';
		return view('jenis-asset.create', $data);
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
			'nama' => 'required|max:255'
		], [
			'required' => 'Field :attribute diperlukan',
        ]);

        $data = $request->only('nama');

        JenisAsset::create([
                'nama' => $data['nama']
                ]);

		return redirect()->route('jenis-aset.index')->with('status', 'Data Jenis Aset berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jenisAsset = JenisAsset::findOrFail($id);
        $data['page_title'] = "Jemaat $jenisAsset->nama";
        $data['jenis_asset'] = $jenisAsset;

        return view('jenis-asset.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jenisAsset = JenisAsset::findOrFail($id);
        $data['page_title'] = "Jemaat $jenisAsset->nama";
        $data['jenis_asset'] = $jenisAsset;

		return view('jenis-asset.edit', $data);
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

        $jenisAsset = JenisAsset::findOrFail($id);

		$jenisAsset->update($data);

        return redirect()->route('jenis-aset.index')->with('status', 'Data Jenis Asset berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jenisAsset = JenisAsset::findOrFail($id);
        $jenisAsset->delete();

		return redirect()->back()->with('status', 'Data Jenis Asset berhasil dihapus.');
    }
}