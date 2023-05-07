<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MstDesa;
use App\Http\Resources\MstDesaCollection;
use DB;

class MstDesaController extends Controller
{
    public function index()
    {
       $desas = DB::table('mst_desas as a')
       ->leftJoin('mst_kecamatans as b', 'a.id_kecamatan', '=', 'b.id')
       ->leftJoin('mst_tps as c', 'a.id', '=', 'c.desa_id')
       ->leftJoin(DB::raw('(SELECT id_desa, COUNT(*) as jumlah_konstituen FROM trx_konstituens GROUP BY id_desa) as d'),
            function($join){
                $join->on('a.id', '=', 'd.id_desa');
            }
        )
       ->leftJoin(DB::raw('(SELECT desa_id, COUNT(*) as jumlah_tps FROM mst_tps GROUP BY desa_id) as e'),
            function($join){
                $join->on('a.id', '=', 'e.desa_id');
            }
        )
       ->leftJoin(DB::raw('(SELECT id_tps, jenis_kelamin, 
       CAST(SUM(CASE WHEN jenis_kelamin = "pria" THEN 1 ELSE 0 END) AS INTEGER ) as pria, 
       CAST(SUM(CASE WHEN jenis_kelamin = "wanita" THEN 1 ELSE 0 END) AS INTEGER ) as wanita 
       FROM mst_dpts GROUP BY id_tps) as f'),
            function($join){
                $join->on('c.id', '=', 'f.id_tps');
            }
        )
       ->select(DB::raw('a.id, a.nama, a.id_kecamatan, b.nama as nama_kecamatan, d.jumlah_konstituen, e.jumlah_tps, CAST(SUM(f.pria) AS INTEGER) as pemilih_pria, CAST(SUM(f.wanita) AS INTEGER) as pemilih_wanita'))
       ->groupBy('a.id');
       if (request()->q != '') {
           $desas = $desas->where('nama', 'LIKE', '%' . request()->q . '%');
       }
        $desas = $desas->paginate(10);
        return new MstDesaCollection($desas);
    }

    public function getNameDesa(){
        // $desa = MstDesa::all();
        $desa = DB::table('mst_desas')->select(DB::raw('*'))->groupBy(DB::raw('id'));

        // return response()->json(['status' => 'success', 'data' => $desa]);
        return new MstDesaCollection($desa->paginate(50));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id_kecamatan' => 'required',
            'nama' => 'required|string|max:100',
            'pemilih_pria' => 'required|integer',
            'pemilih_wanita' => 'required|integer',
            'jumlah_tps' => 'required|integer',
        ]);

        try {
            MstDesa::create([
                'nama' => $request->nama,
                'id_kecamatan' => $request->id_kecamatan['id'],
                'pemilih_pria' => $request->pemilih_pria,
                'pemilih_wanita' => $request->pemilih_wanita,
                'jumlah_tps' => $request->jumlah_tps,
            ]);
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed']);
        }
    }

    public function edit($id)
    {
        $desas = MstDesa::find($id);
        return response()->json(['status' => 'success', 'data' => $desas]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id_kecamatan' => 'required',
            'nama' => 'required|string|max:100',
            'pemilih_pria' => 'required|integer',
            'pemilih_wanita' => 'required|integer',
            'jumlah_tps' => 'required|integer',
        ]);

        $desas = MstDesa::find($id);
        $desas->update([
            'nama' => $request->nama,
            'id_kecamatan' => $request->id_kecamatan['id'],
            'pemilih_pria' => $request->pemilih_pria,
            'pemilih_wanita' => $request->pemilih_wanita,
            'jumlah_tps' => $request->jumlah_tps,
            'user_id' => auth()->user()->id,
        ]);
        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $desas = MstDesa::find($id);
        $desas->delete();
        return response()->json(['status' => 'success']);
    }
}
