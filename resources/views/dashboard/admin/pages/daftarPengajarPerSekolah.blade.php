@extends('template')

@section('css')
    <style>
        .form-select {
            font-size: 14px;
        }

        .form-control {
            font-size: 14px;
        }

        #table1_wrapper .row:nth-child(2) {
            overflow-x: auto;
        }

        tr.lunas {
            background-color: #00B050 !important;
            color: white !important;
        }

        tr.batal {
            background-color: #FF4747 !important;
            color: white !important;
        }
    </style>
@endsection

@section('content')
    <div class="page-content" style="font-size: 18px;">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3>DAFTAR RESERVASI</h3>
                        <div id="export-button-container">
                            <label></label>
                            <button class="btn btn-success btn-sm" id="export-button">Export to Excel</button>
                        </div>
                    </div>
                    <br>
                    <form>
                        <div class="row">
                            <div class="col-sm-2">
                                <label>Tgl Awal</label>
                                <input type="date" class="form-control form-control-sm" id="tgl_awal" name="tgl_awal"
                                    value="{{ $tgl_awal }}">
                            </div>
                            <div class="col-sm-2">
                                <label>Tgl Akhir</label>
                                <input type="date" class="form-control form-control-sm" id="tgl_akhir" name="tgl_akhir"
                                    value="{{ $tgl_akhir }}">
                            </div>
                            <div class="col-sm-3" style="width:220px">
                                <label>Filter</label>
                                <select class="form-select form-select-sm" id="filter" name="filter">
                                    <option value="0" {{ $filter == 0 ? 'selected' : '' }}>Waktu Keberangkatan</option>
                                    <option value="1" {{ $filter == 1 ? 'selected' : '' }}>Waktu Lunas</option>
                                    <option value="2" {{ $filter == 2 ? 'selected' : '' }}>Waktu Pemesanan</option>
                                    <option value="3" {{ $filter == 3 ? 'selected' : '' }}>Waktu Pembatalan</option>
                                </select>
                            </div>
                            <div class="col-sm-3" style="width:220px">
                                <label>Status</label>
                                <select class="form-select form-select-sm" id="status" name="status">
                                    <option value="0" {{ $status == 0 ? 'selected' : '' }}>Semua</option>
                                    <option value="1" {{ $status == 1 ? 'selected' : '' }}>Paid</option>
                                    <option value="2" {{ $status == 2 ? 'selected' : '' }}>Book</option>
                                    <option value="3" {{ $status == 3 ? 'selected' : '' }}>Cancel</option>
                                </select>
                            </div>
                            <div class="col-sm-2" style="width:100px">
                                <label></label>
                                <button type="submit" class="form-control btn btn-primary btn-sm">
                                    <i data-feather="filter"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                    <hr>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-bordered " id="table1" style="font-size: 14px; text-align: center;">
                            <thead>
                                @foreach ($data['header'] as $row)
                                    <tr>
                                        @foreach ($row as $cell)
                                            @if (is_array($cell))
                                                @php($content = $cell[0])
                                                @php($colspan = isset($cell['colspan']) ? 'colspan=' . $cell['colspan'] : '')
                                                @php($rowspan = isset($cell['rowspan']) ? 'rowspan=' . $cell['rowspan'] : '')

                                                <th {{ $colspan }} {{ $rowspan }}>{{ $content }}</th>
                                            @else
                                                <th style="min-width: 100px;">{{ $cell }}</th>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </thead>
                            <tbody>
                                @foreach ($data['data'] as $row)
                                    <tr>
                                        @foreach ($row as $value)
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.2.0/exceljs.min.js"></script>

    <script>
        $(document).ready(function() {
            var table1 = $('#table1').DataTable();
            table1.columns([1, 2]).visible(false);

            var rowColors = [];

            function setRowColors() {
                table1.rows().every(function(rowIdx, tableLoop, rowLoop) {
                    var data = this.data();
                    var isLunas = parseInt(data[1]);
                    var isBatal = parseInt(data[2]);

                    if (isLunas === 1 && isBatal === 0) {
                        rowColors[rowIdx] = {
                            fill: {
                                type: 'pattern',
                                pattern: 'solid',
                                fgColor: {
                                    argb: '00B050'
                                },
                            },
                            font: {
                                color: {
                                    argb: 'FFFFFF'
                                },
                            },
                            name: 'lunas',
                        };
                    } else if (isBatal === 1) {
                        rowColors[rowIdx] = {
                            fill: {
                                type: 'pattern',
                                pattern: 'solid',
                                fgColor: {
                                    argb: 'FF4747'
                                },
                            },
                            font: {
                                color: {
                                    argb: 'FFFFFF'
                                },
                            },
                            name: 'batal',
                        };
                    }
                });
            }

            setRowColors();

            table1.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var rowColor = rowColors[rowIdx];
                if (rowColor) {
                    $(this.node()).addClass(rowColor.name);
                }
            });


            $('#export-button').on('click', function() {
                var table1PageLength = table1.page.len();
                table1.page.len(-1).draw();

                var workbook = new ExcelJS.Workbook();
                var worksheet = workbook.addWorksheet('Detail Reservasi');

                var header = [];
                table1.columns().every(function(colIdx) {
                    if (colIdx !== 1 && colIdx !== 2) {
                        header.push(this.header().textContent);
                    }
                });
                worksheet.addRow(header);

                table1.rows().every(function(rowIdx, tableLoop, rowLoop) {
                    var rowData = this.data();
                    var filteredData = [];
                    for (var i = 0; i < rowData.length; i++) {
                        if (i !== 1 && i !== 2) {
                            var cellText = rowData[i].toString();
                            if (i === 18 || i === 19 || i === 20) {
                                cellText = cellText.replace("Rp ", "").replace(/\./g, "");
                            }
                            filteredData.push(cellText);
                        }
                    }
                    worksheet.addRow(filteredData);

                    var rowColor = rowColors[rowIdx];
                    if (rowColor) {
                        worksheet.getRow(rowIdx + 2).fill = rowColor.fill;
                        worksheet.getRow(rowIdx + 2).font = rowColor.font;
                    }
                });

                // Mengatur lebar kolom berdasarkan isi konten
                for (var i = 1; i <= header.length; i++) {
                    worksheet.getColumn(i).eachCell({
                        includeEmpty: true
                    }, function(cell, rowNumber) {
                        var column = worksheet.getColumn(cell.col);
                        var length = String(cell.value).length;
                        if (column.width === undefined || length > column.width) {
                            column.width = length;
                        }
                    });
                }
                workbook.xlsx.writeBuffer().then(function(buffer) {
                    var blob = new Blob([buffer], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    });
                    saveAs(blob, 'laporan_daftar_reservasi.xlsx');
                });

                table1.page.len(table1PageLength).draw();
            });

        });
    </script>
@endsection
