<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="{{ asset('dist/css/lightbox.min.css') }}" rel="stylesheet">

    <div class="max-w-7xl mt-3 mx-auto sm:px-6 lg:px-8 pb-5">
        <div class="row">
            @if(Session::has('pesan'))
            <div class="alert alert-success">{{Session::get('pesan')}}</div>
            @endif
            @if(Session::has('error'))
            <div class="alert alert-danger">{{Session::get('error')}}</div>
            @endif
        </div>
        <div class="bg-white p-6 dark:bg-gray-800 shadow-sm sm:rounded-lg row">
            <div class="col-md-4">
                <a href="{{ asset($buku->filepath)}}" data-lightbox="image-1">
                    @if ($buku->filepath)
                    <img class="object-cover object-center" src="{{ $buku->filepath }}"
                        style="width: 80%; height: 270px;"><br>
                    @endif
                </a>
            </div>
            <div class="col-md-4">
                <h4 class="text-center">Detail Buku</h4><br>
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row">Judul</th>
                            <td>{{$buku->judul}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Penulis</th>
                            <td>{{$buku->penulis}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Harga</th>
                            <td>{{$buku->harga}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Rating</th>
                            <td><span style="color:orange;">★</span>
                                {{ $AR }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Terbit</th>
                            <td>2{{$buku->tgl_terbit}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                @if(Auth::check() && Auth::user()->level == 'user' || Auth::user()->level == 'admin')
                <h6><b>Rating buku ini</b></h6>
                <form action="{{ route('ratings.store', $buku->id) }}" method="POST" class="mb-3">
                    @csrf
                    <select name="rating" id="rating" style="border:none; color:orange;">
                        <option value="1">★</option>
                        <option value="2">★★</option>
                        <option value="3" selected>★★★</option>
                        <option value="4">★★★★</option>
                        <option value="5">★★★★★</option>
                    </select>
                    <input type="submit" class="btn btn-warning mb-3" value="Rate">

                    <a class="btn btn-primary mt-5" style="width:80%;" href="{{ route('favorit.store', $buku->id) }}">
                        Add Favourite
                    </a>
                </form>
                @endif
            </div>
        </div>
        <div class="bg-white p-6 dark:bg-gray-800 shadow-sm sm:rounded-lg row mt-3">
            <h4>Galeri</h4><br>
            <div class="row">
                @foreach ($buku->galeri()->get() as $item)
                <div class="col-md-3">
                    <a href="{{ asset($item->path)}}" data-lightbox="image-1" class="mb-4">
                        <img class='object-cover object-center mb-4' src='{{ $item->path }}'
                            style="width: 100%; height: 240px;">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <script src="{{ asset('dist/js/lightbox-plus-jquery.min.js') }}"></script>
</x-app-layout>