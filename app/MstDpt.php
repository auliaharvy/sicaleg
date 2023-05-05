<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MstTps;

class MstDpt extends Model
{
    protected $guarded = [];

    public function tps(){
        return $this->belongsTo(MstTps::class);
    }
}
