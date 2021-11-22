<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pemainseleksi extends Model
{
        public $table = "pemainseleksi";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'pemain_id',
            'tahunpenilaian_id',
        ];


        public function pemain()
        {
            return $this->belongsTo('App\Models\pemain');
        }

        public function tahunpenilaian()
        {
            return $this->belongsTo('App\Models\tahunpenilaian');
        }


}
