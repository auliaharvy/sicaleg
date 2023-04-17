<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MstDesa;
use App\MstKecamatan;
use App\MstTps;

class MstKonstituen extends Model
{
    protected $guarded = [];

    public function desa(){
        return $this->belongsTo(MstDesa::class);
    }

    public function kecamatan(){
        return $this->belongsTo(MstKecamatan::class);
    }


    public function tps(){
        return $this->belongsTo(MstTps::class);
    }
}
