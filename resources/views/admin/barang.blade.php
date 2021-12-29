@extends('admin.base')

@section('title')
    Data Siswa
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
                <h5>Data Barang</h5>
                <button type="button" class="btn btn-primary btn-sm ms-auto" id="addData">Tambah Data
                </button>
            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Satuan</th>
                    <th>Qty</th>
                    <th>Foto Produk</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @forelse($data as $v)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $v->nama }}</td>
                        <td>Rp {{ number_format($v->harga, 0, ",", ".") }}</td>
                        <td>{{ $v->satuan }}</td>
                        <td>{{ $v->qty }}</td>
                        <td>
                            @if($v->gambar != null)
                                <a target="_blank"
                                   href="{{ asset($v->gambar) }}">
                                    <img src="{{ asset($v->gambar) }}" alt="Gambar Barang"
                                         style="width: 75px; height: 100px; object-fit: cover"/>
                                </a>
                            @else
                                Tidak Ada Gambar
                            @endif
                        </td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm btn-edit"
                                    data-id="{{ $v->id }}"
                                    data-nama="{{ $v->nama }}"
                                    data-harga="{{ $v->harga }}"
                                    data-qty="{{ $v->qty }}"
                                    data-satuan="{{ $v->satuan }}"
                            >Ubah
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-hapus" data-id="{{ $v->id }}">hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak Ada Data Barang</td>
                    </tr>
                @endforelse
                </tbody>

            </table>

        </div>


        <div>
            <!-- Modal Tambah-->
            <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Barang</label>
                                    <input type="text" required class="form-control" id="nama" name="nama">
                                </div>

                                <div class="mb-3">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <input type="text" required class="form-control" id="satuan" name="satuan">
                                </div>


                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" required class="form-control" id="harga" name="harga">
                                </div>
                                <div class="mb-3">
                                    <label for="qty" class="form-label">Qty</label>
                                    <input type="number" required class="form-control" id="qty" name="qty">
                                </div>

                                <div class="mt-3 mb-2">
                                    <label for="foto" class="form-label">Foto Barang</label>
                                    <input class="form-control" type="file" id="foto" name="foto">
                                    <div id="showFoto"></div>
                                </div>

                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="/admin/barang/patch" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id-edit" id="id-edit">
                                <div class="mb-3">
                                    <label for="nama-edit" class="form-label">Nama Barang</label>
                                    <input type="text" required class="form-control" id="nama-edit" name="nama-edit">
                                </div>

                                <div class="mb-3">
                                    <label for="satuan-edit" class="form-label">Satuan</label>
                                    <input type="text" required class="form-control" id="satuan-edit" name="satuan-edit">
                                </div>


                                <div class="mb-3">
                                    <label for="harga-edit" class="form-label">Harga</label>
                                    <input type="number" required class="form-control" id="harga-edit" name="harga-edit">
                                </div>
                                <div class="mb-3">
                                    <label for="qty-edit" class="form-label">Qty</label>
                                    <input type="number" required class="form-control" id="qty-edit" name="qty-edit">
                                </div>

                                <div class="mt-3 mb-2">
                                    <label for="foto-edit" class="form-label">Foto Barang</label>
                                    <input class="form-control" type="file" id="foto-edit" name="foto-edit">
                                    <div id="showFoto"></div>
                                </div>

                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@section('script')
    <script>
        $(document).ready(function () {

            $('#addData').on('click', function () {
                $('#modal').modal('show')
            });

            $('.btn-edit').on('click', function () {
                $('#id-edit').val(this.dataset.id);
                $('#nama-edit').val(this.dataset.nama);
                $('#satuan-edit').val(this.dataset.satuan);
                $('#harga-edit').val(this.dataset.harga);
                $('#qty-edit').val(this.dataset.qty);
                $('#modal-edit').modal('show')
            })

            $('.btn-hapus').on('click', function () {
                hapus(this.dataset.id)
            })
        });

        $(document).on('click', '#editData', function () {
            // $('#modal #id').val($(this).data('id'))
            // $('#modal #nama').val($(this).data('nama'))
            // $('#modal #nphp').val($(this).data('hp'))
            // $('#modal #alamat').val($(this).data('alamat'))
            // $('#modal #no_ktp').val($(this).data('ktp'))
            // $('#modal #username').val($(this).data('username'))
            // $('#modal #password').val('')
            // $('#modal #password-confirmation').val('')
            // $('#showFoto').empty();
            // if ($(this).data('id')) {
            //     $('#modal #password').val('**********')
            //     $('#modal #password-confirmation').val('**********')
            // }
            // if ($(this).data('foto')) {
            //     $('#showFoto').html('<img src="' + $(this).data('foto') + '" height="50">')
            // }
            // $('#modal').modal('show')
        })

        function save() {
            saveData('Simpan Data', 'form');
            return false;
        }

        function after() {

        }
        async function destroy(id) {
            try {
                let response = await $.post('/admin/barang/delete', {
                    _token: '{{ csrf_token() }}',
                    id: id
                });
                swal("Berhasil Menghapus data!", {
                    icon: "success",
                });
                window.location.reload();
                console.log(response)
            } catch (e) {
                console.log(e);
                alert('gagal')
            }
        }
        function hapus(id, name) {
            swal({
                title: "Menghapus data?",
                text: "Apa kamu yakin, ingin menghapus data ?!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        destroy(id)
                    } else {
                        swal("Data belum terhapus");
                    }
                });
        }
    </script>

@endsection
