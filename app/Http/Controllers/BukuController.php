<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Galeri;
use App\Models\Rating;
use App\Models\Favorit;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class BukuController extends Controller
{
    public function index()
    {
        $batas = 5;
        $data_buku = Buku::orderBy('id', 'desc')->paginate($batas);
        $jumlah_buku = Buku::count();
        $total = Buku::sum('harga');


        return view('dashboard', compact('data_buku', 'jumlah_buku', 'total'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {

        $fileName = 'default_thumbnail.png';
        $filePath = 'uploads/default_thumbnail.png';
        if ($request->hasFile('thumbnail')) {
            $request->validate([
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);
            $fileName = time() . '_' . $request->thumbnail->getClientOriginalName();
            $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');
            Image::make(storage_path() . '/app/public/uploads/' . $fileName)->fit(240, 320)->save();
        }
        $buku = Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'harga' => $request->harga,
            'tgl_terbit' => $request->tgl_terbit,
            'filename' => $fileName,
            'filepath' => '/storage/' . $filePath
        ]);

        if ($request->file('galeri')) {
            foreach ($request->file('galeri') as $key => $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
                $galeri = Galeri::create([
                    'nama_galeri' => $fileName,
                    'path' => '/storage/' . $filePath,
                    'foto' => $fileName,
                    'buku_id' => $buku->id
                ]);
            }
        }
        return redirect('/buku')->with('pesan', 'Data Buku Berhasil Disimpan!');
    }

    public function destroy($id)
    {
        $buku = Buku::find($id);
        $buku->delete();
        return redirect('/buku')->with('pesanDelete', 'Data buku berhasil di hapus');
    }

    public function galeriDestroy($id)
    {
        $galeri = Galeri::find($id);
        $galeri->delete();
        return redirect()->back()->with('pesan', 'Gambar Galeri Berhasil Dihapus!');
    }

    public function edit($id)
    {
        $buku = Buku::find($id);
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, string $id)
    {
        $buku = Buku::find($id);

        if ($request->hasFile('thumbnail')) {
            $request->validate([
                'thumbnail' => 'image|mimes:jpeg,jpg,png|max:2048'
            ]);

            $fileName = time() . '_' . $request->thumbnail->getClientOriginalName();
            $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');

            Image::make(storage_path() . '/app/public/uploads/' . $fileName)
                ->fit(480, 640)
                ->save();
            $buku->update([
                'judul' => $request->nama,
                'penulis' => $request->penulis,
                'harga' => $request->harga,
                'tgl_terbit' => $request->tgl_terbit,
                'filename' => $fileName,
                'filepath' => '/storage/' . $filePath
            ]);

        }

        $buku->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'harga' => $request->harga,
            'tgl_terbit' => $request->tgl_terbit,
        ]);

        if ($request->file('galeri')) {
            foreach ($request->file('galeri') as $key => $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                $galeri = Galeri::create([
                    'nama_galeri' => $fileName,
                    'path' => '/storage/' . $filePath,
                    'foto' => $fileName,
                    'buku_id' => $id
                ]);
            }
        }

        return redirect('/buku')->with('pesan', 'Data buku berhasil di edit');
        ;
    }

    public function search(Request $request)
    {
        $batas = 5;
        $cari = $request->kata;
        $data_buku = Buku::where('judul', 'like', "%" . $cari . "%")->orwhere('penulis', 'like', "%" . $cari . "%")->paginate($batas);
        $jumlah_buku = $data_buku->count();
        $total = Buku::sum('harga');
        return view('buku.search', compact('jumlah_buku', 'total', 'data_buku', 'cari'));
    }

    public function galbuku($id)
    {
        $buku = Buku::find($id);

        $rating = Rating::where('buku_id', $id);

        $ratingCounts = $rating->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        $a = $ratingCounts[1] ?? 0;
        $b = $ratingCounts[2] ?? 0;
        $c = $ratingCounts[3] ?? 0;
        $d = $ratingCounts[4] ?? 0;
        $e = $ratingCounts[5] ?? 0;

        $R = Rating::where('buku_id', $id)->count();

        if ($R != 0) {
            $AR = ($a + 2 * $b + 3 * $c + 4 * $d + 5 * $e) / $R;
        } else {
            $AR = "Rating is not available";
        }
        return view('buku.detail', compact('buku', 'AR', 'R'));
    }


    public function ratingStore(Request $request, string $id)
    {
        $bukuId = $id;
        $userId = auth()->user()->id;

        $existingRating = Rating::where('user_id', $userId)
            ->where('buku_id', $bukuId)
            ->first();

        if ($existingRating) {
            return redirect()->back()->with('error', 'Anda telah memberikan rating untuk buku ini.');
        }

        Rating::updateOrCreate(
            ['user_id' => $userId, 'buku_id' => $bukuId],
            ['rating' => $request->input('rating')]
        );

        return redirect()->back()->with('pesan', 'Rating berhasil ditambahkan!');
    }

    public function favorit()
    {
        $user = auth()->user();
        $favoritedBooks = $user->favorits()->with('buku')->get();

        return view('buku.favorit', compact('favoritedBooks'));
    }

    public function favoritStore(Request $request, string $id)
    {
        $bukuId = $id;
        $userId = auth()->user()->id;

        $existingFavorit = Favorit::where('user_id', $userId)
            ->where('buku_id', $bukuId)
            ->first();

        if ($existingFavorit) {
            return redirect()->back()->with('error', 'Anda telah menambahkan favorit untuk buku ini.');
        }

        Favorit::updateOrCreate(
            ['user_id' => $userId, 'buku_id' => $bukuId]
        );

        return redirect()->back()->with('pesan', 'Favorit berhasil ditambahkan!');
    }

}
