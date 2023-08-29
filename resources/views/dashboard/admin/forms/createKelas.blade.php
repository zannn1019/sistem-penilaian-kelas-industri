@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full flex justify-center items-center">
        <form action="{{ route('kelas.store') }}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="max-md:w-full max-md:flex max-md:justify-center">
                <div
                    class="input-logo bg-gray-100 w-36 max-md:w-53 aspect-square border border-black h-36 rounded-circle flex justify-center items-center relative">
                    <div
                        class="overflow-hidden text-4xl text-gray-500 w-full h-full bg-gray-200 z-10 flex justify-center items-center rounded-circle border border-black relative hover:brightness-50 ">
                        <input type="file" name="logo" id="input-photo"
                            class="z-10 w-full h-full rounded-circle cursor-pointer opacity-0 absolute top-0 left-0"
                            accept="image/*" required>
                        <i class="fa-solid fa-plus "></i>
                        <img src="" alt=""
                            class="absolute top-0 left-0 w-full h-full pointer-events-none z-20" id="photo-preview">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
