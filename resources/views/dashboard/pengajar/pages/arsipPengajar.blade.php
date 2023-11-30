@extends('dashboard.layouts.main')
@section('content')
    <div class="w-full h-full gap-2 p-5 text-black flex flex-col">
        <div class="flex w-full">
            <div class="w-full h-full flex px-2 flex-col gap-2">
                <div class="w-full flex items-center gap-4">
                    <a href="{{ route('dashboard-admin') }}"
                        class="fa-solid fa-chevron-left max-md:text-lg text-black text-2xl"></a>
                    <div class="text-sm breadcrumbs">
                        <ul>
                            <li>Arsip</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-10">
            <div class="flex justify-between gap-2 text-4xl py-5 flex-wrap border-gray-400 border-b-2">
                <span class="font-semibold">Data Yang Diarsipkan</span>
                <div class="w-1/3 max-lg:w-full h-full max-h-14 rounded-full">
                    <div
                        class="input px-4 py-2 w-full bg-transparent flex items-center gap-2 h-full border-none rounded-6xl bg-zinc-300">
                        <i class="fa-solid fa-search border-r pr-4 py-2 border-black"></i>
                        <input type="text" placeholder="Telusuri arsip..." class=" w-full h-full bg-transparent" />
                    </div>
                </div>
                <p class="text-sm max-w-xl">
                    Data yang Anda arsipkan akan muncul disini. Untuk membuka arsip, pulihkan
                    data dengan mengklik pada sekolah yang ingin diakses kembali.
                </p>

            </div>
            @if ($arsip->count())
                <div class="overflow-x-auto w-full h-full scroll-arrow" data-theme="light">
                    <div class="w-full flex flex-wrap h-14 px-[3vw] gap-5 items-center">
                        <input type="checkbox" class="checkbox" data-theme="light" id="check-all-btn">
                        <div class="button-list flex gap-2 hidden" id="button-list">
                            <button
                                class="text-gray-600 px-3 py-2 hover:bg-opacity-30 transition-all duration-150 hover:text-error hover:bg-error rounded-circle delete-btn"
                                onclick="arsipModal.showModal()"data-aksi="hapus">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                            <button
                                class="text-gray-600 px-3 py-2 hover:bg-opacity-30 transition-all duration-150 hover:text-success hover:bg-success rounded-circle restore-btn"onclick="arsipModal.showModal()"
                                data-aksi="pulihkan">
                                <i class="fa fa-recycle" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <table
                        class="table table-zebra max-sm:table-sm border-2 border-darkblue-500 text-center table-pin-rows table-pin-cols"
                        id="tabel-arsip">
                        <thead>
                            <tr class="text-white bg-darkblue-500">
                                <td></td>
                                <th class="bg-darkblue-500 text-white">Nama</th>
                                <td>Tipe</td>
                                <td>Tanggal diarsip</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        @foreach ($arsip as $arsip_value)
                            <tbody>
                                <tr class="capitalize text-black">
                                    <th class="border-r-2 border-darkblue-500"><input type="checkbox" class="checkbox"
                                            data-id="{{ $arsip_value['id'] }}" data-tipe="{{ $arsip_value['tipe'] }}"></th>
                                    <td class="border-r-2 border-darkblue-500 bg-white truncate max-sm:max-w-[10rem]">
                                        @php
                                            $fieldsToCheck = ['nama', 'nama_kelas', 'nama_mapel'];
                                            $value = null;
                                            foreach ($fieldsToCheck as $field) {
                                                if (isset($arsip_value[$field])) {
                                                    $value = $arsip_value[$field];
                                                    break;
                                                }
                                            }
                                        @endphp
                                        {{ $value }}
                                    </td>
                                    <td class="border-r-2 border-darkblue-500">{{ $arsip_value['tipe'] }}</td>
                                    <td class="border-r-2 border-darkblue-500">
                                        {{ \Carbon\Carbon::parse($arsip_value['deleted_at'])->format('d-m-Y H:i:s') }}
                                    </td>
                                    <td class="border-r-2 border-darkblue-500">
                                        <button class="btn btn-error text-white delete-btn" onclick="arsipModal.showModal()"
                                            data-id="{{ $arsip_value['id'] }}" data-tipe="{{ $arsip_value['tipe'] }}"
                                            data-aksi="hapus">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                        <button
                                            class="btn btn-success text-white restore-btn"onclick="arsipModal.showModal()"
                                            data-id="{{ $arsip_value['id'] }}" data-tipe="{{ $arsip_value['tipe'] }}"
                                            data-aksi="pulihkan">
                                            <i class="fa fa-recycle" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                    <div class="p-5">
                        {{ $arsip->links('components.pagination') }}
                    </div>
                </div>
            @else
                <div
                    class="w-full h-full flex flex-col text-black justify-center items-center pointer-events-none select-none">
                    <img src="{{ asset('img/404_kelas.png') }}" alt="">
                    <h1>Tidak ada data arsip!</h1>
                </div>
            @endif
        </div>
    </div>
    <dialog id="arsipModal" class="modal" data-theme="light">
        <div class="modal-box text-black flex justify-center gap-5 flex-col text-center">
            <h3 class="font-bold text-lg">Apakah Anda yakin?</h3>
            <span id="modalMessage"></span>
            <div class="modal-action flex justify-center">
                <form method="dialog">
                    <button class="btn btn-error text-white cancel-btn">Tutup</button>
                </form>
                <form action="{{ route('aksiArsipPengajar') }}" method="POST" id="form-aksi-arsip">
                    @csrf
                    <input type="text" name="aksi" id="input-aksi" hidden>
                    <input type="submit" value="Konfirmasi" class="btn btn-success text-white">
                </form>
            </div>
        </div>
    </dialog>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function createInput(id, tipe) {
                let container = $("#form-aksi-arsip");
                let inputId = $("<input>", {
                    type: "text",
                    name: "id[]",
                    id: "input-id-" + id,
                    class: "inputaksi",
                    value: id,
                    hidden: true
                });

                let inputTipe = $("<input>", {
                    type: "text",
                    name: "tipe[]",
                    id: "input-tipe-" + tipe,
                    class: "inputaksi",
                    value: tipe,
                    hidden: true
                });
                container.append(inputId);
                container.append(inputTipe);
            }

            $(".checkbox").click(function() {
                if ($(this).is(":checked")) {
                    $("#button-list").removeClass("hidden");
                    createInput($(this).data('id'), $(this).data('tipe'));
                } else {
                    $("#input-id-" + $(this).data('id')).remove();
                    $("#input-tipe-" + $(this).data('tipe')).remove();
                    if ($("#tabel-arsip").find(".checkbox:checked").length == 0) {
                        $("#button-list").addClass("hidden");
                        $("#check-all-btn").prop("checked", false);
                    }
                }
            });

            $("#check-all-btn").click(function() {
                if ($(this).is(":checked")) {
                    $("#button-list").removeClass("hidden");
                    $("#tabel-arsip").find(".checkbox").prop("checked", true);
                    $.each($("#tabel-arsip").find(".checkbox:checked"), function(i, val) {
                        createInput($(val).data('id'), $(val).data('tipe'));
                    });
                } else {
                    $.each($("#tabel-arsip").find(".checkbox:checked"), function(i, val) {
                        $("#input-id-" + $(val).data('id')).remove();
                        $("#input-tipe-" + $(val).data('tipe')).remove();
                    });
                    $("#button-list").addClass("hidden");
                    $("#tabel-arsip").find(".checkbox").prop("checked", false);
                }
            });

            $(".delete-btn, .restore-btn").click(function() {
                let aksi = $(this).data('aksi');
                $("#input-aksi").val(aksi);
                if (aksi === 'hapus') {
                    $("#modalMessage").text("Apakah Anda yakin ingin menghapus data ini secara permanen?");
                } else if (aksi === 'pulihkan') {
                    $("#modalMessage").text("Anda ingin mengembalikan data ini dari arsip?");
                }
                if ($("#form-aksi-arsip").find('#input-id-' + $(this).data('id')).length == 0) {
                    createInput($(this).data('id'), $(this).data('tipe'));
                }
            });

            $(".checkbox").click(function() {
                if ($(this).is(":checked")) {
                    $("#button-list").removeClass("hidden");
                } else {
                    if ($("#tabel-arsip").find(".checkbox:checked").length == 0) {
                        $("#button-list").addClass("hidden");
                        $("#check-all-btn").prop("checked", false);
                    }
                }
            });
        });
    </script>
@endsection
