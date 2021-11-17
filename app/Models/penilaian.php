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
            'pemain_id',
            'kriteriadetail_id',
            'nilai',
            'pelatih_id',
            'tahunpenilaian_id',
            'ket',
        ];


        public function tahunpenilaian()
        {
            return $this->belongsTo('App\Models\tahunpenilaian');
        }

        public function pemain()
        {
            return $this->belongsTo('App\Models\pemain');
        }

        public function pelatih()
        {
            return $this->belongsTo('App\Models\pelatih');
        }

        public function kriteriadetail()
        {
            return $this->belongsTo('App\Models\kriteriadetail');
        }

}
