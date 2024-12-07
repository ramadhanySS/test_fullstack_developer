@extends('layouts.app')

@section('title', 'Daftar Pegawai')

@section('content')
    <a href="{{ route('pegawai.create') }}" class="btn btn-primary m-3">Tambah Pegawai</a>

    <form action="{{ route('pegawai.index') }}" method="GET" class="my-3">
        <div class="row">
            <div class="col">
                <input type="text" name="date_range" id="daterange" class="form-control" placeholder="Pilih Tanggal">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-secondary">Cari</button>
            </div>
        </div>
        
    
    </form>
    
    <div class="table-responsive">
        <table id="pegawai-table" class="table table-hover table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Tanggal Lahir</th>
                    <th>Email</th>
                    <th>KTP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pegawais as $pegawai)
                    <tr>
                        <td>{{ $pegawai->name }}</td>
                        <td>{{ $pegawai->jabatan }}</td>
                        <td>{{ $pegawai->tanggal_lahir }}</td>
                        <td>{{ $pegawai->email }}</td>
                        <td>
                            <a href="/pegawai/download-file/{{ $pegawai->file_ktp }}" class="text-black text-hover-primary">{{ $pegawai->file_ktp }}</a>
                        </td>
                        <td>
                            <a href="{{ route('pegawai.edit', $pegawai) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('pegawai.destroy', $pegawai) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pegawai ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Tidak ada pegawai ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
