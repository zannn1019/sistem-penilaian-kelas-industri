@extends('dashboard.layouts.main')
@section('head')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
@endsection

@section('content')
    <div class="w-full h-full gap-2 p-5 text-black flex flex-col">
        <div class="flex w-full">
            <div class="w-full h-full flex px-2 flex-col gap-2">
                <div class="w-full flex items-center gap-4">
                    <a href="{{ route('dashboard-admin') }}"
                        class="fa-solid fa-chevron-left max-md:text-lg text-black text-2xl"></a>
                    <div class="text-sm breadcrumbs">
                        <ul>
                            <li>Kehadiran</li>
                        </ul>
                    </div>
                </div>
                <div class="w-full">
                    <div id='calendar' class="fullcalendar-container"></div>
                </div>
            </div>
        </div>
    </div>
    <dialog id="inputKehadiran" class="modal" data-theme="light">
        <div class="modal-box text-black">
            <h3 class="font-bold text-3xl text-center">Tambah Kehadiran</h3>
            <form action="{{ route('kehadiran.store') }}" method="POST" class="flex flex-col gap-2" id="form-kehadiran">
                @csrf
                <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                <input type="date" name="tanggal" id="inputTanggal" value="" class="hidden" required>
                <label for="" class="font-bold">Kegiatan</label>
                <div class="list-kegiatan flex
                flex-col gap-2">
                    <div class="w-full flex relative gap-1 text-left text-sm">
                        <label for="" class="w-full">Nama Kegiatan</label>
                        <label for="" class="w-1/2">Mulai</label>
                        <label for="" class="w-1/2">Selesai</label>
                    </div>
                    <div class="w-full flex relative gap-1">
                        <input type="text" name="kegiatan[]" placeholder="Nama Kegiatan"
                            class="input-kegiatan input input-bordered w-full" required />
                        <input type="time" name="jam_mulai[]" id=""
                            class="input input-bordered w-1/2 input-jam-mulai">
                        <input type="time" name="jam_selesai[]" id=""
                            class="input input-bordered w-1/2 input-jam-selesai">
                        <a
                            class="opacity-0 pointer-events-none user-select-none text-error h-10 aspect-square rounded-full flex justify-center items-center cursor-pointer hover:bg-error hover:bg-opacity-20 transition-all duration-100 sticky right-0 top-0 kehadiran-delete-btn"><i
                                class="fa fa-trash" aria-hidden="true"></i></a>
                    </div>
                </div>
                <a class="btn btn-accent my-2 w-full text-white" id="addKegiatan">Tambah kegiatan lainnya</a>
                <div class="w-full flex gap-2 justify-end">
                    <a class="btn" onclick="inputKehadiran.close()">Close</a>
                    <input type="submit" class="btn btn-success text-white" value="Tambah">
                </div>
            </form>
        </div>
    </dialog>
    <dialog id="updateKegiatan" class="modal" data-theme="light">
        <div class="modal-box text-black">
            <h3 class="font-bold text-3xl text-center mb-2">Edit Kegiatan</h3>
            <form action="" method="POST" class="flex flex-col gap-2" id="form-kehadiran">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                <label for="">Tanggal</label>
                <input type="date" name="tanggal" id="tanggalKegiatan" class="input input-bordered" max="">
                <div class="w-full flex relative gap-1 text-left text-sm">
                    <label for="" class="w-full">Nama Kegiatan</label>
                    <label for="" class="w-1/2">Mulai</label>
                    <label for="" class="w-1/2">Selesai</label>
                </div>
                <div class="w-full flex relative gap-1">
                    <input type="text" name="kegiatan" placeholder="Kegiatan"
                        class="update-kegiatan input input-bordered w-full" required />
                    <input type="time" name="jam_mulai" id="jam_mulai" class="input input-bordered w-1/2 ">
                    <input type="time" name="jam_selesai" id="jam_selesai" class="input input-bordered w-1/2">
                </div>
                <div class="w-auto flex gap-2 justify-end">
                    <a class="btn" onclick="updateKegiatan.close()">Close</a>
                    <input type="submit" class="btn btn-success text-white" value="UBAH">
                </div>
            </form>
            <form action="" id="deleteKegiatan" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" class="btn btn-error text-white absolute bottom-6" value="HAPUS">
            </form>
        </div>
    </dialog>
    <template id="input-template">
        <div class="w-full flex relative gap-1">
            <input type="text" name="kegiatan[]" placeholder="Nama Kegiatan"
                class="input-kegiatan input input-bordered w-full" required />
            <input type="time" name="jam_mulai[]" id="" class="input input-bordered w-1/2 input-jam-mulai">
            <input type="time" name="jam_selesai[]" id=""
                class="input input-bordered w-1/2 input-jam-selesai">
            <a
                class="text-error h-10 aspect-square rounded-full flex justify-center items-center cursor-pointer hover:bg-error hover:bg-opacity-20 transition-all duration-100 sticky right-0 top-0 kehadiran-delete-btn"><i
                    class="fa fa-trash" aria-hidden="true"></i></a>
        </div>
    </template>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let calendar;
            const calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'local',
                locale: 'id',
                headerToolbar: {
                    left: 'dayGridMonth,listWeek',
                    center: 'title',
                    right: 'today,prev,next',
                },
                initialView: 'dayGridMonth',
                dateClick: function(info) {
                    $("#inputTanggal").val(info.dateStr);
                    inputKehadiran.showModal();
                },
                dayMaxEventRows: true,
                views: {
                    timeGrid: {
                        dayMaxEventRows: 6
                    }
                },
                events: getKehadiranData(),
                eventOrder: false,
                eventClick: function(info) {
                    let eventId = info.event.id;
                    let url = "{{ route('kegiatan.update', ':id') }}";
                    let urlDelete = "{{ route('kegiatan.destroy', ':id') }}";
                    url = url.replace(':id', eventId);
                    urlDelete = url.replace(':id', eventId);
                    let mulai = new Date(info.event.start);
                    let selesai = new Date(info.event.end);
                    let jam_mulai = pad(mulai.getHours()) + ":" + pad(mulai.getMinutes());
                    let jam_selesai = pad(selesai.getHours()) + ":" + pad(selesai.getMinutes());
                    let tanggal_kegiatan = pad(mulai.getFullYear() + "-" + pad(mulai.getMonth() + 1) +
                        "-" +
                        pad(mulai.getDate()));

                    function pad(number) {
                        return (number < 10 ? '0' : '') + number;
                    }

                    $("#updateKegiatan").find(".update-kegiatan").val(info.event.title);
                    $("#updateKegiatan").find("#form-kehadiran").attr("action", url);
                    $("#updateKegiatan").find("#deleteKegiatan").attr("action", urlDelete);
                    $("#updateKegiatan").find("#jam_mulai").val(jam_mulai);
                    $("#updateKegiatan").find("#jam_selesai").val(jam_selesai);
                    $("#updateKegiatan").find("#tanggalKegiatan").val(tanggal_kegiatan);

                    let today = new Date();
                    let dd = String(today.getDate()).padStart(2, '0');
                    let mm = String(today.getMonth() + 1).padStart(2, '0');
                    let yyyy = today.getFullYear();

                    today = yyyy + '-' + dd + '-' + mm;
                    $("#updateKegiatan").find("#tanggalKegiatan").attr("max", today);
                    updateKegiatan.showModal();
                }
            });


            $("#addKegiatan").click(function() {
                let template = $('#input-template');
                let clone = template.contents().clone(true, true);
                let jumlahInput = $('#form-kehadiran .input-kegiatan').length;
                $('.list-kegiatan').append(clone);
            });

            $("#form-kehadiran").on("click", ".kehadiran-delete-btn", function() {
                $(this).parent().remove();
            });

            function triggerSubmit() {
                $("#form-kegiatan").trigger("submit");
            }

            function getKehadiranData() {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('getKehadiranData') }}",
                        data: {
                            id: {{ auth()->user()->id }}
                        },
                        dataType: "JSON",
                        success: function(response) {
                            response.forEach(kehadiran => {
                                kehadiran.child.forEach(kegiatan => {
                                    calendar.addEvent({
                                        id: kegiatan.id,
                                        title: kegiatan.title,
                                        start: kegiatan.start,
                                        end: kegiatan.end,
                                    });
                                })
                            });
                        }
                    });
                });
            }
            calendar.render();
        });
    </script>
@endsection
