@extends('dashboard.layouts.main')

@section('content')
    <div class="w-full h-full p-5 flex flex-col gap-2">
        <header class="w-full flex justify-between  border-b border-black gap-3 items-center text-2xl text-black">
            <div class="w-full flex gap-3 py-3">
                <a href="{{ route('admin-kelas-pengajar', ['pengajar' => $info_pengajar->id]) }}"
                    class="fa-solid fa-chevron-left max-md:text-lg text-black"></a>
                <div class="w-full flex flex-col text-xs">
                    <div class="text-sm max-sm:hidden breadcrumbs p-0">
                        <ul>
                            <li><a href="{{ route('pengajar.index') }}">Pengajar</a></li>
                            <li><a href="{{ route('pengajar.show', ['pengajar' => $info_pengajar->id]) }}">Profil
                                    Pengajar</a>
                            </li>
                            <li><a href="{{ route('admin-kelas-pengajar', ['pengajar' => $info_pengajar->id]) }}">Kelas
                                    Pengajar</a></li>
                            <li>Mata Pelajaran</li>
                        </ul>
                    </div>
                    <h1 class="text-3xl font-semibold">Kelas Industri - {{ $info_kelas->sekolah->nama }}</h1>
                    <h1 class="text-5xl font-semibold">
                        {{ $info_kelas->tingkat . ' ' . $info_kelas->jurusan . ' ' . $info_kelas->kelas }}</h1>
                </div>
            </div>
        </header>
        <div
            class="overflow-auto grid grid-rows-[repeat(auto-fit, 1fr)] grid-cols-3 max-sm:grid-cols-1 gap-5 p-5 max-sm:p-0 h-full max-md:grid-cols-1 ">
            @foreach ($info_pengajar->mapel()->paginate(8) as $mapel)
                <div class="box w-full h-56 p-2">
                    <a href="" class="w-full flex h-full bg-tosca-100 rounded-box p-5 shadow-lg flex-col">
                        <div class="w-full flex justify-between h-2/6">
                            <div class="flex justify-between items-center w-full">
                                <h1 class="text-black text-2xl font-semibold">{{ $mapel->nama_mapel }}</h1>
                                <span class="bg-black flex justify-center items-center p-2 px-2.5 rounded-circle"><i
                                        class="fa-solid fa-arrow-right text-white"></i></span>
                            </div>
                        </div>
                        <div class="w-full h-full grid grid-cols-2 gap-2 justify-between items-center text-black">
                            <img src="{{ asset('img/mapel.png') }}" alt="" class="w-full">
                        </div>
                    </a>
                    <h1 class="text-black p-1 font-semibold text-sm">Mata Pelajaran - {{ $mapel->nama_mapel }}</h1>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('script')
    <script>
        $("#filter .btn").click(function() {
            let filter = $("#filter");
            let filterOption = $("#filter-option");
            let isOpen = filter.data('toggle') == "open";

            filter.velocity({
                width: isOpen ? "auto" : "100%"
            });
            setTimeout(() => {
                filterOption.css("display", isOpen ? "none" : "flex");
            }, isOpen ? 250 : 500);

            filter.data('toggle', isOpen ? "closed" : "open");
        });
    </script>
@endsection
