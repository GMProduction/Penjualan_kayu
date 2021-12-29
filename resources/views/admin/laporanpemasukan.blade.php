@extends('admin.base')

@section('title')
    Data Pemasukan
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
                <div>
                    <div class="d-flex align-items-end">
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
                </div>

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
                window.open('/admin/laporanpemasukan/cetak?start=' + start + '&end=' + end, '_blank');
            });
            console.log($('#start').val());
            table = $('#myTable').DataTable({
                scrollX: true,
                processing: true,
                ajax: {
                    url: '/admin/laporanpemasukan/list-laporan',
                    type: 'GET',
                    'data': function (d) {
                        return $.extend(
                            {},
                            d,
                            {
                                'start': $('#start').val(),
                                'end': $('#end').val(),
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
