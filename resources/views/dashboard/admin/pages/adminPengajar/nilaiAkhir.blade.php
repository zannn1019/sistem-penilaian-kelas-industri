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
                            <li>Nilai Akhir</li>
                        </ul>
                    </div>
                    <h1 class="text-3xl font-semibold max-sm:text-sm"><span class="max-sm:hidden"> Kelas Industri - </span>
                        {{ $info_kelas->sekolah->nama }}</h1>
                    <h1 class="text-5xl font-semibold max-sm:text-xl">
                        {{ $info_kelas->tingkat . ' ' . $info_kelas->jurusan . ' ' . $info_kelas->kelas }}</h1>
                    <h1 class="text-2xl font-semibold max-sm:text-sm">
                        {{ $info_kelas->tahun_ajar . ' - Semester ' . $info_kelas->semester }}</h1>
                </div>
                <div class="d-flex gap-1 w-40 text-sm self-end p-2 font-semibold">
                    <i class="fa-solid fa-list-check"></i>
                    <span id="jumlah-ternilai">{{ $total_ternilai }}</span>
                    <span id="total-ternilai">/{{ $info_kelas->siswa->count() }}</span>
                    <span>Ternilai</span>
                </div>
            </div>
        </header>
        <div class="w-full h-[75%] max-sm:h-full py-2 flex gap-1 max-sm:flex-col-reverse max-sm:p-0 relative px-10"
            id="tabel-nilai">
            @if ($info_kelas->siswa->count())
                <div class="overflow-x-auto w-full h-full scroll-arrow" dir="rtl" data-theme="light">
                    <table
                        class="table table-zebra max-sm:table-sm border-2 border-darkblue-500 text-center table-pin-rows table-pin-cols"
                        dir="ltr">
                        <thead>
                            <tr class="text-white bg-darkblue-500">
                                <th class="bg-darkblue-500 text-white">Nama Siswa</th>
                                <td>Waktu/Tanggal diubah</td>
                                <td>Nilai</td>
                                <td>Keterangan</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($info_kelas->siswa as $siswa)
                                <tr>
                                    <th class="border-r-2 border-darkblue-500 bg-white truncate max-sm:max-w-[10rem]">
                                        {{ $siswa->nama }}
                                    </th>
                                    <td class="border-r-2 border-darkblue-500 waktu-tanggal">
                                        {{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()->updated_at ?? '-' }}
                                    </td>
                                    <td class="border-r-2 border-darkblue-500 input-nilai relative {{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()->nilai <= 75? 'bg-red-300': '' }}"
                                        data-id="{{ $siswa->id }}">
                                        <input type="number"
                                            class="w-auto text-center pointer-events-none bg-transparent focus:outline-none"
                                            placeholder="{{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()->nilai ?? '-' }}"
                                            value="{{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()->nilai ?? '' }}"
                                            disabled min="0" max="100">
                                    </td>
                                    <td class="border-r-2 border-darkblue-500 input-keterangan relative"
                                        data-id="{{ $siswa->id }}">
                                        <input type="text"
                                            class="w-auto text-center pointer-events-none bg-transparent focus:outline-none"
                                            placeholder="{{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()->keterangan ?? '-' }}"
                                            value="{{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()->keterangan ?? '' }}"
                                            disabled>
                                    </td>
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
