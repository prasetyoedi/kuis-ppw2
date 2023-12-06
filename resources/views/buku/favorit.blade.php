<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buku Favorit') }}
        </h2>
    </x-slot>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <div class="container mt-4">
        <div class="row gap-4">
            @foreach($favoritedBooks as $favorit)
            <div class="col-md-3 bg-white p-6 dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div>
                    @if ($favorit->buku->filepath)
                    <img class="object-cover object-center" src="{{ $favorit->buku->filepath }}"
                        style="width: 100%; height: 400px;"><br>
                    @endif
                    <h4>{{ $favorit->buku->judul }}</h4>
                    <h6>{{ $favorit->buku->penulis }}</h6>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

