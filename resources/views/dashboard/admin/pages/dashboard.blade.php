@extends('dashboard.layouts.main')

@mobile
    @php
        $jumlah = 7;
    @endphp
@elsemobile
    @php
        $jumlah = 10;
    @endphp
@endmobile

@section('content')
    <div class="w-full h-full text-black p-2 flex flex-col gap-2 overflow-y-auto">
        <div class="w-full h-24 grid grid-cols-2 max-md:grid-cols-1 grid-rows-1">
            <div class="w-full border-2 p-2 h-full rounded-3xl shadow-xl flex flex-col justify-center items-center">
                <h1 class="font-semibold">Instansi Terkait</h1>
                <div class="w-full h-full flex justify-center items-center">
                    @foreach ($data_sekolah as $sekolah)
                        @if ($loop->iteration > $jumlah)
                            @if ($loop->last)
                                <div
                                    class="w-10 bg-bluesea-200 shadow-lg border border-bluesea-400 aspect-square object-contain -mr-3 rounded-circle flex justify-center items-center">
                                    {{ $loop->count - $jumlah }}+
                                </div>
                            @endif
                        @else
                            <img src="{{ asset('storage/sekolah/' . $sekolah->logo) }}" alt=""
                                class="w-10 aspect-square object-contain -mr-3 rounded-circle">
                        @endif
                    @endforeach
                    <a href="{{ route('sekolah.create') }}"
                        class="w-10 bg-gray-200 rounded-circle aspect-square shadow-box border-2 border-darkblue-100 flex justify-center items-center"><i
                            class="fa-solid fa-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="w-full h-full max-h-full flex gap-5 max-md:flex-col">
            <div
                class="w-8/12 max-md:w-full max-sm:h-max max-sm:max-h-96 flex flex-col h-full shadow-2xl bg-gradient-to-r from-bluesky-500 from-20% to-darkblue-500 rounded-2xl">
                <div class="w-full h-3/6 flex items-center justify-center">
                    <div class="w-auto text-center py-10">
                        <h1 class="bg-tosca-500 px-5 py-1 rounded-2xl max-sm:text-xs">{{ date('d M Y') }}</h1>
                        <h1 class="text-8xl text-white max-sm:text-2xl">{{ $daftar_pengajar->count() }}</h1>
                        <span class="text-white text-xl max-sm:text-sm">Pengajar</span>
                    </div>
                    <img src="{{ asset('img/meet.png') }}" alt=""
                        class="h-full max-md:h-36 object-cover max-sm:h-24">
                </div>
                <div
                    class="w-full h-3/6 rounded-2xl bg-gray-100 shadow-inner grid grid-cols-2 max-sm:grid-cols-1 overflow-hidden">
                    <div class="h-auto flex flex-col gap-1 overflow-y-auto bg-white shadow-box">
                        <div class="p-2">
                            <div class="w-full rounded-box bg-gray-300 flex justify-between items-center px-2">
                                <input type="text" class="bg-transparent p-2 w-full">
                                <i class="fa-solid fa-magnifying-glass border-l-2 border-black pl-2"></i>
                            </div>
                        </div>
                        @foreach ($daftar_pengajar as $pengajar)
                            <div data-id="{{ $pengajar->id }}"
                                class="info-pengajar w-full flex gap-2 cursor-pointer hover:bg-gray-200 text-sm pr-2 {{ $loop->iteration == $loop->last ? '' : 'border-b' }}">
                                <div class="h-full p-1 py-5 bg-darkblue-500 rounded-l rounded-xl hidden indikator-pengajar">
                                </div>
                                <img src="{{ asset('storage/pengajar/' . $pengajar->foto) }}" alt=""
                                    class="w-11 rounded-circle aspect-square ml-2 py-1">
                                <div class="info w-full text-xs flex flex-col gap-1 py-2">
                                    <h1>{{ $pengajar->nama }}</h1>
                                    <div class="w-full flex justify-between">
                                        <span class="text-2xs"><i
                                                class="fa-solid fa-school-flag bg-darkblue-100 p-0.5 rounded-lg aspect-square"></i>
                                            {{ $pengajar->jumlah_sekolah }} sekolah</span>
                                        <span class="text-2xs"><i
                                                class="fa-solid fa-chalkboard-user bg-darkblue-100 p-0.5 rounded-lg aspect-square"></i>
                                            {{ $pengajar->kelas()->count() }} kelas</span>
                                        <span class="text-2xs"><i
                                                class="fa-solid fa-id-card bg-darkblue-100 p-0.5 rounded-lg aspect-square"></i>
                                            {{ $pengajar->nik }}</span>
                                    </div>
                                </div>
                                <div class="h-full flex justify-center items-center text-xl hidden indikator-pengajar">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="w-full h-full p-2 flex flex-col justify-center items-center gap-3 max-sm:hidden text-center "
                        id="profile-pengajar">
                        <h1>Lihat profil lengkap pengajar</h1>
                        <a href="{{ route('pengajar.index') }}"
                            class="btn bg-bluesky-500 border-none hover:bg-bluesky-600 outline-none text-white rounded-6xl shadow-custom px-5 text-sm">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
            <div class="w-4/12 max-md:w-full grid grid-cols-2 grid-rows-2 h-full gap-2">
                <div
                    class="w-full h-full bg-tosca-100 flex justify-evenly items-center flex-col shadow-custom rounded-xl relative overflow-hidden">
                    <img src="{{ asset('img/sekolah_tosca.png') }}" alt="" class="p-1">
                    <h1 class="text-xl w-full text-center bg-white z-10 p-2 shadow-custom-2">Instansi Sekolah
                    </h1>
                    <div
                        class="w-16 h-16 text-3xl font-semibold border border-tosca-500 rounded-circle flex justify-center items-center bg-white absolute z-0">
                        <h1>{{ $data_sekolah->count() }}</h1>
                    </div>
                </div>
                <div
                    class="w-full h-full bg-tosca-100 flex justify-evenly items-center flex-col shadow-custom rounded-xl relative overflow-hidden">
                    <img src="{{ asset('img/sekolah_tosca.png') }}" alt="" class="p-1">
                    <h1 class="text-xl w-full text-center bg-white z-10 p-2 shadow-custom-2">Mata Pelajaran
                    </h1>
                    <div
                        class="w-16 h-16 text-3xl font-semibold border border-tosca-500 rounded-circle flex justify-center items-center bg-white absolute z-0">
                        <h1>{{ $mapel }}</h1>
                    </div>
                </div>
                <div
                    class="w-full h-full bg-tosca-100 flex justify-evenly items-center flex-col shadow-custom rounded-xl relative overflow-hidden">
                    <img src="{{ asset('img/sekolah_tosca.png') }}" alt="" class="p-1">
                    <h1 class="text-xl w-full text-center bg-white z-10 p-2 shadow-custom-2">Kelas Industri
                    </h1>
                    <div
                        class="w-16 h-16 text-3xl font-semibold border border-tosca-500 rounded-circle flex justify-center items-center bg-white absolute z-0">
                        <h1>{{ $kelas }}</h1>
                    </div>
                </div>
                <div
                    class="w-full h-full bg-tosca-100 flex justify-evenly items-center flex-col shadow-custom rounded-xl relative overflow-hidden">
                    <img src="{{ asset('img/sekolah_tosca.png') }}" alt="" class="p-1">
                    <h1 class="text-xl w-full text-center bg-white z-10 p-2 shadow-custom-2">Siswa/Siswi
                    </h1>
                    <div
                        class="w-16 h-16 text-3xl font-semibold border border-tosca-500 rounded-circle flex justify-center items-center bg-white absolute z-0">
                        <h1>{{ $siswa }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <template id="info-pengajar-template">
        <div class="w-full flex flex-col h-full justify-center items-center relative">
            <a href="{{ route('pengajar.show', ['pengajar' => 15]) }}" class="absolute top-0 right-0" id="link_profile">
                <i class="fa-solid fa-up-right-from-square"></i>
            </a>
            <img src="{{ asset('storage/pengajar/ahmad-fauza.jpg') }}" alt=""
                class="aspect-square w-20 rounded-circle" id="foto_pengajar">
            <span class="text-black font-semibold leading-3 text-lg" id="nama_pengajar">Ahmad Fauzan</span>
            <span class="text-gray-400 text-xs py-0.5">Pengajar</span>
            <table>
                <tr class="border border-black">
                    <th class="border border-black p-0.5 px-2 text-xs">SEKOLAH</th>
                    <th class="border border-black p-0.5 px-2 text-xs">KELAS</th>
                    <th class="border border-black p-0.5 px-2 text-xs">SISWA</th>
                </tr>
                <tr>
                    <td class="py-1 text-lg font-semibold" id="jumlah_sekolah">10</td>
                    <td class="py-1 text-lg font-semibold" id="jumlah_kelas">10</td>
                    <td class="py-1 text-lg font-semibold" id="jumlah_siswa">10</td>
                </tr>
            </table>
        </div>
    </template>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            function infoPengajarCard(id, nama, foto, jumlah_sekolah, jumlah_kelas, jumlah_siswa) {
                const template = document.getElementById('info-pengajar-template');
                const clone = document.importNode(template.content, true);
                const namaPengajar = clone.getElementById('nama_pengajar');
                const fotoPengajar = clone.getElementById('foto_pengajar');
                const jumlahSekolah = clone.getElementById('jumlah_sekolah');
                const jumlahKelas = clone.getElementById('jumlah_kelas');
                const jumlahSiswa = clone.getElementById('jumlah_siswa');
                const linkProfile = clone.getElementById('link_profile');

                namaPengajar.textContent = nama;
                fotoPengajar.setAttribute('src', "{{ asset('storage/pengajar') }}/" + foto);
                linkProfile.setAttribute('href', "/admin/pengajar/" + id);
                jumlahSekolah.textContent = jumlah_sekolah;
                jumlahKelas.textContent = jumlah_kelas;
                jumlahSiswa.textContent = jumlah_siswa;

                return clone
            }
            $(".info-pengajar").click(function() {
                let id = $(this).data('id')
                $(this).find('.indikator-pengajar').removeClass('hidden');
                $(".indikator-pengajar").not($(this).find('.indikator-pengajar')).addClass('hidden');
                $(this).addClass("bg-gray-200")
                $(".info-pengajar").not($(this)).removeClass("bg-gray-200")
                $("#profile-pengajar").addClass("bg-white border-l")
                $.ajax({
                    type: "GET",
                    url: "{{ route('pengajar.index') }}",
                    data: {
                        pengajar: id
                    },
                    dataType: "json",
                    success: function(response) {
                        let clone = infoPengajarCard(response.data.id, response.data.nama,
                            response.data
                            .foto,
                            response
                            .jumlah_sekolah, response.jumlah_kelas, response.jumlah_siswa)
                        $("#profile-pengajar").html('')
                        $("#profile-pengajar").append(clone)
                    }
                });
            });
        });
    </script>
@endsection
