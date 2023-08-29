@extends('dashboard.layouts.main')

@section('content')
    <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto relative">
        <header class="w-full h-14 flex gap-3 items-center text-2xl justify-between">
            <div class="flex justify-center items-center gap-2">
                <a href="{{ route('pengajar.index') }}" class="fa-solid fa-chevron-left max-sm:text-xl text-black"></a>
                <div class="text-sm max-sm:hidden breadcrumbs">
                    <ul>
                        <li><a href="{{ route('pengajar.index') }}">Pengajar</a></li>
                        <li>Profil Pengajar</li>
                    </ul>
                </div>
            </div>
            <div class="h-full">
                <div class="button r" id="button-3">
                    <input type="checkbox" class="checkbox" id="edit-btn" />
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
                    <div
                        class="input-logo bg-gray-100 w-52 max-md:w-53 aspect-square border border-black rounded-circle flex justify-center items-center relative">
                        <div
                            class="overflow-hidden text-4xl text-gray-500 w-full h-full bg-gray-200 z-10 flex justify-center items-center rounded-circle border border-black relative">
                            <input type="file" name="foto" id="input-photo"
                                class="hidden z-10 w-full h-full rounded-circle cursor-pointer opacity-0 absolute top-0 left-0"
                                accept="image/*">
                            <img src="{{ asset('storage/pengajar/' . $data_pengajar->foto) }}" alt=""
                                class="absolute top-0 left-0 w-full h-full pointer-events-none z-20" id="photo-preview">
                        </div>
                    </div>
                </div>
                <hr class="border-white">
                <div class="w-full flex flex-col gap-2 text-white ">
                    <div class="p-2 text-xs">
                        <label for="username">Status</label>
                        <select id="" name="status"
                            class="profile-input w-full border px-3 py-1 rounded-box flex items-center border-white text-white bg-darkblue-500"
                            disabled>
                            <option value="aktif" {{ $data_pengajar->status == 'aktif' ? 'selected' : '' }}>aktif</option>
                            <option value="nonaktif" {{ $data_pengajar->status == 'nonaktif' ? 'selected' : '' }}>nonaktif
                            </option>
                        </select>
                    </div>
                    <div class="p-2 text-xs">
                        <label for="username">Username</label>
                        <input type="text" name="username" id=""
                            class="profile-input w-full border px-3 py-1 rounded-box flex items-center border-white bg-transparent"
                            disabled value="{{ $data_pengajar->username }}">
                    </div>
                    <div class="p-2 text-xs">
                        <label for="email">Email</label>
                        <input type="text" name="email" id=""
                            class="profile-input w-full border px-3 py-1 rounded-box flex items-center border-white bg-transparent"
                            disabled value="{{ $data_pengajar->email }}">
                    </div>
                    <div class="p-2 text-xs">
                        <label for="no_telp">Nomor Telepon</label>
                        <input type="text" name="no_telp" id=""
                            class="profile-input w-full border px-3 py-1 rounded-box flex items-center border-white bg-transparent"
                            disabled value="{{ $data_pengajar->no_telp }}">
                    </div>
                </div>
            </div>
            <div class="w-full h-full px-5 flex flex-col gap-2">
                <h1 class="font-semibold text-xl">PROFIL PENGAJAR</h1>
                <h1
                    class="font-semibold text-5xl max-sm:text-3xl text-transparent bg-clip-text bg-gradient-to-r from-tosca-500 via-blue-500 to-bluesea-500">
                    {{ $data_pengajar->nama }}
                </h1>
                <div class="w-full p-10 max-sm:p-5 flex flex-col shadow-custom rounded-6xl gap-5 h-full">
                    <div class="w-full grid grid-cols-2 max-sm:hidden">
                        <div class="w-full flex flex-col gap-2">
                            <span><b>Nama</b></span>
                            <span><b>NIK</b></span>
                            <span><b>Mata Pelajaran</b></b></span>
                        </div>
                        <div class="w-full flex flex-col gap-2 border-l border-black px-5">
                            <input type="text" name="nama" id=""
                                class="profile-input profile-input-2 w-full flex items-center px-2 bg-transparent" disabled
                                value="{{ $data_pengajar->nama }}">
                            <input type="text" name="nik" id=""
                                class="profile-input profile-input-2 w-full flex items-center px-2 bg-transparent" disabled
                                value="{{ $data_pengajar->nik }}">
                            <span class="px-2">SQL,PHP,PYTON</span>
                        </div>
                    </div>
                    <div class="w-full hidden grid-cols-1 max-sm:grid">
                        <span><b>Nama</b></span>
                        <span>{{ $data_pengajar->nama }}</span>
                        <span><b>NIK</b></span>
                        <span>{{ $data_pengajar->nik }}</span>
                        <span><b>Mata Pelajaran</b></b></span>
                        <span>SQL,PHP,PYTON</span>
                    </div>
                    <div class="w-full h-full">
                        <h1 class="font-semibold">Detail</h1>
                        <div
                            class="w-full h-full grid grid-cols-2 gap-2 p-5 max-md:grid-cols-1 max-md:p-0 place-content-center">
                            <div
                                class="w-full overflow-hidden rounded-3xl bg-darkblue-200 relative flex justify-center items-center gap-2 h-24">
                                <img src="{{ asset('img/sekolah.png') }}" class="object-fill absolute -bottom-1/2 left-0"
                                    alt="">
                                <h1 class="text-4xl font-semibold ">10</h1>
                                <span class="font-semibold">Sekolah</span>
                            </div>
                            <div
                                class="w-full overflow-hidden rounded-3xl bg-bluesea-100 relative flex justify-center items-center gap-2 h-24">
                                <img src="{{ asset('img/kelas.png') }}" class="object-fill absolute -bottom-1/2 left-0"
                                    alt="">
                                <h1 class="text-4xl font-semibold ">10</h1>
                                <span class="font-semibold">Kelas</span>
                            </div>
                            <div
                                class="w-full overflow-hidden rounded-3xl bg-bluesky-100 relative flex justify-center items-center gap-2 h-24">
                                <img src="{{ asset('img/tugas.png') }}" class="object-fill absolute -bottom-1/2 left-0"
                                    alt="">
                                <h1 class="text-4xl font-semibold ">10</h1>
                                <span class="font-semibold">Tugas</span>
                            </div>
                            <div
                                class="w-full overflow-hidden rounded-3xl bg-tosca-100 relative flex justify-center items-center gap-2 h-24">
                                <img src="{{ asset('img/siswa.png') }}" class="object-fill absolute -bottom-1/2 left-0"
                                    alt="">
                                <h1 class="text-4xl font-semibold ">10</h1>
                                <span class="font-semibold">Siswa</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-end p-5">
                    <input type="submit" value="Simpan Perubahan" id="edit-submit" class="btn btn-info text-white"
                        disabled>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#input-photo").on("change", function(e) {
                const file = URL.createObjectURL(e.target.files[0]);
                $("#photo-preview").attr("src", file);
            });
            $("#edit-btn").click(function() {
                if ($(this).is(':checked')) {
                    $("#edit-1").addClass('hover:brightness-50');
                    $("#edit-1 > input").removeClass('hidden');
                    $(".profile-input").removeAttr('disabled');
                    $(".profile-input.profile-input-2").addClass('border border-black');
                    $("#edit-submit").removeAttr('disabled')
                } else {
                    $("#edit-1").removeClass('hover:brightness-50');
                    $("#edit-1 > input").addClass('hidden');
                    $(".profile-input").attr('disabled', 'true');
                    $("#edit-submit").attr('disabled', 'true')
                    $(".profile-input.profile-input-2").removeClass('border border-black');
                }
            })
        })
    </script>
@endsection
