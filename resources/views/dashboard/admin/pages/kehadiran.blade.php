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
                <div class="dropdown z-30 " data-theme="light">
                    <div tabindex="0" role="button" class="btn m-1 btn-success text-white"><i class="fa fa-download"
                            aria-hidden="true"></i>
                    </div>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="{{ route('ExportKehadiran', ['tipe' => 'all']) }}">Keseluruhan</a></li>
                        <li><a href="{{ route('ExportKehadiran', ['tipe' => 'year']) }}">Tahun Sekarang</a></li>
                        <li><a href="{{ route('ExportKehadiran', ['tipe' => 'month']) }}">Bulan Sekarang</a></li>
                    </ul>
                </div>
                <div class="w-full">
                    <div id='calendar' class="fullcalendar-container"></div>
                </div>
            </div>
        </div>
    </div>

    <dialog id="daftarKegiatan" class="modal" data-theme="light">
        <div class="modal-box text-black flex flex-col gap-2">
            <h3 class="font-bold text-3xl text-center mb-2">Daftar Kegiatan</h3>
            <label for="">Tanggal</label>
            <input disabled type="date" name="tanggal" id="tanggalKegiatan" class="input input-bordered w-full"
                max="">
            <div class="w-full flex relative gap-1 text-left text-sm">
                <label for="" class="w-full">Nama Kegiatan</label>
                <label for="" class="w-1/2">Mulai</label>
                <label for="" class="w-1/2">Selesai</label>
            </div>
            <div class="flex flex-col gap-2" id="listKegiatan">

            </div>
            <div class="w-full flex gap-2 justify-end mt-2">
                <a class="btn" onclick="daftarKegiatan.close()">Close</a>
            </div>
        </div>
    </dialog>

    <template id="templateKegiatan">
        <div class="w-full flex relative gap-1">
            <input disabled type="text" name="kegiatan" placeholder="Kegiatan"
                class="update-kegiatan input input-bordered w-full" required />
            <input disabled type="time" name="jam_mulai" id="jam_mulai" class="input input-bordered w-1/2">
            <input disabled type="time" name="jam_selesai" id="jam_selesai" class="input input-bordered w-1/2">
        </div>
    </template>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let calendar;
            const calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'Asia/Jakarta ',
                locale: 'id',
                headerToolbar: {
                    left: 'dayGridMonth,listWeek',
                    center: 'title',
                    right: 'today,prev,next',
                },
                initialView: 'dayGridMonth',
                dayMaxEventRows: true,
                views: {
                    timeGrid: {
                        dayMaxEventRows: 6
                    }
                },
                events: getKehadiranData(),
                eventOrder: false,
                eventClick: function(info) {
                    const childEvents = info.event.extendedProps.child;
                    const tanggal = new Date(info.event.start);
                    const tanggal_kegiatan = tanggal.getFullYear() + "-" + (tanggal.getMonth() + 1) +
                        "-" + tanggal.getDate();
                    $("#daftarKegiatan").find("#tanggalKegiatan").val(tanggal_kegiatan);
                    $("#listKegiatan").empty()
                    childEvents.forEach((child) => {
                        const template = $('#templateKegiatan');
                        const clone = template.contents().clone(true, true);
                        const mulai = new Date(child.start);
                        const selesai = new Date(child.end);

                        function pad(number) {
                            return (number < 10 ? '0' : '') + number;
                        }

                        clone.find("input[name='kegiatan']").val(child.title);
                        clone.find("input[name='jam_mulai']").val(pad(mulai.getHours()) + ":" +
                            pad(mulai.getMinutes()));
                        clone.find("input[name='jam_selesai']").val(pad(selesai.getHours()) +
                            ":" + pad(selesai.getMinutes()));
                        $("#listKegiatan").append(clone)
                    })

                    daftarKegiatan.showModal();
                }
            });

            $("#addKegiatan").click(function() {
                let template = $('#input-template');
                let clone = template.contents().clone(true, true);
                let jumlahInput = $('#form-kehadiran .input-kegiatan').length;
                clone.find('.input-kegiatan').attr('placeholder', 'Kegiatan ' + (jumlahInput + 1));
                $('.list-kegiatan').append(clone);
            });

            $("#form-kehadiran").on("click", ".kehadiran-delete-btn", function() {
                $(this).parent().remove();
                updatePlaceholder();
            });

            function updatePlaceholder() {
                $('#form-kehadiran .input-kegiatan').each(function(index) {
                    $(this).attr('placeholder', 'Kegiatan ' + (index + 1));
                });
            }

            function triggerSubmit() {
                $("#form-kegiatan").trigger("submit");
            }

            function getKehadiranData() {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('getKehadiranDataAdmin') }}",
                        data: {
                            id: {{ auth()->user()->id }}
                        },
                        dataType: "JSON",
                        success: function(response) {
                            let jamKegiatan = [];
                            response.forEach(kehadiran => {
                                kehadiran.child.forEach(kegiatan => {
                                    const jamStart = new Date(kegiatan.start)
                                        .getHours();
                                    const menitStart = new Date(kegiatan.start)
                                        .getMinutes();
                                    const jamEnd = new Date(kegiatan.end)
                                        .getHours();
                                    const menitEnd = new Date(kegiatan.end)
                                        .getMinutes();

                                    jamKegiatan.push(jamStart * 60 + menitStart,
                                        jamEnd * 60 + menitEnd);

                                });
                                const jamAwal = Math.min(...jamKegiatan);
                                const jamAkhir = Math.max(...jamKegiatan);
                                const formatJamAwal =
                                    `${Math.floor(jamAwal / 60).toString().padStart(2, '0')}:${(jamAwal % 60).toString().padStart(2, '0')}`;
                                const formatJamAkhir =
                                    `${Math.floor(jamAkhir / 60).toString().padStart(2, '0')}:${(jamAkhir % 60).toString().padStart(2, '0')}`;
                                calendar.addEvent({
                                    title: kehadiran.title,
                                    start: kehadiran.start + " " +
                                        formatJamAwal,
                                    end: kehadiran.start + " " + formatJamAkhir,
                                    child: kehadiran.child
                                });
                            });


                        }
                    });
                });
            }
            calendar.render();
        });
    </script>
@endsection
