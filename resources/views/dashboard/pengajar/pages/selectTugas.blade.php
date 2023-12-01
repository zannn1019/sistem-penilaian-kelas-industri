@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full p-5 flex flex-col gap-2 ">
        <header
            class="w-full h-1/4 max-sm:h-auto flex justify-between  border-b border-black gap-3 items-center text-2xl text-black">
            <div class="w-full flex gap-3 py-3">
                <a href="{{ route('select-mapel', ['kelas' => $info_kelas->id]) }}"
                    class="fa-solid fa-chevron-left max-md:text-lg text-black"></a>
                <div class="w-full flex flex-col text-xs">
                    <div class="text-sm max-sm:hidden breadcrumbs p-0">
                        <ul>
                            <li><a href="{{ route('kelas-pengajar') }}">Kelas</a></li>
                            <li><a href="{{ route('select-mapel', ['kelas' => $info_kelas->id]) }}">Mata Pelajaran</a></li>
                            <li>{{ $info_mapel->nama_mapel }}</li>
                        </ul>
                    </div>
                    <h1 class="text-3xl font-semibold max-sm:text-sm"><span class="max-sm:hidden">Kelas Industri -</span>
                        {{ $info_kelas->sekolah->nama }}</h1>
                    <h1 class="text-5xl font-semibold max-sm:text-lg    ">
                        {{ $info_kelas->tingkat . ' ' . $info_kelas->jurusan . ' ' . $info_kelas->kelas }}</h1>
                    <h1 class="text-2xl font-semibold max-sm:text-sm">
                        {{ $info_kelas->tahun_ajar . ' - Semester ' . $info_kelas->semester }}</h1>
                </div>
            </div>
        </header>
        <div class="flex h-auto max-sm:h-full relative">
            <div class="self-end sticky bottom-0 py-5 flex flex-col gap-2 max-sm:fixed max-sm:right-5 max-sm:bottom-2">
                <div class="relative w-12 rounded-circle aspect-square flex items-end">
                    <details class="dropdown dropdown-top">
                        <summary
                            class="dropdown-btn absolute bottom-0 bg-darkblue-500 z-[1] p-3 shadow-box btn rounded-circle text-white text-2xl flex justify-center items-center aspect-square"
                            id="list-btn"><i class="fa-solid fa-bars-staggered"></i></summary>
                        <div
                            class="p-3 shadow-box rounded-3xl dropdown-content bg-white absolute bottom-0 left-0 max-sm:-left-52 w-64  flex flex-col text-black text-center justify-center items-center gap-2">
                            <a href="{{ route('show-siswa', ['kelas' => $info_kelas->id]) }}"
                                class="w-full border-b p-2 border-black hover:font-semibold">Daftar siswa</a>
                            <a href="{{ route('tugas.shownilai', ['kelas' => $info_kelas->id, 'mapel' => $info_mapel->id]) }}"
                                class="w-full p-2 hover:font-semibold">Daftar nilai</a>
                        </div>
                    </details>
                </div>
                <div class="relative w-12 rounded-circle aspect-square flex items-end z-10">
                    <details class="dropdown dropdown-top">
                        <summary
                            class="dropdown-btn absolute bottom-0 bg-darkblue-500 z-[1] p-3 shadow-box btn rounded-circle text-white text-2xl flex justify-center items-center aspect-square"
                            id="add-btn"><i class="fa-solid fa-plus"></i></summary>
                        <div
                            class="p-3 shadow-box rounded-3xl dropdown-content bg-white absolute bottom-0 left-0 max-sm:-left-52 w-64 aspect-video flex flex-col text-black justify-center items-center gap-2">
                            <button class="w-full border-b p-2 border-black hover:font-semibold"
                                onclick="tugas.showModal()">Tambah
                                Tugas</button>
                            <button class="w-full border-b p-2 border-black hover:font-semibold"
                                onclick="quiz.showModal()">Tambah
                                Kuis</button>
                            <button class="w-full p-2 hover:font-semibold" onclick="latihan.showModal()">Tambah
                                Latihan</button>
                        </div>
                    </details>
                </div>
            </div>
            <div class="px-5 py-2 max-sm:px-0 w-full h-full text-black flex flex-col gap-2">
                @if ($daftar_tugas['tugas']->count())
                    <h1 class="font-semibold">Daftar Tugas</h1>
                    <div class="w-full grid grid-cols-3  max-sm:grid-cols-1 max-md:grid-cols-2">
                        @foreach ($daftar_tugas['tugas'] as $tugas)
                            <div class="box w-full h-56 p-2">
                                <div class="w-full flex h-full bg-bluesea-100 rounded-box p-5 shadow-lg flex-col">
                                    <div class="w-full flex justify-between h-2/6">
                                        <div class="flex justify-between items-center w-full">
                                            <h1 class="text-black text-2xl font-bold w-52">{{ $tugas->nama }}</h1>
                                            <div class="dropdown dropdown-left">
                                                <label tabindex="0" class="cursor-pointer text-2xl m-1"><i
                                                        class="fa-solid fa-ellipsis"></i></label>
                                                <div tabindex="0"
                                                    class="dropdown-content z-[1] menu p-2 w-40 text-center shadow rounded-box flex flex-col gap-2"
                                                    data-theme="light">
                                                    <button data-id="{{ $tugas->id }}" data-tipe="1"
                                                        class=" edit-btn hover:font-semibold py-1 px-4 w-full border-b border-black">Edit</button>
                                                    <form action="{{ route('tugas.destroy', ['tugas' => $tugas->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="submit" value="Arsip"
                                                            class="hover:font-semibold py-1 px-4 w-full cursor-pointer">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('input-nilai', ['kelas' => $info_kelas->id, 'tugas' => $tugas->id]) }}"
                                        class="w-full h-full grid grid-cols-2 gap-4 justify-between items-center text-black">
                                        <img src="{{ asset('img/_' . $tugas->tipe . '.png') }}" alt=""
                                            class="min-h-12 max-h-40">
                                        <div class=" w-full h-full flex justify-center items-center">
                                            <div
                                                class="flex justify-center flex-col items-center overflow-hidden w-28 aspect-square bg-bluesea-500 rounded-circle">
                                                <div class="w-full flex items-end justify-center">
                                                    <span
                                                        class="font-semibold text-3xl">{{ $tugas->nilai->count() }}</span>
                                                    <span class="text-sm">/{{ $tugas->kelas->siswa->count() }}</span>
                                                </div>
                                                <span>Ternilai</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if (!$daftar_tugas['tugas']->count() && !$daftar_tugas['ujian']->count())
                    <div class="w-full h-full flex flex-col text-black justify-center items-center">
                        <img src="{{ asset('img/404_kelas.png') }}" alt="">
                        <h1>Tidak ada data tugas!</h1>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <dialog id="tugas" class="modal" data-theme="light">
        <div class="modal-box">
            <h3 class="font-semibold text-2xl text-black text-center w-full">Masukkan judul tugas!</h3>
            <form action="{{ route('tugas.store') }}" method="POST"
                class="flex flex-col gap-2 justify-center items-center">
                @csrf
                <input type="hidden" value="{{ $info_kelas->id }}" name="id_kelas">
                <input type="hidden" value="{{ $pengajar_mapel->id }}" name="id_pengajar">
                <input type="hidden" value="tugas" name="tipe">
                <input type="text" name="nama" class="input input-bordered text-black w-full"
                    placeholder="Judul tugas" required>
                <div class="w-full flex gap-5 checkbox-tahunajar">
                    <div class="form-control w-full">
                        <label class="label p-0">
                            <span class="label-text">Tahun ajaran</span>
                        </label>
                        <input type="text" placeholder="Masukkan tahun ajaran" name="tahun_ajar" id="tahun_ajar"
                            class="input input-bordered focus:outline-none border-black  w-full placeholder:text-xs"
                            value="{{ $info_kelas->tahun_ajar }}" disabled />
                    </div>
                    <div class="form-control w-full">
                        <label class="label p-0">
                            <span class="label-text">Semester</span>
                        </label>
                        <select name="semester" id="semester" class="select select-bordered border-black " disabled>
                            <option value="1" {{ $info_kelas->semester == 'ganjil' ? 'selected' : '' }}>Ganjil
                            </option>
                            <option value="2" {{ $info_kelas->semester == 'genap' ? 'selected' : '' }}>Genap
                            </option>
                        </select>
                    </div>
                </div>
                <div class="flex w-full items-center p-2 text-xs gap-2">
                    <input type="checkbox" checked="checked" class="checkbox w-6 h-5 tahun_ajaran" />
                    <span>Ubah tahun ajaran dan semester</span>
                </div>
                <input type="submit" value="Tambah" class="btn self-end">
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    <dialog id="latihan" class="modal" data-theme="light">
        <div class="modal-box">
            <h3 class="font-semibold text-2xl text-black text-center w-full">Masukkan judul latihan!</h3>
            <form action="{{ route('tugas.store') }}" method="POST"
                class="flex flex-col gap-2 justify-center items-center">
                @csrf
                <input type="hidden" value="{{ $info_kelas->id }}" name="id_kelas">
                <input type="hidden" value="{{ $pengajar_mapel->id }}" name="id_pengajar">
                <input type="hidden" value="latihan" name="tipe">
                <input type="text" name="nama" class="input input-bordered text-black w-full"
                    placeholder="Judul Latihan" required>
                <div class="w-full flex gap-5 checkbox-tahunajar">
                    <div class="form-control w-full">
                        <label class="label p-0">
                            <span class="label-text">Tahun ajaran</span>
                        </label>
                        <input type="text" placeholder="Masukkan tahun ajaran" name="tahun_ajar" id="tahun_ajar"
                            class="input input-bordered focus:outline-none border-black  w-full placeholder:text-xs"
                            value="{{ $info_kelas->tahun_ajar }}" disabled />
                    </div>
                    <div class="form-control w-full">
                        <label class="label p-0">
                            <span class="label-text">Semester</span>
                        </label>
                        <select name="semester" id="semester" class="select select-bordered border-black " disabled>
                            <option value="1" {{ $info_kelas->semester == 'ganjil' ? 'selected' : '' }}>Ganjil
                            </option>
                            <option value="2" {{ $info_kelas->semester == 'genap' ? 'selected' : '' }}>Genap
                            </option>
                        </select>
                    </div>
                </div>
                <div class="flex w-full items-center p-2 text-xs gap-2">
                    <input type="checkbox" checked="checked" class="checkbox w-6 h-5 tahun_ajaran" />
                    <span>Ubah tahun ajaran dan semester</span>
                </div>
                <input type="submit" value="Tambah" class="btn self-end">
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    <dialog id="quiz" class="modal" data-theme="light">
        <div class="modal-box">
            <h3 class="font-semibold text-2xl text-black text-center w-full">Masukkan judul kuis!</h3>
            <form action="{{ route('tugas.store') }}" method="POST"
                class="flex flex-col gap-2 justify-center items-center form-tugas">
                @csrf
                <input type="hidden" value="{{ $info_kelas->id }}" name="id_kelas">
                <input type="hidden" value="{{ $pengajar_mapel->id }}" name="id_pengajar">
                <input type="hidden" value="quiz" name="tipe">
                <input type="text" name="nama" class="input input-bordered text-black w-full"
                    placeholder="Judul tugas" required>
                <div class="w-full flex gap-5 checkbox-tahunajar">
                    <div class="form-control w-full">
                        <label class="label p-0">
                            <span class="label-text">Tahun ajaran</span>
                        </label>
                        <input type="text" placeholder="Masukkan tahun ajaran" name="tahun_ajar" id="tahun_ajar"
                            class="input input-bordered focus:outline-none border-black  w-full placeholder:text-xs"
                            value="{{ $info_kelas->tahun_ajar }}" disabled />
                    </div>
                    <div class="form-control w-full">
                        <label class="label p-0">
                            <span class="label-text">Semester</span>
                        </label>
                        <select name="semester" id="semester" class="select select-bordered border-black " disabled>
                            <option value="1" {{ $info_kelas->semester == 'ganjil' ? 'selected' : '' }}>Ganjil
                            </option>
                            <option value="2" {{ $info_kelas->semester == 'genap' ? 'selected' : '' }}>Genap
                            </option>
                        </select>
                    </div>
                </div>
                <div class="flex w-full items-center p-2 text-xs gap-2">
                    <input type="checkbox" checked="checked" class="checkbox w-6 h-5 tahun_ajaran" />
                    <span>Ubah tahun ajaran dan semester</span>
                </div>
                <input type="submit" value="Tambah" class="btn self-end">
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    <template id="edit-template">
        <dialog id="edit_modal" class="modal" data-theme="light">
            <div class="modal-box text-black">
                <h3 class="font-semibold text-2xl text-black text-center w-full" id="title">Edit Assessment!</h3>
                <form action="" method="POST" class="flex flex-col gap-2 justify-center items-center"
                    id="edit-form">
                    @csrf
                    <input type="hidden" value="{{ $info_kelas->id }}" name="id_kelas">
                    <input type="hidden" value="{{ $pengajar_mapel->id }}" name="id_pengajar">
                    <input type="text" name="nama" class="input input-bordered text-black w-full"
                        placeholder="Judul" required id="judul">
                    <select name="tipe" id="assessment-select" class="input input-bordered w-full">
                        <option value="" selected>Pilih Blok</option>
                        <option value="assessment_blok_a">Blok A</option>
                        <option value="assessment_blok_b">Blok B</option>
                    </select>
                    <div class="w-full flex gap-5">
                        <div class="form-control w-full">
                            <label class="label p-0">
                                <span class="label-text">Tahun ajaran</span>
                            </label>
                            <input type="text" placeholder="Masukkan tahun ajaran" name="tahun_ajar" id="tahun_ajar"
                                class="input input-bordered focus:outline-none border-black  w-full placeholder:text-xs"
                                value="{{ $info_kelas->tahun_ajar }}" />
                        </div>
                        <div class="form-control w-full">
                            <label class="label p-0">
                                <span class="label-text">Semester</span>
                            </label>
                            <select name="semester" id="semester" class="select select-bordered border-black ">
                                <option value="ganjil" {{ $info_kelas->semester == 'ganjil' ? 'selected' : '' }}>Ganjil
                                </option>
                                <option value="genap" {{ $info_kelas->semester == 'genap' ? 'selected' : '' }}>Genap
                                </option>
                            </select>
                        </div>
                    </div>
                    <input type="submit" value="Edit" class="btn self-end">
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
    </template>
    <div id="modal"></div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            /**
             *
             * @param tipe 1 untuk kuis dan tugas
             * @param tipe 2 untuk assessment
             *
             */
            function editModal(tipe, id) {
                $("#modal").html('');
                const id_tugas = id;
                const template = document.getElementById("edit-template");
                const clone = document.importNode(template.content, true);
                const modal = clone.getElementById("edit_modal");
                const title = clone.getElementById("title");
                const judul = clone.getElementById("judul");
                const assessment = clone.getElementById("assessment-select");
                const tahun_ajar = clone.getElementById("tahun_ajar");
                const semester = clone.getElementById("semester");
                const edit_form = clone.getElementById("edit-form");

                $.ajax({
                    type: "GET",
                    url: `/pengajar/tugas/${id_tugas}`,
                    dataType: "JSON",
                    success: function(response) {
                        judul.value = response.judul;
                        tahun_ajar.value = response.tahun_ajar;
                        tahun_ajar.semester = response.semester;
                        assessment.value = response
                            .tipe;
                        edit_form.action = `/pengajar/tugas/${id_tugas}`;
                    }
                });

                switch (tipe) {
                    case 1:
                        title.textContent = "Edit Tugas";
                        assessment.remove();
                        break;
                    case 2:
                        title.textContent = "Edit Assesment";
                        break;
                    default:
                        return null;
                        break;
                }
                return clone;
            }

            $(".edit-btn").click(function() {
                let id = $(this).data("id");
                let tipe = $(this).data("tipe");
                let modal = editModal(tipe, id);
                $("#modal").append(modal);
                edit_modal.showModal();
            })


            $("#add-btn").click(function() {
                $(this).toggleClass("rotate-45");
            });
            $(".dropdown-btn").click(function() {
                $('.dropdown-btn').not($(this)).parent().removeAttr('open')
                $('.dropdown-btn').not($(this)).removeClass("rotate-45")
            })
            $("#ujian-otomatis").click(function() {
                if ($(this).is(":checked")) {
                    $("#form-ujian").find("input[type='text'],select").attr(
                        "disabled", true)
                } else {
                    $("#form-ujian").find("input[type='text'],select").removeAttr(
                        "disabled")
                }
            })
            $(".tahun_ajaran").click(function() {
                if ($(this).is(":checked")) {
                    $(".checkbox-tahunajar").find("input[type='text'],select").attr(
                        "disabled", true)
                } else {
                    $(".checkbox-tahunajar").find("input[type='text'],select").removeAttr(
                        "disabled")
                }
            })
        });
    </script>
@endsection
