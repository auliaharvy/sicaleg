<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MstTps;
use App\MstCSatu;
use App\Http\Resources\MstTpsCollection;
use DB;

class MstTpsController extends Controller
{
    /**
    * Menampilkan halaman TPS
    *
    * 
    * @return \Illuminate\View\View
    */
    public function index()
    {
        $tps = DB::table('mst_tps as a')
            ->leftJoin('mst_desas as b', 'a.desa_id', '=', 'b.id')
            ->leftJoin(DB::raw('(SELECT id_tps, COUNT(*) as jumlah_pemilih FROM mst_dpts GROUP BY id_tps) as c'),
                function($join){
                    $join->on('a.id', '=', 'c.id_tps');
                }
            )
            ->leftJoin(DB::raw('(SELECT id_tps, COUNT(*) as jumlah_konstituens FROM trx_konstituens GROUP BY id_tps) as d'),
                function($join){
                    $join->on('a.id', '=', 'd.id_tps');
                }
            )
            ->leftJoin('mst_c_satus as e', 'a.id', '=', 'e.id_tps')
          ->select(DB::raw('a.id, b.nama as nama_desa, a.desa_id, a.no_tps, c.jumlah_pemilih, d.jumlah_konstituens, e.foto, e.id as id_cSatu'));
          // QUERY SQL PHPMYADMIN
// SELECT mst_tps.id, mst_dpts.jumlah_pemilih, trx_konstituens.jumlah_konstituen
// FROM mst_tps  
// LEFT OUTER JOIN 
// (
//   SELECT id_tps, count(*) AS jumlah_pemilih
//   FROM mst_dpts
//   GROUP BY id_tps
// ) AS mst_dpts ON mst_tps.id = mst_dpts.id_tps
// LEFT OUTER JOIN 
// (
//   SELECT id_tps, count(*) AS jumlah_konstituen
//   FROM trx_konstituens
//   GROUP BY id_tps
// ) AS trx_konstituens ON mst_tps.id = trx_konstituens.id_tps
        if (request()->q != '') {
            $tps = $tps->where('nama', 'LIKE', '%' . request()->q . '%');
        }

        $tps = $tps->paginate(10);
        return new MstTpsCollection($tps);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'desa_id' => 'required|exists:mst_desas,id',
            'no_tps' => 'required|string',
        ]);

        try {
            MstTps::create([
                // 'desa_id' => $request->desa_id['id'],
                'desa_id' => $request->desa_id,
                'no_tps' => $request->no_tps,
            ]);
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e]);
        }
    }

    public function edit($id){
        $tps = MstTps::find($id);
        // $tps = db::table('mst_tps as a')
        //     ->leftjoin('mst_c_satus as b', 'a.id', '=', 'b.id_tps')
        //     ->select(db::raw('a.id, a.desa_id, a.no_tps'))
        //     ->where('a.id', '=', $id)
        //     ->orderby('a.created_at', 'asc')
        //     ->groupby(db::raw('a.id'))
        //     // gunakan get jika tidak memakai paginate
        //     ->get();
 
        return response()->json(['status' => 'success', 'data' => $tps]);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'desa_id' => 'required|exists:mst_desas,id',
            'no_tps' => 'required|string',
        ]);

        $tps = MstTps::find($id);
        $tps->update($request->all());
        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $tps = MstTps::find($id);
        if($tps == null){
            return response()->json(['status' => 'error'], 422);
        }

        // $cSatu = MstCSatu::where('id_tps', '=', $id);
        // if($cSatu != null){
        //     $cSatu->delete();
        // }
        $tps->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function chart($id){
        $chart = DB::table('mst_tps as a')
            ->leftJoin(DB::raw('(SELECT id_tps, COUNT(*) as jumlah_pemilih FROM mst_dpts GROUP BY id_tps) as c'),
                function($join){
                    $join->on('a.id', '=', 'c.id_tps');
                }
            )
            ->leftJoin(DB::raw('(SELECT id_tps, COUNT(*) as jumlah_konstituens FROM trx_konstituens GROUP BY id_tps) as d'),
                function($join){
                    $join->on('a.id', '=', 'd.id_tps');
                }
            )
            ->leftJoin('mst_c_satus as e', 'a.id', '=', 'e.id_tps')
            ->select(DB::raw('c.jumlah_pemilih, d.jumlah_konstituens, e.jml_suara as jumlah_suara'))
            ->where('a.id', '=', $id)
            ->groupBy(DB::raw('a.id'))
            ->get();

        return response()->json(['status' => 'success', 'data' => $chart]);
    }
}