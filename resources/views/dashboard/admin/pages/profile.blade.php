@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full flex flex-col px-10 py-5 text-black">
        <header class="w-full h-14 flex gap-3 items-center text-2xl justify-between">
            <div class="flex justify-center items-center gap-2">
                <a href="{{ route('dashboard-admin') }}" class="fa-solid fa-chevron-left max-md:text-lg text-black"></a>
                <div class="text-sm max-sm:hidden breadcrumbs">
                    <ul>
                        <li>Profile</li>
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
        <form action="{{ route('users.update', ['user' => auth()->user()->id]) }}" method="POST"
            class="w-full h-full flex justify-center items-center gap-5" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class=" flex flex-col profile bg-darkblue-500 p-10 rounded-2xl w-72 gap-2">
                <div class="profile-picture rounded-circle aspect-square  relative">
                    <div class="editable-foto w-full h-full">
                        <img src="{{ asset('storage/pengajar/' . auth()->user()->foto) }}"
                            class="object-cover rounded-circle w-full h-full" alt="" id="foto-preview">
                    </div>
                    <div class="foto-edit hidden top-2 w-10 h-10 justify-center items-center right-2 absolute z-10 text-white bg-bluesea-500 rounded-circle"
                        id="edit-pen-foto">
                        <i class="fa-solid fa-pen" aria-hidden="true"></i>
                        <input type="file" name="foto" id="foto-input"
                            class="absolute opacity-0 w-full h-full rounded-circle" accept="image/*">
                    </div>
                </div>
                <div class="info flex flex-col w-full justify-center items-center gap-2">
                    <span class="font-semibold text-white capitalize">{{ auth()->user()->role }}</span>
                    <div class="w-full relative flex">
                        <input type="text" class="absolute left-0 top-0 w-full input input-bordered opacity-0" disabled
                            data-theme="light" id="input-nama" name="nama" value="{{ auth()->user()->nama }}">
                        <span id="nama"
                            class="text-3xl font-bold break-words w-full p-2 rounded-xl text-transparent text-center h-full bg-gradient-to-r from-tosca-500 to-bluesea-500 bg-clip-text"></span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-end w-1/2" data-theme="light">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">NIK</span>
                    </label>
                    <input disabled type="text" placeholder="Type here" class="input input-bordered border-black w-full"
                        value="{{ auth()->user()->nik }}" name="nik" />
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Username</span>
                    </label>
                    <input disabled type="text" placeholder="Type here" class="input input-bordered border-black w-full"
                        value="{{ auth()->user()->username }}" name="username" />
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input disabled type="text" placeholder="Type here" class="input input-bordered border-black w-full"
                        value="{{ auth()->user()->email }}" name="email" />
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Kontak</span>
                    </label>
                    <input disabled type="text" placeholder="Type here" class="input input-bordered border-black w-full"
                        value="{{ auth()->user()->no_telp }}" name="no_telp" />
                </div>
                <input type="hidden" value="{{ auth()->user()->status }}" name="status">
                <br>

                <input type="submit" class="btn btn-info text-white hidden" value="SIMPAN PERUBAHAN" id="submit-btn">
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#edit-btn").click(function() {
                if ($(this).is(':checked')) {
                    $("#submit-btn").removeClass('hidden');
                    $("input[type='text']").removeAttr('disabled');
                    $("#edit-pen-foto").addClass('flex');
                    $("#edit-pen-foto").removeClass('hidden');
                    $("#nama").addClass('border border-white');
                } else {
                    $("#submit-btn").addClass('hidden')
                    $("input[type='text']").attr('disabled', true)
                    $("#edit-pen-foto").removeClass('flex');
                    $("#edit-pen-foto").addClass('hidden');
                    $("#nama").removeClass('border border-white')
                }
            })

            $("#foto-input").on("change", function(e) {
                const file = URL.createObjectURL(e.target.files[0]);
                $("#foto-preview").attr("src", file);
            });

            $("#nama").text($("#input-nama").val());
            $("#input-nama").on('input', function(event) {
                var inputValue = $(this).val();
                $("#nama").text(inputValue);
                if (inputValue === "") {
                    $("#nama").text("Hello");
                }
                if (inputValue !== "") {
                    $("#nama").addClass('bg-gradient-to-r from-tosca-500 to-bluesea-500 bg-clip-text');
                } else {
                    $("#nama").removeClass('bg-gradient-to-r from-tosca-500 to-bluesea-500 bg-clip-text');
                }
            })
        });
    </script>
@endsection
