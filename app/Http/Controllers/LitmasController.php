<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Litmas;

class LitmasController extends Controller
{
    private $listProdi = [
        'D4 - Gizi dan Dietetika',
        'D4 - Promosi Kesehatan',
        'D3 - Gizi',
        'D3 - Sanitasi',
        'D3 - Teknologi Laboratorium Medis',
        'D4 - Keperawatan',
        'D3 - Keperawatan',
        'D3 - Keperawatan (Kampus Curup)',
        'Profesi - Pendidikan Profesi Ners',
        'D4 - Kebidanan',
        'D3 - Kebidanan',
        'D3 - Kebidanan (Kampus Curup)',
        'Profesi - Pendidikan Profesi Bidan',
        'D3 - Farmasi',
    ];

    // Daftar data Litmas
    public function index()
    {
        $query = Litmas::query();
        if (auth()->user()->role === 'ketua_pelaksana') {
            $query->where('user_id', auth()->id());
        }
        $litmas = $query->orderBy('tahun', 'desc')->get();
        return view('litmas.index', compact('litmas'));
    }

    // Form tambah Litmas
    public function create()
    {
        $prodis = $this->listProdi;
        return view('litmas.create', compact('prodis'));
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
        $data = $request->all();
        $data['user_id'] = auth()->id(); // User pemilik data
        Litmas::create($data);
        return redirect()->route('litmas.index')->with('success', 'Data Litmas berhasil disimpan!');
    }

    // Form edit data
    public function edit($id)
    {
        $litmas = Litmas::findOrFail($id);
        if (auth()->user()->role === 'ketua_pelaksana' && $litmas->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak');
        }
        $prodis = $this->listProdi;
        return view('litmas.edit', compact('litmas', 'prodis'));
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
        if (auth()->user()->role === 'ketua_pelaksana' && $litmas->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak');
        }
        $litmas->update($request->all());
        return redirect()->route('litmas.index')->with('success', 'Data Litmas berhasil diupdate!');
    }

    // Hapus data
    public function destroy($id)
    {
        $litmas = Litmas::findOrFail($id);
        if (auth()->user()->role === 'ketua_pelaksana' && $litmas->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak');
        }
        $litmas->delete();
        return redirect()->route('litmas.index')->with('success', 'Data Litmas dihapus!');
    }

    // Form input/upload capaian luaran
    public function editLuaran($id)
    {
        $litmas = Litmas::findOrFail($id);
        if (auth()->user()->role === 'ketua_pelaksana' && $litmas->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak');
        }
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
        if (auth()->user()->role === 'ketua_pelaksana' && $litmas->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak');
        }

        if ($request->hasFile('luaran_file')) {
            $path = $request->file('luaran_file')->store('luaran', 'public');
            $litmas->luaran_file = $path;
        }
        if ($request->luaran_link) {
            $litmas->luaran_link = $request->luaran_link;
        }
        $litmas->status = 'Menunggu Verifikasi';
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
        if (auth()->user()->role === 'ketua_pelaksana') {
            $query->where('user_id', auth()->id());
        }
        if ($status) $query->where('status', $status);
        if ($prodi) $query->where('prodi', 'like', "%$prodi%");
        if ($tahun) $query->where('tahun', $tahun);

        $litmas = $query->orderBy('tahun', 'desc')->get();
        $prodis = Litmas::select('prodi')->distinct()->pluck('prodi');
        $tahuns = Litmas::select('tahun')->distinct()->pluck('tahun');
        $statuses = ['Belum Tercapai', 'Menunggu Verifikasi', 'Tercapai', 'Revisi', 'Ditolak'];
        return view('litmas.monitoring', compact('litmas', 'prodis', 'tahuns', 'statuses', 'status', 'prodi', 'tahun'));
    }

    // Dashboard Statistik Grafik
    public function dashboard()
    {
        $rekapStatus = Litmas::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $rekapProdi = Litmas::select('prodi', \DB::raw('count(*) as total'))
            ->groupBy('prodi')
            ->pluck('total', 'prodi');

        $rekapTahun = Litmas::select('tahun', \DB::raw('count(*) as total'))
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->pluck('total', 'tahun');

        return view('litmas.dashboard', compact('rekapStatus', 'rekapProdi', 'rekapTahun'));
    }

    // Verifikasi (oleh PPM)
    public function verifikasi(Request $request, $id)
    {
        $action = $request->input('action');
        $allowed = ['Tercapai', 'Revisi', 'Ditolak'];
        if (!in_array($action, $allowed)) {
            return back()->with('error', 'Aksi tidak valid!');
        }

        $litmas = Litmas::findOrFail($id);
        $litmas->status = $action;
        $litmas->save();

        return back()->with('success', 'Status capaian berhasil diubah menjadi: ' . $action);
    }
}
