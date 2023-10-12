@extends('dashboard.layouts.main')
@section('head')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                dateClick: function(info) {
                    let linkURL = "?tgl=" + info.dateStr
                    window.location.href = linkURL
                },
            });
            calendar.render();
        });
    </script>
@endsection
@section('content')
    <div class="w-full h-full flex pl-3 gap-1 max-md:p-0 max-sm:flex-col max-md:flex-col overflow-y-auto">
        <div class="w-10/12 max-sm:w-full max-md:w-full h-full flex flex-col text-black items-center py-5 px-4 gap-2">
            <div
                class="filter flex items-center flex-wrap max-sm:gap-2 max-md:gap-2 max-md:justify-normal max-sm:justify-normal text-sm gap-2 border-b border-b-black pb-2 w-full justify-center">
                <span class="font-semibold max-sm:hidden">Filter by:</span>
                <a href="?filter=all"
                    class="px-3 py-1 rounded-box {{ request('filter') == 'all' ? 'bg-tosca-500' : 'bg-gray-300' }}">All</a>
                <select name="" id="" class="text-black bg-gray-300  px-3 py-1 rounded-box">
                    <option value="">Kelas</option>
                    <option value="">1</option>
                    <option value="">1</option>
                </select>
                <select name="" id="" class="text-black bg-gray-300  px-3 py-1 rounded-box">
                    <option value="">Sekolah</option>
                    <option value="">1</option>
                    <option value="">1</option>
                </select>
                <select name="" id="" class="text-black bg-gray-300  px-3 py-1 rounded-box">
                    <option value="">Tugas</option>
                    <option value="">1</option>
                    <option value="">1</option>
                </select>
                <select name="" id="" class="text-black bg-gray-300  px-3 py-1 rounded-box">
                    <option value="">Semester</option>
                    <option value="">1</option>
                    <option value="">1</option>
                </select>
            </div>
            @if ($data_nilai->count())
                <div class="overflow-x-auto w-full relative pr-5">
                    <div class="w-[99%] z-10 justify-between absolute left-0.5 transition-all duration-300 pointer-events-none hidden max-sm:opacity-0 max-md:opacity-0"
                        id="indicator">
                        <div class="w-2 h-full bg-bluesea-500 bg-opacity-30">
                            <div class="w-full h-full bg-blue-500 rounded-r-3xl"></div>
                        </div>
                        <div class="w-full bg-bluesea-500 bg-opacity-30"></div>
                        <div class="w-5 h-full flex justify-center items-center text-lg font-bold text-bluesea-500">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>
                    </div>
                    <table class="table text-center border-separate border-spacing-x-0.5">
                        <thead>
                            <tr class="bg-darkblue-100 text-black text-xs">
                                <th>Waktu & Tanggal</th>
                                <th>Nama Siswa</th>
                                <th>Kelas Industri</th>
                                <th>Kategori</th>
                            </tr>
                        </thead>
                        <tbody class="bg-bluesea-200 text-xs">
                            @foreach ($data_nilai as $nilai)
                                <tr class="clickable-row"
                                    data-link="{{ route('detail-siswa', ['kelas' => $nilai->siswa->kelas->id, 'siswa' => $nilai->siswa->id]) }}">
                                    <td>{{ $nilai->updated_at }}</td>
                                    <td>{{ $nilai->siswa->nama }} </td>
                                    <td>{{ $nilai->siswa->kelas->sekolah->nama }} -
                                        {{ $nilai->siswa->kelas->tingkat }}-{{ $nilai->siswa->kelas->jurusan }}-{{ $nilai->siswa->kelas->kelas }}
                                    </td>
                                    <td> {{ implode(' ', array_map('ucfirst', explode('_', $nilai->tugas->tipe))) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <form action="" method="GET" class="w-full flex gap-3">
                    <input type="search"
                        class="w-full bg-gray-300 px-3 py-2 rounded-lg placeholder:text-sm placeholder:italic"
                        placeholder="Cari nilai...">
                    <input type="submit" value="Search"
                        class="btn border-none text-white bg-bluesea-500 hover:bg-bluesea-600">
                </form>
                <div class="noting w-full h-full justify-center items-center flex flex-col">
                    <img src="{{ asset('img/calendar.svg') }}" alt="" draggable="false">
                    <h1 class="w-1/2 text-center  text-gray-400">Masukkan tanggal untuk melihat nilai yang
                        ter-entry.</h1>
                </div>
            @endif
        </div>
        <div class="w-5/12 h-full max-sm:w-full max-md:w-full bg-gray-200 flex flex-col justify-between">
            <div class="w-full h-3/6 bg-gray-200 p-2 flex justify-center">
                <div id='calendar' class="text-xs text-black font-semibold w-11/12 h-full"></div>
            </div>
            <div class="w-full h-20 bg-gray-300 flex justify-between items-center p-5 text-black">
                <div class="flex gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-2xl"></i>
                    <h1 class="text-xl">Terakhir Dibuka</h1>
                </div>
                <a href="" class="text-xs">Buka History</a>
            </div>
            <div class="w-full h-1/3 bg-gray-200 flex flex-col gap-2 p-2 pb-4">
                <a href=""
                    class="box w-full bg-bluesea-200 h-1/2 rounded-lg flex gap-5 p-2 items-center justify-between">
                    <img src="{{ asset('img/dkv.png') }}" alt="" class="h-full">
                    <div class="info w-full text-2xs flex flex-col text-black">
                        <span class="font-bold">SMKN 2 Cimahi</span>
                        <h1 class="text-sm font-bold leading-3 text-bluesea-500">Kelas DKV</h1>
                        <span>XII-DKV-C - Semester Genap</span>
                        <span class="leading-5">Terakhir diakses hari ini pukul 11:02</span>
                    </div>
                    <div class="info text-2xs flex flex-col text-bluesea-500 text-5xl">
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                </a>
                <a href=""
                    class="box w-full bg-bluesea-200 h-1/2 rounded-lg flex gap-5 p-2 items-center justify-between">
                    <img src="{{ asset('img/dkv.png') }}" alt="" class="h-full">
                    <div class="info w-full text-2xs flex flex-col text-black">
                        <span class="font-bold">SMKN 2 Cimahi</span>
                        <h1 class="text-sm font-bold leading-3 text-bluesea-500">Kelas DKV</h1>
                        <span>XII-DKV-C - Semester Genap</span>
                        <span class="leading-5">Terakhir diakses hari ini pukul 11:02</span>
                    </div>
                    <div class="info text-2xs flex flex-col text-bluesea-500 text-5xl">
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $(".clickable-row").click(function() {
                window.location.href = $(this).data('link')
            })
            $(".clickable-row").hover(function() {
                $("#indicator").css('display', 'flex')
                let h = $(this).height()
                let position = $(this).position();
                let top = position.top;
                $("#indicator").css("top", top + 'px')
                $("#indicator").css("height", h)
            })
            $(".clickable-row").mouseleave(function() {
                $("#indicator").css('display', 'none')
            });
        });
    </script>
@endsection
