<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Daftar Buku</title>
</head>

<body>
    <div class="container" style="padding: 20px;">
        @if(Session::has('pesan'))
        <div class="alert alert-success">{{Session::get('pesan')}}</div>
        @endif

        @if(Session::has('pesanDelete'))
        <div class="alert alert-danger">{{Session::get('pesanDelete')}}</div>
        @endif
        <form action="{{ route('buku.search')}}" method="get">
            @csrf
            <input type="text" name="kata" class="form-control" placeholder="cari...."
                style="width: 30%; display: inline; margin-top: 10px; margin-bottom: 10px; float:right;">
        </form>
        @if(Auth::check() && Auth::user()->level == 'admin')
        <a href="{{ route('buku.create')}}" class="btn btn-primary">Tambah Buku</a>
        @endif
        <table class="table my-3">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Cover</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Rating</th>
                    <th>Harga</th>
                    <th>Tgl. Terbit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data_buku as $buku)
                <tr>
                    <th scope="row">{{ ($data_buku->currentPage() - 1) * $data_buku->perPage() + $loop->index + 1 }}
                    </th>
                    <td>
                        @if ( $buku->filepath )
                        <div class="relative h-10 w-10">
                            <img class="h-full w-full object-cover object-center" src="{{ asset($buku->filepath)}}" />
                        </div>
                        @endif
                    </td>
                    <td>{{ $buku->judul }}</td>
                    <td>{{ $buku->penulis }}</td>
                    <td><span style="color:orange;">★</span>
                        @php
                        $averageRating = $buku->rating()->avg('rating');
                        @endphp
                        @if ($averageRating !== null)
                        {{ number_format($averageRating, 1) }}
                        @else
                        <span style="color:grey;">Belum Dirating</span>
                        @endif
                    </td>
                    <td>{{ "Rp ".number_format($buku->harga, 2, ',', '.') }}</td>
                    <td>{{ $buku->tgl_terbit->format('d/m/Y') }}</td>
                    <td class="d-flex">
                        <form action="{{ route('buku.destroy', $buku->id) }}" method="post">
                            @csrf
                            @if(Auth::check() && Auth::user()->level == 'admin')
                            @method('DELETE')
                            <a class="btn btn-outline-primary me-1" href="{{ route('buku.edit', $buku->id) }}">Edit</a>
                            <button type="submit" class="btn btn-outline-danger"
                                onclick="return confirmDelete('{{ $buku->judul }}')">Delete</button>
                            @endif
                            <a class="btn btn-outline-success" href="{{ route('galeri.buku', $buku->id) }}">Detail</a>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $data_buku->links() }}
        </div>
        <!-- <div class="d-flex gap-5">
            <p><b>Jumlah Buku :</b> {{$jumlah_buku}}</p>
            <p><b>Total Harga :</b> {{ "Rp ".number_format($total, 2, ',', '.') }}</p>
        </div> -->
    </div>

    <script>
        function confirmDelete(judul) {
            var result = confirm("Are you sure you want to delete '" + judul + "'?");
            return result;
        }
    </script>
</body>

</html>