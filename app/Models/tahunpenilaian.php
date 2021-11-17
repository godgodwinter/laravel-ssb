<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tahunpenilaian extends Model
{
        public $table = "tahunpenilaian";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'status',
            'ket',
        ];


        public function penilaian()
        {
            return $this->hasMany('App\Models\penilaian');
        }


}
