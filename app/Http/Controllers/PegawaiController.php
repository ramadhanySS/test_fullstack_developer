<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $dateRange = $request->input('date_range');
        try {
            $pegawais = Pegawai::query()->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('jabatan', 'like', '%' . $search . '%');
            })->when($dateRange, function ($query, $dateRange) {
                $dates = explode(' - ', $dateRange);
                if (count($dates) == 6) {
                    try {
                        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $dates[0])->startOfDay();
                        $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $dates[1])->endOfDay();
                        return $query->whereBetween('tanggal_lahir', [$startDate, $endDate]);
                    } catch (\Exception $e) {
                        return redirect()->route('pegawai.index')->withErrors('Tanggal atau nama pegawai tidak ditemukan');
                    }
                }
            })
                ->orderBy('name')
                ->get();
        } catch (\Exception $e) {
            return redirect()->route('pegawai.index')->withErrors('Terjadi kesalahan saat memuat data.');
        }

        $request->validate([
            'search' => 'nullable|string|max:255',
            'date_range' => ['nullable', 'regex:/^\d{4}-\d{2}-\d{2} - \d{4}-\d{2}-\d{2}$/'],
        ]);

        return view('pegawai.index', compact('pegawais', 'search', 'dateRange'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|email|unique:pegawais,email',
            'file_ktp' => 'required|file|mimes:jpg,jpeg,pdf,png',
        ]);

        if($request->hasFile("file_ktp")){
            $file = $request->file('file_ktp');
            $file_name = time() . '_' . $file->getClientOriginalName();
            
            $file->move(storage_path('files'), $file_name);
        };
        $pegawai = new Pegawai();
        $pegawai->name = $request->get("name");
        $pegawai->jabatan = $request->get('jabatan');
        $pegawai->email = $request->get('email');
        $pegawai->tanggal_lahir = $request->get('tanggal_lahir');
        $pegawai->file_ktp = $file_name;
        $pegawai->save();
        
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        return view('pegawai.edit', compact('pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|email|unique:pegawais,email,' . $pegawai->id,
            'file_ktp' => 'file|mimes:jpg,jpeg,pdf,png|max:2048',
        ]);

        if($request->hasFile("file_ktp")){
            $file = $request->file('file_ktp');
            $file_name = time() . '_' . $file->getClientOriginalName();
            
            $file->move(storage_path('files'), $file_name);
            $pegawai->file_ktp = $file_name;
        };

        $pegawai->name = $request->get("name");

        $pegawai->jabatan = $request->get('jabatan');

        $pegawai->email = $request->get('email');

        $pegawai->tanggal_lahir = $request->get('tanggal_lahir');

        


        $pegawai->save();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasi diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasi dihapus!');
    }

    public function downloadFile($file_name)
    {
        return response()->download(storage_path('files/'.$file_name));
    }

    public function getJabatan(Request $request)
{
    $search = $request->input('search');
    $jabatans = [
        'Chief',
        'Manager',
        'Supervisor',
        'Staff',
        'Outsource'
    ];

    $jabatans = collect($jabatans)->filter(function ($item) use ($search) {
        return str_contains(strtolower($item), strtolower($search));
    })->map(function ($item) {
        return ['id' => $item, 'text' => $item];
    })->values();

    return response()->json($jabatans);
}

}
