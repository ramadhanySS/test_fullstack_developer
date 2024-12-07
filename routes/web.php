<?php

use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;

Route::resource('pegawai', PegawaiController::class);
Route::get('/get-jabatan', [PegawaiController::class, 'getJabatan']);
Route::get('/pegawai/download-file/{nama_file}', [PegawaiController::class, 'downloadFile']);

// Route::get('/', function () {
//     return view('pegawai.index');
// });
