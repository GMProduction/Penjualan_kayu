@extends('admin.base')

@section('title')
    Data Barang
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
                        <form>
                            <div>
                                <label for="kategori" class="form-label">Status Sewa</label>
                                <div class="d-flex">
                                    <select class="form-select me-2" aria-label="Default select example" id="selectStatus"
                                        name="status">
                                        <option selected value="">Semua</option>
                                        <option value="11">Menunggu Konfirmasi</option>
                                        <option value="1">Menunggu Diambil</option>
                                        <option value="2">Dipinjam</option>
                                        <option value="3">Selesai</option>
                                    </select>
                                </div>
                            </div>

                            <div class="me-2 ms-2">
                                <label for="kategori" class="form-label">Periode</label>
                                <div class="input-group input-daterange">
                                    <input type="text" class="form-control me-2" name="start"
                                        style="background-color: white; line-height: 2.0;" readonly
                                        value="{{ request('start') }}" required>
                                    <div class="input-group-addon">to</div>
                                    <input type="text" class="form-control ms-2" name="end"
                                        style="background-color: white; line-height: 2.0;" readonly
                                        value="{{ request('end') }}" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success mx-2">Cari</button>
                            <a class="btn btn-warning" id="cetak" target="_blank" href="#!">Cetak</a>
                        </form>

                    </div>
                </form>

            </div>

            <table class="table table-striped table-bordered ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal Pesan</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>

            </table>


        </div>

    </section>

@endsection

@section('script')
    <script>
        $('.input-daterange input').each(function() {
            $(this).datepicker({
                format: "dd-mm-yyyy"
            });
        });

        $(document).on('click', '#cetak', function() {
            // console.log(window.location.pathname+'/cetak'+window.location.search )
            $(this).attr('href', window.location.pathname + '/cetak' + window.location.search);
        })
    </script>

@endsection
