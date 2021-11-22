<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class penilaianhasil extends Model
{
        public $table = "penilaianhasil";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'pemainseleksi_id',
            'posisiseleksi_id',
            'total',
        ];


        public function pemainseleksi()
        {
            return $this->belongsTo('App\Models\pemainseleksi');
        }

        public function posisiseleksi()
        {
            return $this->belongsTo('App\Models\posisiseleksi');
        }



}
