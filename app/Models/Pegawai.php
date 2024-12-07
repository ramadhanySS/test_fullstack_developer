<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = ['name','jabatan','tanggal_lahir','email','file_ktp'];

    protected $table = 'pegawais';
}
