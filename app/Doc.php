<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Doc extends Model
{
    public function transmittal()
    {
        return $this->belongsTo('App\Transmittal', 'trans_id');
    }
}
