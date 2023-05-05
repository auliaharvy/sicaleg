<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MstCSatu;
use App\MstTps;
use File;
use DB;

class MstCSatuController extends Controller
{
    public function index()
    {
        $cSatu = MstCSatu::all();
        return response()->json(['status' => 'success', 'data' => $cSatu]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'id_tps' => 'required|exists:mst_tps,id',
           'foto' => 'required',
           'jml_suara' => 'required|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            $nama_foto = NULL;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $nama_foto = $request->nama. '-' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/cSatu', $nama_foto);
            }

            MstCSatu::create([
               'id_tps' => $request->id_tps,
               'foto' => $nama_foto,
               'jml_suara' => $request->jml_suara,
            ]);
            DB::commit();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
        }
    }

    public function edit($id)
    {
        $cSatuEdit = MstCSatu::find($id);
        if($cSatuEdit == null){
            $cSatuAdd = MstCSatu::where('id_tps', '=', $id)->get();
            if($cSatuAdd == null){
                return response()->json(['status' => 'error not found'],422);
            }else{
                return response()->json(['status' => 'success', 'data' => $cSatuAdd], 200);
            }
        }

        return response()->json(['status' => 'success', 'data' => $cSatuEdit], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id_tps' => 'required|exists:mst_tps,id',
            'jml_suara' => 'required|string|max:100',
            'foto' => 'required',
        ]);

        $cSatu = MstCSatu::find($id);

        $namaFoto = $cSatu->foto;

        if($request->hasFile('foto')){
            $file = $request->file('foto');
            File::delete(storage_path('app/public/c1/'. $namaFoto));
            $namaFoto = $request->nama . '-' . time() . '.' . $file->getClientOriginalName();
            $file->storeAs('public/cSatu', $namaFoto);
        }

        $cSatu->update([
           'id_tps' => $request->id_tps,
           'foto' => $namaFoto,
           'jml_suara' => $request->jml_suara,
        ]);

        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $cSatu = MstCSatu::find($id);
        File::delete(storage_path('app/public/cSatu/' . $cSatu->foto));
        $c1->delete();
        return response()->json(['status' => 'success'], 200);
    }
}