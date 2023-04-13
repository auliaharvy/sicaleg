<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TrxKonstituenCollection;
use App\TrxKonstituen;
use DB;

class TrxKonstituenController extends Controller
{
    public function index()
    {
        // $kecamatans = MstKecamatan::orderBy('created_at', 'DESC');
        $konstituens = DB::table('trx_konstituen as a')
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
