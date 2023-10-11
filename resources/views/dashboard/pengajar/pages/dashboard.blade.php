@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full flex flex-col overflow-y-auto overflow-x-hidden p-5">
        <div class="w-full flex max-sm:flex-col max-md:flex-col gap-5 pb-2">
            <div
                class="w-6/12 h-full max-sm:w-full max-md:w-full bg-gradient-to-tl relative from-bluesky-500 from-10% to-darkblue-500 to-90% rounded-box grid grid-cols-2 max-sm:grid-cols-1">
                <div class="statistik p-5 flex flex-col gap-1 max-sm:w-full">
                    <div class="bg-tosca-500 text-black rounded-box py-1 w-10/12 max-sm:w-full max-sm:px-2 text-center">
                        {{ date('d M Y') }}</div>
                    <div class="text-white">
                        <span class="text-5xl font-bold">{{ $status_tugas['total_ternilai'] }}</span>
                        <span>/ {{ $status_tugas['total_tugas'] }}</span>
                        <h1 class="text-sm">Tugas Ternilai</h1>
                    </div>
                    <div class="counter flex flex-col text-sm gap-2">
                        <div class="w-full text-white flex items-center gap-1">
                            <i class="fa-regular fa-calendar text-black bg-tosca-500 p-2 rounded-md"></i>
                            <span>{{ $status_tugas['harian']['ternilai'] }}</span>
                            <span class="text-xs">/ {{ $status_tugas['harian']['total'] }}</span>
                            <span class="text-xs text-tosca-500">Harian</span>
                        </div>
                        <div class="w-full text-white flex items-center gap-1">
                            <svg width="30" height="30" viewBox="0 0 19 19" fill="none"
                                class="bg-tosca-400 p-2 rounded-md" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14 4.66045e-09C14.7652 -4.26217e-05 15.5015 0.292325 16.0583 0.817284C16.615 1.34224 16.9501 2.06011 16.995 2.824L17 3V13H17.75C18.397 13 18.93 13.492 18.994 14.122L19 14.25V16C19 16.7652 18.7077 17.5015 18.1827 18.0583C17.6578 18.615 16.9399 18.9501 16.176 18.995L16 19H6C5.23479 19 4.49849 18.7077 3.94174 18.1827C3.38499 17.6578 3.04989 16.9399 3.005 16.176L3 16V6H1.25C0.940542 6.00014 0.642032 5.88549 0.412234 5.67823C0.182437 5.47097 0.0376885 5.18583 0.00600005 4.878L4.66045e-09 4.75V3C-4.26217e-05 2.23479 0.292325 1.49849 0.817284 0.941739C1.34224 0.384993 2.06011 0.0498925 2.824 0.00500012L3 4.66045e-09H14ZM14 2H5V16C5 16.2652 5.10536 16.5196 5.29289 16.7071C5.48043 16.8946 5.73478 17 6 17C6.26522 17 6.51957 16.8946 6.70711 16.7071C6.89464 16.5196 7 16.2652 7 16V14.25C7 13.56 7.56 13 8.25 13H15V3C15 2.73478 14.8946 2.48043 14.7071 2.29289C14.5196 2.10536 14.2652 2 14 2ZM17 15H9V16C9 16.35 8.94 16.687 8.83 17H16C16.2652 17 16.5196 16.8946 16.7071 16.7071C16.8946 16.5196 17 16.2652 17 16V15ZM10 9C10.2652 9 10.5196 9.10536 10.7071 9.29289C10.8946 9.48043 11 9.73478 11 10C11 10.2652 10.8946 10.5196 10.7071 10.7071C10.5196 10.8946 10.2652 11 10 11H8C7.73478 11 7.48043 10.8946 7.29289 10.7071C7.10536 10.5196 7 10.2652 7 10C7 9.73478 7.10536 9.48043 7.29289 9.29289C7.48043 9.10536 7.73478 9 8 9H10ZM12 5C12.2652 5 12.5196 5.10536 12.7071 5.29289C12.8946 5.48043 13 5.73478 13 6C13 6.26522 12.8946 6.51957 12.7071 6.70711C12.5196 6.89464 12.2652 7 12 7H8C7.73478 7 7.48043 6.89464 7.29289 6.70711C7.10536 6.51957 7 6.26522 7 6C7 5.73478 7.10536 5.48043 7.29289 5.29289C7.48043 5.10536 7.73478 5 8 5H12ZM3 2C2.75507 2.00003 2.51866 2.08996 2.33563 2.25272C2.15259 2.41547 2.03566 2.63975 2.007 2.883L2 3V4H3V2Z"
                                    fill="black" />
                            </svg>
                            <span>{{ $status_tugas['assessment_blok_a']['ternilai'] }}</span>
                            <span class="text-xs">/ {{ $status_tugas['assessment_blok_a']['total'] }}</span>
                            <span class="text-xs text-tosca-500">Assessment Blok A</span>
                        </div>
                        <div class="w-full text-white flex items-center gap-1">
                            <svg width="30" height="30" viewBox="0 0 24 24" fill="none"
                                class="bg-tosca-400 p-1 rounded-md" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16 3C16.7652 2.99996 17.5015 3.29233 18.0583 3.81728C18.615 4.34224 18.9501 5.06011 18.995 5.824L19 6V16H19.75C20.397 16 20.93 16.492 20.994 17.122L21 17.25V19C21 19.7652 20.7077 20.5015 20.1827 21.0583C19.6578 21.615 18.9399 21.9501 18.176 21.995L18 22H8C7.23479 22 6.49849 21.7077 5.94174 21.1827C5.38499 20.6578 5.04989 19.9399 5.005 19.176L5 19V9H3.25C2.94054 9.00014 2.64203 8.88549 2.41223 8.67823C2.18244 8.47097 2.03769 8.18583 2.006 7.878L2 7.75V6C1.99996 5.23479 2.29233 4.49849 2.81728 3.94174C3.34224 3.38499 4.06011 3.04989 4.824 3.005L5 3H16ZM19 18H10V19C10 19.35 9.94 19.687 9.83 20H18C18.2652 20 18.5196 19.8946 18.7071 19.7071C18.8946 19.5196 19 19.2652 19 19V18ZM12 12H10C9.74512 12.0003 9.49997 12.0979 9.31463 12.2728C9.1293 12.4478 9.01776 12.687 9.00283 12.9414C8.98789 13.1958 9.07067 13.4464 9.23426 13.6418C9.39785 13.8373 9.6299 13.9629 9.883 13.993L10 14H12C12.2549 13.9997 12.5 13.9021 12.6854 13.7272C12.8707 13.5522 12.9822 13.313 12.9972 13.0586C13.0121 12.8042 12.9293 12.5536 12.7657 12.3582C12.6021 12.1627 12.3701 12.0371 12.117 12.007L12 12ZM14 8H10C9.73478 8 9.48043 8.10536 9.29289 8.29289C9.10536 8.48043 9 8.73478 9 9C9 9.26522 9.10536 9.51957 9.29289 9.70711C9.48043 9.89464 9.73478 10 10 10H14C14.2652 10 14.5196 9.89464 14.7071 9.70711C14.8946 9.51957 15 9.26522 15 9C15 8.73478 14.8946 8.48043 14.7071 8.29289C14.5196 8.10536 14.2652 8 14 8ZM5 5C4.73478 5 4.48043 5.10536 4.29289 5.29289C4.10536 5.48043 4 5.73478 4 6V7H5V5Z"
                                    fill="black" />
                            </svg>
                            <span>{{ $status_tugas['assessment_blok_b']['ternilai'] }}</span>
                            <span class="text-xs">/ {{ $status_tugas['assessment_blok_b']['total'] }}</span>
                            <span class="text-xs text-tosca-500">Assessment Blok B</span>
                        </div>
                    </div>
                    <a href="{{ route('nilai.index') }}"
                        class="text-black bg-tosca-500 text-center p-2 rounded-tl-box rounded-br-box absolute -bottom-3 -right-3 px-7 shadow-xl">Lihat
                        Detail Nilai <i class="fa-solid fa-chevron-right text-xs"></i></a>
                </div>
                <img src="{{ asset('img/stats_tugas.png') }}" alt="" class="object-fit max-sm:hidden"
                    draggable="false">
            </div>
            <div class="w-6/12 max-sm:w-full max-md:w-full h-full ">
                <div
                    class="box-kelas bg-bluesky-500 w-10/12 h-full rounded-box shadow-xl relative p-10 text-white max-sm:w-full">
                    <img src="{{ asset('img/book.png') }}" alt="" class="absolute -top-20 -right-32 max-sm:hidden">
                    <h1 class="text-8xl ">{{ $info_pengajar->kelas()->count() }}</h1>
                    <h1 class="text-2xl">Kelas <br> Industri</h1>
                    <a href="{{ route('kelas-pengajar') }}"
                        class="btn text-white rounded-6xl absolute right-3 bottom-2 px-5 capitalize">Detail <i
                            class="fa-solid fa-chevron-right text-xs"></i></a>
                </div>
            </div>
        </div>
        @if ($info_pengajar->kelas()->get()->count() > 0)
            <div class="w-full h-1/3 grid grid-cols-3 max-sm:grid-cols-1 max-md:grid-cols-2 text-black gap-5">
                @foreach ($info_pengajar->kelas()->get()->count() > 3
            ? $info_pengajar->kelas()->get()->random(3)
            : $info_pengajar->kelas()->get() as $kelas)
                    <a href="{{ route('select-mapel', ['kelas' => $kelas->id]) }}" class="box ">
                        <h1 class="font-bold trunca">{{ $kelas->nama_kelas }}</h1>
                        <div class="box-content w-11/12 h-44 bg-blue-200 rounded-2xl flex flex-col gap-2 p-4 shadow-lg">
                            <div class="info-sekolah flex justify-between items-center w-full h-10">
                                <div class="nama-kelas">
                                    <span class="text-xs font-semibold ">{{ $kelas->sekolah->nama }}</span>
                                    <h1 class="font-bold leading-5 text-xl text-bluesea-500">
                                        {{ $kelas->nama_kelas }}</h1>
                                </div>
                                <div class="logo avatar h-full">
                                    <img src="{{ asset('storage/sekolah/' . $kelas->sekolah->logo) }}" alt=""
                                        class="w-full h-full">
                                </div>
                            </div>
                            <div
                                class="w-full h-full grid grid-cols-2 gap-2 justify-between items-center max-md:items-start overflow-hidden">
                                <img src="{{ asset('img/data_kelas.png') }}" alt=""
                                    class="w-full max-md:w-52 object-cover">
                                <div class="info flex flex-col text-xs gap-2">
                                    <span class="font-bold">Semester {{ $kelas->semester }}</span>
                                    <span><i class="fa-solid fa-chalkboard"></i>
                                        {{ $kelas->tingkat . '-' . $kelas->jurusan . '-' . $kelas->kelas }}</span>
                                    <span><i class="fa-solid fa-users"></i> {{ $kelas->siswa->count() }} Siswa</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="w-full flex justify-center items-center flex-col">
                <img src="{{ asset('img/404_kelas.png') }}" class="w-60" alt="">
                <h1>Tidak ada data kelas!</h1>
            </div>
        @endif
    </div>
@endsection
