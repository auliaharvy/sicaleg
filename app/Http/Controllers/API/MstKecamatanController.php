<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MstKecamatanCollection;
use App\MstKecamatan;
use DB;

class MstKecamatanController extends Controller
{
    public function index()
    {
        // $kecamatans = MstKecamatan::orderBy('created_at', 'DESC');
       $kecamatans = DB::table('mst_kecamatans as a')
       ->leftJoin('mst_desas as b', 'a.id', '=', 'b.id_kecamatan')
       ->leftJoin('mst_tps as c', 'b.id', '=', 'c.desa_id')
       ->leftJoin(DB::raw('(SELECT id_desa, COUNT(*) as jumlah_konstituen FROM trx_konstituens GROUP BY id_desa) as d'),
            function($join){
                $join->on('b.id', '=', 'd.id_desa');
            }
        )
       ->leftJoin(DB::raw('(SELECT desa_id, COUNT(*) as jumlah_tps FROM mst_tps GROUP BY desa_id) as e'),
            function($join){
                $join->on('b.id', '=', 'e.desa_id');
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
       ->select(DB::raw('a.id, a.nama, a.dapil, CAST(COUNT(d.jumlah_konstituen) AS INTEGER) AS jumlah_konstituen, CAST(COUNT(e.jumlah_tps) AS INTEGER) AS total_tps, CAST(SUM(f.pria) AS INTEGER) as pemilih_pria, CAST(SUM(f.wanita) AS INTEGER) as pemilih_wanita'))
       ->groupBy('a.id');
 
       if (request()->q != '') {
            $kecamatans = $kecamatans->where('a.nama', 'LIKE', '%' . request()->q . '%');
        }
        return new MstKecamatanCollection($kecamatans->paginate(10));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:100',
            'dapil' => 'required|string|max:100',
        ]);

        MstKecamatan::create($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function edit($id)
    {
        $kecamatan = MstKecamatan::whereCode($id)->first();
        return response()->json(['status' => 'success', 'data' => $kecamatan], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:100',
        ]);

        $kecamatan = MstKecamatan::whereCode($id)->first();
        $kecamatan->update($request->except('code'));
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $kecamatan = MstKecamatan::find($id);
        $kecamatan->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
