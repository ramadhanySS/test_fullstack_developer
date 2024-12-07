@extends('layouts.app')

@section('title', 'Tambah Pegawai')

@section('content')
    <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <select name="jabatan" id="jabatan" class="form-select">
                <option value="" selected></option>
            </select>
            @error('jabatan') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="text" id="tanggal_lahir" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
            @error('tanggal_lahir') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="file_ktp" class="form-label">Upload KTP</label>
            <input type="file" id="file_ktp" name="file_ktp" class="form-control" value="{{ old('file_ktp') }}" data-preview-file-type="image" required>
            @error('file_ktp') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form> 


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#jabatan').select2({
                placeholder: "-- Pilih Jabatan --",
                ajax: {
                    url: '/get-jabatan',
                    dataType: 'json',
                    data: function(params){
                        return {
                            search: params.term
                        }
                    },
                    processResults: function(data, params){                        
                        return {
                            results: data
                        }
                    }
                },
                allowClear: true
            });
        });
    </script>
@endsection
