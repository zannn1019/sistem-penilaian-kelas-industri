@extends('dashboard.layouts.main')
@section('content')
    @php
        use NumberToWords\NumberToWords;
    @endphp
    <div class="w-full h-full p-3 flex flex-col">
        <header class="w-full flex justify-between gap-3 items-center text-2xl text-black">
            <div class="w-full flex gap-3 py-3 max-md:px-3 justify-center items-center">
                <a href="{{ route('kelas.show', ['kela' => $info_siswa->kelas->id]) }}"
                    class="fa-solid fa-chevron-left max-md:text-lg text-black"></a>
                <div class="w-full flex flex-col text-xs border-b border-black">
                    <div class="text-sm max-sm:hidden breadcrumbs p-0">
                        <ul>
                            <li><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
                            <li><a
                                    href="{{ route('sekolah.show', ['sekolah' => $info_siswa->sekolah->id]) }}">{{ $info_siswa->sekolah->nama }}</a>
                            </li>
                            <li>
                                <a href="{{ route('kelas.show', ['kela' => $info_siswa->kelas->id]) }}">
                                    {{ $info_siswa->kelas->nama_kelas . ' ( ' . $info_siswa->kelas->tingkat . ' ' . $info_siswa->kelas->jurusan . ' ' . $info_siswa->kelas->kelas . ' )' }}
                                </a>
                            </li>
                            <li>{{ $info_siswa->nama }}</li>
                        </ul>
                    </div>
                    <div class="w-full flex justify-between items-center">
                        <div class="flex flex-col">
                            <h1
                                class="text-6xl max-md:text-3xl py-2 max-sm:py-0 font-semibold max-sm:text-lg truncate w-full max-w-5xl max-sm:max-w-[15rem]">
                                {{ $info_siswa->nama }}
                            </h1>
                            <span class="text-2xl font-semibold">{{ $info_siswa->nis }}</span>
                        </div>
                        <div class="dropdown dropdown-left justify-self-end self-end p-5" data-theme="light">
                            <label tabindex="0"
                                class="text-4xl self-end justify-self-end bg-transparent cursor-pointer "><i
                                    class="fa-solid fa-ellipsis-vertical"></i></label>
                            <div tabindex="0"
                                class="dropdown-content z-[1] p-2 shadow bg-gray-300 rounded-box w-52 flex flex-col">
                                <button class="w-full hover:font-semibold text-start border-b border-black p-2"
                                    onclick="editModal.showModal()">Edit</button>
                                <a href="" class="w-full hover:font-semibold p-2">Arsip </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="w-full h-full px-7 max-sm:px-0 flex flex-col">
            <div
                class="w-full bg-darkblue-500 py-5 px-10 max-sm:px-5 rounded-3xl grid grid-cols-3 max-sm:grid-cols-1 text-white text-sm gap-2">
                <div class="flex gap-2 items-center">
                    <i class="fa-solid fa-envelope text-xl"></i>
                    <span class="font-semibold">Email</span>
                    <span class="border-l px-2 text-xs">{{ $info_siswa->email }}</span>
                </div>
                <div class="flex gap-2 items-center">
                    <i class="fa-solid fa-calendar text-xl"></i>
                    <span class="font-semibold">Tahun Ajaran</span>
                    <span class="border-l px-2 text-xs capitalize">{{ $info_siswa->kelas->tahun_ajar }}</span>
                </div>
                <div class="flex gap-2 items-center">
                    <i class="fa-solid fa-school text-xl"></i>
                    <span class="font-semibold">Sekolah</span>
                    <span class="border-l px-2 text-xs capitalize">{{ $info_siswa->sekolah->nama }}</span>
                </div>
                <div class="flex gap-2 items-center">
                    <i class="fa-solid fa-phone text-xl"></i>
                    <span class="font-semibold">No. Telepon</span>
                    <span class="border-l px-2 text-xs capitalize">{{ $info_siswa->no_telp }}</span>
                </div>
                <div class="flex gap-2 items-center">
                    <i class="fa-solid fa-book text-xl"></i>
                    <span class="font-semibold">Semester</span>
                    <span class="border-l px-2 text-xs capitalize">{{ $info_siswa->kelas->semester }}</span>
                </div>
                <div class="flex gap-2 items-center">
                    <i class="fa-solid fa-chalkboard text-xl"></i>
                    <span class="font-semibold">Kelas</span>
                    <span
                        class="border-l px-2 text-xs">{{ $info_siswa->kelas->tingkat }}-{{ $info_siswa->kelas->jurusan }}-{{ $info_siswa->kelas->kelas }}</span>
                </div>
            </div>
            <div class="w-full grid {{ request('view') == 'full' ? 'grid-cols-1' : 'grid-cols-2' }} max-sm:grid-cols-1">
                @if (request('view') != 'full')
                    <div class="w-full flex flex-wrap">
                        <div class="max-sm:w-full">
                            <div class="w-full flex justify-center items-center rounded-circle ">
                                <canvas id="myChart" class="max-w-xs max-h-60 max-sm:max-h-44 m-0"></canvas>
                            </div>
                            <div
                                class="w-full text-black py-3 px-10 flex items-end gap-1 max-sm:flex max-sm:justify-center">
                                <span>Rata-rata nilai :</span>
                                <span class="text-4xl" id="rata-rata" data-avg="{{ $rata_rata ?? 'null' }}">
                                    @if ($rata_rata == null)
                                        <div class="tooltip tooltip-error" data-tip="Nilai belum lengkap!">
                                            <button class="">
                                                <i class="fa fa-info-circle text-error  text-lg" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col max-sm:flex-row justify-between gap-2 text-black">
                            <div class="flex flex-col h-full justify-center gap-2 px-5">
                                <div class="flex gap-1">
                                    <div class="w-5 h-5 bg-bluesea-500"></div>
                                    <span class="text-sm">Tugas Harian</span>
                                </div>
                                <div class="flex gap-1">
                                    <div class="w-5 h-5 bg-bluesky-500"></div>
                                    <span class="text-sm">Kuis</span>
                                </div>
                                <div class="flex gap-1">
                                    <div class="w-5 h-5 bg-tosca-500"></div>
                                    <span class="text-sm">Assessment</span>
                                </div>
                                <div class="flex gap-1">
                                    <div class="w-5 h-5 bg-gray-200"></div>
                                    <span class="text-sm">Belum Dinilai</span>
                                </div>
                            </div>
                            <div class="flex flex-col py-5 justify-center">
                                <div class="flex flex-col border-l max-sm:border-none border-black gap-1 px-5">
                                    <div class="w-full">
                                        <i class="fa-solid fa-calendar bg-bluesea-500 p-2 rounded"></i>
                                        <span id="tugas_ternilai">0</span>
                                        <span class="text-xs">/ {{ $tugas['tugas'] }}</span>
                                        <span class="text-xs text-bluesea-500">Harian</span>
                                    </div>
                                    <div class="w-full flex gap-1 items-center">
                                        <svg width="30" height="30" viewBox="0 0 19 19" fill="none"
                                            class="bg-bluesky-400 p-2 rounded-md" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14 4.66045e-09C14.7652 -4.26217e-05 15.5015 0.292325 16.0583 0.817284C16.615 1.34224 16.9501 2.06011 16.995 2.824L17 3V13H17.75C18.397 13 18.93 13.492 18.994 14.122L19 14.25V16C19 16.7652 18.7077 17.5015 18.1827 18.0583C17.6578 18.615 16.9399 18.9501 16.176 18.995L16 19H6C5.23479 19 4.49849 18.7077 3.94174 18.1827C3.38499 17.6578 3.04989 16.9399 3.005 16.176L3 16V6H1.25C0.940542 6.00014 0.642032 5.88549 0.412234 5.67823C0.182437 5.47097 0.0376885 5.18583 0.00600005 4.878L4.66045e-09 4.75V3C-4.26217e-05 2.23479 0.292325 1.49849 0.817284 0.941739C1.34224 0.384993 2.06011 0.0498925 2.824 0.00500012L3 4.66045e-09H14ZM14 2H5V16C5 16.2652 5.10536 16.5196 5.29289 16.7071C5.48043 16.8946 5.73478 17 6 17C6.26522 17 6.51957 16.8946 6.70711 16.7071C6.89464 16.5196 7 16.2652 7 16V14.25C7 13.56 7.56 13 8.25 13H15V3C15 2.73478 14.8946 2.48043 14.7071 2.29289C14.5196 2.10536 14.2652 2 14 2ZM17 15H9V16C9 16.35 8.94 16.687 8.83 17H16C16.2652 17 16.5196 16.8946 16.7071 16.7071C16.8946 16.5196 17 16.2652 17 16V15ZM10 9C10.2652 9 10.5196 9.10536 10.7071 9.29289C10.8946 9.48043 11 9.73478 11 10C11 10.2652 10.8946 10.5196 10.7071 10.7071C10.5196 10.8946 10.2652 11 10 11H8C7.73478 11 7.48043 10.8946 7.29289 10.7071C7.10536 10.5196 7 10.2652 7 10C7 9.73478 7.10536 9.48043 7.29289 9.29289C7.48043 9.10536 7.73478 9 8 9H10ZM12 5C12.2652 5 12.5196 5.10536 12.7071 5.29289C12.8946 5.48043 13 5.73478 13 6C13 6.26522 12.8946 6.51957 12.7071 6.70711C12.5196 6.89464 12.2652 7 12 7H8C7.73478 7 7.48043 6.89464 7.29289 6.70711C7.10536 6.51957 7 6.26522 7 6C7 5.73478 7.10536 5.48043 7.29289 5.29289C7.48043 5.10536 7.73478 5 8 5H12ZM3 2C2.75507 2.00003 2.51866 2.08996 2.33563 2.25272C2.15259 2.41547 2.03566 2.63975 2.007 2.883L2 3V4H3V2Z"
                                                fill="black" />
                                        </svg>
                                        <span id="kuis_ternilai">0</span>
                                        <span class="text-xs">/ {{ $tugas['kuis'] }}</span>
                                        <span class="text-xs text-bluesky-500">Kuis</span>
                                    </div>
                                    <div class="w-full flex gap-1 items-center">
                                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none"
                                            class="bg-tosca-400 p-1 rounded-md" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M16 3C16.7652 2.99996 17.5015 3.29233 18.0583 3.81728C18.615 4.34224 18.9501 5.06011 18.995 5.824L19 6V16H19.75C20.397 16 20.93 16.492 20.994 17.122L21 17.25V19C21 19.7652 20.7077 20.5015 20.1827 21.0583C19.6578 21.615 18.9399 21.9501 18.176 21.995L18 22H8C7.23479 22 6.49849 21.7077 5.94174 21.1827C5.38499 20.6578 5.04989 19.9399 5.005 19.176L5 19V9H3.25C2.94054 9.00014 2.64203 8.88549 2.41223 8.67823C2.18244 8.47097 2.03769 8.18583 2.006 7.878L2 7.75V6C1.99996 5.23479 2.29233 4.49849 2.81728 3.94174C3.34224 3.38499 4.06011 3.04989 4.824 3.005L5 3H16ZM19 18H10V19C10 19.35 9.94 19.687 9.83 20H18C18.2652 20 18.5196 19.8946 18.7071 19.7071C18.8946 19.5196 19 19.2652 19 19V18ZM12 12H10C9.74512 12.0003 9.49997 12.0979 9.31463 12.2728C9.1293 12.4478 9.01776 12.687 9.00283 12.9414C8.98789 13.1958 9.07067 13.4464 9.23426 13.6418C9.39785 13.8373 9.6299 13.9629 9.883 13.993L10 14H12C12.2549 13.9997 12.5 13.9021 12.6854 13.7272C12.8707 13.5522 12.9822 13.313 12.9972 13.0586C13.0121 12.8042 12.9293 12.5536 12.7657 12.3582C12.6021 12.1627 12.3701 12.0371 12.117 12.007L12 12ZM14 8H10C9.73478 8 9.48043 8.10536 9.29289 8.29289C9.10536 8.48043 9 8.73478 9 9C9 9.26522 9.10536 9.51957 9.29289 9.70711C9.48043 9.89464 9.73478 10 10 10H14C14.2652 10 14.5196 9.89464 14.7071 9.70711C14.8946 9.51957 15 9.26522 15 9C15 8.73478 14.8946 8.48043 14.7071 8.29289C14.5196 8.10536 14.2652 8 14 8ZM5 5C4.73478 5 4.48043 5.10536 4.29289 5.29289C4.10536 5.48043 4 5.73478 4 6V7H5V5Z"
                                                fill="black" />
                                        </svg>
                                        <span id="ujian_ternilai">0</span>
                                        <span class="text-xs">/ {{ $tugas['ujian'] }}</span>
                                        <span class="text-xs text-tosca-500">Assessment</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex-grow w-full rounded-2xl border-black border h-16 text-black text-center relative justify-center items-center">
                            <div class="progress-nilai opacity-0 relative progress-bar bg-gradient-to-r from-tosca-500 to-bluesky-500 h-full w-0 rounded-2xl"
                                id="bar-ternilai">
                            </div>
                            <div class="absolute z-10 font-semibold top-1/3 right-1/3">
                                <span id="tugas-ternilai">{{ $tugas['ternilai'] }}</span>
                                <span>/</span>
                                <span id="total-tugas">{{ $tugas['total'] }}</span>
                                <span>Tugas ternilai</span>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="w-full p-1 max-sm:pt-5 px-2 text-black flex flex-col h-full">
                    <div class="w-full flex justify-end gap-2 text-lg">
                        <h1
                            class="w-full justify-self-start font-semibold {{ request('view') == 'full' ? '' : 'hidden' }}">
                            Daftar nilai siswa</h1>
                        <a href="{{ route('ExportPerSiswa', ['siswa' => $info_siswa->id]) }}">
                            <i class="fa-solid fa-download"></i>
                        </a>
                        <a href="{{ request('view') == 'full' ? '?view=min' : '?view=full' }}">
                            @if (request('view') == 'full')
                                <i class="fa-solid fa-minimize"></i>
                            @else
                                <i class="fa-solid fa-maximize"></i>
                            @endif
                        </a>
                    </div>
                    <div class="w-full bg-white">
                        <div class="overflow-auto h-80 scroll-arrow">
                            <div class="bg-darkblue-100 border rounded-3xl border-black overflow-hidden">
                                @if (request('view') == 'full')
                                    <div
                                        class="flex max-md:grid max-md:grid-flow-col overflow-x-auto w-full h-max bg-gradient-to-r from-bluesky-500 to-tosca-500 text-center rounded-t-2xl">
                                        <h1 class="w-28 flex justify-center items-center border-r border-black">
                                            NO
                                        </h1>
                                        <h1 class="w-72  flex justify-center items-center border-r border-black">
                                            Mapel
                                        </h1>
                                        <h1 class="w-28 flex justify-center items-center border-r border-black">
                                            KKM
                                        </h1>
                                        <div
                                            class="flex-col w-60 flex justify-center items-center border-r border-black text-sm">
                                            <h1 class="w-full text-center">Nilai</h1>
                                            <div class="w-full flex">
                                                <h1 class="w-20 border-t border-r border-black">Angka</h1>
                                                <h1 class="w-full flex-grow border-t border-black">Huruf</h1>
                                            </div>
                                        </div>
                                        <h1 class="flex justify-center items-center flex-grow px-3">
                                            Deskripsi
                                        </h1>
                                    </div>
                                @else
                                    <div
                                        class="grid grid-cols-3 h-max bg-gradient-to-r from-bluesky-500 to-tosca-500 text-center rounded-t-3xl">
                                        <h1
                                            class="w-full p-3 border-r border-black h-full flex justify-center items-center">
                                            Mapel</h1>
                                        <h1
                                            class="w-full p-3 border-r border-black h-full flex justify-center items-center">
                                            KKM</h1>
                                        <h1 class="w-full p-3 h-full flex justify-center items-center">
                                            Rata-rata</h1>
                                    </div>
                                @endif
                                @foreach ($daftar_mapel as $mapel)
                                    @php
                                        $nilaiKosong = false;
                                        $totalNilai = 0;
                                        $totalTugas = 0;
                                        $tugasBelumDinilai = [];
                                        foreach (
                                            $mapel->tugas
                                                ->where('id_kelas', $info_siswa->kelas->id)
                                                ->where('tahun_ajar', $info_siswa->kelas->tahun_ajar)
                                                ->where('semester', $info_siswa->kelas->semester)
                                            as $tugas
                                        ) {
                                            $nilai = $tugas->nilai->where('id_siswa', $info_siswa->id)->first();

                                            if ($nilai === null) {
                                                $nilaiKosong = true;
                                                $tugasBelumDinilai[] = $tugas->nama;
                                            } else {
                                                $totalNilai += $nilai->nilai;
                                                $totalTugas++;
                                            }
                                        }

                                        $avgNilai = $nilaiKosong ? '-' : number_format($totalTugas > 0 ? $totalNilai / $totalTugas : 0);
                                        $isKosong = $nilaiKosong ? 'belum_dinilai' : 'dinilai';
                                    @endphp
                                    @if (request('view') == 'full')
                                        <div tabindex="0"
                                            class="collapse rounded-none h-max border-t border-black  overflow-x-auto">
                                            <div class="collapse-title p-0 flex h-max text-center text-sm w-full min-h-0">
                                                <h1 class="w-28 flex justify-center items-center border-r border-black">
                                                    {{ $loop->iteration }}
                                                </h1>
                                                <h1 class="w-72 flex justify-center items-center border-r border-black">
                                                    {{ $mapel->nama_mapel }}
                                                </h1>
                                                <h1 class="w-28 flex justify-center items-center border-r border-black">
                                                    75
                                                </h1>
                                                <div
                                                    class="flex-col w-60 flex justify-center items-center border-r border-black text-sm">
                                                    <div class="w-full flex">
                                                        <h1 class="w-20 border-r border-black py-2">
                                                            {{ $avgNilai }}
                                                        </h1>
                                                        <h1 class="flex-grow w-full border-black py-2 capitalize">
                                                            {{ $avgNilai != '-' ? NumberToWords::transformNumber('id', $avgNilai) : '-' }}
                                                        </h1>
                                                    </div>
                                                </div>
                                                <h1 class="flex justify-center items-center flex-grow">
                                                    @if ($avgNilai != '-')
                                                        {{ $mapel->tugas->where('tahun_ajar', $info_siswa->kelas->tahun_ajar)->where('semester', $info_siswa->kelas->semester)->avg(function ($tugas) use ($info_siswa) {
                                                                return $tugas->nilai->where('id_siswa', $info_siswa->id)->where('tahun_ajar', $info_siswa->kelas->tahun_ajar)->where('semester', $info_siswa->kelas->semester)->avg('nilai');
                                                            }) <= 75
                                                            ? 'Nilai kurang'
                                                            : 'Terlampaui' }}
                                                    @else
                                                        Belum lengkap
                                                    @endif
                                                </h1>
                                            </div>
                                            <div
                                                class="collapse-content flex flex-col justify-center items-center pb-0 px-0 border-t border-black w-full bg-darkblue-200">
                                                @if ($mapel->tugas->where('id_kelas', $info_siswa->kelas->id)->where('tahun_ajar', $info_siswa->kelas->tahun_ajar)->where('semester', $info_siswa->kelas->semester)->count())
                                                    @foreach ($mapel->tugas->where('id_kelas', $info_siswa->kelas->id)->where('tahun_ajar', $info_siswa->kelas->tahun_ajar)->where('semester', $info_siswa->kelas->semester) as $tugas)
                                                        <div
                                                            class="p-0 flex h-max text-center text-sm w-full min-h-0 border-b border-black {{ $tugas->nilai->value('nilai') == null || $tugas->nilai->value('nilai') <= 75 ? 'text-red-600' : '' }}">
                                                            <h1
                                                                class="w-28 flex justify-center items-center border-r border-black">
                                                            </h1>
                                                            <h1
                                                                class="w-72  flex justify-center items-center border-r border-black">
                                                                {{ $tugas->nama }}
                                                            </h1>
                                                            <h1
                                                                class="w-28 flex justify-center items-center border-r border-black">
                                                                75
                                                            </h1>
                                                            <div
                                                                class="flex-col w-60 flex justify-center items-center border-r border-black text-sm">
                                                                <div class="w-full flex">
                                                                    <h1 class="w-20 border-r border-black py-2">
                                                                        {{ $tugas->nilai->where('id_siswa', $info_siswa->id)->where('tahun_ajar', $info_siswa->kelas->tahun_ajar)->where('semester', $info_siswa->kelas->semester)->value('nilai') ?? '-' }}
                                                                    </h1>
                                                                    <h1
                                                                        class="flex-grow w-full border-black py-2 capitalize">
                                                                        {{ $tugas->nilai->where('id_siswa', $info_siswa->id)->where('tahun_ajar', $info_siswa->kelas->tahun_ajar)->where('semester', $info_siswa->kelas->semester)->value('nilai') != null
                                                                            ? NumberToWords::transformNumber(
                                                                                'id',
                                                                                $tugas->nilai->where('id_siswa', $info_siswa->id)->where('tahun_ajar', $info_siswa->kelas->tahun_ajar)->where('semester', $info_siswa->kelas->semester)->value('nilai'),
                                                                            )
                                                                            : '-' }}
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                            <h1
                                                                class="flex justify-center items-center flex-grow max-md:truncate max-md:px-3">
                                                                @if ($tugas->nilai->where('id_siswa', $info_siswa->id)->where('tahun_ajar', $info_siswa->kelas->tahun_ajar)->where('semester', $info_siswa->kelas->semester)->value('nilai') != null)
                                                                    {{ $tugas->nilai->where('id_siswa', $info_siswa->id)->where('tahun_ajar', $info_siswa->kelas->tahun_ajar)->where('semester', $info_siswa->kelas->semester)->value('nilai') <= 75
                                                                        ? 'Nilai kurang'
                                                                        : 'Terlampaui' }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </h1>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <h1 class="p-2 font-semibold">Belum ada data tugas!</h1>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div tabindex="0"
                                            class="collapse rounded-none h-max border-t border-black {{ $isKosong == 'belum_dinilai' ? 'bg-red-500 font-semibold' : '' }}">
                                            <div
                                                class="collapse-title p-0 grid grid-cols-3 text-center text-sm w-full place-content-center min-h-0">
                                                <h1
                                                    class="w-full py-3 border-r border-black h-full flex justify-center items-center">
                                                    {{ $mapel->nama_mapel }}</h1>
                                                <h1
                                                    class="w-full py-3 border-r border-black h-full flex justify-center items-center">
                                                    75</h1>
                                                <h1 class="w-full py-3 h-full flex justify-center items-center">
                                                    {{ $avgNilai }}
                                                </h1>
                                            </div>
                                            <div
                                                class="collapse-content flex flex-col justify-center items-center pb-0 px-0 border-t border-black w-full bg-darkblue-200 font-normal">
                                                @if ($mapel->tugas->where('id_kelas', $info_siswa->kelas->id)->where('tahun_ajar', $info_siswa->kelas->tahun_ajar)->where('semester', $info_siswa->kelas->semester)->count())
                                                    @foreach ($mapel->tugas->where('id_kelas', $info_siswa->kelas->id)->where('tahun_ajar', $info_siswa->kelas->tahun_ajar)->where('semester', $info_siswa->kelas->semester) as $tugas)
                                                        <div class="grid grid-cols-3 text-center text-sm w-full ">
                                                            <h1
                                                                class=" w-full h-full flex justify-center items-center py-3 border-r border-b border-black ">
                                                                {{ $tugas->nama }}</h1>
                                                            <h1
                                                                class=" w-full h-full flex justify-center items-center py-3 border-r border-b border-black ">
                                                                75</h1>
                                                            <h1
                                                                class=" w-full h-full flex justify-center items-center py-3 border-b border-black ">
                                                                {{ $tugas->nilai->where('id_siswa', $info_siswa->id)->where('tahun_ajar', $info_siswa->kelas->tahun_ajar)->where('semester', $info_siswa->kelas->semester)->value('nilai') ?? 'Belum Dinilai' }}
                                                            </h1>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <h1 class="p-2 font-semibold">Belum ada data tugas!</h1>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <dialog id="editModal" class="modal" data-theme="light">
        <div class="modal-box text-black">
            <h1 class="font-bold text-3xl w-full text-center ">Edit Siswa</h1>
            <form action="{{ route('siswa.update', ['siswa' => $info_siswa->id]) }}" method="POST"
                class="w-full h-full flex flex-col gap-2">
                @csrf
                @method('PATCH')
                <select name="id_sekolah" id="select_sekolah" class="select select-bordered border-black ">
                    <option value="" selected>Pilih Sekolah</option>
                    @foreach ($info_siswa->sekolah->all() as $sekolah)
                        <option value="{{ $sekolah->id }}"
                            {{ $info_siswa->sekolah->id == $sekolah->id ? 'selected' : '' }}>{{ $sekolah->nama }}</option>
                    @endforeach
                </select>
                <select name="id_kelas" id="select_kelas" class="select select-bordered border-black" disabled>
                    <option value="" selected>Pilih Kelas</option>
                </select>
                <input name="nama" type="text" class="input-bordered input border-black" placeholder="NIS"
                    value="{{ $info_siswa->nama }}" required>
                <input name="nis" type="text" class="input-bordered input border-black" placeholder="No.Telp"
                    value="{{ $info_siswa->nis }}" required>
                <input name="email" type="email" class="input-bordered input border-black" placeholder="Email"
                    value="{{ $info_siswa->email }}" required>
                <input name="no_telp" pattern="[0-9]+" type="text" class="input-bordered input border-black"
                    placeholder="No.Telp" value="{{ $info_siswa->no_telp }}" required>
                <input type="submit" value="Edit" class="btn btn-info text-white">
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js"
        integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            if ($("#select_sekolah").val() != "") {
                let id_sekolah = $(this).find(':selected').val()
                let id_kelas_siswa = "{{ $info_siswa->kelas->id }}"
                $("#select_kelas").removeAttr("disabled")
                $.ajax({
                    type: "get",
                    url: "{{ route('kelas.index') }}",
                    data: {
                        id_sekolah: id_sekolah
                    },
                    dataType: "json",
                    success: function(response) {
                        let option = document.createElement("option")
                        $.each(response, function(i, val) {
                            option = $("<option>")
                                .attr("value", val.id)
                                .attr("selected", val.id == id_kelas_siswa ? true : false)
                                .text(val.tingkat + " " + val.jurusan + " " + val
                                    .kelas);
                            $("#select_kelas").append(option);
                        });
                    }
                });
            }
            $("#select_sekolah").change(function() {
                let id_sekolah = $(this).val();
                let $selectKelas = $("#select_kelas");

                $selectKelas.empty();

                if (id_sekolah !== "") {
                    $.ajax({
                        type: "get",
                        url: "{{ route('kelas.index') }}",
                        data: {
                            id_sekolah: id_sekolah
                        },
                        dataType: "json",
                        success: function(response) {
                            let option = $("<option>")
                                .attr("value", "")
                                .text("Pilih Kelas");
                            $selectKelas.append(option);

                            $.each(response, function(i, val) {
                                option = $("<option>")
                                    .attr("value", val.id)
                                    .text(val.tingkat + " " + val.jurusan + " " + val
                                        .kelas);
                                $selectKelas.append(option);
                            });

                            $selectKelas.removeAttr("disabled");
                        }
                    });
                } else {
                    $selectKelas.attr("disabled", true);
                }
            });

            let rataRata = $("#rata-rata").data('avg');
            if (rataRata != null) {
                let num = 0;
                let interval = setInterval(() => {
                    num++;
                    $("#rata-rata").text(num);
                    if (num >= rataRata) {
                        clearInterval(interval);
                    }
                }, 10);
            }

            function makeChart(tugas, kuis, ujian, belum) {
                const data = {
                    datasets: [{
                        data: [tugas, kuis, ujian, belum],
                        backgroundColor: ['#139aed', '#17bbdf', '#1eebcc', '#D9D9D9'],
                        borderColor: ['#139aed', '#17bbdf', '#1eebcc', '#D9D9D9'],
                        borderWidth: 1
                    }]
                };
                new Chart("myChart", {
                    type: 'pie',
                    data: data,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                enabled: false
                            },
                            datalabels: {
                                color: 'black',
                                formatter: (value, context) => {
                                    if (value == 0) {
                                        value = "";
                                        return value;
                                    }
                                    let datasets = context.chart.data.datasets;
                                    let sum = datasets[0].data.reduce((a, b) => a + b, 0);
                                    let percentage = Math.round((value / sum) * 100) + '%';
                                    return percentage;
                                },
                                font: {
                                    weight: 'semibold',
                                    size: 14,
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            }

            $.ajax({
                type: "GET",
                url: "{{ route('getNilai') }}",
                data: {
                    'id_siswa': {{ $info_siswa->id }}
                },
                dataType: "json",
                success: function(response) {
                    $("#tugas_ternilai").text(response.nilai.tugas)
                    $("#kuis_ternilai").text(response.nilai.kuis)
                    $("#ujian_ternilai").text(response.nilai.ujian)
                    const isiData = response.nilai;
                    const ternilai = isiData.tugas + isiData.kuis + isiData.ujian
                    makeChart(isiData.tugas, isiData.kuis, isiData.ujian, isiData.belum)
                    $("#bar-ternilai").velocity({
                        width: `${ternilai / isiData.total * 100}%`,
                        opacity: 1
                    }, {
                        duration: 1000
                    });
                }
            });
        });
    </script>
@endsection
