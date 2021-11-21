<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class posisipemain extends Model
{
        public $table = "posisipemain";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'kode',
        ];



}
