<ul class="nav sidebar-menu">
    <li>
        <a href="{{ route('admin./') }}">
            <i class="menu-icon c-black-500 glyphicon glyphicon-th-large"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li> 
    <li>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon fa fa-desktop"></i>
            <span class="menu-text"> Master </span>
            <i class="menu-expand"></i>
        </a>
        <ul class="submenu">
            <li>
                <a href="{{ route('admin.jabatan') }}">
                    <i class="menu-icon c-black-500 glyphicon glyphicon-th-list"></i>
                    <span class="menu-text"> Jabatan </span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.karyawan') }}">
                    <i class="menu-icon c-black-500 glyphicon glyphicon-user"></i>
                    <span class="menu-text"> Karyawan </span>
                </a>
            </li>
        </ul>
    </li>   
    <li>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon glyphicon glyphicon glyphicon-edit"></i>
            <span class="menu-text"> Absensi </span>
            <i class="menu-expand"></i>
        </a>
        <ul class="submenu">
            <li>
                <a href="{{ route('admin.kehadiran') }}">
                    <i class="menu-icon c-black-500 glyphicon glyphicon-list-alt"></i>
                    <span class="menu-text"> Kehadiran </span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.cuti') }}">
                    <i class="menu-icon c-black-500 glyphicon glyphicon glyphicon-transfer"></i>
                    <span class="menu-text"> Cuti </span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.izin') }}">
                    <i class="menu-icon c-black-500 glyphicon glyphicon-random"></i>
                    <span class="menu-text"> Izin </span>
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon glyphicon glyphicon-envelope"></i>
            <span class="menu-text"> Pengajuan </span>
            <i class="menu-expand"></i>
        </a>
        <ul class="submenu">
            <li>
                <a href="{{ route('admin.pengajuan_cuti') }}">
                    <i class="menu-icon c-black-500 glyphicon glyphicon glyphicon-transfer"></i>
                    <span class="menu-text"> Cuti </span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pengajuan_izin') }}">
                    <i class="menu-icon c-black-500 glyphicon glyphicon-random"></i>
                    <span class="menu-text"> Izin </span>
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="{{ route('admin.kantor') }}">
            <i class="menu-icon c-black-500 glyphicon glyphicon-map-marker"></i>
            <span class="menu-text"> Kantor </span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.rekap-kehadiran') }}">
            <i class="menu-icon c-black-500 glyphicon glyphicon-print"></i>
            <span class="menu-text"> Rekap Kehadiran </span>
        </a>
    </li> 
    <li>
        <a href="{{ route('admin.generate-hari-libur') }}">
            <i class="menu-icon c-black-500 glyphicon glyphicon-plane"></i>
            <span class="menu-text"> Generate Hari Libur </span>
        </a>
    </li> 
    <li>
        <a href="{{ route('admin.modul') }}">
            <i class="menu-icon c-black-500 glyphicon glyphicon-link"></i>
            <span class="menu-text"> Modul </span>
        </a>
    </li>
</ul>