<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <div class="max-w-7xl mt-5 mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 dark:bg-gray-800 shadow-sm sm:rounded-lg">
            <h4 class="text-center mb-5">Edit Buku</h4>
            <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul" value="{{ $buku->judul }}">
                        </div>
                        <div class="mb-3">
                            <label for="penulis" class="form-label">Penulis</label>
                            <input type="text" class="form-control" id="penulis" name="penulis"
                                value="{{ $buku->penulis }}">
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga" value="{{ $buku->harga }}">
                        </div>
                        <div class="mb-3">
                            <label for="tgl_terbit" class="form-label">Tgl. Terbit</label>
                            <input type="date" class="form-control" id="tgl_terbit" name="tgl_terbit"
                                value="{{ $buku->tgl_terbit }}">
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Cover Buku</label>
                            @if ($buku->filepath)
                            <img class="object-cover object-center" src="{{ $buku->filepath }}"
                                style="width: 200px; height: 200px;"><br>
                            @endif
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail"
                                value="{{ $buku->filepath }}"><br>
                        </div>
                        <label for="galeri" class="form-label">Tambah Galeri</label><br>
                        <span class="text-muted small">Anda dapat memilih lebih dari satu file</span>
                        <div class="mb-3">
                            <input type="file" class="form-control" name="galeri[]" id="galeri" multiple>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="/buku" class="btn btn-danger">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
            <div>
                @if ($buku->galeri()->count() > 0)
                <br>
                <p>Galeri:</p>
                @endif
                <div class="d-flex flex-wrap">
                    @foreach ($buku->galeri()->get() as $item)
                    <div class='m-3 d-flex flex-column align-items-center'
                        style="flex: 0 0 340px; max-width: 340px; height: 100%;">
                        <img class='object-cover object-center mb-1' src='{{ $item->path }}'
                            style="width: 100%; height: 100%;">

                        <form action="{{ route('buku.delete_galeri', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')">
                                Hapus
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>