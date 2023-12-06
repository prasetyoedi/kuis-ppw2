<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <div class="max-w-7xl mt-5 mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <h4 class="text-center mb-5">Tambah Buku</h4>
            @if (count($errors) > 0)
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            @endif
            <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul">
                        </div>
                        <div class="mb-3">
                            <label for="penulis" class="form-label">Penulis</label>
                            <input type="text" class="form-control" id="penulis" name="penulis">
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga">
                        </div>
                        <div class="mb-3">
                            <label for="tgl_terbit" class="form-label">Tgl. Terbit</label>
                            <input type="date" class="date form-control" id="tgl_terbit" name="tgl_terbit">
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Cover Buku</label>
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail"><br>
                        </div>
                        <div class="mb-3">
                            <label for="galeri" class="form-label">Tambah Galeri</label><br>
                            <span class="text-muted small">Anda dapat memilih lebih dari satu file</span>
                            <input type="file" class="form-control" name="galeri[]" id="galeri" multiple>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="/buku" class="btn btn-danger">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>