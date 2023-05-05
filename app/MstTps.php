<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MstDesa;
use App\MstKonstituen;
use App\MstDpt;

class MstTps extends Model
{
    protected $guarded = [];

    public function desa(){
        return $this->belongsTo(MstDesa::class);
    }

    public function konstituen(){
        return $this->belongsTo(MstKonstituen::class);
    }
    
    public function dpt(){
        return $this->belongsTo(MstDpt::class);
    }
}
