<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class posisiseleksi extends Model
{
        public $table = "posisiseleksi";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'posisipemain_id',
            'tahunpenilaian_id',
        ];


        public function posisipemain()
        {
            return $this->belongsTo('App\Models\posisipemain');
        }

        public function tahunpenilaian()
        {
            return $this->belongsTo('App\Models\tahunpenilaian');
        }


}
