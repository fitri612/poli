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
                                            <div>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mt-5">
                                            <div class="card-body">
                                                <h5 class="text-center">Jadwal Praktik Sekarang</h5>
                                                @if ($schedule)
                                                    <table class="table table-bordered mt-4">
                                                        <thead>
                                                            <tr>
                                                                <th>Hari</th>
                                                                <th>Jam Mulai</th>
                                                                <th>Jam Selesai</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    @if ($schedule->day == 1)
                                                                        Senin
                                                                    @elseif($schedule->day == 2)
                                                                        Selasa
                                                                    @elseif($schedule->day == 3)
                                                                        Rabu
                                                                    @elseif($schedule->day == 4)
                                                                        Kamis
                                                                    @elseif($schedule->day == 5)
                                                                        Jumat
                                                                    @elseif($schedule->day == 6)
                                                                        Sabtu
                                                                    @elseif($schedule->day == 7)
                                                                        Minggu
                                                                    @endif
                                                                </td>
                                                                <td>{{ $schedule->start_time }}</td>
                                                                <td>{{ $schedule->end_time}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <p class="text-center mt-5">Anda belum memiliki jadwal praktek <br> Atur jadwal praktik di form pada sisi kiri</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
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
