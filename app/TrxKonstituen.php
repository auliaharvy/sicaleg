<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrxKonstituen extends Model
{
    protected $guarded = [];

    public function kecamatan()
    {
        return $this->belongsTo(MstKecamatan::class);
    }

    public function desa()
    {
        return $this->belongsTo(MstDesa::class);
    }
    
    public function tps()
    {
        return $this->belongsTo(MstTps::class);
    }
}
