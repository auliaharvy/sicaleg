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
        $desas = DB::table('mst_desas as a')
        ->leftJoin('mst_kecamatans as b', 'a.id_kecamatan', '=', 'b.id')
        ->leftJoin('trx_konstituens as c', 'a.id', '=', 'c.id_desa')
        ->select(DB::raw('a.id, a.nama, b.nama as nama_kecamatan,b.dapil, CAST(sum(a.pemilih_pria) AS INTEGER) as pemilih_pria, CAST(sum(a.pemilih_wanita) AS INTEGER) as pemilih_wanita, 
        count(c.id) as jumlah_konstituen, sum(a.jumlah_tps) as total_tps'))
        ->orderBy('a.created_at', 'ASC')
        ->groupBy(DB::raw('a.id'))->get();
        return $desas;
    }

    public function exportData(Request $request)
    {
        $transaction = $this->chart();
        return Excel::download(new TransactionExport($transaction, request()->month, request()->year), 'transaction.xlsx');
    }
}
