@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full gap-2 p-5 text-black flex flex-col">
        <div class="flex w-full h-24">
            <div class="w-full h-full flex px-2 flex-col gap-2">
                <div class="w-full flex items-center gap-4">
                    <a href="{{ route('dashboard-admin') }}"
                        class="fa-solid fa-chevron-left max-md:text-lg text-black text-2xl"></a>
                    <div class="text-sm breadcrumbs">
                        <ul>
                            <li>Riwayat Edit</li>
                        </ul>
                    </div>
                </div>
                <div class="w-full flex gap-5 h-12">
                    <div
                        class="switch flex-1 bg-gray-300 rounded-full flex justify-between overflow-hidden items-center p-1">
                        <a href="?data=admin"
                            class="w-1/2 h-full rounded-full flex justify-center items-center font-semibold {{ request('data') == 'admin' || request('data') == null ? 'text-white bg-darkblue-500' : 'text-gray-500 bg-transparent' }} ">OLEH
                            ADMIN</a>
                        <a href="?data=pengajar"
                            class="w-1/2 h-full rounded-full flex justify-center items-center font-semibold {{ request('data') == 'pengajar' ? 'text-white bg-darkblue-500' : 'text-gray-500 bg-transparent' }}">OLEH
                            PENGAJAR</a>
                    </div>
                    <div class="w-1/3 h-full bg-red-500 rounded-full"></div>
                </div>
            </div>
        </div>
        <div class="h-full w-full flex flex-col overflow-auto gap-2 p-5">
            @php
                $event = collect([
                    'created' => 'bg-green-500',
                    'update' => 'bg-bluesky-500',
                    'deleted' => 'bg-red-500',
                    'arsip' => 'bg-yellow-500',
                ]);
            @endphp
            {{-- @if ($riwayat->count())
                @foreach ($riwayat as $data)
                    <div class="w-full flex flex-col gap-4">
                        <h1 class="font-bold">{{ \Carbon\Carbon::parse($data['tanggal'])->diffForHumans() }}</h1>
                        @foreach ($data['data'] as $riwayat)
                            <div class="w-full h-40 flex gap-2 shadow-box rounded-xl">
                                <div
                                    class="w-6 rounded-l-xl h-full {{ $event->get($riwayat->event) ?? 'bg-darkblue-500' }} inline-block">
                                </div>
                                <div class="p-5 px-10 w-40 h-full flex justify-center items-center">
                                    <img src="{{ asset('img/' . $riwayat->event . '.png') }}" alt="">
                                </div>
                                <div class="info flex py-5 flex-col">
                                    <h1 class="text-3xl font-semibold mb-5">{{ $riwayat->description }}</h1>
                                    <span>Oleh : {{ $data_user->find($riwayat->causer_id)->nama }}</span>
                                    <span>Waktu : {{ $riwayat->created_at }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                {{ $riwayat->links('components.pagination') }}
            @endif --}}
            @if ($riwayat->count())
                @foreach ($riwayat as $data)
                    <div class="w-full flex flex-col gap-4">
                        <h1 class="font-bold">
                            @php
                                $carbonDate = \Carbon\Carbon::parse($data['tanggal']);
                                $diff = $carbonDate->diffForHumans();
                                if (strpos($diff, 'menit yang lalu') !== false && $carbonDate->diffInDays() == 0) {
                                    $diff = 'Hari ini';
                                }
                            @endphp
                            {{ $diff }}
                        </h1>
                        @foreach ($data['data'] as $riwayatItem)
                            @if ($riwayatItem->causer_id != null)
                                <div class="w-full h-40 flex gap-2 shadow-box rounded-xl relative">
                                    <div class="w-full h-40 flex gap-2 shadow-box rounded-xl">
                                        <div
                                            class="w-6 rounded-l-xl h-full {{ $event->get($riwayatItem->event) ?? 'bg-darkblue-500' }} inline-block">
                                        </div>
                                        <div class="p-5 px-10 w-40 h-full flex justify-center items-center">
                                            <img src="{{ asset('img/' . $riwayatItem->event . '.png') }}" alt="">
                                        </div>
                                        <div class="info flex py-5 flex-col capitalize">
                                            <h1 class="text-3xl font-semibold mb-5">{{ $riwayatItem->description }}</h1>
                                            <div class="max-w-full grid grid-rows-2 grid-flow-col gap-2">
                                                <span>Oleh : <strong>
                                                        {{ $data_user->find($riwayatItem->causer_id)->nama }}</strong></span>
                                                <span>Role :
                                                    <strong>{{ $data_user->find($riwayatItem->causer_id)->role }}</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="absolute
                                                top-0 right-0 p-5">
                                        <span class="font-semibold">{{ $riwayatItem->created_at }}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
                {{ $riwayat->links('components.pagination') }}
            @else
                <div
                    class="w-full h-full flex flex-col text-black justify-center items-center pointer-events-none select-none">
                    <img src="{{ asset('img/404_kelas.png') }}" alt="">
                    <h1>Tidak ada riwayat edit!</h1>
                </div>
            @endif
        </div>
    </div>
@endsection
