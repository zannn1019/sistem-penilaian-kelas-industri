<div class="flex gap-2 text-sm uppercase p-1 rounded-full bg-gray-300 text-gray-500 font-semibold">
    <a href="{{ route('admin-dashboard-pengajar', ['pengajar' => $info_pengajar->id]) }}"
        class="p-3 px-4 rounded-full {{ $title == 'Dashboard Pengajar' ? 'bg-darkblue-500 text-white' : '' }}">Dashboard</a>
    <a href="{{ route('admin-kelas-pengajar', ['pengajar' => $info_pengajar->id]) }}"
        class="p-3 px-4 rounded-full {{ $title == 'Kelas Pengajar' ? 'bg-darkblue-500 text-white' : '' }}">Kelas</a>
</div>
