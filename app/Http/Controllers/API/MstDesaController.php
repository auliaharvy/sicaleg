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
            ->leftJoin('trx_konstituen as c', 'a.id', '=', 'c.id_desa')
            ->select(DB::raw('a.id, a.nama, b.nama as nama_kecamatan,b.dapil, CAST(sum(a.pemilih_pria) AS INTEGER) as pemilih_pria, CAST(sum(a.pemilih_wanita) AS INTEGER) as pemilih_wanita, 
            count(c.id) as jumlah_konstituen, sum(a.jumlah_tps) as total_tps'))
            ->orderBy('a.created_at', 'ASC')
            ->groupBy(DB::raw('a.id'));
            // ->select('a.*', 'b.nama as nama_kecamatan')
            // ->orderBy('a.created_at', 'ASC');
        if (request()->q != '') {
            $desas = $desas->where('nama', 'LIKE', '%' . request()->q . '%');
        }
        $desas = $desas->paginate(10);
        return new MstDesaCollection($desas);
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
