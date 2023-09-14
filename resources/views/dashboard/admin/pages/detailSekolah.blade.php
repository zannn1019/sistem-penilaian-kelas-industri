@extends('dashboard.layouts.main')
@php
    $warna = collect(['tosca', 'bluesea', 'bluesky']);
@endphp
@section('content')
    <div class="absolute inset-0 backdrop-blur-lg z-10 w-full h-full hidden" id="bg-blur"></div>
    <div class="w-full h-full text-black p-5 max-sm:p-0  flex flex-col gap-2 overflow-y-auto relative"id="content">
        <header class="w-full flex gap-3 items-center text-2xl">
            <a href="{{ route('sekolah.index') }}" class="fa-solid fa-chevron-left max-md:text-lg text-black max-sm:p-5"></a>
            <div class="text-sm max-sm:hidden breadcrumbs">
                <ul>
                    <li><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
                    <li>{{ $info_sekolah->nama }}</li>
                </ul>
            </div>
        </header>
        <div class="w-full h-full flex flex-col max-md:px-5 px-16 gap-2">
            <div class="info-sekolah flex max-md:flex-col max-md:items-center gap-5 relative w-full max-md:pb-10">
                <img src="{{ asset('storage/sekolah/' . $info_sekolah->logo) }}"
                    class="w-44 h-44 z-[5] aspect-square bg-white rounded-circle border-4 border-darkblue-500"
                    alt="">
                <div class="info w-full text-center">
                    <h1 class="text-5xl font-semibold py-2 border-b border-black w-full text-start">
                        {{ $info_sekolah->nama }}</h1>
                </div>
                <div
                    class="w-full h-1/2 rounded-box text-white p-5 flex justify-end max-md:justify-start px-20 max-md:px-0 items-center absolute bottom-0 left-0 bg-darkblue-500">
                    <a href="{{ route('sekolah.edit', ['sekolah' => $info_sekolah->id]) }}"
                        class="absolute top-0 right-0 px-3 py-2"><i
                            class="fa-solid fa-pen rounded-circle border border-white p-2"></i></a>
                    <div class="data w-10/12 max-md:w-full max-md:px-5 max-md:pt-12 max-sm:pt-0 max-sm:pb-0 max-md:pb-5">
                        <div class="contact flex max-md:flex-col max-md:gap-0 gap-10 text-xs">
                            <div class="email flex gap-2 max-md:justify-start justify-center items-center">
                                <i class="fa-solid fa-envelope text-lg"></i>
                                <span><b>Email</b></span>
                                <span> | </span>
                                <span>{{ $info_sekolah->email }}</span>
                            </div>
                            <div class="phone flex gap-2 max-md:justify-start justify-center items-center">
                                <i class="fa-solid fa-phone text-lg"></i>
                                <span><b>No. Telepon</b></span>
                                <span>|</span>
                                <span>{{ $info_sekolah->no_telp }}</span>
                            </div>
                        </div>
                        <div class="address flex items-center gap-2 text-xs">
                            <span><i class="fa-solid fa-school text-sm"></i></span>
                            <span><b>Alamat</b></span>
                            <span>|</span>
                            <span
                                class="capitalize truncate">{{ Str::lower($info_sekolah->jalan . ', ' . $info_sekolah->kelurahan . ', ' . $info_sekolah->kecamatan . ', ' . $info_sekolah->kabupaten_kota . ', ' . $info_sekolah->provinsi) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="data w-full h-full border flex flex-col border-black rounded-box">
                <div
                    class="flex justify-between bg-gray-300 gap-2 w-full rounded-box outline outline-gray-300 p-1 text-center max-sm:flex-col text-gray-500">
                    <a href="{{ route('sekolah.show', ['sekolah' => $info_sekolah->id, 'data' => 'kelas']) }}"
                        class="link-hover w-full {{ Request::get('data') == 'kelas' || Request::get('data') == null ? 'bg-darkblue-500 text-white' : '' }}  p-1 rounded-box">Kelas
                        Industri
                        ({{ $info_sekolah->kelas->count() }})</a>
                    <a href="{{ route('sekolah.show', ['sekolah' => $info_sekolah->id, 'data' => 'pengajar']) }}"
                        class="link-hover w-full {{ Request::get('data') == 'pengajar' ? 'bg-darkblue-500 text-white' : '' }} p-1 rounded-box">Pengajar
                        ({{ $jumlah_pengajar->count() }})</a>
                </div>
                <div class="w-full h-full flex flex-col gap-2 justify-between relative">
                    @if ($info_sekolah->kelas->count() > 0)
                        <div class="w-full grid grid-cols-3 max-md:grid-cols-1 p-2 max-sm:p-0 gap-2">
                            @foreach ($data->paginate(3) as $info)
                                @php
                                    $data_warna = $warna->random();
                                @endphp
                                @if (Request::get('data') == 'kelas' || Request::get('data') == null)
                                    <div class="box w-full h-56 p-2">
                                        <a href="{{ route('kelas.show', ['kela' => $info->id]) }}"
                                            class="w-full flex h-full bg-{{ $data_warna }}-100 rounded-box p-5 shadow-lg flex-col items-center">
                                            <div class="w-full flex justify-between h-2/6">
                                                <div class="info">
                                                    <h1 class="text-black text-xs font-semibold">
                                                        {{ $info->sekolah->nama }}
                                                    </h1>
                                                    <h1
                                                        class="text-{{ $data_warna }}-500 font-bold text-2xl max-sm:text-lg">
                                                        {{ $info->nama_kelas }}
                                                    </h1>
                                                </div>
                                                <img src="{{ asset('storage/sekolah/' . $info->sekolah->logo) }}"
                                                    alt="" class="w-12 h-12 aspect-square rounded-circle">
                                            </div>
                                            <div class="flex w-full text-black text-sm items-center justify-evenly gap-5">
                                                <img src="{{ asset('img/data_kelas.png') }}" alt=""
                                                    class="w-36 max-sm:w-24">
                                                <div class="status flex flex-col gap-1 text-xs">
                                                    <h1 class="font-semibold">Semester Genap</h1>
                                                    <h1 class="font-semibold">
                                                        {{ $info->tingkat }}-{{ $info->jurusan }}-{{ $info->kelas }}
                                                    </h1>
                                                    <span class="font-semibold">{{ $info->siswa->count() }} Siswa</span>
                                                </div>
                                            </div>
                                        </a>
                                        <h1 class="text-black px-2 py-1 font-bold text-xs">
                                            {{ $info->tingkat . ' ' . $info->jurusan . ' ' . $info->kelas }}-
                                            Semester Genap
                                        </h1>
                                    </div>
                                @else
                                    @php
                                        if (Cache::has('is_online' . $info->id) && $info->status == 'aktif') {
                                            $is_online = true;
                                            $bg = 'bg-bluesea-100';
                                            $btn = 'bg-bluesea-500';
                                        } else {
                                            $is_online = false;
                                            if ($info->status == 'aktif') {
                                                $bg = 'bg-tosca-100';
                                                $btn = 'bg-tosca-500';
                                            } else {
                                                $bg = 'bg-darkblue-100';
                                                $btn = 'bg-darkblue-500';
                                            }
                                        }
                                    @endphp
                                    <div
                                        class="w-full h-fit {{ $bg }} flex p-2 rounded-box shadow-xl flex-col items-center gap-0.5 relative py-5">
                                        <div class="dropdown dropdown-end absolute top-0 right-0 px-5 py-3">
                                            <label tabindex="0" class="cursor-pointer">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </label>
                                            <div tabindex="0"
                                                class="dropdown-content z-[1] menu shadow bg-white rounded-box w-20 flex flex-col">
                                                <a href="{{ route('pengajar.show', ['pengajar' => $info->id]) }}"
                                                    class="p-2 hover:font-bold">Edit</a>
                                                <form action="{{ route('users.destroy', $info->id) }}" method="POST"
                                                    class="p-2 hover:font-bold">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="avatar">
                                            <div class="w-20 rounded-full">
                                                <img src="{{ asset('storage/pengajar/' . $info->foto) }}" alt="">
                                            </div>
                                        </div>
                                        <h1 class="font-semibold truncate w-full px-2 text-center">
                                            {{ $info->nama }}
                                        </h1>
                                        <span class="capitalize text-xs">
                                            {!! $is_online == true ? 'Mengakses : ' . '<b>' . Cache::get('at_page' . $info->id) . '</b>' : $info->status !!}</span>
                                        <div class="w-full flex flex-wrap text-center justify-evenly items-center gap-5">
                                            <div>
                                                <h1 class="text-xs">Sekolah</h1>
                                                <span class="font-semibold">{{ $info->jumlah_sekolah }}</span>
                                            </div>
                                            <div>
                                                <h1 class="text-xs">Kelas</h1>
                                                <span class="font-semibold">{{ $info->kelas()->count() }}</span>
                                            </div>
                                            <div>
                                                <h1 class="text-xs">Mapel</h1>
                                                <span class="font-semibold">{{ $info->mapel()->count() }}</span>
                                            </div>
                                        </div>
                                        <div class="w-full flex justify-evenly p-2">
                                            <a href="{{ route('pengajar.show', ['pengajar' => $info->id]) }}"
                                                class="{{ $btn }} px-3 py-1 rounded-box text-white text-xs"><i
                                                    class="fa-solid fa-user"></i> Profile</a>
                                            <div class="dropdown bg-transparent" data-theme="light">
                                                <div tabindex="0"
                                                    class="{{ $btn }} cursor-pointer px-3 py-1 rounded-box text-white text-xs">
                                                    <i class="fa-solid fa-envelope"></i> Contact
                                                </div>
                                                <ul tabindex="0"
                                                    class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-44 ">
                                                    <li><a href="https://wa.me/{{ $info->no_telp }}">Nomor Telepon</a>
                                                    </li>
                                                    <li><a href="mailto:{{ $info->email }}">Email</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="w-full h-full flex flex-col font-semibold text-gray-300 justify-center items-center ">
                            <img src="{{ asset('img/404_kelas.png') }}" alt="" draggable="false">
                            <h1>Belum ada kelas!</h1>
                        </div>
                    @endif
                    <div class="w-full flex justify-between px-5 py-1 items-end gap-1">
                        <a href=""
                            class="btn rounded-circle text-black bg-transparent border-none hover:bg-transparent"><i
                                class="fa-solid fa-up-right-from-square text-xl"></i></a>
                        {{ $data->paginate(3)->links('components.pagination') }}
                        <div class="dropdown dropdown-left dropdown-end relative z-10 w-20">
                            <label id="add-btn" tabindex="0"
                                class="btn rounded-circle text-white text-xl absolute bottom-0 right-0 z-10"><i
                                    class="fa-solid fa-plus"></i></label>
                            <ul tabindex="0"
                                class="dropdown-content z-[1] menu p-2 shadow-box bg-white rounded-box w-64">
                                <li class="border-b"><a onclick="kelasModal.showModal()">Tambah kelas baru</a></li>
                                <li><a onclick="pengajarModal.showModal()">Tambah Pengajar</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <dialog id="kelasModal" class="modal">
        <form method="POST" action="{{ route('kelas.store') }}"
            class="modal-box shadow-box text-center bg-white text-black flex flex-col gap-2" data-theme="light">
            <h3 class="font-semibold text-3xl">Menambahkan Kelas</h3>
            @csrf
            <input type="hidden" name="id_sekolah" value="{{ $info_sekolah->id }}">
            <div class="input-range p-3 border rounded-xl flex items-center border-black bg-gray-100">
                <input type="text" placeholder="Nama Kelas" class="border-black bg-gray-100  w-full "
                    name="nama_kelas" maxlength="25" id="nama_kelas" />
                <span class="font-normal" id="indicator">0</span>
                <span class="font-normal">/25</span>
            </div>
            <h1 class="text-start font-semibold">Informasi kelas</h1>
            <div class="w-full flex flex-wrap gap-1">
                <select class="file-input file-input-bordered border-black  flex-grow border px-2" name="tingkat">
                    <option disabled selected>Tingkat</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                </select>
                <input type="text" placeholder="Jurusan" class="input flex-grow input-bordered border-black "
                    name="jurusan" />
                <input type="text" placeholder="Kelas"
                    class="input flex-grow input-bordered border-black  uppercase placeholder:capitalize" name="kelas"
                    maxlength="1" />
            </div>
            <div class="modal-action w-full flex justify-between items-center">
                <button class="bg-gray-100 rounded-6xl py-1 px-5" id="close-kelas-modal">Batal</button>
                <button type="submit" class="bg-black text-white rounded-6xl py-1 px-5">Tambah</button>
            </div>
        </form>
    </dialog>
    <dialog id="pengajarModal" class="modal">
        <form method="POST" action="{{ route('pengajar.store', ['tipe' => 'sekolah']) }}"
            class="modal-box shadow-box text-center bg-white text-black flex flex-col gap-2 overflow-y-visible"
            data-theme="light" id="pengajar-kelas-form">
            <h3 class="font-semibold text-3xl">Menambahkan Pengajar</h3>
            @csrf
            <input type="hidden" name="id_sekolah" value="{{ $info_sekolah->id }}">
            <select name="id_kelas" id="" class="input input-bordered">
                <option value="" selected>Pilih kelas</option>
                @foreach ($data_kelas as $kelas)
                    <option value="{{ $kelas->id }}">
                        {{ $kelas->nama_kelas . ' - ' . $kelas->tingkat . ' ' . $kelas->jurusan . ' ' . $kelas->kelas }}
                    </option>
                @endforeach
            </select>
            <div class="input-autocomplete relative w-full">
                <input type="text" class="input input-bordered border-black w-full" id="input-autocomplete"
                    placeholder="Masukkan nama pengajar!">
                <input type="hidden" name="id_user" id="pengajar_value">
                <div id="result"
                    class="hidden absolute z-20 w-full border border-black rounded-lg mt-1 bg-white max-h-40 overflow-auto">
                </div>
            </div>
            <div class="modal-action w-full flex justify-between items-center">
                <button class="bg-gray-100 rounded-6xl py-1 px-5" id="close-pengajar-modal">Batal</button>
                <button type="submit" class="bg-black text-white rounded-6xl py-1 px-5">Tambah</button>
            </div>
        </form>
    </dialog>
    <template id="pengajar-card-template">
        <div class="flex justify-between text-start result-items cursor-pointer hover:bg-gray-100 p-2 rounded-lg text-sm gap-2"
            data-id=''>
            <div class="flex gap-1">
                <div class="avatar w-10 rounded-circle overflow-hidden aspect-square">
                    <img src="" alt="" id="foto-pengajar">
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold truncate" id="nama-pengajar"></span>
                    <span class="text-xs" id="nik-pengajar"></span>
                </div>
            </div>
            <div class=" flex justify-center items-center float-right gap-1 px-2" id="mapel-pengajar">
            </div>
        </div>
    </template>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            function isValidLetter(key) {
                return /^[a-zA-Z]$/.test(key);
            }

            function createPengajarCard(id, foto, nama, nik, mapel) {
                const template = document.getElementById('pengajar-card-template');
                const clone = document.importNode(template.content, true);
                const pengajarFoto = clone.getElementById('foto-pengajar');
                const pengajarNama = clone.getElementById('nama-pengajar');
                const pengajarNik = clone.getElementById('nik-pengajar');
                const pengajarDaftarMapel = clone.getElementById('mapel-pengajar');

                const resultItems = clone.querySelectorAll('.result-items')
                resultItems.forEach(item => {
                    item.setAttribute("data-id", id)
                });
                pengajarFoto.setAttribute('src', "{{ asset('storage/pengajar') }}/" + foto);
                pengajarNama.textContent = nama;
                pengajarNik.textContent = nik;

                $.each(mapel, function(i, value) {
                    if (i > 0) {
                        if (i === mapel.length - 1) {
                            const countBadge = document.createElement('div');
                            countBadge.className =
                                'w-5 bg-bluesea-200 shadow-lg border border-bluesea-400 aspect-square object-contain -mr-3 rounded-circle flex justify-center items-center text-2xs';
                            countBadge.textContent = `${mapel.length - 1}+`;
                            pengajarDaftarMapel.appendChild(countBadge);
                        }
                    } else {
                        const mapelBadge = document.createElement('div');
                        mapelBadge.className = 'badge badge-outline flex gap-2 text-xs';
                        mapelBadge.textContent = value;
                        pengajarDaftarMapel.appendChild(mapelBadge);
                    }
                });
                return clone;
            }

            $("#result").on('click', '.result-items', function() {
                let id = $(this).data('id');
                let nama_pengajar = $(this).find("#nama-pengajar").text()
                $("#input-autocomplete").val(nama_pengajar)
                $("#result").addClass("hidden")
                $("#pengajar_value").val(id)
            })
            $("#pengajar-kelas-form").submit(function(e) {
                if ($("#pengajar_value").val() == '') {
                    e.preventDefault()
                    $("#input-autocomplete").addClass("border-error bg-red-100")
                }
            })

            let debounceTimer
            $("#input-autocomplete").keyup(function(e) {
                clearTimeout(debounceTimer);
                let inputVal = $(this).val();
                if (inputVal !== "") {
                    if (isValidLetter(e.key)) {
                        debounceTimer = setTimeout(function() {
                            $("#result").removeClass("hidden");
                            $("#result").empty();
                            let query = inputVal;
                            let data_mapel = [];
                            $.ajax({
                                type: "GET",
                                url: "{{ route('pengajar.index') }}",
                                data: {
                                    'query': query,
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (!response.error) {
                                        $.each(response, function(i, data) {
                                            $.each(data.mapel, function(i,
                                                mapel) {
                                                data_mapel.push(mapel
                                                    .nama_mapel)
                                            });
                                            $("#result").append(
                                                createPengajarCard(
                                                    data.id,
                                                    data.foto,
                                                    data.nama,
                                                    data.nik,
                                                    data_mapel)
                                            )
                                        });
                                    } else {
                                        $("#result").append(
                                            `
                                            <div><h1>Pengajar tidak ada</h1></div>
                                            `
                                        )
                                    }
                                }
                            });
                        }, 300);
                    }
                } else {
                    $("#result").addClass("hidden");
                    $("#pengajar_value").val('');
                }
            });

            function closeModal(modalId) {
                modalId.close()
            }

            $("#nama_kelas").keyup(function() {
                $("#indicator").text($(this).val().length)
            })
            $("#nama_kelas").keydown(function() {
                $("#indicator").text($(this).val().length)
            })
            $("#add-btn").click(function() {
                $("#bg-blur").removeClass("hidden");
            })
            $("#bg-blur").click(function() {
                $(this).addClass("hidden");
            })
            $("#close-kelas-modal").click(function(e) {
                e.preventDefault()
                closeModal(kelasModal)
                $("#bg-blur").addClass('hidden')
            })
            $("#close-pengajar-modal").click(function(e) {
                e.preventDefault()
                closeModal(pengajarModal)
                $("#bg-blur").addClass('hidden')
            })
        });
    </script>
@endsection
