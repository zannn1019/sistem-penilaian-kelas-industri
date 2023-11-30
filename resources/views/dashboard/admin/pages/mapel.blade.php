@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full gap-2 p-5 text-black flex flex-col">
        <div class="flex w-full h-full">
            <div class="w-full h-full flex px-2 flex-col gap-2">
                <div class="w-full flex items-center gap-4">
                    <a href="{{ route('dashboard-admin') }}"
                        class="fa-solid fa-chevron-left max-md:text-lg text-black text-2xl"></a>
                    <div class="text-sm breadcrumbs">
                        <ul>
                            <li>Mata Pelajaran</li>
                        </ul>
                    </div>
                </div>
                <div class="w-full p-2 flex gap-2 max-sm:flex-wrap text-sm">
                    <a href="?filter=a-z"
                        class="max-sm:text-xs {{ request('filter') == 'a-z' ? 'bg-darkblue-500 text-white' : '' }} border flex justify-center items-center gap-2 border-darkblue-500 p-3 py-1 rounded-2xl font-semibold">
                        <svg width="15" height="10" viewBox="0 0 15 10" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10V8.33333H5V10H0ZM0 5.83333V4.16667H10V5.83333H0ZM0 1.66667V0H15V1.66667H0Z"
                                fill="{{ request('filter') == 'a-z' ? '#fff' : '#25364F' }}" />
                        </svg>
                        A-Z</a>
                    <a href="?filter=edited"
                        class="max-sm:text-xs {{ request('filter') == 'edited' ? 'bg-darkblue-500 text-white' : '' }} border flex justify-center items-center gap-2 border-darkblue-500 p-3 py-1 rounded-2xl font-semibold">
                        <svg width="15" height="10" viewBox="0 0 15 10"
                            fill="wik]\\"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10V8.33333H5V10H0ZM0 5.83333V4.16667H10V5.83333H0ZM0 1.66667V0H15V1.66667H0Z"
                                fill="{{ request('filter') == 'edited' ? '#fff' : '#25364F' }}" />
                        </svg>
                        Terakhir
                        diedit</a>
                    <a href="?filter=newest"
                        class="max-sm:text-xs {{ request('filter') == 'newest' ? 'bg-darkblue-500 text-white' : '' }} border flex justify-center items-center gap-2 border-darkblue-500 p-3 py-1 rounded-2xl font-semibold">
                        <svg width="15" height="10" viewBox="0 0 15 10" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10V8.33333H5V10H0ZM0 5.83333V4.16667H10V5.83333H0ZM0 1.66667V0H15V1.66667H0Z"
                                fill="{{ request('filter') == 'newest' ? '#fff' : '#25364F' }}" /> />
                        </svg>
                        Terbaru -
                        Terlama</a>
                    <a href="?filter=oldest"
                        class="max-sm:text-xs {{ request('filter') == 'oldest' ? 'bg-darkblue-500 text-white' : '' }} border flex justify-center items-center gap-2 border-darkblue-500 p-3 py-1 rounded-2xl font-semibold">
                        <svg width="15" height="10" viewBox="0 0 15 10" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10V8.33333H5V10H0ZM0 5.83333V4.16667H10V5.83333H0ZM0 1.66667V0H15V1.66667H0Z"
                                fill="{{ request('filter') == 'oldest' ? '#fff' : '#25364F' }}" /> />
                        </svg>
                        Terlama -
                        Terbaru</a>
                </div>
                @if ($daftar_mapel->count())
                    <div class="w-full min-h-auto flex flex-col gap-4 scroll-arrow" dir="rtl">
                        @foreach ($daftar_mapel as $mapel)
                            <div class="w-full h-36 bg-gradient-to-r from-tosca-200 to-bluesky-200 rounded-xl shadow-box border overflow-hidden flex"
                                dir="ltr">
                                <div
                                    class="w-60 max-md:hidden bg-transparent relative z-20 flex justify-start items-center">
                                    <img src="{{ asset('img/mapel.png') }}" class="p-5 w-44 bg-white" alt="">
                                    <div class="w-52 bg-white h-full absolute top-0 left-0 -z-10 skew-x-[20deg]">
                                    </div>
                                </div>
                                <div class="py-2 max-md:px-2 flex-grow flex flex-col h-full">
                                    <h1 class="text-2xl font-semibold">{{ $mapel->nama_mapel }}</h1>
                                    <div class="counter flex-wrap flex text-sm max-w-[15rem]">
                                        <div class="text-black font-semibold flex items-center gap-1 m-1">
                                            <i class="fa-regular fa-calendar text-black bg-bluesea-500 p-2 rounded-md"></i>
                                            <span>{{ $mapel->tugas()->where('tipe', ['tugas'])->count() }}</span>
                                            <span class="text-xs ">Tugas harian</span>
                                        </div>
                                        <div class="text-black font-semibold flex items-center gap-1 m-1">
                                            <svg width="30" height="30" viewBox="0 0 24 24" fill="none"
                                                class="bg-tosca-400 p-1 rounded-md" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M16 3C16.7652 2.99996 17.5015 3.29233 18.0583 3.81728C18.615 4.34224 18.9501 5.06011 18.995 5.824L19 6V16H19.75C20.397 16 20.93 16.492 20.994 17.122L21 17.25V19C21 19.7652 20.7077 20.5015 20.1827 21.0583C19.6578 21.615 18.9399 21.9501 18.176 21.995L18 22H8C7.23479 22 6.49849 21.7077 5.94174 21.1827C5.38499 20.6578 5.04989 19.9399 5.005 19.176L5 19V9H3.25C2.94054 9.00014 2.64203 8.88549 2.41223 8.67823C2.18244 8.47097 2.03769 8.18583 2.006 7.878L2 7.75V6C1.99996 5.23479 2.29233 4.49849 2.81728 3.94174C3.34224 3.38499 4.06011 3.04989 4.824 3.005L5 3H16ZM19 18H10V19C10 19.35 9.94 19.687 9.83 20H18C18.2652 20 18.5196 19.8946 18.7071 19.7071C18.8946 19.5196 19 19.2652 19 19V18ZM12 12H10C9.74512 12.0003 9.49997 12.0979 9.31463 12.2728C9.1293 12.4478 9.01776 12.687 9.00283 12.9414C8.98789 13.1958 9.07067 13.4464 9.23426 13.6418C9.39785 13.8373 9.6299 13.9629 9.883 13.993L10 14H12C12.2549 13.9997 12.5 13.9021 12.6854 13.7272C12.8707 13.5522 12.9822 13.313 12.9972 13.0586C13.0121 12.8042 12.9293 12.5536 12.7657 12.3582C12.6021 12.1627 12.3701 12.0371 12.117 12.007L12 12ZM14 8H10C9.73478 8 9.48043 8.10536 9.29289 8.29289C9.10536 8.48043 9 8.73478 9 9C9 9.26522 9.10536 9.51957 9.29289 9.70711C9.48043 9.89464 9.73478 10 10 10H14C14.2652 10 14.5196 9.89464 14.7071 9.70711C14.8946 9.51957 15 9.26522 15 9C15 8.73478 14.8946 8.48043 14.7071 8.29289C14.5196 8.10536 14.2652 8 14 8ZM5 5C4.73478 5 4.48043 5.10536 4.29289 5.29289C4.10536 5.48043 4 5.73478 4 6V7H5V5Z"
                                                    fill="black" />
                                            </svg>
                                            <span>{{ $mapel->tugas()->where('tipe', ['assessment_blok_a', 'assessment_blok_b'])->count() }}</span>
                                            <span class="text-xs ">Assessment</span>
                                        </div>
                                        <div class="text-black font-semibold flex items-center gap-1 m-1">
                                            <svg width="30" height="30" viewBox="0 0 19 19" fill="none"
                                                class="bg-bluesky-400 p-2 rounded-md" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14 4.66045e-09C14.7652 -4.26217e-05 15.5015 0.292325 16.0583 0.817284C16.615 1.34224 16.9501 2.06011 16.995 2.824L17 3V13H17.75C18.397 13 18.93 13.492 18.994 14.122L19 14.25V16C19 16.7652 18.7077 17.5015 18.1827 18.0583C17.6578 18.615 16.9399 18.9501 16.176 18.995L16 19H6C5.23479 19 4.49849 18.7077 3.94174 18.1827C3.38499 17.6578 3.04989 16.9399 3.005 16.176L3 16V6H1.25C0.940542 6.00014 0.642032 5.88549 0.412234 5.67823C0.182437 5.47097 0.0376885 5.18583 0.00600005 4.878L4.66045e-09 4.75V3C-4.26217e-05 2.23479 0.292325 1.49849 0.817284 0.941739C1.34224 0.384993 2.06011 0.0498925 2.824 0.00500012L3 4.66045e-09H14ZM14 2H5V16C5 16.2652 5.10536 16.5196 5.29289 16.7071C5.48043 16.8946 5.73478 17 6 17C6.26522 17 6.51957 16.8946 6.70711 16.7071C6.89464 16.5196 7 16.2652 7 16V14.25C7 13.56 7.56 13 8.25 13H15V3C15 2.73478 14.8946 2.48043 14.7071 2.29289C14.5196 2.10536 14.2652 2 14 2ZM17 15H9V16C9 16.35 8.94 16.687 8.83 17H16C16.2652 17 16.5196 16.8946 16.7071 16.7071C16.8946 16.5196 17 16.2652 17 16V15ZM10 9C10.2652 9 10.5196 9.10536 10.7071 9.29289C10.8946 9.48043 11 9.73478 11 10C11 10.2652 10.8946 10.5196 10.7071 10.7071C10.5196 10.8946 10.2652 11 10 11H8C7.73478 11 7.48043 10.8946 7.29289 10.7071C7.10536 10.5196 7 10.2652 7 10C7 9.73478 7.10536 9.48043 7.29289 9.29289C7.48043 9.10536 7.73478 9 8 9H10ZM12 5C12.2652 5 12.5196 5.10536 12.7071 5.29289C12.8946 5.48043 13 5.73478 13 6C13 6.26522 12.8946 6.51957 12.7071 6.70711C12.5196 6.89464 12.2652 7 12 7H8C7.73478 7 7.48043 6.89464 7.29289 6.70711C7.10536 6.51957 7 6.26522 7 6C7 5.73478 7.10536 5.48043 7.29289 5.29289C7.48043 5.10536 7.73478 5 8 5H12ZM3 2C2.75507 2.00003 2.51866 2.08996 2.33563 2.25272C2.15259 2.41547 2.03566 2.63975 2.007 2.883L2 3V4H3V2Z"
                                                    fill="black" />
                                            </svg>
                                            <span>{{ $mapel->tugas()->where('tipe', ['quiz'])->count() }}</span>
                                            <span class="text-xs ">Kuis</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-60 max-sm:hidden bg-white h-16 m-2 rounded-xl shadow-inner self-end">
                                    <div class="w-full h-full flex justify-center items-center">
                                        @php
                                            $jumlah = 5;
                                        @endphp
                                        @if ($mapel->pengajar->count())
                                            @foreach ($mapel->pengajar()->get() as $pengajar)
                                                @if ($loop->iteration > $jumlah)
                                                    @if ($loop->last)
                                                        <div
                                                            class="w-10 bg-bluesea-200 shadow-lg border border-bluesea-400 aspect-square object-contain -mr-3 rounded-circle flex justify-center items-center">
                                                            {{ $loop->count - $jumlah }}+
                                                        </div>
                                                    @endif
                                                @else
                                                    <img src="{{ asset('storage/pengajar/' . $pengajar->foto) }}"
                                                        alt=""
                                                        class="w-10 aspect-square object-cover -mr-3 rounded-circle">
                                                @endif
                                            @endforeach
                                        @else
                                            Tidak ada pengajar!
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('mapel.show', ['mapel' => $mapel->id]) }}"
                                    class="h-full bg-bluesky-500 px-2 flex justify-center items-center">
                                    <i class="fa fa-chevron-right text-2xl text-white" aria-hidden="true"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="w-full h-full flex justify-center items-center flex-col text-gray-500">
                        <img src="{{ asset('img/404_kelas.png') }}" alt="" draggable="false">
                        <h1>Belum ada mata pelajaran!</h1>
                    </div>
                @endif
            </div>
            <button onclick="mapelAdd.showModal()"
                class="self-end fixed text-3xl max-sm:fixed right-10 bottom-10 btn rounded-circle p-2 aspect-square flex justify-center items-center bg-black ">
                <i class="fa fa-plus text-white" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <dialog id="mapelAdd" class="modal" data-theme="light">
        <form action="{{ route('mapel.store') }}" method="POST" class="modal-box text-black flex flex-col w-full gap-2">
            @csrf
            <h1 class="font-semibold text-3xl w-full text-center">Tambah Mata Pelajaran</h1>
            <input type="text" class="input input-bordered" placeholder="Nama mata pelajaran" name="nama_mapel"
                required>
            <div class="w-full flex justify-between py-2">
                <button id="close-btn" class="px-4 py-1 bg-gray-200 rounded-2xl">Close</button>
                <button type="submit" class="px-4 py-1 bg-darkblue-500 rounded-2xl text-white">Tambah</button>
            </div>
        </form>
    </dialog>
@endsection

@section('script')
    <script>
        $("#close-btn").click(function(e) {
            e.preventDefault()
            mapelAdd.close()
        })
    </script>
@endsection
