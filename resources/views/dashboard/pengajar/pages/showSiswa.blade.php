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
                            <li>Daftar siswa</li>
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
        <div class="w-full h-[75%] max-sm:h-full max-sm:pl-0 py-2 flex gap-1 max-sm:flex-col-reverse pl-10">
            @if ($info_kelas->siswa->count())
                <div class="overflow-x-auto w-full h-full scroll-arrow" dir="rtl" data-theme="light">
                    <table class="table border-2 border-darkblue-500 text-center" dir="ltr">
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
                            @foreach ($info_kelas->siswa->all() as $siswa)
                                <tr class="clickable-row hover:bg-gray-200 even:bg-gray-100"
                                    data-link="{{ route('detail-siswa', ['kelas' => $info_kelas->id, 'siswa' => $siswa->id]) }}">
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
                <div class="w-full flex justify-center items-center flex-col text-gray-500">
                    <img src="{{ asset('img/404_kelas.png') }}" alt="" draggable="false">
                    <h1>Belum ada siswa!</h1>
                </div>
            @endif
            <a href="{{ route('siswa.create', ['kelas' => $info_kelas->id]) }}"
                class="btn btn-circle self-end max-sm:self-end sticky"><i
                    class="fa-solid fa-plus text-white text-2xl "></i></a>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(".clickable-row").click(function() {
                window.location.href = $(this).data('link');
            })
        });
    </script>
@endsection
