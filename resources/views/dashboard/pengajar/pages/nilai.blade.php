@extends('dashboard.layouts.main')
@section('head')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <style>
        .selected-date {
            background-color: turquoise !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                dateClick: function(info) {
                    let allDates = document.querySelectorAll('.fc-day');
                    allDates.forEach(function(date) {
                        date.classList.remove('selected-date');
                    });

                    info.dayEl.classList.add('selected-date');

                    let todayDates = document.querySelectorAll('.fc-day-today');
                    todayDates.forEach(function(today) {
                        today.classList.remove('selected-date');
                    });

                    let todayDate = document.querySelector('.fc-day[data-date="' + info.dateStr + '"]');
                    todayDate.classList.add('selected-date');

                    let linkURL = "?tgl=" + info.dateStr;
                    window.location.href = linkURL;
                },
            });
            calendar.render();

            let queryString = window.location.search;
            if (queryString) {
                let params = new URLSearchParams(queryString);
                let tglParam = params.get('tgl');
                if (tglParam) {
                    let dateElements = document.querySelectorAll('.fc-day');
                    dateElements.forEach(function(dateElement) {
                        if (dateElement.getAttribute('data-date') === tglParam) {
                            dateElement.classList.add('selected-date');
                        }
                    });
                }
            }
        });
    </script>
@endsection
@section('content')
    <div class="w-full h-full flex pl-3 gap-1 max-md:p-0 max-sm:flex-col max-md:flex-col overflow-y-auto">
        <div class="w-10/12 max-sm:w-full max-md:w-full h-full flex flex-col text-black items-center py-5 px-4 gap-2">
            <div
                class="filter flex flex-wrap max-sm:gap-2 max-md:gap-2 max-md:justify-normal max-sm:justify-normal text-sm gap-2 border-b border-b-black pb-2 w-full justify-center">
                <span class="font-semibold max-sm:hidden">Filter by:</span>
                <a href="?filter=all"
                    class="px-3 py-1 rounded-box {{ request('filter') == 'all' ? 'bg-tosca-500' : 'bg-gray-300' }}">All</a>
                <select name="sekolah" class="custom-select text-black bg-gray-300  px-3 py-1 rounded-box max-w-[8rem]"
                    data-filter="sekolah">
                    <option value="">Pilih Sekolah</option>
                    @foreach ($info_pengajar->sekolah as $sekolah)
                        <option value="{{ $sekolah->id }}" class="truncate"
                            {{ $sekolah->id == request('sekolah') ? 'selected' : '' }}>
                            {{ $sekolah->nama }}</option>
                    @endforeach
                </select>
                <select name="kelas" class="custom-select text-black bg-gray-300  px-3 py-1 rounded-box max-w-[8rem]"
                    data-filter="kelas" {{ request('sekolah') == null ? 'disabled' : '' }}>
                    <option value="">Pilih Kelas</option>
                    @if (request('sekolah') != null)
                        @foreach ($info_pengajar->sekolah->find(request('sekolah'))->kelas as $kelas)
                            <option value="{{ $kelas->id }}" class="truncate"
                                {{ $kelas->id == request('kelas') ? 'selected' : '' }}>
                                {{ $kelas->tingkat }} - {{ $kelas->jurusan }} - {{ $kelas->kelas }}
                            </option>
                        @endforeach
                    @endif
                </select>
                <select name="semester" class="custom-select text-black bg-gray-300  px-3 py-1 rounded-box max-w-[8rem]"
                    data-filter="semester">
                    <option value="">Pilih Semester</option>
                    <option value="ganjil" {{ request('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="genap" {{ request('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
                </select>
                <select name="tugas" class="custom-select text-black bg-gray-300  px-3 py-1 rounded-box max-w-[8rem]"
                    data-filter="tugas"
                    {{ request('sekolah') != null && request('kelas') != null && request('semester') != null ? '' : 'disabled' }}>
                    <option value="">Pilih Tugas</option>
                    @if (request('sekolah') != null && request('kelas') != null && request('semester') != null)
                        @foreach ($info_pengajar->sekolah->find(request('sekolah'))->kelas()->find(request('kelas'))->tugas->where('semester', request('semester')) as $tugas)
                            <option value="{{ $tugas->id }}"{{ request('tugas') == $tugas->id ? 'selected' : '' }}>
                                {{ $tugas->nama }}
                            </option>
                        @endforeach
                    @endif
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
                                <th>Nama Tugas</th>
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
                                    <td>{{ $nilai->tugas->nama }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pt-5">
                        {{ $data_nilai->links('components.pagination') }}
                    </div>
                </div>
            @else
                <form action="" method="GET" class="w-full flex gap-3">
                    <input type="search"
                        class="w-full bg-gray-300 px-3 py-2 rounded-lg placeholder:text-sm placeholder:italic"
                        placeholder="Cari nilai...">
                    <input type="submit" value="Search"
                        class="btn border-none text-white bg-bluesea-500 hover:bg-bluesea-600">
                </form>
                <div class="w-full h-full flex flex-col font-semibold text-gray-300 justify-center items-center ">
                    <img src="{{ asset('img/404_kelas.png') }}" alt="" draggable="false">
                    <h1>Data nilai tidak ditemukan!</h1>
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
                    <h1 class="text-xl">Terakhir Dinilai</h1>
                </div>
            </div>
            <div class="w-full h-1/3 bg-gray-200 flex flex-col gap-2 p-2 pb-4">
                @foreach ($terakhir_dinilai as $nilai)
                    <a href="{{ route('select-mapel', ['kelas' => $nilai->siswa->kelas->id]) }}"
                        class="box w-full bg-bluesea-200 h-1/2 rounded-lg flex gap-5 p-2 items-center justify-between">
                        <img src="{{ asset('img/data_kelas.png') }}" alt="" class="h-full">
                        <div class="info w-full text-2xs flex flex-col text-black">
                            <span class="font-bold">{{ $nilai->siswa->kelas->sekolah->nama }}</span>
                            <h1 class="text-sm font-bold leading-3 text-bluesea-500">{{ $nilai->siswa->kelas->nama_kelas }}
                            </h1>
                            <span>{{ $nilai->siswa->kelas->tingkat }} {{ $nilai->siswa->kelas->jurusan }}
                                {{ $nilai->siswa->kelas->kelas }} - {{ $nilai->siswa->kelas->semester }}</span>
                            <span class="leading-5">Terakhir dinilai {{ $nilai->timeElapsed }}</span>
                        </div>
                        <div class="info text-2xs flex flex-col text-bluesea-500 text-5xl">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $(".custom-select").change(function() {
                let selectedValue = $(this).val();
                let filter = $(this).data('filter');
                let queryParams = new URLSearchParams(window.location.search);
                queryParams.set(filter, selectedValue);
                let newUrl = window.location.pathname + "?" + queryParams.toString();
                window.location.href = newUrl;
            });
            $("select[name='sekolah']").change(function() {
                let selectedValue = $(this).val();
                let newUrl = window.location.pathname + "?sekolah=" + selectedValue;
                window.location.href = newUrl;
            });
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
