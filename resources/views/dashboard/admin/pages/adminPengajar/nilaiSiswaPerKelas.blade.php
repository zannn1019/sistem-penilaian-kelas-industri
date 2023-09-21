@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto relative">
        <header class="w-full flex justify-between  border-b border-black gap-3 items-center text-2xl text-black">
            <div class="w-full flex gap-3 py-3">
                <a href="{{ route('admin-show-mapel-pengajar', ['pengajar' => $info_pengajar->id, 'kelas' => $info_kelas->id]) }}"
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
                            <li><a
                                    href="{{ route('admin-show-mapel-pengajar', ['pengajar' => $info_pengajar->id, 'kelas' => $info_kelas->id]) }}">Mata
                                    Pelajaran</a></li>
                            <li>{{ $data_tugas->nama }}</li>
                        </ul>
                    </div>
                    <h1 class="text-3xl font-semibold max-sm:text-sm"> <span class="max-sm:hidden">Kelas Industri -</span>
                        {{ $info_kelas->sekolah->nama }}</h1>
                    <h1 class="text-5xl font-semibold max-sm:text-lg">
                        {{ $info_kelas->tingkat . ' ' . $info_kelas->jurusan . ' ' . $info_kelas->kelas }}</h1>
                </div>
            </div>
            <div class="d-flex gap-1 w-40 text-sm self-end p-2 font-semibold">
                <i class="fa-solid fa-list-check"></i>
                <span id="jumlah-ternilai">{{ $data_tugas->nilai->count() }}</span>
                <span id="total-ternilai">/{{ $data_tugas->kelas->siswa->count() }}</span>
                <span>Ternilai</span>
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
                                <td>Kategori Penilaian</td>
                                <td>Nilai</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($info_kelas->siswa->all() as $siswa)
                                <tr>
                                    <th class="border-r-2 border-darkblue-500 bg-white truncate">
                                        {{ $siswa->nama }}
                                    </th>
                                    <td class="border-r-2 border-darkblue-500 waktu-tanggal">
                                        {{ optional($siswa->nilai->where('id_tugas', $data_tugas->id)->first())->updated_at ?? '-' }}
                                    </td>
                                    <td class="border-r-2 border-darkblue-500">{{ $data_tugas->tipe }}</td>
                                    <td class="border-r-2 border-darkblue-500 input-nilai cursor-pointer relative"
                                        data-id="{{ $siswa->id }}" data-tugas="{{ $data_tugas->id }}">
                                        <input type="number"
                                            class="w-24 text-center pointer-events-auto bg-transparent focus:outline-none"
                                            placeholder="{{ optional($siswa->nilai->where('id_tugas', $data_tugas->id)->first())->nilai ?? 'Belum Dinilai' }}"
                                            value="{{ optional($siswa->nilai->where('id_tugas', $data_tugas->id)->first())->nilai ?? '' }}"
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
@section('script')
    <script>
        $(document).ready(function() {
            $(document).on('click', function(event) {
                if (!$(event.target).closest('.input-nilai').length) {
                    $(".input-nilai").removeClass("outline outline-darkblue-500");
                }
            });
            $(".input-nilai").click(function() {
                $(this).find("input").focus();

                $(".input-nilai").removeClass("outline outline-darkblue-500");
                $(this).addClass("outline outline-darkblue-500");

                $(".input-nilai input").removeAttr("disabled");
                $(this).siblings().find('input').attr("disabled", true);
            });



            $(".input-nilai input").on('keydown', function(event) {
                if (event.key === "ArrowUp") {
                    let currentInput = $(this);
                    let currentTd = currentInput.closest("td");
                    let currentTr = currentTd.closest("tr");
                    let prevTr = currentTr.prev();
                    let prevInput = prevTr.find(".input-nilai input");
                    let prevTd = prevTr.find(".input-nilai");

                    if (prevInput.length > 0) {
                        $(".input-nilai").not($(this)).removeClass("outline outline-darkblue-500");
                        $(".input-nilai input").not($(this).find('input')).attr("disabled", true)
                        prevInput.removeAttr("disabled");
                        prevInput.focus();
                        $(prevTd).addClass("outline outline-darkblue-500");
                    }
                }
                if (event.key === "ArrowDown") {
                    let currentInput = $(this);
                    let currentTd = currentInput.closest("td");
                    let currentTr = currentTd.closest("tr");
                    let nextTr = currentTr.next();
                    let nextInput = nextTr.find(".input-nilai input");
                    let nextTd = nextTr.find(".input-nilai");

                    if (nextInput.length > 0) {
                        $(".input-nilai").not($(this)).removeClass("outline outline-darkblue-500");
                        $(".input-nilai input").not($(this).find('input')).attr("disabled", true)
                        nextInput.removeAttr("disabled");
                        nextInput.focus();
                        $(nextTd).addClass("outline outline-darkblue-500");
                    }
                }
                if (event.key === "Enter") {
                    let currentInput = $(this);
                    let currentTd = currentInput.closest("td");
                    let currentTr = currentTd.closest("tr");
                    let nextTr = currentTr.next();
                    let nextInput = nextTr.find(".input-nilai input");
                    let nextTd = nextTr.find(".input-nilai");

                    if (currentInput.val() != '') {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('nilai.store') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id_siswa': currentTd.data('id'),
                                'id_tugas': currentTd.data('tugas'),
                                'nilai': $(this).val()
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    let tanggal = currentTr.find('.waktu-tanggal')
                                    tanggal.text(response.time)
                                }
                                if (response.success == 'data_store') {
                                    let count = $("#jumlah-ternilai").text()
                                    $("#jumlah-ternilai").text(parseInt(count) + 1)
                                }
                            }
                        });
                    }

                    if (nextInput.length > 0) {
                        $(".input-nilai").not($(this)).removeClass("outline outline-darkblue-500");
                        $(".input-nilai input").not($(this).find('input')).attr("disabled", true)
                        nextInput.removeAttr("disabled");
                        nextInput.focus();
                        $(nextTd).addClass("outline outline-darkblue-500");
                    }
                }
            });

        });
    </script>
@endsection
