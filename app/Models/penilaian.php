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
            'pemainseleksi_id',
            'kriteriadetail_id',
            'nilai',
            'pelatih_id',
            'ket',
        ];


        public function pemainseleksi()
        {
            return $this->belongsTo('App\Models\pemainseleksi');
        }

        public function kriteriadetail()
        {
            return $this->belongsTo('App\Models\kriteriadetail');
        }

        public function pelatih()
        {
            return $this->belongsTo('App\Models\pelatih');
        }


}
