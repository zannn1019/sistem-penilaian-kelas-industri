@extends('dashboard.layouts.main')

@section('content')
    <div class="w-full h-full max-sm:h-auto text-black p-5 flex flex-col gap-2 overflow-y-auto relative">
        <header class="w-full h-14 flex gap-3 items-center text-2xl justify-between">
            <div class="flex justify-center items-center gap-2">
                <a href="{{ route('pengajar.index') }}" class="fa-solid fa-chevron-left max-md:text-lg text-black"></a>
                <div class="text-sm max-sm:hidden breadcrumbs">
                    <ul>
                        <li><a href="{{ route('pengajar.index') }}">Pengajar</a></li>
                        <li>Profil Pengajar</li>
                    </ul>
                </div>
            </div>
            <div class="h-full">
                <div class="button r" id="button-3">
                    <input type="checkbox" class="checkbox-custom" id="edit-btn" />
                    <div class="knobs"></div>
                    <div class="layer"></div>
                </div>
            </div>
        </header>
        <form method="POST" enctype="multipart/form-data"
            action="{{ route('users.update', ['user' => $data_pengajar->id]) }}"
            class="w-full h-full flex max-md:flex-col max-md:px-1 px-10 max-md:gap-5" id="form-edit" data-theme="light">
            <div class="profile-info flex flex-col max-md:w-full gap-2 p-5 w-60 bg-darkblue-500 rounded-6xl shadow-box">
                @csrf
                @method('PATCH')
                <div class="profile-picture flex justify-center items-center relative">
                    <div id="edit-gambar"
                        class="input-logo bg-gray-100 w-52 max-md:w-53 aspect-square border border-black rounded-circle flex justify-center items-center relative">
                        <div
                            class="absolute cursor-pointer edit-btn hidden border-darkblue-500 border-4 top-2 right-2 z-30 bg-bluesea-500 px-2 py-1 rounded-circle text-white">
                            <i class="fa-solid fa-pen" aria-hidden="true"></i>
                        </div>
                        <div
                            class="overflow-hidden text-4xl text-gray-500 w-full h-full bg-gray-200 z-10 flex justify-center items-center rounded-circle border border-black relative">
                            <input type="file" name="foto" id="input-photo"
                                class="hidden z-10 w-full h-full rounded-circle cursor-pointer opacity-0 absolute top-0 left-0"
                                accept="image/*">
                            <img src="{{ asset('storage/pengajar/' . $data_pengajar->foto) }}" alt=""
                                class="absolute top-0 left-0 w-full h-full pointer-events-none z-20 object-cover"
                                id="photo-preview">
                        </div>
                    </div>
                </div>
                <hr class="border-white">
                <div class="w-full flex flex-col text-white ">
                    <div class="p-1 text-xs">
                        <label for="username">Status</label>
                        <select id="" name="status"
                            class="profile-input w-full border px-3 py-1 rounded-box flex items-center border-white text-white bg-darkblue-500"
                            disabled>
                            <option value="aktif" {{ $data_pengajar->status == 'aktif' ? 'selected' : '' }}>aktif</option>
                            <option value="nonaktif" {{ $data_pengajar->status == 'nonaktif' ? 'selected' : '' }}>nonaktif
                            </option>
                        </select>
                    </div>
                    <div class="p-1 text-xs">
                        <label for="username">Username</label>
                        <input type="text" name="username" id=""
                            class="profile-input w-full border px-3 py-1 rounded-box flex items-center border-white bg-transparent"
                            disabled value="{{ $data_pengajar->username }}">
                    </div>
                    <div class="p-1 text-xs">
                        <label for="email">Email</label>
                        <input type="text" name="email" id=""
                            class="profile-input w-full border px-3 py-1 rounded-box flex items-center border-white bg-transparent"
                            disabled value="{{ $data_pengajar->email }}">
                    </div>
                    <div class="p-1 text-xs">
                        <label for="no_telp">Nomor Telepon</label>
                        <input type="text" name="no_telp" id=""
                            class="profile-input w-full border px-3 py-1 rounded-box flex items-center border-white bg-transparent"
                            disabled value="{{ $data_pengajar->no_telp }}">
                    </div>
                    <div class="pt-5 border-none">
                        <a href="{{ route('admin-dashboard-pengajar', ['pengajar' => $data_pengajar]) }}"
                            class="btn max-sm:w-full border-none bg-bluesea-500 text-white hover:bg-bluesea-600 rounded-6xl">Buka
                            Dashboard Pengajar
                        </a>
                    </div>
                </div>
            </div>
            <div class="w-full h-full px-5 flex flex-col gap-2">
                <h1 class="font-semibold text-xl">PROFIL PENGAJAR</h1>
                <h1
                    class="font-semibold text-4xl max-sm:text-2xl text-transparent bg-clip-text bg-gradient-to-r from-tosca-500 via-blue-500 to-bluesea-500">
                    {{ $data_pengajar->nama }}
                </h1>
                <div class="w-full p-5 flex flex-col shadow-custom rounded-6xl gap-5 h-full">
                    <div class="w-full grid grid-cols-2 max-sm:grid-cols-1 border-collapse gap-0.5">
                        <span><b>Nama</b></span>
                        <input type="text" name="nama" id=""
                            class="profile-input border-l border-black profile-input-2 w-full flex items-center px-2 bg-transparent"
                            disabled value="{{ $data_pengajar->nama }}">
                        <span><b>NIK</b></span>
                        <input type="text" name="nik" id=""
                            class="profile-input border-l border-black profile-input-2 w-full flex items-center px-2 bg-transparent"
                            disabled value="{{ $data_pengajar->nik }}">
                        <span><b>Mata Pelajaran</b></b></span>
                        <span class="px-2 font-semibold flex flex-wrap gap-2 border-l items-center border-black">
                            @php
                                $warna = collect(['bg-purple-200 border-purple-500 text-purple-700', 'bg-tosca-200 border-tosca-500 text-tosca-700', 'bg-bluesea-200 border-bluesea-500 text-bluesea-700', 'bg-bluesky-200 border-bluesky-500 text-bluesky-700', 'bg-orange-200 border-orange-500 text-orange-700']);
                            @endphp

                            @foreach ($mapel_pengajar as $mapel)
                                @php
                                    $data_warna = $warna->random();
                                @endphp
                                <div class="badge badge-outline {{ $data_warna }} flex gap-2 text-xs">
                                    {{ $mapel->nama_mapel }}
                                    <button class="remove-btn hidden" data-id="{{ $mapel->id }}"><i
                                            class="fa-solid fa-x"></i></button>
                                </div>
                            @endforeach
                            <a onclick="mapel_modal.showModal()"
                                class="rounded-full bg-bluesea-500 grid place-content-center cursor-pointer p-1 px-2 text-white hidden text-xs"
                                id="mapel-add">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                        </span>
                    </div>

                    <div class="w-full h-full">
                        <h1 class="font-semibold">Detail</h1>
                        <div
                            class="relative w-full h-full grid grid-cols-2 gap-2 p-5 max-md:grid-cols-1 max-md:p-0 place-content-center">
                            <div
                                class="w-full rounded-3xl bg-darkblue-200 relative flex justify-center items-center gap-2 h-24">
                                <img src="{{ asset('img/sekolah.png') }}"
                                    class="object-cover w-full absolute bottom-0 left-0 h-full" alt="">
                                <h1 class="text-4xl font-semibold ">
                                    {{ $jumlah_sekolah }}</h1>
                                <span class="font-semibold">Sekolah</span>
                                <div class="absolute cursor-pointer edit-btn hidden border-white border-4 -top-2 -right-2 bg-bluesea-500 px-2 py-1 rounded-circle text-white"
                                    onclick="daftar_sekolah_modal.showModal()">
                                    <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div
                                class="w-full rounded-3xl bg-bluesea-100 relative flex justify-center items-center gap-2 h-24">
                                <img src="{{ asset('img/kelas.png') }}"
                                    class="object-cover w-full absolute bottom-0 left-0 h-full" alt="">
                                <h1 class="text-4xl font-semibold ">{{ $data_pengajar->kelas()->count() }}</h1>
                                <span class="font-semibold">Kelas</span>
                                <div class="absolute cursor-pointer edit-btn hidden border-white border-4 -top-2 -right-2 bg-bluesea-500 px-2 py-1 rounded-circle text-white"
                                    onclick="daftar_kelas_modal.showModal()">
                                    <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div
                                class="w-full rounded-3xl bg-bluesky-100 relative flex justify-center items-center gap-2 h-24">
                                <img src="{{ asset('img/tugas.png') }}"
                                    class="object-cover w-full absolute bottom-0 left-0 h-full" alt="">
                                <h1 class="text-4xl font-semibold ">{{ $data_pengajar->tugas()->count() }}</h1>
                                <span class="font-semibold">Tugas</span>
                            </div>
                            <div
                                class="w-full rounded-3xl bg-tosca-100 relative flex justify-center items-center gap-2 h-24">
                                <img src="{{ asset('img/siswa.png') }}"
                                    class="object-cover w-full absolute bottom-0 left-0 h-full" alt="">
                                <h1 class="text-4xl font-semibold ">{{ $jumlah_siswa }}</h1>
                                <span class="font-semibold">Siswa</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-end items-center flex-nowrap gap-1">
                    <input type="submit" value="Simpan Perubahan" id="edit-submit"
                        class="btn max-sm:w-full  btn-info text-white " disabled>
                </div>
            </div>
        </form>

    </div>
    <dialog id="mapel_modal" class="modal">
        <form action="{{ route('pengajar.store', ['tipe' => 'mapel']) }}" method="POST"
            class="modal-box overflow-y-visible flex flex-col gap-1" data-theme="light" id="form_mapel">
            @csrf
            <input type="hidden" name="id_user" value="{{ $data_pengajar->id }}">
            <h3 class="font-bold text-lg">Tambah Mapel</h3>
            <p class="pt-4">Nama mapel</p>
            <div class="input-autocomplete relative w-full">
                <input type="hidden" name="id_mapel" value="" id="id_mapel">
                <input type="text" class="input input-bordered border-black w-full" id="input-autocomplete">
                <div id="result"
                    class="hidden absolute z-20 w-full border border-black rounded-lg mt-1 bg-white max-h-40 overflow-auto">
                </div>
            </div>
            <div id="input-list" class="flex gap-1 flex-wrap">
            </div>
            <div class="modal-action">
                <button class="btn" id="close-btn">Close</button>
                <button class="btn" type="submit">Tambah</button>
            </div>
        </form>
    </dialog>
    <dialog id="daftar_sekolah_modal" class="modal" data-theme="light">
        <div class="modal-box w-full h-auto flex flex-col text-black">
            <h3 class="font-bold text-lg">Daftar Sekolah pengajar</h3>
            <div class="w-full h-full max-h-96 overflow-auto flex flex-col gap-3">
                @foreach ($data_pengajar->sekolah->unique() as $sekolah)
                    <div
                        class="box w-full h-full border p-2 flex gap-3 rounded-xl shadow-md justify-between border-gray-300">
                        <div class="flex h-full justify-center items-center gap-2">
                            <img src="{{ asset('storage/sekolah/' . $sekolah->logo) }}" class="w-10 h-10"
                                alt="">
                            <div class="flex flex-col">
                                <span class="font-semibold">{{ $sekolah->nama }}</span>
                                <span class="text-sm">{{ $sekolah->no_telp }}</span>
                            </div>
                        </div>
                        <a class="self-center justify-self-end btn detach-btn" data-tipe="sekolah"
                            data-id="{{ $sekolah->id }}">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Batal</button>
                </form>
            </div>
        </div>
    </dialog>
    <dialog id="daftar_kelas_modal" class="modal" data-theme="light">
        <div class="modal-box w-full h-auto flex flex-col text-black">
            <h3 class="font-bold text-lg">Daftar kelas pengajar</h3>
            <div class="w-full h-full max-h-96 overflow-auto flex flex-col">
                @foreach ($data_pengajar->sekolah->unique() as $sekolah)
                    <h1 class="font-semibold">{{ $sekolah->nama }}</h1>
                    @foreach ($data_pengajar->kelas->where('id_sekolah', $sekolah->id) as $kelas)
                        <div
                            class="box w-full h-full border p-2 flex gap-3 rounded-xl shadow-md justify-between mb-1 border-gray-300">
                            <div class="flex h-full flex-col gap-2">
                                <h1 class="font-semibold">{{ $kelas->nama_kelas }}</h1>
                                <span
                                    class="text-sm">{{ $kelas->tingkat }}-{{ $kelas->jurusan }}-{{ $kelas->kelas }}</span>
                            </div>
                            <a class="self-center justify-self-end detach-btn btn" data-tipe="kelas"
                                data-id="{{ $kelas->id }}">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        </div>
                    @endforeach
                @endforeach
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Batal</button>
                </form>
            </div>
        </div>
    </dialog>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function isValidLetter(key) {
                return /^[a-zA-Z]$/.test(key);
            }

            $(".detach-btn").click(function(e) {
                e.preventDefault()
                let id = $(this).data('id');
                let tipe = $(this).data('tipe');
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('pengajar.destroy', ['pengajar' => $data_pengajar->id]) }}",
                    data: {
                        tipe: tipe,
                        id: id,
                        '_token': '{{ csrf_token() }}'
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        }
                    }
                });
            })

            $(".remove-btn").click(function(e) {
                e.preventDefault()
                let id = $(this).data('id');
                let btn = $(this);
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('pengajar.destroy', ['pengajar' => $data_pengajar]) }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'tipe': 'mapel',
                        'id_mapel': id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            btn.parent().remove()
                        }
                    }
                });
            })
            let debounceTimer;

            $("#input-autocomplete").keyup(function(e) {
                clearTimeout(debounceTimer);
                let inputVal = $(this).val();

                if (inputVal !== "") {
                    if (isValidLetter(e.key)) {
                        debounceTimer = setTimeout(function() {
                            $("#result").removeClass("hidden");
                            $("#result").empty();
                            let query = inputVal;
                            let id = "{{ $data_pengajar->id }}"
                            $.ajax({
                                type: "GET",
                                url: "{{ route('mapel.index') }}",
                                data: {
                                    'query': query,
                                    'id': id
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.error == null) {
                                        $.each(response, function(i, val) {
                                            let option =
                                                `<div class="result-items cursor-pointer hover:bg-gray-100 p-2 rounded-lg text-xs" data-id='${val.id}'>${val.nama_mapel}</div>`
                                            $("#result").append(option);
                                        });
                                    } else {
                                        let option =
                                            `<div class="cursor-pointer hover:bg-gray-100 p-2 rounded-lg text-xs" id="tambah_mapel" >Tambahkan mapel "${query}"</div>`
                                        $("#result").append(option);
                                    }
                                }
                            });
                        }, 300);
                    }
                } else {
                    $("#result").addClass("hidden");
                }
            });

            let id = [];
            $("#result").on("click", ".result-items ", function() {
                $("#result").addClass("hidden")
                $("#input-autocomplete").val('')
                if (jQuery.inArray($(this).data('id'), id) == '-1') {
                    id.push($(this).data('id'))
                    $("#input-list").append(
                        `
                    <div class="badge badge-outline flex gap-2 text-xs">
                        ${$(this).text()}
                        <button class="remove-btn" data-id=""><i class="fa-solid fa-x"></i></button>
                    </div>
                    `
                    )
                }
                $("#id_mapel").val(id)
            });
            $("#result").on("click", "#tambah_mapel", function() {
                window.location.href = "{{ route('mapel.index') }}"
            });
            $("#close-btn").click(function(e) {
                e.preventDefault()
                mapel_modal.close()
            })
            $("#input-photo").on("change", function(e) {
                const file = URL.createObjectURL(e.target.files[0]);
                $("#photo-preview").attr("src", file);
            });
            $("#edit-btn").click(function() {
                if ($(this).is(':checked')) {
                    $("#edit-gambar").addClass('hover:brightness-50');
                    $("#input-photo").removeClass('hidden');
                    $(".profile-input").removeAttr('disabled');
                    $(".profile-input.profile-input-2").addClass('outline outline-1');
                    $("#edit-submit").removeAttr('disabled')
                    $("#mapel-add").removeClass('hidden')
                    $(".remove-btn").removeClass("hidden")
                    $(".edit-btn").removeClass("hidden");
                    $(this).addClass("bg-green-200");
                } else {
                    $("#edit-gambar").removeClass('hover:brightness-50');
                    $("#input-photo").addClass('hidden');
                    $(".profile-input").attr('disabled', 'true');
                    $("#edit-submit").attr('disabled', 'true')
                    $(".profile-input.profile-input-2").removeClass('outline outline-1');
                    $("#mapel-add").addClass('hidden')
                    $(".remove-btn").addClass("hidden")
                    $(".edit-btn").addClass("hidden");
                }
            })
        })
    </script>
@endsection
