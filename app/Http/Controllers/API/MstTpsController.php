<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MstTps;
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
            ->leftJoin('trx_konstituens as c', 'a.id', '=', 'c.id_tps')
            ->select(DB::raw('a.id, b.nama as nama_desa, a.jml_pemilih, a.no_tps, count(c.id) as jumlah_konstituen'))
            ->orderBy('a.created_at', 'ASC')
            ->groupBy(DB::raw('a.id'));
            // ->select('a.*', 'b.nama as nama_tps')
            // ->orderBy('a.created_at', 'ASC');

        if (request()->q != '') {
            $tps = $tps->where('nama', 'LIKE', '%' . request()->q . '%');
        }

        $tps = $tps->paginate(10);
        return new MstTpsCollection($tps);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'desa_id' => 'required',
            'no_tps' => 'required|integer',
            'jml_pemilih' => 'required|string|max:100',
        ]);

        try {
            MstTps::create([
                // 'desa_id' => $request->desa_id['id'],
                'desa_id' => $request->desa_id,
                'no_tps' => $request->no_tps,
                'jml_pemilih' => $request->jml_pemilih,
            ]);
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e]);
        }
    }

    public function edit($id){
        $tps = MstTps::find($id);
        // $tps = DB::table('mst_tps as a')
        //     ->leftJoin('mst_desas as b', 'a.desa_id', '=', 'b.id')
        //     ->select(DB::raw('a.id, b.nama as nama_desa, a.no_tps, a.jml_pemilih'))
        //     ->orderBy('a.created_at', 'ASC')
        //     ->groupBy(DB::raw('a.id'));
 
        return response()->json(['status' => 'success', 'data' => $tps]);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'desa_id' => 'required',
            'no_tps' => 'required|string',
            'jml_pemilih' => 'required|integer'
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

        $tps->delete();
        return response()->json(['status' => 'success'], 200);
    }
}