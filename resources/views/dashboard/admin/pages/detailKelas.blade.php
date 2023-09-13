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
            <a onclick="kelasModal.showModal()"
                class="p-2 cursor-pointer border border-black rounded-lg font-semibold flex
                gap-2 justify-center items-center">
                <i class="fa-solid fa-pen"></i> <span class="max-md:hidden">Edit Kelas</span></a>
        </div>
        <div class="w-full h-[75%] py-2 flex gap-1 max-sm:flex-col-reverse pl-10 max-sm:p-4 max-sm:h-full">
            @if ($data->siswa->count())
                <div class="overflow-x-auto w-full h-full scroll-arrow" dir="rtl" data-theme="light">
                    <table class="table table-zebra border-2 border-darkblue-500 text-center" dir="ltr">
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
                                <tr>
                                    <td class="border-r-2 border-darkblue-500">{{ $loop->iteration }}</td>
                                    <td class="border-r-2 border-darkblue-500">{{ $siswa->nis }}</td>
                                    <td class="border-r-2 border-darkblue-500">{{ $siswa->nama }}</td>
                                    <td class="border-r-2 border-darkblue-500">{{ $siswa->tahun_ajar }}</td>
                                    <td class="border-r-2 border-darkblue-500">{{ $siswa->semester }}</td>
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
            <a href="{{ route('siswa.create', ['kelas' => $data->id]) }}"
                class="btn btn-circle self-end max-sm:self-start sticky"><i
                    class="fa-solid fa-plus text-white text-2xl "></i></a>
        </div>
    </div>
    <dialog id="kelasModal" class="modal backdrop-blur-lg">
        <form method="POST" action="{{ route('kelas.update', ['kela' => $data->id]) }}"
            class="modal-box shadow-box text-center bg-white text-black flex flex-col gap-2" data-theme="light">
            <h3 class="font-semibold text-3xl">Edit Kelas</h3>
            @csrf
            @method('PATCH')
            <input type="hidden" name="id_sekolah" value="{{ $data->sekolah->id }}">
            <div class="input-range p-3 border rounded-xl flex items-center border-black bg-gray-100">
                <input type="text" placeholder="Nama Kelas" class="border-black bg-gray-100  w-full " name="nama_kelas"
                    maxlength="25" id="nama_kelas" value="{{ $data->nama_kelas }}" id="nama_kelas" />
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
