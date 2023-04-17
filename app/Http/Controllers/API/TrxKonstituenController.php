<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TrxKonstituenCollection;
use App\User;
use App\TrxKonstituen;
use App\MstKecamatan;
use App\MstDesa;
use App\MstTps;
use File;
use DB;

class TrxKonstituenController extends Controller
{
    public function index()
    {
        // $kecamatans = MstKecamatan::orderBy('created_at', 'DESC');
        $konstituens = DB::table('trx_konstituens as a')
            ->leftJoin('mst_desas as b', 'b.id', '=', 'a.id_desa')
            ->leftJoin('mst_kecamatans as c', 'c.id', '=', 'a.id_kecamatan')
            ->leftJoin('users as d', 'd.id', '=', 'a.submit_by')
            ->select(DB::raw('a.*, b.nama as nama_desa, c.nama as nama_kecamatan, d.name as rekruter'))
            ->orderBy('a.created_at', 'ASC');
        if (request()->q != '') {
            $konstituens = $konstituens->where('a.nama', 'LIKE', '%' . request()->q . '%');
        }
        return new TrxKonstituenCollection($konstituens->paginate(10));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nik' => 'required|string|unique:trx_konstituens,nik',
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'id_kecamatan' => 'required|exists:mst_kecamatans,id',
            'id_desa' => 'required|exists:mst_desas,id',
            'id_tps' => 'required|exists:mst_tps,id',
            'agama' => 'required|string',
            'pekerjaan' => 'required|string',
            'status_pernikahan' => 'required|string',
            'kewarganegaraan' => 'required|string|max:30',
            'foto' => 'required',
            'submit_by' => 'required|exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            $nama_foto = NULL;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $nama_foto = $request->nama. '-' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/konstituen', $nama_foto);
            }
            TrxKonstituen::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'id_kecamatan' => $request->id_kecamatan,
                'id_desa' => $request->id_desa,
                'id_tps' => $request->id_tps,
                'agama' => $request->agama,
                'status_pernikahan' => $request->status_pernikahan,
                'pekerjaan' => $request->pekerjaan,
                'kewarganegaraan' => $request->kewarganegaraan,
                'foto' => $nama_foto,
                'submit_by' => $request->submit_by,
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
        $konstituen = TrxKonstituen::find($id);
        // OTAK ATIK VUE SELECT
        // $konstituen = DB::table('trx_konstituens as a')
        //     ->leftJoin('users as b', 'a.submit_by', '=', 'b.id')
        //     ->leftJoin('mst_desas as c', 'a.submit_by', '=', 'c.id')
        //     ->leftJoin('mst_kecamatans as d', 'a.submit_by', '=', 'd.id')
        //     ->leftJoin('mst_tps as e', 'a.submit_by', '=', 'e.id')
        //     ->select(DB::raw('a.*, c.nama as nama_desa, e.no_tps, d.nama as nama_kecamatan, b.name as rekruter'))
        //     ->where('a.id', '=', $id)
        //     ->first();

        if($konstituen == null){
            return response()->json(['status' => 'error not found'],422);
        }

        return response()->json(['status' => 'success', 'data' => $konstituen], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nik' => 'required|string',
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'id_kecamatan' => 'required|exists:mst_kecamatans,id',
            'id_desa' => 'required|exists:mst_desas,id',
            'id_tps' => 'required|exists:mst_tps,id',
            'agama' => 'required|string',
            'pekerjaan' => 'required|string',
            'status_pernikahan' => 'required|string',
            'kewarganegaraan' => 'required|string|max:30',
            'foto' => 'nullable',
            'updated_by' => 'required|exists:users,id',
        ]);

        $konstituen = TrxKonstituen::find($id);
        // OTAK ATIK VUE SELECT
        // $idKecamatan = MstKecamatan::where('nama', '=', $request->id_kecamatan)->first();
        // $idDesa = MstDesa::where('nama', '=', $request->id_desa)->first();
        // $idTps = MstTps::where('no_tps', '=', $request->id_tps)->first();
        // $rekruterSubmitBy = User::where('name', '=', $request->rekruter_submit_by)->first();
        // $rekruterUpdatedBy = User::where('name', '=', $request->rekruter_updated_by)->first();

        $namaFoto = $konstituen->foto;

        if($request->hasFile('foto')){
            $file = $request->file('foto');
            File::delete(storage_path('app/public/konstituen/'. $namaFoto));
            $namaFoto = $request->nama . '-' . time() . '.' . $file->getClientOriginalName();
            $file->storeAs('public/konstituen', $namaFoto);
        }

        $konstituen->update([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            // 'id_kecamatan' => $idKecamatan->id,
            'id_kecamatan' => $request->id_kecamatan,
            'id_desa' => $request->id_desa,
            'id_tps' => $request->id_tps,
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan,
            'status_pernikahan' => $request->status_pernikahan,
            'kewarganegaraan' => $request->kewarganegaraan,
            'foto' => $namaFoto,
            //'rekruter_submit_by' => $rekruterSubmitBy->id,
            'updated_by' => $request->updated_by,
        ]);

        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $konstituen = TrxKonstituen::find($id);
        File::delete(storage_path('app/public/konstituen/' . $konstituen->foto));
        $konstituen->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
