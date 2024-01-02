@extends('dashboard/master')
@section('title', 'Daftar Poli')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Pendaftaran Poli</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Daftar Poli</li>
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
                                    <div class="col-md-4">
                                        @if ($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Whoops!</strong> Terjadi kesalahan input data yang anda
                                                masukan.<br><br>
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }} </li>
                                                    @endforeach
                                                </ul>
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="close">
                                                    <span aria-hidden="true"> &times; </span>
                                                </button>
                                            </div>
                                        @endif
                                        <form method="POST" action="{{ route('dashboard.patient.poli.store') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="rm_number">Nomor Rekam Medis</label>
                                                    <input type="rm_number"
                                                        class="form-control rounded-0 @error('jam_mulai') is-invalid @enderror"
                                                        value="{{ Auth::user()->patient->rm_number }}" readonly>
                                                </div>
                                                <label for="nama">Pilih Poli</label>
                                                <select name="poli_id" id="poli_id" class="form-control">
                                                    <option value="">-- Pilih Poli --</option>
                                                    @foreach ($polis as $poli)
                                                        <option value="{{ $poli->id }}">
                                                            {{ $poli->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama">Pilih Jadwal</label>
                                                <select name="schedule_id" id="schedule_id" class="form-control">
                                                    <option value="">-- Pilih Jadwal --</option>
                                                    @foreach ($schedules as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->doctor->name }} - Poli {{ $item->doctor->poli->name }}
                                                            ({{ $item->day == 1 ? 'Senin' : '' }}
                                                            {{ $item->day == 2 ? 'Selasa' : '' }}
                                                            {{ $item->day == 3 ? 'Rabu' : '' }}
                                                            {{ $item->day == 4 ? 'Kamis' : '' }}
                                                            {{ $item->day == 5 ? 'Jumat' : '' }}
                                                            {{ $item->day == 6 ? 'Sabtu' : '' }}
                                                            {{ $item->day == 7 ? 'Minggu' : '' }}
                                                            - {{ $item->start_time }} s/d {{ $item->end_time }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama">Keluhan</label>
                                                <textarea id="" cols="30" rows="3" class="form-control" name="complaint" placeholder="Keluhan">{{ old('complaint') }}</textarea>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-8">
                                        <table id="example1" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>No Antrian</th>
                                                    <th>Poli</th>
                                                    <th>Dokter</th>
                                                    <th>Keluhan</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($registerPoli as $item)
                                                    <tr>
                                                        <td>{{ $item->queue_number }}</td>
                                                        <td>
                                                            {{ $item->schedule->doctor->poli->name }}
                                                            <br>
                                                            {{ $item->schedule->day == 1 ? 'Senin' : '' }}
                                                            {{ $item->schedule->day == 2 ? 'Selasa' : '' }}
                                                            {{ $item->schedule->day == 3 ? 'Rabu' : '' }}
                                                            {{ $item->schedule->day == 4 ? 'Kamis' : '' }}
                                                            {{ $item->schedule->day == 5 ? 'Jumat' : '' }}
                                                            {{ $item->schedule->day == 6 ? 'Sabtu' : '' }}
                                                            {{ $item->schedule->day == 7 ? 'Minggu' : '' }}
                                                            <br> Jam {{ $item->schedule->start_time }} s/d
                                                            {{ $item->schedule->end_time }}
                                                            <br>
                                                            Tanggal {{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}
                                                        </td>
                                                        <td>
                                                            {{ $item->schedule->doctor->name }}
                                                        </td>
                                                        <td>{{ $item->complaint }}</td>
                                                        <td>
                                                            @php
                                                                // ambil hari ini apakah senin, selasa, rabu, dst
                                                                $day = \Carbon\Carbon::now()->format('N');
                                                                $timeNow = \Carbon\Carbon::now()->format('H:i:s');
                                                                $today = \Carbon\Carbon::now()->format('Y-m-d');
                                                            @endphp
                                                            @if ($item->status == 'waiting')
                                                                <span class="badge badge-warning">Menunggu</span>
                                                                   @elseif($item->created_at->format('Y-m-d') != $today && $item->status == 'waiting')
                                                                <span class="badge badge-danger">Telat</span>
                                                            @elseif($item->status == 'done')
                                                                <span class="badge badge-success">Selesai</span>
                                                            @endif

                                                            @if ($item->status == 'waiting')
                                                                @if ($item->schedule->day == $day)
                                                                    @if ($timeNow >= $item->schedule->start_time && $timeNow <= $item->schedule->end_time)
                                                                        <span class="badge badge-primary">
                                                                            Saatnya Periksa
                                                                        </span>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('dashboard.patient.poli.show', $item->id) }}"
                                                                class="btn btn-sm btn-info">
                                                                Detail <br> Riwayat Periksa
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
