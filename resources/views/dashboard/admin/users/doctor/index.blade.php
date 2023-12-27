@extends('dashboard/master')
@section('title', 'Data Dokter')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dokter</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dokter</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card">
                                <div class="card-header">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modalTambah">
                                        <i class="fas fa-file"></i> Tambah Data
                                    </button>
                                    {{-- message error validation --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                    @endif
                                    <div class="modal fade" id="modalTambah">
                                        <div class="modal-dialog">
                                            <div class="modal-content" id="modalTambah">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Tambah Data Baru</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="POST"
                                                    action="{{ route('dashboard.admin.users.doctor.store') }}"
                                                    enctype="multipart/form-data" id="formTambah">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input type="email"
                                                                class="form-control rounded-0 @error('email') is-invalid @enderror"
                                                                id="email" name="email" value=""
                                                                placeholder="Email....">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="nama">Nama</label>
                                                            <input type="text"
                                                                class="form-control rounded-0 @error('name') is-invalid @enderror"
                                                                id="name" name="name" value=""
                                                                placeholder="Nama....">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nama">No Telp</label>
                                                            <input type="text"
                                                                class="form-control rounded-0 @error('phone_number') is-invalid @enderror"
                                                                id="phone_number" name="phone_number" value=""
                                                                placeholder="No Telp....">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nama">Alamat</label>
                                                            <input type="text"
                                                                class="form-control rounded-0 @error('address') is-invalid @enderror"
                                                                id="address" name="address" value=""
                                                                placeholder="Alamat...">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nama">Password</label>
                                                            <input type="text"
                                                                class="form-control rounded-0 @error('password') is-invalid @enderror"
                                                                id="password" name="password" value=""
                                                                placeholder="Password...">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nama">Poli</label>
                                                            <select name="poli_id" id="poli_id" class="form-control">
                                                                @foreach ($polis as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        {{--
                                                        <div class="form-group">
                                                            <label for="nama">Hari</label>
                                                            <select name="hari" id="hari" class="form-control">
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
                                                        </div> --}}

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan
                                                            Data</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Poli</th>
                                                <th>Email</th>
                                                <th>Nama</th>
                                                <th>Phone</th>
                                                <th>Alamat</th>
                                                <th>Jadwal</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($doctors as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->poli->name }}</td>
                                                    <td>{{ $item->user->email }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->phone_number }}</td>
                                                    <td>{{ $item->address }}</td>
                                                    <td>
                                                        @if ($item->serviceSchedule)
                                                            <p>
                                                                Hari :
                                                                {{ $item->serviceSchedule->day == 1 ? 'Senin' : '' }}
                                                                {{ $item->serviceSchedule->day == 2 ? 'Selasa' : '' }}
                                                                {{ $item->serviceSchedule->day == 3 ? 'Rabu' : '' }}
                                                                {{ $item->serviceSchedule->day == 4 ? 'Kamis' : '' }}
                                                                {{ $item->serviceSchedule->day == 5 ? 'Jumat' : '' }}
                                                                {{ $item->serviceSchedule->day == 6 ? 'Sabtu' : '' }}
                                                                {{ $item->serviceSchedule->day == 7 ? 'Minggu' : '' }}
                                                                <br>
                                                                Jam Mulai :
                                                                {{ $item->serviceSchedule->start_time }}
                                                                <br>
                                                                Jam Selesai :
                                                                {{ $item->serviceSchedule->end_time }}
                                                            </p>
                                                        @else
                                                            Dokter belum mengatur jadwal
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->user->is_active == 1)
                                                            <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            <span class="badge badge-danger">Tidak Aktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            <button type="button" class="btn btn-warning"
                                                                data-toggle="modal"
                                                                data-target="#modalEdit-{{ $item->id }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger"
                                                                data-toggle="modal"
                                                                data-target="#modalHapus-{{ $item->user->id }}">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                        <form method="POST"
                                                            action="{{ route('dashboard.admin.users.doctor.update', $item->user->id) }}"
                                                            enctype="multipart/form-data">
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
                                                                                <label for="email">Email</label>
                                                                                <input type="email"
                                                                                    class="form-control rounded-0 @error('email') is-invalid @enderror"
                                                                                    id="email" name="email"
                                                                                    value="{{ $item->user->email }}"
                                                                                    placeholder="">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="nama">No Telp</label>
                                                                                <input type="text"
                                                                                    class="form-control rounded-0 @error('phone_number') is-invalid @enderror"
                                                                                    id="phone_number" name="phone_number"
                                                                                    value="{{ $item->phone_number }}"
                                                                                    placeholder="">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="nama">Nama</label>
                                                                                <input type="text"
                                                                                    class="form-control rounded-0 @error('name') is-invalid @enderror"
                                                                                    id="name" name="name"
                                                                                    value="{{ $item->name }}"
                                                                                    placeholder="">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="nama">Alamat</label>
                                                                                <input type="text"
                                                                                    class="form-control rounded-0 @error('address') is-invalid @enderror"
                                                                                    id="address" name="address"
                                                                                    value="{{ $item->address }}"
                                                                                    placeholder="">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="nama">Hari</label>
                                                                                <select name="hari" id="hari"
                                                                                    class="form-control">
                                                                                    <option value="1"
                                                                                        {{ $item->day == 1 ? 'selected' : '' }}>
                                                                                        Senin</option>
                                                                                    <option value="2"
                                                                                        {{ $item->day == 2 ? 'selected' : '' }}>
                                                                                        Selasa</option>
                                                                                    <option value="3"
                                                                                        {{ $item->day == 3 ? 'selected' : '' }}>
                                                                                        Rabu</option>
                                                                                    <option value="4"
                                                                                        {{ $item->day == 4 ? 'selected' : '' }}>
                                                                                        Kamis</option>
                                                                                    <option value="5"
                                                                                        {{ $item->day == 5 ? 'selected' : '' }}>
                                                                                        Jumat</option>
                                                                                    <option value="6"
                                                                                        {{ $item->day == 6 ? 'selected' : '' }}>
                                                                                        Sabtu</option>
                                                                                    <option value="7"
                                                                                        {{ $item->day == 7 ? 'selected' : '' }}>
                                                                                        Minggu</option>
                                                                                </select>
                                                                            </div>

                                                                            {{-- <div class="form-group">
                                                                                <label for="nama">Jam Mulai</label>
                                                                                <input type="time"
                                                                                    class="form-control rounded-0 @error('jam_mulai') is-invalid @enderror"
                                                                                    id="jam_mulai" name="jam_mulai"
                                                                                    value="{{ $item->serviceSchedules->start_time }}"
                                                                                    placeholder="">
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="nama">Jam Selesai</label>
                                                                                <input type="time"
                                                                                    class="form-control rounded-0 @error('jam_selesai') is-invalid @enderror"
                                                                                    id="jam_selesai" name="jam_selesai"
                                                                                    value="{{ $item->serviceSchedules->end_time }}"
                                                                                    placeholder="">
                                                                            </div> --}}
                                                                            <div class="form-group">
                                                                                <label for="nama">Poli</label>
                                                                                <select name="poli_id" id="poli_id"
                                                                                    class="form-control">
                                                                                    @foreach ($polis as $poli)
                                                                                        <option
                                                                                            value="{{ $poli->id }}">
                                                                                            {{ $poli->name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="nama">Is Active</label>
                                                                                <select name="is_active" id="is_active"
                                                                                    class="form-control"
                                                                                    value={{ $item->user->is_active }}>
                                                                                    <option value="1">Active</option>
                                                                                    <option value="0">Non Active
                                                                                    </option>
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
                                                        <form method="POST"
                                                            action="{{ route('dashboard.admin.users.doctor.destroy', $item->user->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="modal fade"
                                                                id="modalHapus-{{ $item->user->id }}">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Hapus Data :
                                                                                {{ $item->nama }}</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Anda yakin akan menghapus data :
                                                                                {{ $item->nama }}</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Hapus Data</button>
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
