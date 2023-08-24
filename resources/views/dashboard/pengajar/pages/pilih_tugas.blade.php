@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full p-5 flex relative" id="content">
        <div class="h-full text-3xl flex flex-col justify-between">
            <a href="{{ route('kelas') }}" class="fa-solid fa-chevron-left max-sm:text-lg text-black"></a>
            <div class="w-full max-sm:h-44">
                <div class="relative z-20 flex flex-col gap-2" id="add">
                    <div class="relative">
                        <button id="add-btn" class="btn rounded-circle text-white text-lg transition-all duration-500"><i
                                class="fa-solid fa-plus"></i></button>
                        <div id="add-content"
                            class="w-52 h-40 absolute left-0 bottom-0 hidden rounded-6xl -z-10 bg-white shadow-box text-black px-8 text-sm">
                            <div class="flex w-full h-full flex-col gap-2">
                                <button class=" border-b border-gray-400 px-2 py-3 hover:font-bold"
                                    onclick="tugas.showModal()">Tambah
                                    Tugas</button>
                                <dialog id="tugas" class="modal">
                                    <form method="POST" class="w-full modal-box bg-white flex gap-5 flex-col"
                                        data-theme="light">
                                        <h3 class="font-semibold text-2xl text-center w-full">Masukkan Nama Tugas</h3>
                                        <div class="w-full flex rounded-6xl bg-gray-300 justify-center items-center px-5"
                                            id="input-batas">
                                            <input type="text"
                                                class="bg-transparent w-full h-full p-3 rounded-6xl focus:outline-none"
                                                maxlength="30">
                                            <span class="font-semibold">0</span>
                                            <b class="font-semibold">/30</b>
                                        </div>
                                        <div class="w-full flex justify-around">
                                            <div class="px-5 cursor-pointer text-black font-semibold py-1 bg-gray-200 rounded-2xl text-xs"
                                                onclick="tugas.close()">Batal</div>
                                            <button
                                                class="px-5 text-black font-semibold py-1 bg-gray-200 rounded-2xl text-xs"
                                                type="submit">Simpan</button>
                                        </div>
                                    </form>
                                </dialog>
                                <button class=" border-b border-gray-400 px-2 py-3 hover:font-bold"
                                    onclick="kuis.showModal()">Tambah
                                    Kuis</button>
                                <dialog id="kuis" class="modal">
                                    <form method="POST" class="w-full modal-box bg-white flex gap-5 flex-col"
                                        data-theme="light">
                                        <h3 class="font-semibold text-2xl text-center w-full">Masukkan Nama Kuis</h3>
                                        <div class="w-full flex rounded-6xl bg-gray-300 justify-center items-center px-5"
                                            id="input-batas">
                                            <input type="text"
                                                class="bg-transparent w-full h-full p-3 rounded-6xl focus:outline-none"
                                                maxlength="30">
                                            <span class="font-semibold">0</span>
                                            <b class="font-semibold">/30</b>
                                        </div>
                                        <div class="w-full flex justify-around">
                                            <div class="px-5 cursor-pointer text-black font-semibold py-1 bg-gray-200 rounded-2xl text-xs"
                                                onclick="kuis.close()">Batal</div>
                                            <button
                                                class="px-5 text-black font-semibold py-1 bg-gray-200 rounded-2xl text-xs"
                                                type="submit">Simpan</button>
                                        </div>
                                    </form>
                                </dialog>
                                <button class="px-2 py-3 hover:font-bold" onclick="ujian.showModal()">Tambah
                                    Ujian</button>
                                <dialog id="ujian" class="modal">
                                    <form method="POST" class="w-full modal-box bg-white flex gap-5 flex-col"
                                        data-theme="light">
                                        <h3 class="font-semibold text-2xl text-center w-full">Masukkan Nama Ujian</h3>
                                        <div class="w-full flex rounded-6xl bg-gray-300 justify-center items-center px-5"
                                            id="input-batas">
                                            <input type="text"
                                                class="bg-transparent w-full h-full p-3 rounded-6xl focus:outline-none"
                                                maxlength="30">
                                            <span class="font-semibold">0</span>
                                            <b class="font-semibold">/30</b>
                                        </div>
                                        <div class="w-full flex justify-around">
                                            <div class="px-5 cursor-pointer text-black font-semibold py-1 bg-gray-200 rounded-2xl text-xs"
                                                onclick="ujian.close()">Batal</div>
                                            <button
                                                class="px-5 text-black font-semibold py-1 bg-gray-200 rounded-2xl text-xs"
                                                type="submit">Simpan</button>
                                        </div>
                                    </form>
                                </dialog>
                            </div>
                        </div>
                    </div>
                    <button class="btn rounded-circle text-white" onclick="arsip.showModal()"> <i
                            class="fa-solid fa-box-archive"></i></button>
                    <dialog id="arsip" class="modal">
                        <form method="POST" class="modal-box text-center" data-theme="light">
                            <h3 class="font-bold text-3xl">Arsipkan kelas?</h3>
                            <p class="py-4 text-lg">Kelas yang diarsipkan dapat dilihat dan dipulihkan kembali melalui
                                halaman
                                “Arsip Kelas”.</p>
                            <div class="modal-action flex justify-around">
                                <div class="cursor-pointer px-5 py-1 rounded-6xl bg-gray-200 text-sm text-black"
                                    onclick="arsip.close()">
                                    Batal</div>
                                <button class="px-5 py-1 rounded-6xl bg-black text-sm text-white"
                                    type="submit">Arsipkan</button>
                            </div>
                        </form>
                    </dialog>
                </div>
                <div class="absolute w-full h-full top-0 left-0 backdrop-blur-lg z-10 hidden " id="bg-blur">
                </div>
            </div>
        </div>
        <div class="w-full h-full flex flex-col pr-10 max-sm:pr-0">
            <div class="text-sm max-sm:text-xs breadcrumbs text-black ">
                <ul>
                    <li><a href="{{ route('kelas') }}">Kelas</a></li>
                    <li><a href="">Semester Genap</a></li>
                </ul>
            </div>
            <div class="w-full flex flex-col gap-3 max-sm:gap-0">
                <div class="info text-black font-bold text-4xl max-sm:text-sm">
                    <h1>Kelas Industri - {{ $kelas->sekolah->nama }}</h1>
                    <div class="w-full flex justify-between items-end">
                        <h1>{{ $kelas->tingkat . ' ' . $kelas->jurusan }}</h1>
                        <a href="" class="info-siswa text-sm font-normal flex gap-2 items-center justify-center">
                            <i class="fa-solid fa-users"></i>
                            <span>{{ $kelas->siswa->count() }} Siswa</span>
                        </a>
                    </div>
                </div>
                <hr class="border-black">
                <b class="text-black font-semibold text-sm">Ujian</b>
                <div class="grid grid-cols-4 gap-2">
                    <div class="w-full bg-tosca-100 p-5 rounded-xl shadow-lg text-black h-full flex flex-col gap-2">
                        <div class="atas w-full flex justify-between">
                            <span class="text-sm font-semibold">Penilaian Tengah Semester (PAS)</span>
                            <a href=""><i class="fa-solid fa-circle-arrow-right"></i></a>
                        </div>
                        <div class="bawah w-full h-full flex gap-10">
                            <div class="avatar w-1/2">
                                <img src="{{ asset('img/dkv.png') }}" alt="">
                            </div>
                            <div
                                class="stats rounded-circle w-1/2 py-3 text-sm bg-tosca-500 flex flex-col items-center justify-center text-black">
                                <div class="font-semibold">
                                    <span class="text-lg">34</span>
                                    <span class="text-xs">/ 35</span>
                                </div>
                                <span class="border-none">Ternilai</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $("#add-btn").click(function() {
                $("#bg-blur").toggleClass('hidden')
                $("#add-content").toggleClass('hidden')
                $(this).toggleClass("rotate-45")
            });
            $("#input-batas input").keyup(function() {
                $("#input-batas span").text($(this).val().length)
                if ($(this).val().length == 30) {
                    $("#input-batas span, #input-batas b").addClass("text-red-500");
                } else {
                    $("#input-batas span, #input-batas b").removeClass("text-red-500");
                }
            })
        });
    </script>
@endsection
