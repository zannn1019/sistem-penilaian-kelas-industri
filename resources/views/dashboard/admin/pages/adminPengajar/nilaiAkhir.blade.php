{{-- @extends('dashboard.layouts.main')
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
                            <li>Assessment {{ $info_kelas->semester == 'ganjil' ? 'Blok A' : 'Blok B' }}</li>
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
                                        {{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()?->updated_at ?? '-' }}
                                    </td>
                                    <td class="border-r-2 border-darkblue-500 input-nilai relative {{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()?->nilai <= 75? 'bg-red-300': '' }}"
                                        data-id="{{ $siswa->id }}">
                                        <input type="number"
                                            class="w-auto text-center pointer-events-none bg-transparent focus:outline-none"
                                            placeholder="{{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()?->nilai ?? '-' }}"
                                            value="{{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()?->nilai ?? '' }}"
                                            disabled min="0" max="100">
                                    </td>
                                    <td class="border-r-2 border-darkblue-500 input-keterangan relative"
                                        data-id="{{ $siswa->id }}">
                                        <input type="text"
                                            class="w-auto text-center pointer-events-none bg-transparent focus:outline-none"
                                            placeholder="{{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()?->keterangan ?? '-' }}"
                                            value="{{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()?->keterangan ?? '' }}"
                                            disabled>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="w-full flex justify-center items-center flex-col text-gray-500 pointer-events-none select-none">
                    <img src="{{ asset('img/404_kelas.png') }}" alt="" draggable="false">
                    <h1>Belum ada siswa!</h1>
                </div>
            @endif
        </div>
    </div>
@endsection --}}
@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto relative">
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
                            <li>Assessment {{ $info_kelas->semester == 'ganjil' ? 'Blok A' : 'Blok B' }}</li>
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
                                        {{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()?->updated_at ?? '-' }}
                                    </td>
                                    <td class="border-r-2 border-darkblue-500 input-nilai relative {{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()?->nilai <= 75? 'bg-red-300': '' }}"
                                        data-id="{{ $siswa->id }}">
                                        <input type="number"
                                            class="w-auto text-center pointer-events-none bg-transparent focus:outline-none"
                                            placeholder="{{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()?->nilai ?? '-' }}"
                                            value="{{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()?->nilai ?? '' }}"
                                            disabled min="0" max="100">
                                    </td>
                                    <td class="border-r-2 border-darkblue-500 input-keterangan relative"
                                        data-id="{{ $siswa->id }}">
                                        <input type="text"
                                            class="w-auto text-center pointer-events-none bg-transparent focus:outline-none"
                                            placeholder="{{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()?->keterangan ?? '-' }}"
                                            value="{{ optional($siswa->nilai_akhir)->where('tahun_ajar', $info_kelas->tahun_ajar)->where('semester', $info_kelas->semester)->first()?->keterangan ?? '' }}"
                                            disabled>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="w-full flex justify-center items-center flex-col text-gray-500 pointer-events-none select-none">
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
            function clearActiveInput() {
                $(".input-nilai, .input-keterangan").removeClass("outline outline-darkblue-500");
                $(".input-nilai input, .input-keterangan input").attr("disabled", true);
            }

            function inputNilai(input, id_siswa, nilai, keterangan = null, tahun_ajar, semester) {
                let currentInput = input;
                let currentTd = currentInput.closest("td");
                let currentTr = currentTd.closest("tr");
                $.ajax({
                    type: "POST",
                    url: "{{ route('input-nilai-akhir') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id_siswa': id_siswa,
                        'nilai': nilai,
                        'keterangan': keterangan,
                        'tahun_ajar': tahun_ajar,
                        'semester': semester
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.nilai_kurang) {
                            currentTd.addClass('bg-red-300')
                        }
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

            function activateInput(clickedInput) {
                clearActiveInput();
                clickedInput.addClass("outline outline-darkblue-500");
                clickedInput.find('input').removeAttr("disabled");
                clickedInput.find('input').focus();
            }

            function moveUp(input, inputClass) {
                let currentInput = input;
                let currentTd = currentInput.closest("td");
                let currentTr = currentTd.closest("tr");
                let prevTr = currentTr.prev();
                let prevInput = prevTr.find(`.${inputClass} input`);
                let prevTd = prevTr.find(`.${inputClass}`);

                if (prevInput.length > 0) {
                    clearActiveInput();
                    prevInput.removeAttr("disabled");
                    prevInput.focus();
                    prevTd.addClass("outline outline-darkblue-500");
                }
            }

            function moveDown(input, inputClass) {
                let currentInput = input;
                let currentTd = currentInput.closest("td");
                let currentTr = currentTd.closest("tr");
                let nextTr = currentTr.next();
                let nextInput = nextTr.find(`.${inputClass} input`);
                let nextTd = nextTr.find(`.${inputClass}`);

                if (nextInput.length > 0) {
                    clearActiveInput();
                    nextInput.removeAttr("disabled");
                    nextInput.focus();
                    nextTd.addClass("outline outline-darkblue-500");
                }
            }

            function handleEnter(input, inputClass) {
                let currentInput = input;
                let currentTd = currentInput.closest("td");
                let currentTr = currentTd.closest("tr");
                let nextTr = currentTr.next();
                let nextInput = nextTr.find(`.${inputClass} input`);
                let nextTd = nextTr.find(`.${inputClass}`);

                if (currentInput.val() != '') {
                    if ($(currentInput).val() <= 100 && $(currentInput).val() >= 0) {
                        if ($(currentInput).val() <= 75) {
                            let closestTd = currentTd.next();
                            activateInput(closestTd);
                            currentTd.addClass("bg-red-300");
                        } else {
                            currentTd.removeClass("bg-red-300");
                            moveDown(input, "input-nilai");
                            inputNilai(input, $(currentTd).data('id'), $(currentInput).val(), $(currentInput)
                                .parent()
                                .next().find('input').val(),
                                "{{ $info_kelas->tahun_ajar }}", "{{ $info_kelas->semester }}")
                        }
                    } else {
                        currentTd.addClass("bg-red-300")
                    }
                }
            }

            function handleKeterangan(input, nilai) {
                let currentInput = input;
                let currentTd = currentInput.closest("td");
                let prevTd = currentInput.prev();
                if (nilai == null || nilai === '') {
                    $(currentInput).parent().prev().addClass("bg-red-300")
                } else {
                    inputNilai(input, $(currentTd).data('id'), nilai, $(currentInput).val(),
                        "{{ $info_kelas->tahun_ajar }}", "{{ $info_kelas->semester }}")
                    moveDown($(currentInput), "input-nilai");
                }
            }

            $(document).on('click', function(event) {
                if (!$(event.target).closest('.input-nilai, .input-keterangan').length) {
                    $(".input-nilai, .input-keterangan").removeClass("outline outline-darkblue-500");
                }
            });

            $(".input-nilai, .input-keterangan").click(function() {
                activateInput($(this));
            });

            $(".input-nilai input").on('keydown', function(event) {
                if (event.key === "ArrowUp") {
                    moveUp($(this), "input-nilai");
                }
                if (event.key === "ArrowDown") {
                    moveDown($(this), "input-nilai");
                }
                if (event.key === "Enter") {
                    handleEnter($(this), "input-nilai");
                }
            });

            $(".input-keterangan input").on('keydown', function(event) {
                if (event.key === "ArrowUp") {
                    moveUp($(this), "input-keterangan");
                }
                if (event.key === "ArrowDown") {
                    moveDown($(this), "input-keterangan");
                }
                if (event.key === "Enter") {
                    let nilai = $(this).parent().prev().find('input').val();
                    handleKeterangan($(this), nilai);
                }
            });

        });
    </script>
@endsection
