@extends('dashboard/master')
@section('title', 'Data Obat')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Obat</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                            <li class="breadcrumb-item active">Obat</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card">
                                <div class="card-header">
                                    <!-- Button Tambah -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modalTambah">
                                        <i class="fas fa-file"></i> Tambah Data
                                    </button>
                                    <!-- End Button Tambah -->
                                    <!-- Modal Tambah -->
                                    <form method="POST" action="{{ route('dashboard.admin.drug.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal fade" id="modalTambah">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Tambah Data Obat</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="code">Kode (Auto jika kosong)</label>
                                                            <input type="text"
                                                                class="form-control rounded-0 @error('code') is-invalid @enderror"
                                                                id="code" name="code" value=""
                                                                placeholder="Kode Obat....">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name">Nama <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text"
                                                                class="form-control rounded-0 @error('name') is-invalid @enderror"
                                                                id="name" name="name" value=""
                                                                placeholder="Nama Obat....">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="packaging">Satuan Kemasan <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text"
                                                                class="form-control rounded-0 @error('packaging') is-invalid @enderror"
                                                                id="packaging" name="packaging" value=""
                                                                placeholder="Kemasan...">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="price">Harga <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="number"
                                                                class="form-control rounded-0 @error('price') is-invalid @enderror"
                                                                id="price" name="price" value=""
                                                                placeholder="Harga...">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    </form>
                                    <!-- Modal Tambah End -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>Satuan Kemasan</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($drugs as $item)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $item->code }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->packaging }}</td>
                                                    <td>Rp. {{ number_format($item->price) }}</td>
                                                    <td>
                                                        <div class="text-center">
                                                            <!-- Button -->
                                                            <button type="button" class="btn btn-warning"
                                                                data-toggle="modal"
                                                                data-target="#modalEdit-{{ $item->id }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger"
                                                                data-toggle="modal"
                                                                data-target="#modalHapus-{{ $item->id }}">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>

                                                        <!-- Modal Edit -->
                                                        <form method="POST" action="{{ route('dashboard.admin.drug.update',$item->id) }}" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('put')
                                                            <div class="modal fade" id="modalEdit-{{ $item->id }}">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Edit Data :
                                                                                {{ $item->nama }}</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label for="code">Kode <span
                                                                                    class="text-danger">*</span></label>
                                                                                <input type="text"
                                                                                    class="form-control rounded-0 @error('code') is-invalid @enderror"
                                                                                    id="code" name="code" value="{{ $item->code }}"
                                                                                    placeholder="Kode Obat....">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="name">Nama <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="text"
                                                                                    class="form-control rounded-0 @error('name') is-invalid @enderror"
                                                                                    id="name" name="name" value="{{ $item->name }}"
                                                                                    placeholder="Nama Obat....">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="packaging">Satuan Kemasan <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="text"
                                                                                    class="form-control rounded-0 @error('packaging') is-invalid @enderror"
                                                                                    id="packaging" name="packaging" value="{{ $item->packaging }}"
                                                                                    placeholder="Kemasan...">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="price">Harga <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="number"
                                                                                    class="form-control rounded-0 @error('price') is-invalid @enderror"
                                                                                    id="price" name="price" value="{{ $item->price }}"
                                                                                    placeholder="Harga...">
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit"
                                                                                class="btn btn-warning">Update
                                                                                Data</button>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            <!-- /.modal -->
                                                        </form>
                                                        <!-- Modal Edit End -->

                                                        <!-- Modal Hapus -->
                                                        <form method="POST"
                                                            action="{{ route('dashboard.admin.drug.destroy', $item->id) }}">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="modal fade" id="modalHapus-{{ $item->id }}">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Hapus Data :
                                                                                {{ $item->name }}</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Anda yakin akan menghapus data :
                                                                                {{ $item->name }}</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Hapus Data</button>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            <!-- /.modal -->
                                                        </form>
                                                        <!-- Modal Hapus End -->
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('js')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
