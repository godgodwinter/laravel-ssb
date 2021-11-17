<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class kriteriadetail extends Model
{
        public $table = "kriteriadetail";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'kriteria_id',
            'bobot',
            'kode',
            'tipe',
            'ket',
        ];

        public function kriteria()
        {
            return $this->belongsTo('App\Models\kriteria');
        }


        public function penilaian()
        {
            return $this->hasMany('App\Models\penilaian');
        }

}
