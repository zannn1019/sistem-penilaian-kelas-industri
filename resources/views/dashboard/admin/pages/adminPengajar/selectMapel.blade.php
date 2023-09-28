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
                            <li>
                                <a href="{{ route('admin-kelas-pengajar', ['pengajar' => $info_pengajar->id]) }}">Kelas
                                    Pengajar</a>
                            </li>
                            <li>Mata Pelajaran</li>
                        </ul>
                    </div>
                    <h1 class="text-3xl font-semibold max-sm:text-sm"><span class="max-sm:hidden"> Kelas Industri - </span>
                        {{ $info_kelas->sekolah->nama }}</h1>
                    <h1 class="text-5xl font-semibold max-sm:text-xl">
                        {{ $info_kelas->tingkat . ' ' . $info_kelas->jurusan . ' ' . $info_kelas->kelas }}</h1>
                </div>
                <a href="{{ route('admin-show-siswa-pengajar', ['pengajar' => $info_pengajar->id, 'kelas' => $info_kelas->id]) }}"
                    class="self-end text-xs flex gap-1 w-52 justify-center items-center bg-darkblue-500 text-white p-4 py-3 rounded-3xl">
                    <i class="fa-solid fa-users"></i>
                    <span class="max-sm:hidden">Lihat data siswa</span>
                    <i class="fa-solid fa-chevron-right max-sm:hidden"></i>
                    <span class="hidden max-sm:inline-block">Siswa</span>
                </a>
            </div>
        </header>
        <div
            class="overflow-auto grid grid-rows-[repeat(auto-fit, 1fr)] grid-cols-3 max-sm:grid-cols-1 max-md:grid-cols-1 gap-5 h-full  p-5 max-sm:p-0 ">
            @foreach ($data_mapel->paginate(8) as $mapel)
                <div class="box w-full h-56 p-2">
                    <a href="{{ route('admin-show-tugas-pengajar', ['pengajar' => $info_pengajar->id, 'kelas' => $info_kelas->id, 'mapel' => $mapel->id]) }}"
                        class="w-full flex h-full bg-tosca-100 rounded-box p-5 shadow-lg flex-col">
                        <div class="w-full flex justify-between h-2/6">
                            <div class="flex justify-between items-center w-full">
                                <h1 class="text-black text-2xl font-semibold">{{ $mapel->mapel->nama_mapel }}</h1>
                                <span class="bg-black flex justify-center items-center p-2 px-2.5 rounded-circle"><i
                                        class="fa-solid fa-arrow-right text-white"></i></span>
                            </div>
                        </div>
                        <div class="w-full h-full grid grid-cols-2 gap-4 max-h-full text-black ">
                            <img src="{{ asset('img/mapel.png') }}" alt="" class="w-44">
                            <div class="w-full flex flex-col gap-1 justify-center">
                                <div class="w-full text-white flex items-center gap-1">
                                    <svg width="22" height="22" viewBox="0 0 12 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="bg-bluesea-500 p-1 rounded-md">
                                        <path
                                            d="M3.06971 0.504075C3.06971 0.406905 3.03111 0.313715 2.9624 0.245005C2.89369 0.176296 2.8005 0.137695 2.70333 0.137695C2.60616 0.137695 2.51297 0.176296 2.44426 0.245005C2.37555 0.313715 2.33695 0.406905 2.33695 0.504075V0.870454H1.60419C1.21551 0.870454 0.84275 1.02486 0.567912 1.29969C0.293074 1.57453 0.138672 1.94729 0.138672 2.33597L0.138672 3.06873H11.8628V2.33597C11.8628 1.94729 11.7084 1.57453 11.4336 1.29969C11.1587 1.02486 10.786 0.870454 10.3973 0.870454H9.66453V0.504075C9.66453 0.406905 9.62593 0.313715 9.55722 0.245005C9.48851 0.176296 9.39532 0.137695 9.29815 0.137695C9.20098 0.137695 9.10779 0.176296 9.03909 0.245005C8.97038 0.313715 8.93178 0.406905 8.93178 0.504075V0.870454H3.06971V0.504075ZM11.8628 10.3963C11.8628 10.785 11.7084 11.1578 11.4336 11.4326C11.1587 11.7074 10.786 11.8618 10.3973 11.8618H1.60419C1.21551 11.8618 0.84275 11.7074 0.567912 11.4326C0.293074 11.1578 0.138672 10.785 0.138672 10.3963V3.80149H11.8628V10.3963ZM8.35656 5.89351C8.39897 5.89557 8.44136 5.88898 8.48115 5.87417C8.52094 5.85935 8.55731 5.83661 8.58805 5.80732C8.6188 5.77803 8.64327 5.7428 8.65999 5.70377C8.67671 5.66474 8.68534 5.62272 8.68534 5.58026C8.68534 5.5378 8.67671 5.49578 8.65999 5.45675C8.64327 5.41772 8.6188 5.38249 8.58805 5.3532C8.55731 5.32391 8.52094 5.30117 8.48115 5.28635C8.44136 5.27154 8.39897 5.26495 8.35656 5.26701C8.31507 5.26661 8.27392 5.2745 8.23552 5.29019C8.19711 5.30589 8.16222 5.32908 8.13289 5.35842C8.10355 5.38776 8.08036 5.42265 8.06466 5.46105C8.04896 5.49946 8.04108 5.54061 8.04147 5.58209C8.04147 5.75649 8.18216 5.89351 8.35656 5.89351ZM8.60277 6.30606H8.11035V9.31403H8.60277V6.30606ZM3.57091 9.31403V7.62869H5.22768V7.1817H3.57091V5.85395H5.37643V5.40696H3.06971V9.31403H3.57091ZM5.98609 9.31403H6.48143V7.45063C6.48143 7.04468 6.64777 6.71274 7.17975 6.71274C7.27134 6.71274 7.3688 6.71567 7.42083 6.72373V6.27455C7.35921 6.26529 7.29701 6.26039 7.23471 6.25989C6.80824 6.25989 6.58182 6.49438 6.49315 6.67537H6.4785V6.30606H5.98609V9.31403Z"
                                            fill="black" />
                                    </svg>
                                    <span
                                        class="text-black">{{ $mapel->tugas()->tipe(['tipe' => ['tugas'], 'id_kelas' => $info_kelas->id])->count() }}</span>
                                    <span class="text-xs text-bluesea-500">Tugas Harian</span>
                                </div>
                                <div class="w-full text-white flex items-center gap-1">
                                    <svg width="22" height="22" viewBox="0 0 19 19" fill="none"
                                        class="bg-bluesky-500 p-1 rounded-md" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M14 4.66045e-09C14.7652 -4.26217e-05 15.5015 0.292325 16.0583 0.817284C16.615 1.34224 16.9501 2.06011 16.995 2.824L17 3V13H17.75C18.397 13 18.93 13.492 18.994 14.122L19 14.25V16C19 16.7652 18.7077 17.5015 18.1827 18.0583C17.6578 18.615 16.9399 18.9501 16.176 18.995L16 19H6C5.23479 19 4.49849 18.7077 3.94174 18.1827C3.38499 17.6578 3.04989 16.9399 3.005 16.176L3 16V6H1.25C0.940542 6.00014 0.642032 5.88549 0.412234 5.67823C0.182437 5.47097 0.0376885 5.18583 0.00600005 4.878L4.66045e-09 4.75V3C-4.26217e-05 2.23479 0.292325 1.49849 0.817284 0.941739C1.34224 0.384993 2.06011 0.0498925 2.824 0.00500012L3 4.66045e-09H14ZM14 2H5V16C5 16.2652 5.10536 16.5196 5.29289 16.7071C5.48043 16.8946 5.73478 17 6 17C6.26522 17 6.51957 16.8946 6.70711 16.7071C6.89464 16.5196 7 16.2652 7 16V14.25C7 13.56 7.56 13 8.25 13H15V3C15 2.73478 14.8946 2.48043 14.7071 2.29289C14.5196 2.10536 14.2652 2 14 2ZM17 15H9V16C9 16.35 8.94 16.687 8.83 17H16C16.2652 17 16.5196 16.8946 16.7071 16.7071C16.8946 16.5196 17 16.2652 17 16V15ZM10 9C10.2652 9 10.5196 9.10536 10.7071 9.29289C10.8946 9.48043 11 9.73478 11 10C11 10.2652 10.8946 10.5196 10.7071 10.7071C10.5196 10.8946 10.2652 11 10 11H8C7.73478 11 7.48043 10.8946 7.29289 10.7071C7.10536 10.5196 7 10.2652 7 10C7 9.73478 7.10536 9.48043 7.29289 9.29289C7.48043 9.10536 7.73478 9 8 9H10ZM12 5C12.2652 5 12.5196 5.10536 12.7071 5.29289C12.8946 5.48043 13 5.73478 13 6C13 6.26522 12.8946 6.51957 12.7071 6.70711C12.5196 6.89464 12.2652 7 12 7H8C7.73478 7 7.48043 6.89464 7.29289 6.70711C7.10536 6.51957 7 6.26522 7 6C7 5.73478 7.10536 5.48043 7.29289 5.29289C7.48043 5.10536 7.73478 5 8 5H12ZM3 2C2.75507 2.00003 2.51866 2.08996 2.33563 2.25272C2.15259 2.41547 2.03566 2.63975 2.007 2.883L2 3V4H3V2Z"
                                            fill="black" />
                                    </svg>
                                    <span
                                        class="text-black">{{ $mapel->tugas()->tipe(['tipe' => ['quiz'], 'id_kelas' => $info_kelas->id])->count() }}</span>
                                    <span class="text-xs text-bluesky-500">Kuis</span>
                                </div>
                                <div class="w-full text-white flex items-center gap-1">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                        class="bg-tosca-500 p-1 rounded-md" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16 3C16.7652 2.99996 17.5015 3.29233 18.0583 3.81728C18.615 4.34224 18.9501 5.06011 18.995 5.824L19 6V16H19.75C20.397 16 20.93 16.492 20.994 17.122L21 17.25V19C21 19.7652 20.7077 20.5015 20.1827 21.0583C19.6578 21.615 18.9399 21.9501 18.176 21.995L18 22H8C7.23479 22 6.49849 21.7077 5.94174 21.1827C5.38499 20.6578 5.04989 19.9399 5.005 19.176L5 19V9H3.25C2.94054 9.00014 2.64203 8.88549 2.41223 8.67823C2.18244 8.47097 2.03769 8.18583 2.006 7.878L2 7.75V6C1.99996 5.23479 2.29233 4.49849 2.81728 3.94174C3.34224 3.38499 4.06011 3.04989 4.824 3.005L5 3H16ZM19 18H10V19C10 19.35 9.94 19.687 9.83 20H18C18.2652 20 18.5196 19.8946 18.7071 19.7071C18.8946 19.5196 19 19.2652 19 19V18ZM12 12H10C9.74512 12.0003 9.49997 12.0979 9.31463 12.2728C9.1293 12.4478 9.01776 12.687 9.00283 12.9414C8.98789 13.1958 9.07067 13.4464 9.23426 13.6418C9.39785 13.8373 9.6299 13.9629 9.883 13.993L10 14H12C12.2549 13.9997 12.5 13.9021 12.6854 13.7272C12.8707 13.5522 12.9822 13.313 12.9972 13.0586C13.0121 12.8042 12.9293 12.5536 12.7657 12.3582C12.6021 12.1627 12.3701 12.0371 12.117 12.007L12 12ZM14 8H10C9.73478 8 9.48043 8.10536 9.29289 8.29289C9.10536 8.48043 9 8.73478 9 9C9 9.26522 9.10536 9.51957 9.29289 9.70711C9.48043 9.89464 9.73478 10 10 10H14C14.2652 10 14.5196 9.89464 14.7071 9.70711C14.8946 9.51957 15 9.26522 15 9C15 8.73478 14.8946 8.48043 14.7071 8.29289C14.5196 8.10536 14.2652 8 14 8ZM5 5C4.73478 5 4.48043 5.10536 4.29289 5.29289C4.10536 5.48043 4 5.73478 4 6V7H5V5Z"
                                            fill="black" />
                                    </svg>
                                    <span
                                        class="text-black">{{ $mapel->tugas()->tipe(['tipe' => ['pas', 'pts'], 'id_kelas' => $info_kelas->id])->count() }}</span>
                                    <span class="text-xs text-tosca-500">Ujian</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <h1 class="text-black p-1 font-semibold text-sm">Mata Pelajaran - {{ $mapel->mapel->nama_mapel }}</h1>
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
