@extends('dashboard.layouts.main')
@php
    $warna = collect(['tosca', 'bluesea', 'bluesky']);
@endphp
@section('content')
    <div class="absolute inset-0 backdrop-blur-lg z-10 w-full h-full hidden" id="bg-blur"></div>
    <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto relative"id="content">
        <header class="w-full flex gap-3 items-center text-2xl">
            <a href="{{ route('sekolah.index') }}" class="fa-solid fa-chevron-left max-md:text-lg text-black"></a>
            <div class="text-sm max-sm:hidden breadcrumbs">
                <ul>
                    <li><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
                    <li>{{ $data->nama }}</li>
                </ul>
            </div>
        </header>
        <div class="w-full h-full flex flex-col max-md:px-5 px-16 gap-2">
            <div class="info-sekolah flex max-md:flex-col max-md:items-center gap-5 relative w-full">
                <img src="{{ asset('storage/sekolah/' . $data->logo) }}"
                    class="w-44 h-44 z-[5] aspect-square bg-white rounded-circle border-4 border-darkblue-500"
                    alt="">
                <div class="info w-full text-center">
                    <h1 class="text-5xl font-semibold py-2 border-b border-black w-full">{{ $data->nama }}</h1>
                </div>
                <div
                    class="w-full h-1/2 rounded-box text-white p-5 flex justify-end max-md:justify-start px-16 max-md:px-0 items-center absolute bottom-0 left-0 bg-darkblue-500">
                    <a href="{{ route('sekolah.edit', ['sekolah' => $data->id]) }}"
                        class="absolute top-0 right-0 px-3 py-2"><i
                            class="fa-solid fa-pen rounded-circle border border-white p-2"></i></a>
                    <div class="data w-10/12 max-md:w-full max-md:px-5 max-md:pt-12 max-sm:pt-0 max-sm:pb-0 max-md:pb-5">
                        <div class="contact flex max-md:flex-col max-md:gap-0 gap-10 text-xs">
                            <div class="email flex gap-2 max-md:justify-start justify-center items-center">
                                <i class="fa-solid fa-envelope text-lg"></i>
                                <span><b>Email</b></span>
                                <span> | </span>
                                <span>{{ $data->email }}</span>
                            </div>
                            <div class="phone flex gap-2 max-md:justify-start justify-center items-center">
                                <i class="fa-solid fa-phone text-lg"></i>
                                <span><b>No. Telepon</b></span>
                                <span>|</span>
                                <span>{{ $data->no_telp }}</span>
                            </div>
                        </div>
                        <div class="address flex items-center gap-2 text-xs">
                            <span><i class="fa-solid fa-school text-sm"></i></span>
                            <span><b>Alamat</b></span>
                            <span>|</span>
                            <span
                                class="capitalize truncate">{{ Str::lower($data->jalan . ', ' . $data->kelurahan . ', ' . $data->kecamatan . ', ' . $data->kabupaten_kota . ', ' . $data->provinsi) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="data w-full h-full border flex flex-col border-black rounded-box">
                <div
                    class="flex justify-between bg-gray-300 gap-2 w-full rounded-box outline outline-gray-300 p-1 text-center max-sm:flex-col text-gray-500">
                    <a href="{{ route('sekolah.show', ['sekolah' => $data->id, 'data' => 'kelas']) }}"
                        class="link-hover w-full {{ Request::get('data') == 'kelas' || Request::get('data') == null ? 'bg-darkblue-500 text-white' : '' }}  p-1 rounded-box">Kelas
                        Industri
                        ({{ $data->kelas->count() }})</a>
                    <a href="{{ route('sekolah.show', ['sekolah' => $data->id, 'data' => 'pengajar']) }}"
                        class="link-hover w-full {{ Request::get('data') == 'pengajar' ? 'bg-darkblue-500 text-white' : '' }} p-1 rounded-box">Pengajar
                        ({{ $data->pengajar->count() }})</a>
                </div>
                <div class="w-full h-full flex flex-col gap-2 justify-between relative">
                    @if ($data->kelas->count() > 0)
                        <div class="w-full grid grid-cols-3 max-md:grid-cols-1">
                            @foreach ($data_kelas->paginate(3) as $kelas)
                                @php
                                    $data_warna = $warna->random();
                                @endphp
                                <div class="box w-full h-56 p-2">
                                    <a href="{{ route('kelas.show', ['kela' => $kelas->id]) }}"
                                        class="w-full flex h-full bg-{{ $data_warna }}-100 rounded-box p-5 shadow-lg flex-col items-center">
                                        <div class="w-full flex justify-between h-2/6">
                                            <div class="info">
                                                <h1 class="text-black text-xs font-semibold">{{ $kelas->sekolah->nama }}
                                                </h1>
                                                <h1 class="text-{{ $data_warna }}-500 font-bold text-2xl">
                                                    {{ $kelas->nama_kelas }}
                                                </h1>
                                            </div>
                                            <img src="{{ asset('storage/sekolah/' . $kelas->sekolah->logo) }}"
                                                alt="">
                                        </div>
                                        <div class="flex w-full text-black text-sm items-center justify-evenly gap-5">
                                            <img src="{{ asset('img/data_kelas.png') }}" alt="" class="w-36">
                                            <div class="status flex flex-col gap-1 text-xs">
                                                <h1 class="font-semibold">Semester Genap</h1>
                                                <h1 class="font-semibold">
                                                    {{ $kelas->tingkat }}-{{ $kelas->jurusan }}-{{ $kelas->kelas }}</h1>
                                                <span class="font-semibold">{{ $kelas->siswa->count() }} Siswa</span>
                                            </div>
                                        </div>
                                    </a>
                                    <h1 class="text-black px-2 py-1 font-bold text-xs">
                                        {{ $kelas->tingkat . ' ' . $kelas->jurusan . ' ' . $kelas->kelas }}-
                                        Semester Genap
                                    </h1>
                                </div>
                            @endforeach
                        </div>
                        <div class="w-full flex justify-between px-5 py-1 items-center ">
                            <a href=""
                                class="btn rounded-circle text-black bg-transparent border-none hover:bg-transparent"><i
                                    class="fa-solid fa-up-right-from-square text-xl"></i></a>
                            {{ $data_kelas->paginate(3)->links('components.pagination') }}
                            <div class="dropdown dropdown-left dropdown-end relative z-10">
                                <label id="add-btn" tabindex="0"
                                    class="btn rounded-circle text-white text-xl absolute bottom-0 right-0 z-10"><i
                                        class="fa-solid fa-plus"></i></label>
                                <ul tabindex="0"
                                    class="dropdown-content z-[1] menu p-2 shadow-box bg-white rounded-box w-64">
                                    <li class="border-b"><a onclick="kelasModal.showModal()">Tambah kelas baru</a></li>
                                    <li><a>Tambah mata pelajaran</a></li>
                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="w-full h-full flex flex-col font-semibold text-gray-300 justify-center items-center ">
                            <img src="{{ asset('img/404_kelas.png') }}" alt="" draggable="false">
                            <h1>Belum ada kelas!</h1>
                        </div>
                        <div class="w-full h-max flex justify-between px-5 py-1 items-end">
                            <a href=""
                                class="btn rounded-circle text-black bg-transparent border-none hover:bg-transparent"><i
                                    class="fa-solid fa-up-right-from-square text-xl"></i></a>
                            <div class="dropdown dropdown-left dropdown-end relative z-10">
                                <label id="add-btn" tabindex="0"
                                    class="btn rounded-circle text-white text-xl absolute bottom-0 right-0 z-10"><i
                                        class="fa-solid fa-plus"></i></label>
                                <ul tabindex="0"
                                    class="dropdown-content z-[1] menu p-2 shadow-box bg-white rounded-box w-64">
                                    <li class="border-b"><a onclick="kelasModal.showModal()">Tambah kelas baru</a></li>
                                    <li><a>Tambah mata pelajaran</a></li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <dialog id="kelasModal" class="modal">
        <form method="POST" action="{{ route('kelas.store') }}"
            class="modal-box shadow-box text-center bg-white text-black flex flex-col gap-2" data-theme="light">
            <h3 class="font-semibold text-3xl">Menambahkan Kelas</h3>
            @csrf
            <input type="hidden" name="id_sekolah" value="{{ $data->id }}">
            <div class="input-range p-3 border rounded-xl flex items-center border-black bg-gray-100">
                <input type="text" placeholder="Nama Kelas" class="border-black bg-gray-100  w-full " name="nama_kelas"
                    maxlength="25" id="nama_kelas" />
                <span class="font-normal" id="indicator">0</span>
                <span class="font-normal">/25</span>
            </div>
            <h1 class="text-start font-semibold">Informasi kelas</h1>
            <div class="w-full flex flex-wrap gap-1">
                <select class="file-input file-input-bordered border-black  flex-grow border px-2" name="tingkat">
                    <option disabled selected>Tingkat</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                </select>
                <input type="text" placeholder="Jurusan" class="input flex-grow input-bordered border-black "
                    name="jurusan" />
                <input type="text" placeholder="Kelas"
                    class="input flex-grow input-bordered border-black  uppercase placeholder:capitalize" name="kelas"
                    maxlength="1" />
            </div>
            <div class="modal-action w-full flex justify-between items-center">
                <button class="bg-gray-100 rounded-6xl py-1 px-5" id="close-btn">Batal</button>
                <button type="submit" class="bg-black text-white rounded-6xl py-1 px-5">Tambah</button>
            </div>
        </form>
    </dialog>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $("#nama_kelas").keyup(function() {
                $("#indicator").text($(this).val().length)
            })
            $("#nama_kelas").keydown(function() {
                $("#indicator").text($(this).val().length)
            })
            $("#add-btn").click(function() {
                $("#bg-blur").removeClass("hidden");
            })
            $("#bg-blur").click(function() {
                $(this).addClass("hidden");
            })
            $("#close-btn").click(function(e) {
                e.preventDefault()
                kelasModal.close()
                $("#bg-blur").addClass('hidden')
            })
        });
    </script>
@endsection
