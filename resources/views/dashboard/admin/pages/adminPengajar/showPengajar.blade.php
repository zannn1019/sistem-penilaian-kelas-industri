@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto relative "id="content">
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
                            <li>Daftar Pengajar</li>
                        </ul>
                    </div>
                    <h1 class="text-3xl font-semibold">Kelas Industri - {{ $info_kelas->sekolah->nama }}</h1>
                    <h1 class="text-5xl font-semibold">
                        {{ $info_kelas->tingkat . ' ' . $info_kelas->jurusan . ' ' . $info_kelas->kelas }}</h1>
                </div>
            </div>
        </header>
        <div class="w-full h-full grid grid-cols-4 max-sm:grid-cols-1 max-md:grid-cols-2 gap-3">
            @foreach ($data_pengajar->paginate(8) as $pengajar)
                @php
                    if (Cache::has('is_online' . $pengajar->id) && $pengajar->status == 'aktif') {
                        $is_online = true;
                        $bg = 'bg-bluesea-100';
                        $btn = 'bg-bluesea-500';
                    } else {
                        $is_online = false;
                        if ($pengajar->status == 'aktif') {
                            $bg = 'bg-tosca-100';
                            $btn = 'bg-tosca-500';
                        } else {
                            $bg = 'bg-darkblue-100';
                            $btn = 'bg-darkblue-500';
                        }
                    }
                @endphp

                <div
                    class="w-full h-fit {{ $bg }} flex p-2 rounded-box shadow-xl flex-col items-center gap-0.5 relative py-5">
                    <div class="dropdown dropdown-end absolute top-0 right-0 px-5 py-3">
                        <label tabindex="0" class="cursor-pointer">
                            <i class="fa-solid fa-ellipsis"></i>
                        </label>
                        <div tabindex="0"
                            class="dropdown-content z-[1] menu shadow bg-white rounded-box w-20 flex flex-col">
                            <a href="{{ route('pengajar.show', ['pengajar' => $pengajar->id]) }}"
                                class="p-2 hover:font-bold">Edit</a>
                            <form action="{{ route('users.destroy', $pengajar->id) }}" method="POST"
                                class="p-2 hover:font-bold">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus</button>
                            </form>
                        </div>
                    </div>
                    <div class="avatar">
                        <div class="w-20 rounded-full">
                            <img src="{{ asset('storage/pengajar/' . $pengajar->foto) }}" alt="">
                        </div>
                    </div>
                    <h1 class="font-semibold truncate w-full px-2 text-center">{{ $pengajar->nama }}</h1>
                    <span class="capitalize text-xs">
                        {!! $is_online == true
                            ? 'Mengakses : ' . '<b>' . Cache::get('at_page' . $pengajar->id) . '</b>'
                            : $pengajar->status !!}</span>
                    <div class="w-full flex flex-wrap text-center justify-evenly items-center gap-5">
                        <div>
                            <h1 class="text-xs">Sekolah</h1>
                            <span class="font-semibold">{{ $pengajar->sekolah()->groupBy('id_sekolah')->count() }}</span>
                        </div>
                        <div>
                            <h1 class="text-xs">Kelas</h1>
                            <span class="font-semibold">{{ $pengajar->kelas()->count() }}</span>
                        </div>
                        <div>
                            <h1 class="text-xs">Mapel</h1>
                            <span class="font-semibold">{{ $pengajar->mapel()->count() }}</span>
                        </div>
                    </div>
                    <div class="w-full flex justify-evenly p-2">
                        <a href="{{ route('pengajar.show', ['pengajar' => $pengajar->id]) }}"
                            class="{{ $btn }} px-3 py-1 rounded-box text-white text-xs"><i
                                class="fa-solid fa-user"></i> Profile</a>
                        <div class="dropdown bg-transparent" data-theme="light">
                            <div tabindex="0"
                                class="{{ $btn }} cursor-pointer px-3 py-1 rounded-box text-white text-xs">
                                <i class="fa-solid fa-envelope"></i> Contact
                            </div>
                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-44 ">
                                <li><a href="https://wa.me/{{ $pengajar->no_telp }}">Nomor Telepon</a></li>
                                <li><a href="mailto:{{ $pengajar->email }}">Email</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $data_pengajar->paginate(8)->links('components.pagination') }}
        <a href="{{ route('siswa.create', ['kelas' => $info_kelas->id]) }}"
            class="btn btn-circle self-end max-sm:self-start sticky"><i
                class="fa-solid fa-plus text-white text-2xl "></i></a>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#indicator").text($("#nama_kelas").val().length)
            $("#nama_kelas").keyup(function() {
                $("#indicator").text($(this).val().length)
            })
            $("#nama_kelas").keydown(function() {
                $("#indicator").text($(this).val().length)
            })

            $("#close-btn").click(function(e) {
                e.preventDefault()
                kelasModal.close()
                $("#bg-blur").addClass('hidden')
            })
        });
    </script>
@endsection
