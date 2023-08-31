@extends('dashboard.layouts.main')

@section('content')
    <div class="w-full h-full text-black p-5 flex flex-col gap-2 overflow-y-auto relative">
        <header class="w-full flex gap-3 items-center text-2xl">
            <a href="{{ route('pengajar.index') }}" class="fa-solid fa-chevron-left max-sm:text-xl text-black"></a>
            <div class="text-sm max-sm:hidden breadcrumbs">
                <ul>
                    <li><a href="{{ route('pengajar.index') }}">Pengajar</a></li>
                    <li>Pengajar Baru</li>
                </ul>
            </div>
        </header>
        <form class="w-full h-auto px-16 flex gap-2 max-md:flex-col max-md:px-5" action="{{ route('users.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <div class="max-md:w-full max-md:flex max-md:justify-center">
                <div
                    class="input-logo bg-gray-100 w-36 max-md:w-53 aspect-square border border-black h-36 rounded-circle flex justify-center items-center relative">
                    <div
                        class="overflow-hidden text-4xl text-gray-500 w-full h-full bg-gray-200 z-10 flex justify-center items-center rounded-circle border border-black relative hover:brightness-50 ">
                        <input type="file" name="foto" id="input-photo"
                            class="z-10 w-full h-full rounded-circle cursor-pointer opacity-0 absolute top-0 left-0"
                            accept="image/*" required>
                        <i class="fa-solid fa-plus "></i>
                        <img src="" alt=""
                            class="absolute top-0 left-0 w-full h-full pointer-events-none z-20" id="photo-preview">
                    </div>
                    <div
                        class="absolute max-md:hidden w-64 h-10 bg-gradient-to-r from-bluesky-500 to-bluesea-500 top-0 left-12 rounded-6xl border border-black text-white font-semibold text-sm flex items-center justify-end px-2">
                        Tambah foto pengajar</div>
                </div>
            </div>
            <div class="w-full h-max py-14 max-md:py-2 flex flex-col gap-2" data-theme="light">
                <div class="tooltip @error('nama') tooltip-open @enderror z-10 tooltip-error"
                    data-tip="@error('nama'){{ $message }}  @enderror">
                </div>
                <div
                    class="input-nama flex justify-center items-center input input-bordered focus:outline-none @error('nama')input-error placeholder:text-error @enderror  w-full text-xl h-16 text-black font-semibold ">
                    <input type="text" placeholder="Nama Pengajar" name="nama" id="nama-pengajar"
                        class=" w-full h-full " required pattern="[A-Z a-z 0-9 -]+" maxlength="75"
                        value="{{ old('nama') }}" />
                    <span class="font-normal" id="indicator">0</span>
                    <span class="font-normal">/75</span>
                </div>
                <div class="w-full border border-black rounded-xl p-3 flex gap-2 flex-col">
                    <h1 class="font-semibold pb-2">Data Pengajar</h1>
                    <div class="w-full grid grid-cols-2 gap-2 max-sm:grid-cols-1">
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">NIK</h1>
                            <input required type="text" placeholder="Masukkan NIK"
                                class="input input-bordered focus:outline-none @error('nik')input-error placeholder:text-error @enderror w-full"
                                name="nik" value="{{ old('nik') }}" pattern="[0-9]+" />
                        </div>
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Username</h1>
                            <input required type="text" placeholder="Masukkan username"
                                class="input input-bordered focus:outline-none @error('username')input-error placeholder:text-error @enderror w-full"
                                name="username" value="{{ old('username') }}" />
                        </div>
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Password</h1>
                            <input required type="password" placeholder="Buat sandi akun"
                                class="input input-bordered focus:outline-none @error('password')input-error placeholder:text-error @enderror w-full"
                                name="password" value="{{ old('password') }}" />
                        </div>
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Konfirmasi Password</h1>
                            <input required type="password" placeholder="Ketik ulang sandi"
                                class="input input-bordered focus:outline-none @error('password_confirmation')input-error placeholder:text-error @enderror w-full"
                                name="password_confirmation" value="{{ old('password_confirmation') }}" />
                        </div>
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Email</h1>
                            <input required type="email" placeholder="Masukkan email yang valid"
                                class="input input-bordered focus:outline-none @error('email')input-error placeholder:text-error @enderror w-full"
                                name="email" value="{{ old('email') }}" />
                        </div>
                        <div class="w-full text-sm">
                            <h1 class="font-semibold">Nomor Telepon</h1>
                            <input required pattern="[0-9]{10,15}" type="text"
                                placeholder="Masukkan nomor telepon yang valid"
                                class="input input-bordered focus:outline-none w-full" name="no_telp"
                                {{ old('no_telp') }} />
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-end">
                    <input type="submit" value="Selesai" class="btn" id="submit-btn">
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#nama-pengajar").keyup(function() {
                $("#indicator").text($(this).val().length)
            })
            $("#nama-pengajar").keydown(function() {
                $("#indicator").text($(this).val().length)
            })
            $("#input-photo").on("change", function(e) {
                const file = URL.createObjectURL(e.target.files[0]);
                $("#photo-preview").attr("src", file);
            });
        });
    </script>
@endsection
