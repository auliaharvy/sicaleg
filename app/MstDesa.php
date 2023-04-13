<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MstDesa extends Model
{
    protected $guarded = [];

    public function kecamatan()
    {
        return $this->belongsTo(MstKecamatan::class);
    }
}
