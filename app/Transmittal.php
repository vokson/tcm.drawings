<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transmittal extends Model
{
    public function docs()
    {
        return $this->hasMany('App\Doc', 'trans_id');
    }
}
