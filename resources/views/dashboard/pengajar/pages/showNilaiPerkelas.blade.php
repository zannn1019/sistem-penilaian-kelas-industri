@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto relative "id="content">
        <header class="w-full flex justify-between  border-b border-black gap-3 items-center text-2xl text-black">
            <div class="w-full flex gap-3 py-3">
                <a href="{{ route('select-mapel', ['kelas' => $info_kelas->id]) }}"
                    class="fa-solid fa-chevron-left max-md:text-lg text-black"></a>
                <div class="w-full flex flex-col text-xs">
                    <div class="text-sm max-sm:hidden breadcrumbs p-0">
                        <ul>
                            <li><a href="{{ route('kelas-pengajar') }}">Kelas</a></li>
                            <li><a href="{{ route('select-mapel', ['kelas' => $info_kelas->id]) }}">
                                    {{ $info_kelas->tingkat . ' ' . $info_kelas->jurusan . ' ' . $info_kelas->kelas }}</a>
                            </li>
                            <li>Raport Kelas</li>
                        </ul>
                    </div>
                    <h1 class="text-3xl font-semibold max-sm:text-sm"><span class="max-sm:hidden">Kelas Industri -</span>
                        {{ $info_kelas->sekolah->nama }}</h1>
                    <h1 class="text-5xl font-semibold max-sm:text-xl">
                        {{ $info_kelas->tingkat . ' ' . $info_kelas->jurusan . ' ' . $info_kelas->kelas }}</h1>
                </div>
                <div class="self-end text-sm flex gap-1 uppercase justify-center items-center font-semibold">
                    <i class="fa-solid fa-users"></i>
                    <span>{{ $info_kelas->siswa->count() }}</span>
                    <span>Siswa</span>
                </div>
            </div>
        </header>
        <div class="w-full h-[75%] max-sm:h-full max-sm:pl-0 py-2 flex gap-1 flex-col pl-5">
            @if ($info_kelas->siswa->count())
                <div class="w-full flex gap-2 pb-3 items-center justify-between">
                    <div class="flex gap-2">
                        <span class="text-sm">Filter By:</span>
                        <a href="?filter=all"
                            class="text-xs px-5 py-1 rounded-xl filter-link {{ request('filter') == 'all' || request('filter') == '' ? 'bg-tosca-500 text-black' : 'bg-gray-200 text-gray-400' }}">All</a>
                        <a href="?filter=dinilai"
                            class="text-xs px-5 py-1 rounded-xl filter-link {{ request('filter') == 'dinilai' ? 'bg-tosca-500 text-black' : 'bg-gray-200 text-gray-400' }}">Dinilai</a>
                        <a href="?filter=belum_dinilai"
                            class="text-xs px-5 py-1 rounded-xl filter-link {{ request('filter') == 'belum_dinilai' ? 'bg-tosca-500 text-black' : 'bg-gray-200 text-gray-400' }}">Belum
                            Dinilai</a>
                    </div>
                    <a href="" class="text-xs px-4 py-1.5 rounded-xl bg-gray-200"><i
                            class="fa-solid fa-download"></i>
                        Export</a>
                </div>
                <div class="overflow-x-auto w-full h-full scroll-arrow" dir="rtl" data-theme="light">
                    <table class="table max-sm:table-xs table-zebra border-2 border-darkblue-500 text-center"
                        dir="ltr">
                        <thead>
                            <tr class="bg-darkblue-500 text-white">
                                <th>NO</th>
                                <th>Nama Siswa</th>
                                @foreach ($info_pengajar->mapel as $mapel)
                                    <th>{{ $mapel->nama_mapel }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($info_kelas->siswa->all() as $siswa)
                                <tr class=""
                                    data-link="{{ route('admin-detail-siswa-pengajar', ['pengajar' => $info_pengajar->id, 'kelas' => $info_kelas->id, 'siswa' => $siswa->id]) }}">
                                    <td class="border-r-2 border-darkblue-500">{{ $loop->iteration }}</td>
                                    <td class="border-r-2 border-darkblue-500">{{ $siswa->nama }}</td>
                                    @foreach ($info_pengajar->mapel as $mapel)
                                        @php
                                            $nilaiKosong = false;
                                            $totalNilai = 0;
                                            $totalTugas = 0;
                                            $tugasBelumDinilai = [];
                                            foreach ($mapel->tugas as $tugas) {
                                                $nilai = $tugas->nilai->where('id_siswa', $siswa->id)->first();
                                            
                                                if ($nilai === null) {
                                                    $nilaiKosong = true;
                                                    $tugasBelumDinilai[] = $tugas->nama;
                                                } else {
                                                    $totalNilai += $nilai->nilai;
                                                    $totalTugas++;
                                                }
                                            }
                                            
                                            $avgNilai = $nilaiKosong ? 'Belum dinilai' : ($totalTugas > 0 ? $totalNilai / $totalTugas : 0);
                                            $isKosong = $nilaiKosong ? 'belum_dinilai' : 'dinilai';
                                        @endphp
                                        <td class="border-r-2 border-darkblue-500" data-avg="{{ $isKosong }}">
                                            @if ($nilaiKosong)
                                                <div class="tooltip tooltip-error"
                                                    data-tip="{{ $mapel->tugas->count() - $totalTugas }} tugas belum dinilai:
                                            @foreach ($tugasBelumDinilai as $index => $tugas)
                                                {{ $tugas }}{{ $index < count($tugasBelumDinilai) - 1 ? ', ' : '' }} @endforeach">
                                                    <button class="text-red-500">Belum Dinilai</button>
                                                </div>
                                            @else
                                                {{ number_format($avgNilai) }}
                                            @endif
                                        </td>
                                    @endforeach

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="w-full flex justify-center items-center flex-col text-gray-500">
                    <img src="{{ asset('img/404_kelas.png') }}" alt="" draggable="false">
                    <h1>Belum ada siswa!</h1>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.filter-link').on('click', function(e) {
            e.preventDefault();
            $(this).removeClass('bg-gray-200 text-gray-400')
            $(this).addClass('bg-tosca-500 text-black')
            $('.filter-link').not($(this)).removeClass('bg-tosca-500 text-black')
            $('.filter-link').not($(this)).addClass('bg-gray-200 text-gray-400')
            let filter = $(this).attr('href').split('=')[1];

            history.pushState({}, '', '?filter=' + filter);

            setFilter(filter);
        });

        function setFilter(filter) {
            let rows = $('.table tbody tr');
            let visibleRowCount = 0;

            rows.each(function(index) {
                let row = $(this);
                let tds = row.children('td').slice(2);

                tds.each(function() {
                    if (filter === 'all' || $(this).data('avg') === filter) {
                        row.show();
                        visibleRowCount++;
                    } else {
                        row.hide();
                    }
                });

                if (row.is(':visible')) {
                    visibleRowCount++;
                }
            });

            rows.filter(':visible').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
        }
        $(document).ready(function() {
            var filter = getFilterFromUrl();
            setFilter(filter);
        });

        function getFilterFromUrl() {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('filter') || 'all';
        }
    </script>
@endsection
