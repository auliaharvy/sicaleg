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
            ->leftJoin('trx_konstituen as c', 'b.id', '=', 'c.id_desa')
            ->select(DB::raw('a.id, a.nama, a.dapil, CAST(sum(b.pemilih_pria) AS INTEGER) as pemilih_pria, CAST(sum(b.pemilih_wanita) AS INTEGER) as pemilih_wanita, 
            count(c.id) as jumlah_konstituen, sum(b.jumlah_tps) as total_tps'))
            ->orderBy('a.created_at', 'ASC')
            ->groupBy(DB::raw('a.id'));
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
