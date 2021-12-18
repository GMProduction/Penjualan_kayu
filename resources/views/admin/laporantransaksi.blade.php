@extends('admin.base')

@section('title')
    Data Transaksi
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.css"/>
@endsection

@section('content')

    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            swal("Berhasil!", "Berhasil Menambah data!", "success");
        </script>
    @endif

    <section class="m-2">

        <div class="table-container">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="mb-3">Laporan</h5>
                <form id="formTanggal">
                    <div class="d-flex align-items-end">
                        <div>
                            <label for="kategori" class="form-label">Status Transaksi</label>
                            <div class="d-flex">
                                <select class="form-select me-2" aria-label="Default select example" id="selectStatus"
                                        name="status">
                                    <option selected value="">Semua</option>
                                    <option value="0">Menunggu Pembayaran</option>
                                    <option value="1">Menunggu Konfirmasi Admin</option>
                                    <option value="2">Di Proses</option>
                                    <option value="3">Di Kirim</option>
                                    <option value="4">Selesai</option>
                                </select>
                            </div>
                        </div>

                        <div class="me-2 ms-2">
                            <label for="kategori" class="form-label">Periode</label>
                            <div class="input-group input-daterange">
                                <input type="text" class="form-control me-2 txt-tgl" name="start" id="start"
                                       style="background-color: white; line-height: 2.0;" readonly
                                       value="{{ date('d-m-Y') }}" required>
                                <div class="input-group-addon">to</div>
                                <input type="text" class="form-control ms-2 txt-tgl" name="end" id="end"
                                       style="background-color: white; line-height: 2.0;" readonly
                                       value="{{ date('d-m-Y') }}" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success mx-2" id="btn-cari">Cari</button>
                        <a class="btn btn-warning" id="cetak" target="_blank" href="#">Cetak</a>

                    </div>
                </form>

            </div>

            <table class="table table-striped table-bordered w-100" id="myTable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Pesan</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody></tbody>

            </table>


        </div>

    </section>

@endsection

@section('script')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>
    <script type="text/javascript" src="{{ asset('/js/myStyle.js') }}"></script>
    <script>
        $('.input-daterange input').each(function () {
            $(this).datepicker({
                format: "dd-mm-yyyy"
            });
        });

        var table;

        function reload() {
            table.ajax.reload();
        }

        $(document).ready(function () {
            $('#btn-cari').on('click', function () {
                reload()
            });

            $('#cetak').on('click', function (e) {
                e.preventDefault();
                let start = $('#start').val();
                let end = $('#end').val();
                let status = $('#selectStatus').val();
                window.open('/admin/laporantransaksi/cetak?start=' + start + '&end=' + end + '&status=' + status, '_blank');
            });
            console.log($('#start').val());
            table = $('#myTable').DataTable({
                scrollX: true,
                processing: true,
                ajax: {
                    url: '/admin/laporantransaksi/list-laporan',
                    type: 'GET',
                    'data': function (d) {
                        return $.extend(
                            {},
                            d,
                            {
                                'start': $('#start').val(),
                                'end': $('#end').val(),
                                'status': $('#selectStatus').val(),
                            }
                        );
                    },
                },
                'columnDefs': [
                    {
                        "targets": 0, // your case first column
                        "className": "text-center",
                    },
                    {
                        "targets": 2, // your case first column
                        "className": "text-center",
                    },
                    {
                        "targets": 3,
                        "className": "text-end",
                    },
                    {
                        "targets": 4, // your case first column
                        "className": "text-center",
                    },
                ],
                "columns": [
                    {
                        data: null, render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {data: "user.nama"},
                    {data: "tanggal"},
                    {
                        data: null, render: function (data, type, row, meta) {
                            return nominalFormat(data['total']);
                        }
                    },
                    {
                        data: null, render: function (data, type, row, meta) {
                            let status = '-';
                            switch (data['status_transaksi']) {
                                case 0:
                                    status = 'Menunggu Pembayaran';
                                    break;
                                case 1:
                                    status = 'Menunggu Konfirmasi Admin';
                                    break;
                                case 2:
                                    status = 'Di Proses';
                                    break;
                                case 3:
                                    status = 'Di Kirim';
                                    break;
                                case 4:
                                    status = 'Selesai';
                                    break;
                                default:
                                    break;
                            }
                            return status;
                        }
                    },
                    // {
                    //     data: null, render: function (data, type, row, meta) {
                    //         return '<a href="#" class="btn btn-primary btn-sm text-white btn-detail" data-id="' + data['id'] + '">Detail</a>';
                    //     }
                    // },
                ]
            })

            $('#selectStatus').on('change', function () {
                reload();
            });

            $('.txt-tgl').on('change', function () {
                reload();
            });
        })
        // $(document).on('click', '#cetak', function() {
        //     // console.log(window.location.pathname+'/cetak'+window.location.search )
        //     $(this).attr('href', window.location.pathname + '/cetak' + window.location.search);
        // })
    </script>

@endsection
