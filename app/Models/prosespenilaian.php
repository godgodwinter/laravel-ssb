<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class prosespenilaian extends Model
{
        public $table = "prosespenilaian";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'tgl',
            'tahunpenilaian_id',
        ];


        public function tahunpenilaian()
        {
            return $this->belongsTo('App\Models\tahunpenilaian');
        }


}
