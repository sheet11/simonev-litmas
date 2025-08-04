<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Litmas;

class LitmasController extends Controller
{
    // Tampilkan daftar data litmas
    public function index()
    {
        $litmas = Litmas::orderBy('tahun', 'desc')->get();
        return view('litmas.index', compact('litmas'));
    }

    // Tampilkan form tambah data litmas
    public function create()
    {
        return view('litmas.create');
    }

    // Proses simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'tahun' => 'required|numeric|min:2000|max:2100',
            'ketua' => 'required|string',
            'prodi' => 'required|string',
        ]);
        Litmas::create($request->all());
        return redirect()->route('litmas.index')->with('success', 'Data Litmas berhasil disimpan!');
    }

    // Tampilkan form edit data
    public function edit($id)
    {
        $litmas = Litmas::findOrFail($id);
        return view('litmas.edit', compact('litmas'));
    }

    // Proses update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string',
            'tahun' => 'required|numeric|min:2000|max:2100',
            'ketua' => 'required|string',
            'prodi' => 'required|string',
        ]);
        $litmas = Litmas::findOrFail($id);
        $litmas->update($request->all());
        return redirect()->route('litmas.index')->with('success', 'Data Litmas berhasil diupdate!');
    }

    // Hapus data
    public function destroy($id)
    {
        $litmas = Litmas::findOrFail($id);
        $litmas->delete();
        return redirect()->route('litmas.index')->with('success', 'Data Litmas dihapus!');
    }

    // Tampilkan form input/upload capaian luaran
    public function editLuaran($id)
    {
        $litmas = Litmas::findOrFail($id);
        return view('litmas.edit_luaran', compact('litmas'));
    }

    // Simpan capaian luaran
    public function updateLuaran(Request $request, $id)
    {
        $request->validate([
            'luaran_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'luaran_link' => 'nullable|string|max:255',
        ]);
        $litmas = Litmas::findOrFail($id);

        if ($request->hasFile('luaran_file')) {
            $path = $request->file('luaran_file')->store('luaran', 'public');
            $litmas->luaran_file = $path;
        }
        if ($request->luaran_link) {
            $litmas->luaran_link = $request->luaran_link;
        }
        $litmas->status = 'Menunggu Verifikasi'; // atau 'Proses Verifikasi'
        $litmas->save();

        return redirect()->route('litmas.index')->with('success', 'Capaian luaran berhasil dilaporkan!');
    }

    // Monitoring, filter, dan rekap data untuk PPM/Kaprodi
    public function monitoring(Request $request)
    {
        $status = $request->input('status');
        $prodi = $request->input('prodi');
        $tahun = $request->input('tahun');

        $query = Litmas::query();
        if ($status) $query->where('status', $status);
        if ($prodi) $query->where('prodi', 'like', "%$prodi%");
        if ($tahun) $query->where('tahun', $tahun);

        $litmas = $query->orderBy('tahun', 'desc')->get();
        $prodis = Litmas::select('prodi')->distinct()->pluck('prodi');
        $tahuns = Litmas::select('tahun')->distinct()->pluck('tahun');
        $statuses = ['Belum Tercapai', 'Tercapai', 'Revisi', 'Ditolak'];

        return view('litmas.monitoring', compact('litmas', 'prodis', 'tahuns', 'statuses', 'status', 'prodi', 'tahun'));
    }
     

// Method Dasboard
public function dashboard()
{
    $rekapStatus = \App\Models\Litmas::select('status', \DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status');

    $rekapProdi = \App\Models\Litmas::select('prodi', \DB::raw('count(*) as total'))
        ->groupBy('prodi')
        ->pluck('total', 'prodi');

    $rekapTahun = \App\Models\Litmas::select('tahun', \DB::raw('count(*) as total'))
        ->groupBy('tahun')
        ->orderBy('tahun')
        ->pluck('total', 'tahun');

    return view('litmas.dashboard', compact('rekapStatus', 'rekapProdi', 'rekapTahun'));
}


 // Verifikasi 
public function verifikasi(Request $request, $id)
{
    $action = $request->input('action');
    $allowed = ['Tercapai', 'Revisi', 'Ditolak'];
    if (!in_array($action, $allowed)) {
        return back()->with('error', 'Aksi tidak valid!');
    }

    $litmas = \App\Models\Litmas::findOrFail($id);
    $litmas->status = $action;
    $litmas->save();

    return back()->with('success', 'Status capaian berhasil diubah menjadi: ' . $action);
}

}
