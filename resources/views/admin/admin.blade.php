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
                <h5>Data Customer</h5>
                <button type="button" class="btn btn-primary btn-sm ms-auto" data-bs-toggle="modal"
                        data-bs-target="#tambahsiswa">Tambah Data
                </button>
            </div>
            <table class="table table-striped table-bordered ">
                <thead>
                <th>
                    #
                </th>
                <th>
                    Nama
                </th>
                <th>
                    Alamat
                </th>
                <th>
                    No Hp
                </th>

                <th>
                    Action
                </th>

                </thead>
                <tbody>
                @forelse($data as $v)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $v->nama }}</td>
                        <td>{{ $v->alamat }}</td>
                        <td>{{ $v->no_hp }}</td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm btn-edit"
                                    data-id="{{ $v->id }}"
                                    data-username="{{ $v->username }}"
                                    data-nama="{{ $v->nama }}"
                                    data-alamat="{{ $v->alamat }}"
                                    data-nohp="{{ $v->no_hp }}"
                            >Ubah
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-hapus" data-id="{{ $v->id }}">hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak Ada Data</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
        <div>
            <!-- Modal Tambah-->
            <div class="modal fade" id="tambahsiswa" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Admin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" required class="form-control" id="nama" name="nama">
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" rows="3" name="alamat"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="nphp" class="form-label">no. Hp</label>
                                    <input type="number" required class="form-control" id="nphp" name="no_hp">
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" required class="form-control" id="username" name="username">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" required class="form-control" id="password" name="password">
                                </div>
                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Data Admin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="/admin/admin/patch">
                                @csrf
                                <input type="hidden" name="id-edit" id="id-edit">
                                <div class="mb-3">
                                    <label for="nama-edit" class="form-label">Nama</label>
                                    <input type="text" required class="form-control" id="nama-edit" name="nama-edit">
                                </div>
                                <div class="form-group">
                                    <label for="alamat-edit">Alamat</label>
                                    <textarea class="form-control" id="alamat-edit" rows="3"
                                              name="alamat-edit"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="no_hp-edit" class="form-label">no. Hp</label>
                                    <input type="number" required class="form-control" id="no_hp-edit"
                                           name="no_hp-edit">
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label for="username-edit" class="form-label">Username</label>
                                    <input type="text" required class="form-control" id="username-edit"
                                           name="username-edit">
                                </div>

                                <div class="mb-3">
                                    <label for="password-edit" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password-edit" name="password-edit">
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

            $('.btn-edit').on('click', function () {
                $('#id-edit').val(this.dataset.id);
                $('#nama-edit').val(this.dataset.nama);
                $('#alamat-edit').val(this.dataset.alamat);
                $('#no_hp-edit').val(this.dataset.nohp);
                $('#username-edit').val(this.dataset.username);
                $('#modal-edit').modal('show')
            });

            $('.btn-hapus').on('click', function () {
                hapus(this.dataset.id)
            })
        });

        async function destroy(id) {
            try {
                let response = await $.post('/admin/admin/delete', {
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
