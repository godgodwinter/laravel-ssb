<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pemain extends Model
{
        public $table = "pemain";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'jk',
            'alamat',
            'telp',
            'tgllahir',
            'tgldaftar',
            'ket',
            'photo',
            'users_id',
            'tahunpenilaian_id',
        ];


    public function getPhotoAttribute($value){

        return url('storage/'.$value);
    }

    public function penilaian()
    {
        return $this->hasMany('App\Models\penilaian');
    }
    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function tahunpenilaian()
    {
        return $this->belongsTo('App\Models\tahunpenilaian');
    }

}
