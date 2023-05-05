<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MstDpt;
use App\Http\Resources\MstDptCollection;
use DB;

class MstDptController extends Controller
{
    /**
    * Menampilkan halaman TPS
    *
    * 
    * @return \Illuminate\View\View
    */
    public function index()
    {
        $dpt = DB::table('mst_dpts as a')
            ->leftJoin('mst_tps as b', 'a.id_tps', '=', 'b.id')
            ->select(DB::raw('a.id, b.no_tps, a.nik, a.nama, a.jenis_kelamin, b.id as id_tps'))
            ->orderBy('a.created_at', 'ASC');
 

        if (request()->q != '') {
            $dpt = $dpt->where('nama', 'LIKE', '%' . request()->q . '%');
        }

        return new MstDptCollection($dpt->paginate(10));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id_tps' => 'required',
            'nik' => 'required|string|unique:mst_dpts,nik',
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|string|max:100',
        ]);

        try {
            MstDpt::create([
                // 'desa_id' => $request->desa_id['id'],
                'id_tps' => $request->id_tps,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e]);
        }
    }

    public function edit($id){
        $dpt = MstDpt::find($id);
        // $tps = DB::table('mst_tps as a')
        //     ->leftJoin('mst_desas as b', 'a.desa_id', '=', 'b.id')
        //     ->select(DB::raw('a.id, b.nama as nama_desa, a.no_tps, a.jml_pemilih'))
        //     ->orderBy('a.created_at', 'ASC')
        //     ->groupBy(DB::raw('a.id'));
 
        return response()->json(['status' => 'success', 'data' => $dpt]);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'id_tps' => 'required',
            'nik' => 'required|string',
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|string|max:100',
        ]);

        $dpt = MstDpt::find($id);
        $dpt->update($request->all());
        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $dpt = MstDpt::find($id);
        if($dpt == null){
            return response()->json(['status' => 'error'], 422);
        }

        $dpt->delete();
        return response()->json(['status' => 'success'], 200);
    }
}