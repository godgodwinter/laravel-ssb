<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class kriteria extends Model
{
        public $table = "kriteria";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'bobot',
            'kode',
            'tipe',
            'ket',
            'tahunpenilaian_id',
        ];

        public function kriteria()
        {
            return $this->hasMany('App\Models\kriteria');
        }
        public function tahunpenilaian()
        {
            return $this->belongsTo('App\Models\tahunpenilaian');
        }


}
