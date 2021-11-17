<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pelatih extends Model
{
        public $table = "pelatih";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'jk',
            'alamat',
            'telp',
            'tgllahir',
            'ket',
            'spesialis',
            'photo',
        ];


    public function getPhotoAttribute($value){

        return url('storage/'.$value);
    }

    public function penilaian()
    {
        return $this->hasMany('App\Models\penilaian');
    }

}
