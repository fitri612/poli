<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('assets/img/user.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">
                @auth
                    {{ Auth::user()->name }}
                    @if (Auth::user()->role == 'admin')
                        (Admin)
                    @endif
                    @if (Auth::user()->role == 'doctor')
                        (Dokter)
                    @endif
                    @if (Auth::user()->role == 'guest')
                        ({{ Auth::user()->patient->rm_number }})
                    @endif
                @endauth
            </a>
        </div>
    </div>
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('dashboard.index') }}"
                    class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt nav-icon"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            @auth
                @if (Auth::user()->role == 'guest')
                    <li class="nav-item">
                        <a href="{{ route('dashboard.patient.poli.index') }}" class="nav-link {{ Request::is('dashboard/patient/poli') ? 'active' : '' }}">
                            <i class="fas fa-chart-line nav-icon"></i>
                            <p>Daftar Poli</p>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role == 'admin')
                    {{-- <li class="nav-item">
                        <a href="" class="nav-link }">
                            <i class="fas fa-chart-line nav-icon"></i>
                            <p>Aktifitas Poli</p>
                        </a>
                    </li> --}}
                    <li class="nav-item {{ Request::is('*dashboard/admin/users*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('dashboard.admin.users.doctor.index') }}"
                                    class="nav-link  {{ Request::is('*dashboard/admin/users/doctor*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dokter</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard.admin.users.patient.index') }}"
                                    class="nav-link  {{ Request::is('*dashboard/admin/users/patient*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pasien</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-database"></i>
                            <p>
                                Master Data
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('dashboard.admin.drug.index') }}"
                                    class="nav-link  {{ Request::is('*dashboard/admin/drug*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Obat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard.admin.poli.index') }}"
                                    class="nav-link  {{ Request::is('*dashboard/admin/poli*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Poli</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (Auth::user()->role == 'doctor')
                    <li class="nav-item">
                        <a href="{{ route('dashboard.doctor.schedule.index') }}"
                            class="nav-link {{ Request::is('*dashboard/doctor/schedule*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt nav-icon"></i>
                            <p>Jadwal Praktek</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.doctor.checkup.index') }}"
                            class="nav-link {{ Request::is('*dashboard/doctor/checkup*') ? 'active' : '' }}">
                            <i class="fas fa-stethoscope nav-icon"></i>
                            <p>Memeriksa Pasien</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.doctor.history.index') }}"
                            class="nav-link {{ Request::is('*dashboard/doctor/history*') ? 'active' : '' }}">
                            <i class="fas fa-history nav-icon"></i>
                            <p>Riwayat Pasien</p>
                        </a>
                    </li>
                @endif
            @endauth
        </ul>
    </nav>
</div>
