@extends('dashboard/master')
@section('title', 'Data Jadwal Praktek')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Jadwal Praktek</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Jadwal Praktek</li>
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
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form method="POST" action="{{ route('dashboard.doctor.schedule.store') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="nama">Hari</label>
                                                <select name="hari" id="hari" class="form-control">
                                                    <option value="">-- Pilih Hari --</option>
                                                    <option value="1">Senin</option>
                                                    <option value="2">Selasa</option>
                                                    <option value="3">Rabu</option>
                                                    <option value="4">Kamis</option>
                                                    <option value="5">Jumat</option>
                                                    <option value="6">Sabtu</option>
                                                    <option value="7">Minggu</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama">Jam Mulai</label>
                                                <input type="time"
                                                    class="form-control rounded-0 @error('jam_mulai') is-invalid @enderror"
                                                    id="jam_mulai" name="jam_mulai" value=""
                                                    placeholder="Jam Mulai....">
                                            </div>
                                            <div class="form-group">
                                                <label for="nama">Jam Selesai</label>
                                                <input type="time"
                                                    class="form-control rounded-0 @error('jam_selesai') is-invalid @enderror"
                                                    id="jam_selesai" name="jam_selesai" value=""
                                                    placeholder="Jam Selesai....">
                                            </div>
                                            <div class="form-group">
                                                <label for="nama">Status</label>
                                                <select name="is_active" id="is_active" class="form-control">
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="1">Aktif</option>
                                                    <option value="0">Tidak Aktif</option>
                                                </select>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mt-5">
                                            <div class="card-body">
                                                <h5 class="text-center">Jadwal Praktik Sekarang</h5>
                                                <table class="table table-bordered mt-4">
                                                    <thead>
                                                        <tr>
                                                            <th>Hari</th>
                                                            <th>Jam Mulai</th>
                                                            <th>Jam Selesai</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($schedule as $item)
                                                            <tr>
                                                                <td>
                                                                    @if ($item->day == 1)
                                                                        Senin
                                                                    @elseif($item->day == 2)
                                                                        Selasa
                                                                    @elseif($item->day == 3)
                                                                        Rabu
                                                                    @elseif($item->day == 4)
                                                                        Kamis
                                                                    @elseif($item->day == 5)
                                                                        Jumat
                                                                    @elseif($item->day == 6)
                                                                        Sabtu
                                                                    @elseif($item->day == 7)
                                                                        Minggu
                                                                    @endif
                                                                </td>
                                                                <td>{{ $item->start_time }}</td>
                                                                <td>{{ $item->end_time }}</td>
                                                                <td>
                                                                    @if ($item->is_active == 1 || $item->is_active == '1')
                                                                        Aktif
                                                                    @else
                                                                        Tidak Aktif
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="text-center">
                                                                        <button type="button" class="btn btn-warning"
                                                                            data-toggle="modal"
                                                                            data-target="#modalEdit-{{ $item->id }}">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>
                                                                    </div>

                                                                    <form method="POST"
                                                                        action="{{ route('dashboard.doctor.schedule.update', $item->id) }}"
                                                                        enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('put')
                                                                        <div class="modal fade"
                                                                            id="modalEdit-{{ $item->id }}">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h4 class="modal-title">Edit Data :
                                                                                            {{ $item->nama }}</h4>
                                                                                        <button type="button"
                                                                                            class="close"
                                                                                            data-dismiss="modal"
                                                                                            aria-label="Close">
                                                                                            <span
                                                                                                aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="is_active">Status</label>
                                                                                            <select name="is_active"
                                                                                                id="is_active"
                                                                                                class="form-control">
                                                                                                <option value="">
                                                                                                    -- Pilih Status
                                                                                                    --</option>
                                                                                                <option value="1"
                                                                                                    @if ($item->is_active == 1 || $item->is_active == '1') selected @endif>
                                                                                                    Aktif</option>
                                                                                                <option value="0"
                                                                                                    @if ($item->is_active == 0 || $item->is_active == '0') selected @endif>
                                                                                                    Tidak Aktif</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="submit"
                                                                                            class="btn btn-warning">Update
                                                                                            Data</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
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
