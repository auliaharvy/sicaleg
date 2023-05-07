<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Transaction;
use DB;
use Excel;
use App\Exports\TransactionExport;

class DashboardController extends Controller
{
    public function chart()
    {
        $filter = request()->year . '-' . request()->month;
        $parse = Carbon::parse($filter);
        $array_date = range($parse->startOfMonth()->format('d'), $parse->endOfMonth()->format('d'));
        $transaction = Transaction::select(DB::raw('date(created_at) as date,sum(amount) as total'))
            ->where('created_at', 'LIKE', '%' . $filter . '%')
            ->groupBy(DB::raw('date(created_at)'))->get();
        
        $data = [];
        foreach ($array_date as $row) {
            $f_date = strlen($row) == 1 ? 0 . $row:$row;
            $date = $filter . '-' . $f_date;
            $total = $transaction->firstWhere('date', $date);

            $data[] = [
                'date' =>$date,
                'total' => $total ? $total->total:0
            ];
        }
        return $data;
    }

    public function chartDesa()
    {
        // $desas = DB::table('mst_desas as a')
        // ->leftJoin('mst_kecamatans as b', 'a.id_kecamatan', '=', 'b.id')
        // ->leftJoin('trx_konstituens as c', 'a.id', '=', 'c.id_desa')
        // ->select(DB::raw('a.id, a.nama, b.nama as nama_kecamatan, b.dapil, CAST(sum(a.pemilih_pria) AS INTEGER) as pemilih_pria, CAST(sum(a.pemilih_wanita) AS INTEGER) as pemilih_wanita, 
        // count(c.id) as jumlah_konstituen, sum(a.jumlah_tps) as total_tps'))
        // ->orderBy('a.created_at', 'ASC')
        // ->groupBy(DB::raw('a.id'))->get();
        // return $desas;
       $desas = DB::table('mst_desas as a')
           ->leftJoin('mst_tps as b', 'a.id', '=', 'b.desa_id')
           ->leftJoin(DB::raw('(SELECT id_desa, COUNT(*) as jumlah_konstituen FROM trx_konstituens GROUP BY id_desa) as c'),
                    function($join){
                        $join->on('a.id', '=', 'c.id_desa');
                    }
                )
            ->leftJoin(DB::raw('(SELECT id_tps, jenis_kelamin, 
                CAST(SUM(CASE WHEN jenis_kelamin = "pria" THEN 1 ELSE 0 END) AS INTEGER ) as pria, 
                CAST(SUM(CASE WHEN jenis_kelamin = "wanita" THEN 1 ELSE 0 END) AS INTEGER ) as wanita 
                FROM mst_dpts GROUP BY id_tps) as d'),
                    function($join){
                        $join->on('b.id', '=', 'd.id_tps');
                    }
                )
            ->select(DB::raw('a.id, a.nama, CAST(SUM(d.pria) AS INTEGER) as pemilih_pria, CAST(SUM(d.wanita) AS INTEGER) as pemilih_wanita, CAST(COUNT(c.jumlah_konstituen) AS INTEGER) as jumlah_konstituen'))
            // ->select(DB::raw('a.id, a.nama, a.dapil, CAST(COUNT(d.jumlah_konstituen) AS INTEGER) AS jumlah_konstituen, CAST(COUNT(e.jumlah_tps) AS INTEGER) AS total_tps, CAST(SUM(f.pria) AS INTEGER) as pemilih_pria, CAST(SUM(f.wanita) AS INTEGER) as pemilih_wanita'))
            ->groupBy('a.id')
            ->get();
 
        return response()->json(['status' => 'success', 'data' => $desas]);
    }

    public function exportData(Request $request)
    {
        $transaction = $this->chart();
        return Excel::download(new TransactionExport($transaction, request()->month, request()->year), 'transaction.xlsx');
    }
}
