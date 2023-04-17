<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MstDesa;

class MstTps extends Model
{
    protected $guarded = [];

    public function desa(){
        return $this->belongsTo(MstDesa::class);
    }
}
