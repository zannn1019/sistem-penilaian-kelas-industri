@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full text-black p-5 max-sm:p-0 flex flex-col gap-2 overflow-y-auto relative "id="content">
        <header class="w-full flex gap-3 items-center text-2xl">
            <a href="{{ route('sekolah.show', ['sekolah' => $data->sekolah->id]) }}"
                class="fa-solid fa-chevron-left max-md:text-lg text-black max-sm:p-5"></a>
            <div class="text-sm max-sm:hidden breadcrumbs">
                <ul>
                    <li><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
                    <li><a
                            href="{{ route('sekolah.show', ['sekolah' => $data->sekolah->id]) }}">{{ $data->sekolah->nama }}</a>
                    </li>
                    <li>{{ $data->nama_kelas . ' ( ' . $data->tingkat . ' ' . $data->jurusan . ' ' . $data->kelas . ' )' }}
                    </li>
                </ul>
            </div>
        </header>
        <div class="w-full items-end justify-between px-10 flex border-b border-black py-1 max-md:gap-2">
            <div class="info">
                <h1 class="text-3xl max-md:text-sm font-semibold">Kelas Industri - {{ $data->sekolah->nama }}</h1>
                <h2 class="text-5xl max-md:text-lg font-semibold">
                    {{ $data->tingkat . ' ' . $data->jurusan . ' ' . $data->kelas }}</h2>
            </div>
            <div class="dropdown dropdown-left justify-self-end self-end p-5" data-theme="light">
                <label tabindex="0" class="text-4xl self-end justify-self-end bg-transparent cursor-pointer "><i
                        class="fa-solid fa-ellipsis-vertical"></i></label>
                <div tabindex="0" class="dropdown-content z-[1] p-2 shadow bg-gray-300 rounded-box w-52 flex flex-col">
                    <a onclick="kelasModal.showModal()" class="w-full hover:font-semibold p-2 border-b border-black"> Edit
                        Kelas</a>
                    <form action="{{ route('kelas.destroy', $data->id) }}" method="POST" class="p-2 hover:font-bold">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Arsip</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="w-full flex justify-end items-end gap-2">
            <button onclick="my_modal_2.showModal()" class="btn btn-info text-xs self-end"><i
                    class="fa-solid fa-file-import"></i>
                Import</button>
            <a href="{{ route('siswa-excel-format') }}" class="btn btn-success text-xs self-end"><i
                    class="fa-solid fa-file-export"></i>
                Download
                Format</a>
        </div>
        <div class="w-full h-[75%] max-sm:h-full max-sm:pl-0 py-2 flex gap-1 max-sm:flex-col pl-10">
            @if ($data->siswa->count())
                <div class="overflow-x-auto w-full h-full scroll-arrow max-sm:p-5" dir="rtl" data-theme="light">
                    <table class="table border-2 border-darkblue-500 text-center max-sm:table-xs" dir="ltr">
                        <thead>
                            <tr class="bg-darkblue-500 text-white">
                                <th>NO</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Tahun Ajaran</th>
                                <th>Semester</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->siswa->all() as $siswa)
                                <tr class="clickable-row hover:bg-gray-200 even:bg-gray-100"
                                    data-link="{{ route('siswa.show', ['siswa' => $siswa->id]) }}">
                                    <td class="border-r-2 border-darkblue-500">{{ $loop->iteration }}</td>
                                    <td class="border-r-2 border-darkblue-500">{{ $siswa->nis }}</td>
                                    <td class="border-r-2 border-darkblue-500">{{ $siswa->nama }}</td>
                                    <td class="border-r-2 border-darkblue-500">{{ $siswa->kelas->tahun_ajar }}</td>
                                    <td class="border-r-2 border-darkblue-500">{{ $siswa->kelas->semester }}</td>
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
            <a href="{{ route('siswa.create', ['kelas' => $data->id]) }}"
                class="btn btn-circle self-end max-sm:self-end sticky m-2">
                <i class="fa-solid fa-plus text-white text-2xl "></i>
            </a>
        </div>
    </div>
    <dialog id="my_modal_2" class="modal text-black" data-theme="light">
        <form method="POST" action="{{ route('siswa-import', ['kelas' => $data->id]) }}"
            class="modal-box shadow-box text-center bg-white text-black flex flex-col gap-2" data-theme="light"
            enctype="multipart/form-data">
            @csrf
            <h3 class="font-semibold text-3xl">Import data siswa!</h3>
            <div class="flex items-center justify-center w-full relative" id="dropFiles">
                <label for="dropzone-file"
                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-gray-100"
                    id="hover-effect">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Klik untuk
                                mengunggah</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">.xlsx, .xls, .csv</p>
                    </div>
                    <input id="dropzone-file" name="excel-file" type="file" class="hidden" required
                        accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                </label>
            </div>
            <div id="messages"></div>
            <input type="submit" class="btn btn-success" value="TAMBAh">
        </form>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>

    </dialog>

    <dialog id="kelasModal" class="modal backdrop-blur-lg">
        <form method="POST" action="{{ route('kelas.update', ['kela' => $data->id]) }}"
            class="modal-box shadow-box text-center bg-white text-black flex flex-col gap-2" data-theme="light">
            <h3 class="font-semibold text-3xl">Edit Kelas</h3>
            @csrf
            @method('PATCH')
            <input type="hidden" name="id_sekolah" value="{{ $data->sekolah->id }}">
            <div class="input-range p-3 border rounded-xl flex items-center border-black bg-gray-100">
                <input type="text" placeholder="Nama Kelas" class="border-black bg-gray-100  w-full "
                    name="nama_kelas" maxlength="25" id="nama_kelas" value="{{ $data->nama_kelas }}"
                    id="nama_kelas" />
                <span class="font-normal" id="indicator">0</span>
                <span class="font-normal">/25</span>
            </div>
            <h1 class="text-start font-semibold">Informasi kelas</h1>
            <div class="w-full flex flex-wrap gap-1">
                <select class="file-input file-input-bordered border-black  flex-grow border px-2" name="tingkat">
                    <option disabled selected>Tingkat</option>
                    <option value="10" {{ $data->tingkat == '10' ? 'selected' : '' }}>10</option>
                    <option value="11" {{ $data->tingkat == '11' ? 'selected' : '' }}>11</option>
                    <option value="12" {{ $data->tingkat == '12' ? 'selected' : '' }}>12</option>
                    <option value="13" {{ $data->tingkat == '13' ? 'selected' : '' }}>13</option>
                </select>
                <input type="text" placeholder="Jurusan" class="input flex-grow input-bordered border-black "
                    name="jurusan" value="{{ $data->jurusan }}" />
                <input type="text" placeholder="Kelas"
                    class="input flex-grow input-bordered border-black  uppercase placeholder:capitalize" name="kelas"
                    maxlength="1" value="{{ $data->kelas }}" />
                <div class="w-full flex gap-5">
                    <div class="form-control w-full">
                        <label class="label p-0">
                            <span class="label-text">Tahun ajaran</span>
                        </label>
                        <input type="text" placeholder="Masukkan tahun ajaran" name="tahun_ajar" id="tahun_ajar"
                            class="input input-bordered focus:outline-none border-black  w-full placeholder:text-xs"
                            value="{{ $data->tahun_ajar }}" disabled />
                    </div>
                    <div class="form-control w-full">
                        <label class="label p-0">
                            <span class="label-text">Semester</span>
                        </label>
                        <select name="semester" id="semester" class="select select-bordered border-black " disabled>
                            <option value="1" {{ $data->semester == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="2" {{ $data->semester == 'genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>
                </div>
                <div class="w-full col-span-2 text-xs flex items-center gap-2">
                    <input type="checkbox" class="checkbox checkbox-sm" id="checkbox-input" />
                    <label for="">Ubah tahun ajaran dan semester</label>
                </div>
            </div>
            <div class="modal-action w-full flex justify-between items-center">
                <button class="bg-gray-100 rounded-6xl py-1 px-5" id="close-btn">Batal</button>
                <button type="submit" class="bg-black text-white rounded-6xl py-1 px-5">Ubah</button>
            </div>
        </form>
    </dialog>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#dropFiles").on("change", function(ev) {
                ev.preventDefault();
                ev.stopPropagation();
                $("#messages").append(`
                    <b>
                        ${$(this).find("#dropzone-file").val().split('\\').pop()    }
                    </b>
                `);
            })


            $(".clickable-row").click(function() {
                window.location.href = $(this).data('link');
            })
            $("#checkbox-input").change(function() {
                if ($(this).is(":checked")) {
                    $("#tahun_ajar").removeAttr('disabled');
                    $("#semester").removeAttr('disabled');
                } else {
                    $("#tahun_ajar").attr('disabled', true);
                    $("#semester").attr('disabled', true);
                }
            })
            $("#indicator").text($("#nama_kelas").val().length)
            $("#nama_kelas").keyup(function() {
                $("#indicator").text($(this).val().length)
            })
            $("#nama_kelas").keydown(function() {
                $("#indicator").text($(this).val().length)
            })

            $("#close-btn").click(function(e) {
                e.preventDefault()
                kelasModal.close()
                $("#bg-blur").addClass('hidden')
            })
        });
    </script>
@endsection
