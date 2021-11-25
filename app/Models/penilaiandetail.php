<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class penilaian extends Model
{
        public $table = "penilaian";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'penilaian_id',
            'nama',
            'nilai',
        ];


        public function penilaian()
        {
            return $this->belongsTo('App\Models\penilaian');
        }



}
