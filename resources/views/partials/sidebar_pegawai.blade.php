<ul class="nav sidebar-menu">
    <li>
        <a href="{{ route('pegawai./') }}">
            <i class="menu-icon c-black-500 glyphicon glyphicon-th-large"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li> 
    <li>
        <a href="{{ route('pegawai.log-kehadiran') }}">
            <i class="menu-icon c-black-500 glyphicon glyphicon-list-alt"></i>
            <span class="menu-text"> Log Kehadiran </span>
        </a>
    </li> 
    <li>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon glyphicon glyphicon-envelope"></i>
            <span class="menu-text"> Pengajuan </span>
            <i class="menu-expand"></i>
        </a>
        <ul class="submenu">
            <li>
                <a href="{{ route('pegawai.pengajuan-cuti') }}">
                    <i class="menu-icon c-black-500 glyphicon glyphicon glyphicon-transfer"></i>
                    <span class="menu-text"> Cuti </span>
                </a>
            </li>
            <li>
                <a href="{{ route('pegawai.pengajuan-izin') }}">
                    <i class="menu-icon c-black-500 glyphicon glyphicon-random"></i>
                    <span class="menu-text"> Izin </span>
                </a>
            </li>
        </ul>
    </li>
</ul>