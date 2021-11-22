<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class posisiseleksidetail extends Model
{
        public $table = "posisiseleksidetail";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'posisiseleksi_id',
            'kriteriadetail_id',
        ];


        public function posisiseleksi()
        {
            return $this->belongsTo('App\Models\posisiseleksi');
        }

        public function kriteriadetail()
        {
            return $this->belongsTo('App\Models\kriteriadetail');
        }


}
