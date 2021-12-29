@extends('admin.base')

@section('title')
    Data Barang
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

            <div class="d-flex">
                <h5 class="mb-3">Transaksi</h5>
                {{--                <div class="ms-auto">--}}
                {{--                    <div class="mb-3">--}}
                {{--                        <label for="kategori" class="form-label">Status </label>--}}
                {{--                        <div class="d-flex">--}}
                {{--                            <form id="formCari" action="/admin/pesanan">--}}
                {{--                                <select class="form-select" aria-label="Default select example" id="statusCari"--}}
                {{--                                        name="status">--}}
                {{--                                    <option selected value="">Semua</option>--}}
                {{--                                    <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>--}}
                {{--                                    <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>--}}
                {{--                                    <option value="Diproses">Diproses</option>--}}
                {{--                                    <option value="Dikirim">Dikirim</option>--}}
                {{--                                    <option value="Selesai">Selesai</option>--}}
                {{--                                </select>--}}
                {{--                            </form>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>

            <table class="table table-striped table-bordered w-100" id="myTable">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">No. Pesanan</th>
                    <th class="text-center">Tanggal Pesan</th>
                    <th>Nama Pemesan</th>
                    <th class="text-end">Total Harga</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                {{--                <tr>--}}
                {{--                    <td>1</td>--}}
                {{--                    <td>Joni</td>--}}
                {{--                    <td>09 Desember 2021</td>--}}
                {{--                    <td>Rp. {{number_format("60000", 0)}}</td>--}}
                {{--                    <td>Menunggu Pembayaran</td>--}}
                {{--                    <td>--}}
                {{--                        <button type="button" class="btn btn-primary btn-sm" id="detailData">Detail--}}
                {{--                        </button>--}}
                {{--                    </td>--}}
                {{--                </tr>--}}
                </tbody>

            </table>


        </div>


        <!-- Modal Detail-->
        <div class="modal fade" id="detail1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row ">
                            <div class="col-8">
                                <div class="row  border rounded p-3 g-2">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="dnotransaksi" class="form-label fw-bold">Transaksi</label>
                                            <p id="dnotransaksi"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label for="dtanggalPesanan" class="form-label fw-bold">Tanggal</label>
                                            <p id="dtanggalPesanan"></p>
                                        </div>

                                        <div class="mb-3">
                                            <label for="dNamaPelanggan" class="form-label fw-bold">Nama
                                                Pelanggan</label>
                                            <p id="dNamaPelanggan"></p>
                                        </div>

                                        <div class="mb-3">
                                            <label for="dAlamatPengiriman" class="form-label fw-bold">Alamat
                                                Pengiriman</label>
                                            <p id="dAlamatPengirimanKota" class="mb-0"></p>
                                            <textarea type="text" class="form-control" readonly
                                                      id="dAlamatPengiriman"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="dNamaPelanggan" class="form-label fw-bold">Detail
                                                Expedisi</label>
                                            <p id="" class="mb-0">Expedisi : <span id="dExpedisi"></span></p>
                                            <p id="">Estimasi : <span id="dEstimasi"></span></p>
                                        </div>
                                        <p class="mb-0 fw-bold">Biaya</p>
                                        <div class="d-flex justify-content-between">
                                            <p>Pesanan</p>
                                            <h5 class="mb-0" id="dBiaya"></h5>

                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <p>Ongkir</p>
                                            <h5 class="mb-0" id="dOngkir"></h5>

                                        </div>

                                        <hr>

                                        <div class="d-flex justify-content-between">
                                            <p>Total</p>
                                            <h4 class="mb-5 fw-bold" id="dTotal"></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 border rounded px-3">
                                <div class="mb-3">
                                    <a for="dBuktiTransfer" class="d-block">Bukti Transfer</a>
                                    <a id="dBuktiTransfer" class="link-bukti" style="cursor: pointer"
                                       href="#">
                                        <img src=""
                                             style="width: 100px; height: 50px; object-fit: cover"/>
                                    </a>
                                </div>

                                <div class="mb-3 d-none" id="btnKonfirmasi">
                                    <label for="kategori" class="form-label">Konfirmasi Pembayaran</label>
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-sm btn-success me-2 btn-confirm"
                                                data-status="9"
                                                data-type="bayar"
                                                >Terima
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger btn-confirm" data-status="6" data-type="bayar">
                                            Tolak
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <p>Action</p>
                                    <a class="btn btn-sm btn-primary" id="dChat" target="_blank">chat</a>
                                    <a class="btn btn-sm btn-warning d-none btn-confirm"
                                       data-status="3"
                                       data-type="pesanan"
                                       id="btn-kirim"
                                    >Kirim
                                        Barang</a>
                                </div>

                                <div class="mt-3">
                                    <p class="mb-1">Status : <span id="dStatus" class="fw-bold"></span></p>
                                    <p id="dAlasan"></p>
                                </div>

                            </div>
                        </div>

                        <div class="table-container mt-5">
                            <h5 class="mb-3">Isi Keranjang Pesanan</h5>
                            <div style="max-height: 300px" class="overflow-auto">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Gambar</th>
                                        <th>Produk</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Total Harga</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tabelDetail"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>
    <script type="text/javascript" src="{{ asset('/js/myStyle.js') }}"></script>
    <script>
        var table;

        function reload() {
            table.ajax.reload();
        }

        $(document).ready(function () {
            $('#statusCari').val('{{request('status')}}')
            table = $('#myTable').DataTable({
                scrollX: true,
                processing: true,
                ajax: {
                    url: '/admin/transaksi/list',
                    type: 'GET',
                },
                'columnDefs': [
                    {
                        "targets": 0, // your case first column
                        "className": "text-center",
                    },
                    {
                        "targets": 1, // your case first column
                        "className": "text-center",
                    },
                    {
                        "targets": 2, // your case first column
                        "className": "text-center",
                    },
                    {
                        "targets": 4,
                        "className": "text-end",
                    },
                    {
                        "targets": 6,
                        "className": "text-center",
                    }
                ],
                "columns": [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: "no_transaksi"},
                    {data: "tanggal"},
                    {data: "user.nama"},
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
                    {
                        data: null, render: function (data, type, row, meta) {
                            return '<a href="#" class="btn btn-primary btn-sm text-white btn-detail" data-id="' + data['id'] + '">Detail</a>';
                        }
                    },
                ]
            })
        });
        var idPesanan;

        function createTableKeranjang(data, k) {
            return '<tr>' +
                '<td>' + (k + 1) + '</td>' +
                '<td><img src="' + data['barang']['gambar'] + '" height="60" width="60" alt="Gambar Produk"></td>' +
                '<td>' + data['barang']['nama'] + '</td>' +
                '<td>' + data['qty'] + '</td>' +
                '<td>' + nominalFormat(data['harga']) + '</td>' +
                '<td>' + nominalFormat(data['sub_total']) + '</td>' +
                '</tr>';
        }

        function setDetail(data) {
            const {
                id,
                user,
                tanggal,
                no_transaksi,
                sub_total,
                ongkir,
                total,
                ekspedisi,
                alamat,
                status_transaksi,
                status_pembayaran,
                url, bank, estimasi, keranjang
            } = data;
            $('#dnotransaksi').html(no_transaksi);
            $('#dtanggalPesanan').html(tanggal);
            $('#dNamaPelanggan').html(user['nama']);
            $('#dAlamatPengiriman').html(alamat);
            $('#dExpedisi').html(ekspedisi);
            $('#dEstimasi').html(estimasi);
            $('#dBiaya').html(nominalFormat(sub_total));
            $('#dOngkir').html(nominalFormat(ongkir));
            $('#dTotal').html(nominalFormat(total));
            $('.btn-confirm').attr('data-id', id);
            let el = $('#tabelDetail');
            el.empty();
            if (keranjang.length > 0) {
                $.each(keranjang, function (k, v) {
                    el.append(createTableKeranjang(v, k));
                })
            } else {
                el.append('<tr>' +
                    '<td colspan="6" class="text-center">Tidak Ada Keranjang</td>' +
                    '</tr>');
            }
            let elBukti = $('#dBuktiTransfer');
            elBukti.empty();
            if (url !== null) {
                elBukti.append('<img src="' + url + '" height="150" width="150" alt="Gambar Bukti"/>');
                $('.link-bukti').on('click', function (e) {
                    e.preventDefault();
                    window.open(url, '_blank');
                })
            } else {
                elBukti.append('<p class="fw-bold">Belum Ada Bukti Pembayaran</p>');
                $('.link-bukti').on('click', function (e) {
                    e.preventDefault();
                })
            }

            if(status_transaksi === 1) {
                $('#btnKonfirmasi').removeClass('d-none');
                $('.btn-confirm').on('click', function () {
                    let status = this.dataset.status;
                    let type = this.dataset.type;
                    let id = this.dataset.id;
                    confirm(id, status, type)
                })
            } else if(status_transaksi === 3) {
                $('#btnKonfirmasi').addClass('d-none');
                $('#btn-kirim').removeClass('d-none');
                $('#btn-kirim').attr('data-status', 4);
                $('#btn-kirim').html('Selesai');
                $('.btn-confirm').on('click', function () {
                    let status = this.dataset.status;
                    let type = this.dataset.type;
                    let id = this.dataset.id;
                    confirm(id, status, type)
                })

            } else if(status_transaksi === 2) {
                $('#btnKonfirmasi').addClass('d-none');
                if(status_pembayaran === 9) {
                    $('#btn-kirim').removeClass('d-none');

                    $('.btn-confirm').on('click', function () {
                        let status = this.dataset.status;
                        let type = this.dataset.type;
                        let id = this.dataset.id;
                        confirm(id, status, type)
                    })
                }
            } else {
                $('#btnKonfirmasi').addClass('d-none');
            }
        }

        async function detail(id) {
            try {
                let response = await $.get('/admin/transaksi/detail/' + id);
                console.log(response)
                if (response['status'] === 200) {
                    setDetail(response['payload']);
                    $('#detail1').modal('show');
                } else {
                    alert(response['message']);
                }
            } catch (e) {
                console.log(e);
                alert('Terjadi Kesalahan')
            }
        }

        async function confirm(id, status, type) {
            try {
                let response = await $.post('/admin/transaksi/detail/' + id, {
                    _token: '{{ csrf_token() }}',
                    status: status,
                    type: type
                });
                console.log(response)
                if (response['status'] === 200) {
                    reload();
                    $('#detail1').modal('hide');
                } else {
                    alert(response['message']);
                }
            } catch (e) {
                console.log(e);
                alert('Terjadi Kesalahan')
            }
        }

        $(document).on('click', '.btn-detail', function (e) {
            e.preventDefault();
            let id = this.dataset.id;
            detail(id);
        });

        $(document).on('change', '#statusCari', function () {
            document.getElementById('formCari').submit();
        });

        function getDetail() {
            $.get('/admin/pesanan/' + idPesanan, function (data) {
                console.log(data);
                $('#dNamaPelanggan').html(data['get_pelanggan']['nama'])
                $('#dChat').attr('href', 'https://wa.me/' + data['get_pelanggan']['no_hp'])
                $('#dAlamatPengirimanKota').html(data['get_expedisi']['nama_kota'] + ' - ' + data['get_expedisi']['nama_propinsi'])
                $('#dAlamatPengiriman').html(data['alamat_pengiriman'])
                $('#dtanggalPesanan').html(moment(data['tanggal_pesanan']).format('DD MMMM YYYY'))
                var biaya = parseInt(data['total_harga'] - data['biaya_pengiriman']);
                $('#dBiaya').html(biaya.toLocaleString())
                $('#dOngkir').html(data['biaya_pengiriman'].toLocaleString())
                $('#dTotal').html(data['total_harga'].toLocaleString())
                $('#dBuktiTransfer').attr('href', data['url_pembayaran'])
                $('#dBuktiTransfer img').attr('src', data['url_pembayaran'])
                $('#dExpedisi').html(data['get_expedisi']['nama'].toUpperCase() + ' ( ' + data['get_expedisi']['service'] + ' )')
                $('#dEstimasi').html(data['get_expedisi']['estimasi'] + ' Hari')
                var status = data['status_pesanan'];
                var txtStatus = 'Menunggu Pembayaran';
                $('#btnKonfirmasi').addClass('d-none')
                $('#btnKirim').addClass('d-none')
                $('#dAlasan').html('')
                if (status === 1) {
                    $('#btnKonfirmasi').removeClass('d-none')
                    txtStatus = 'Menunggu Konfirmasi'
                } else if (status === 2) {
                    $('#btnKirim').removeClass('d-none')
                    txtStatus = 'Dikemas'
                } else if (status === 3) {
                    txtStatus = 'Dikirim'
                    if (data['get_retur'] && data['get_retur']['status'] === 0) {
                        txtStatus = 'Minta Retur'
                        $('#dAlasan').html(data['get_retur']['alasan'])
                    }
                } else if (status === 4) {
                    txtStatus = 'Selesai'
                } else if (status === 5) {
                    txtStatus = 'Dikembalikan'
                    $('#dAlasan').html(data['get_retur']['alasan'])
                }

                $('#dStatus').html(txtStatus)

                var tabel = $('#tabelDetail');
                tabel.empty();
                $.each(data['get_keranjang'], function (key, value) {
                    console.log(value['get_produk']['get_image'])
                    var foto = value['get_produk']['get_image'].length > 0 ? value['get_produk']['get_image'][0]['url_foto'] : '/static-image/noimage.jpg';
                    tabel.append('<tr>' +
                        '<td>' + parseInt(key + 1) + '</td>' +
                        '<td><img src="' + foto + '" height="50"/></td>' +
                        '<td>' + value['get_produk']['nama_produk'] + '</td>' +
                        '<td>' + value['qty'] + '</td>' +
                        '<td>' + value['keterangan'] + '</td>' +
                        '<td>' + value['total_harga'].toLocaleString() + '</td>' +
                        '</tr>')
                })
            })
        }

        function saveKonfirmasi(a) {
            var title = 'Tolak Pembayaran'
            if (a === 2) {
                title = 'Terima Pembayaran'
            } else if (a === 3) {
                title = 'Kirim Pesanan'
            }
            var form_data = {
                'status': a,
                '_token': '{{csrf_token()}}'
            };
            saveDataObject(title, form_data, '/admin/pesanan/' + idPesanan, getDetail)
            return false;

        }
    </script>

@endsection
