<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simlitabmas UNRI</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta name="csrf-token" content="'{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="icon" type="image/png" href="{{ asset('public/favicon.png') }}">

  <link rel="stylesheet" href="{{ asset('public/adminLTE/bootstrap/css/bootstrap.min.css') }}">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('public/font-awesome/css/font-awesome.min.css') }}">

  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('public/Ionicons/css/ionicons.min.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/adminLTE/dist/css/AdminLTE.min.css') }}">

  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter -->
  <link rel="stylesheet" href="{{ asset('public/adminLTE/dist/css/skins/skin-blue.min.css') }}">

  <!-- Datatables -->
  <link rel="stylesheet" href="{{ asset('public/adminLTE/plugins/datatables/dataTables.bootstrap.css') }}">

  <!-- Datepicker -->
  <link rel="stylesheet" href="{{ asset('public/adminLTE/plugins/datepicker/datepicker3.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  {{--  script  --}}
  <script src="https://datatables.yajrabox.com/js/jquery.min.js"></script>
  <script src="https://datatables.yajrabox.com/js/bootstrap.min.js"></script>
  <script src="https://datatables.yajrabox.com/js/jquery.dataTables.min.js"></script>
  <script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.25.6/sweetalert2.js"></script>

  {{--  Latest compiled and minified CSS  --}}
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="https://datatables.yajrabox.com/css/datatables.bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.25.6/sweetalert2.css">

  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  @yield('addonhref')

<!-- </head> -->
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Simlitabmas</b> UNRI</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        @if(Auth::user()->level == 1 )
          <!-- Notifications Menu -->
          <li class="dropdown notifications-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-users"></i>
              <span class="label label-success"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Ganti Peran</li>
              <li>


                  <ul class="menu">
                    <li><!-- start notification -->
                      <a href="{{route('gantiperan',Auth::user()->id)}}">
                        <i class="fa fa-user text-aqua"></i> Peran sebagai reviewer
                      </a>
                    </li>
                    <!-- end notification -->
                  </ul>

                <!-- Inner Menu: contains the notifications -->


              </li>
            </ul>
          </li>
          <!-- Messages: style can be found in dropdown.less-->
          @if(Auth::user()->level == 1)
          <li class="dropdown messages-menu">
            <!-- Menu notifikasi persetujuan anggota -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user-plus"></i>
              @if (count($person))
              <span class="label label-danger">{{count($person)}}</span>
              @endif
            </a>
            @endif
            <ul class="dropdown-menu">
              @if(Auth::user()->level == 1)
              <li class="header">{{count($person)}} Persetujuan keanggotaan baru</li>
              <li>
                <!-- inner menu: contains the messages -->
                <ul class="menu">
                @foreach($person as $data )
                  <li><!-- start message -->
                    @if ($data->jenis == 1)
                    <a href="{{route('penelitianng.setuju', base64_encode(mt_rand(1,9).($data->id+$data->anggotaid*3)))}}">
                    @else
                    <a href="{{route('pengabdianng.setuju', base64_encode(mt_rand(1,9).($data->id+$data->anggotaid*3)))}}">
                    @endif
                      <!-- User Image -->
                      <div class="pull-left">
                        <img src="{{ asset('public/images/'.$data->foto) }}" class="img-circle" alt="User Image">
                      </div>
                      <!-- Message title and timestamp -->
                      <h4>
                        {{$data->nama}}
                      </h4>
                      <!-- The message -->
                      <p>Setujui keanggotan {{$data->jenis == 1 ? 'penelitian' : 'pengabdian'}}</p>
                      <h4>
                        <small><i class="fa fa-calendar-plus-o"></i> {{tanggal_indonesia($data->created_at,false)}}
                        </small>
                      </h4>

                    </a>
                  </li>
                @endforeach
                  <!-- end message -->
                </ul>
                <!-- /.menu -->
              </li>
              <li class="footer"><a href="#">Tampilkan semua</a></li>
            </ul>
          </li>
          @endif

        @elseif(Auth::user()->level == 2)
          <!-- Notifications Menu -->
            <li class="dropdown notifications-menu">
              <!-- Menu toggle button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-users"></i>
                <span class="label label-success"></span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">Ganti Peran</li>
                <li>
                  <ul class="menu">

                    <li><!-- start notification -->
                      <a href="{{route('gantiperan',Auth::user()->id)}}">
                        <i class="fa fa-user text-aqua"></i> Peran sebagai dosen
                      </a>
                    </li>
                    <!-- end notification -->
                  </ul>

                  <!-- Inner Menu: contains the notifications -->
                </li>
              </ul>
            </li>
        @endif
          
          <!-- /.messages-menu -->

          <!-- Notifications Menu -->
          <li class="dropdown notifications-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">10 Pesan baru</li>
              <li>
                <!-- Inner Menu: contains the notifications -->
                <ul class="menu">
                  <li><!-- start notification -->
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <!-- end notification -->
                </ul>
              </li>
              <li class="footer"><a href="#">Tampilkan semua</a></li>
            </ul>
          </li>

          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="{{ asset('public/images/'.Auth::user()->foto) }}" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="{{ asset('public/images/'.Auth::user()->foto) }}" class="img-circle" alt="User Image">
                <p>
                  {{ Auth::user()->name }}
                  <small>Universitas Riau</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">

                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{route('profile.edit',base64_encode(mt_rand(10,99).Auth::user()->id)) }}" class="btn btn-default btn-flat">Profil Akun</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); ">Sign out</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('public/images/'.Auth::user()->foto) }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <!-- Status -->
          @if(Auth::user()->level == 1)
            <a><i class="fa fa-circle text-success"></i> Dosen</a>
          @elseif(Auth::user()->level == 2)
            <a><i class="fa fa-circle text-success"></i> Reviewer</a>
          @elseif(Auth::user()->level == 3)
            <a><i class="fa fa-circle text-success"></i> Administrator</a>
          @endif
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU NAVIGASI</li>
        <!-- Optionally, you can add icons to the links -->
        <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

        <!-- Menu Dosen -->
        @if(Auth::user()->level == 1)

        <li class="treeview">
          <a href="#"><i class="fa fa-list-ol"></i> <span>Daftar Usulan Baru</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('penelitianng.index') }}"><i class="fa fa-circle-thin text-blue"></i>Penelitian</a></li>
            <li><a href="{{ route('pengabdianng.index') }}"><i class="fa fa-circle-thin text-blue"></i>Pengabdian</a></li>
          </ul>
        </li>
      <!--  <li class="treeview">
          <a href="#"><i class="fa fa-list-ol"></i> <span>Daftar Usulan Lanjutan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="# "><i class="fa fa-circle-thin text-blue"></i>Penelitian</a></li>
            <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>Pengabdian</a></li>
          </ul>
        </li> -->
        <li class="treeview">
          <a href="#"><i class="fa fa-list-ol"></i> <span>Daftar Perbaikan Proposal</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('perbaikanpenelitianng.index') }}"><i class="fa fa-circle-thin text-blue"></i>Penelitian</a></li>
            <li><a href="{{ route('perbaikanpengabdianng.index') }}"><i class="fa fa-circle-thin text-blue"></i>Pengabdian</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-book"></i> <span>Pelaksanaan Kegiatan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
           <!-- <li><a href="{{ route('rancangan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Rancangan Pelaksanaan</a></li>-->
            <li><a href="{{ route('catatanharian.index') }}"><i class="fa fa-circle-thin text-blue"></i>Catatan Harian</a></li>
            <li><a href="{{ route('laporankemajuan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Laporan Kemajuan</a></li>
            <li><a href="{{ route('luarankemajuan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Luaran Kemajuan</a></li>

            <li><a href="{{ route('laporanakhir.index') }}"><i class="fa fa-circle-thin text-blue"></i>Laporan Akhir</a></li>
           <!-- <li><a href="{{ route('penggunaananggaran.index') }}"><i class="fa fa-circle-thin text-blue"></i>Penggunaan Anggaran</a></li>
            <li><a href="{{ route('tanggungjawab.index') }}"><i class="fa fa-circle-thin text-blue"></i>Tanggungjawab Belanja</a></li>
            <li><a href="{{ route('berkasseminar.index') }}"><i class="fa fa-circle-thin text-blue"></i>Berkas Seminar Hasil</a></li>
            <li><a href="{{ route('hasilpenilaian.index') }}"><i class="fa fa-circle-thin text-blue"></i>Hasil Penilaian</a></li>
            <li><a href="{{ route('skseminar.index') }}"><i class="fa fa-circle-thin text-blue"></i>SK Seminar Hasil</a></li>
            <li><a href="{{ route('pengembaliandana.index') }}"><i class="fa fa-circle-thin text-blue"></i>Pengembalian Dana</a></li>-->
          </ul>
        </li>
        <li><a href="#"><i class="fa fa-database"></i>Riwayat Usulan</a></li>
        <li><a href="{{route('profile.show', base64_encode(mt_rand(10,99).Auth::user()->id))}}"><i class="fa fa-user"></i>Profil</a></li>
        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); "><i class="fa fa-power-off text-red"></i>Sign out</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </li>

        <!-- Menu Reviewer -->
        @elseif(Auth::user()->level == 2)

        <li class="treeview">
          <a href="#"><i class="fa fa-list-ol"></i> <span>Tahap Seleksi</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('penelitianr.index') }}"><i class="fa fa-circle-thin text-blue"></i>Penelitian</a></li>
            <li><a href="{{ route('pengabdianr.index') }}"><i class="fa fa-circle-thin text-blue"></i>Pengabdian</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-list-ol"></i> <span>Tahap Pelaksanaan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            
            <li><a href="{{ route('r_catatan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Catatan Harian</a></li>
            <li><a href="{{ route('r_laporankemajuan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Laporan Kemajuan</a></li>
           
            <li><a href="{{ route('r_anggaran.index') }}"><i class="fa fa-circle-thin text-blue"></i>Penggunaan Anggaran</a></li>
             <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>Laporan Akhir</a></li>
            <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>Rancangan Pelaksanaan</a></li>
            <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>Tanggungjawab Belanja</a></li>
            <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>Berkas Seminar Hasil</a></li>
            <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>Hasil Penilaian</a></li>
            <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>SK Seminar Hasil</a></li>
            <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>Pengembalian Dana</a></li>
            <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>Monitoring dan Evaluasi</a></li>
            <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>Seminar Hasil</a></li>
          </ul>

        </li>
        
        
        <li class="treeview">
          <a href="#"><i class="fa fa-list-ol"></i> <span>Penilaian Pelaksanaan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('rn_laporankemajuan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Laporan Kemajuan</a></li>
            <li><a href="{{ route('rn_laporanakhir.index') }}"><i class="fa fa-circle-thin text-blue"></i>Laporan Akhir</a></li>
            <li><a href="{{ route('rn_luaranlainnya.index') }}"><i class="fa fa-circle-thin text-blue"></i>Luaran Lainnya</a></li>
         
         
          </ul>

        </li>
        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); "><i class="fa fa-power-off text-red"></i>Sign out</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </li>

        <!-- Menu Administrator -->
        @elseif(Auth::user()->level == 3)

        <li class="treeview">
          <a href="#"><i class="fa fa-list-ol"></i> <span>Daftar Usulan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('usulan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Daftar Usulan</a></li>
            <li><a href="{{ route('usulandana.index') }}"><i class="fa fa-circle-thin text-blue"></i>Daftar Usulan Didanai</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-book"></i> <span>Penilaian</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>SK Rektor Reviewer</a></li>
            <li><a href="{{ route('p_reviewer.index') }}"><i class="fa fa-circle-thin text-blue"></i>Daftar Reviewer</a></li>
            <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>Penugasan Reviewer</a></li>
            <li><a href="{{ route('plotingreviewer.index') }}"><i class="fa fa-circle-thin text-blue"></i>Plotting Reviewer</a></li>
            <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>Penetapan Tahapan</a></li>
           <li><a href="{{ route('hasilreviewer.index') }}"><i class="fa fa-circle-thin text-blue"></i>Hasil Penilaian  Proposal</a></li>
            <li><a href="{{ route('hasilmonev.index') }}"><i class="fa fa-circle-thin text-blue"></i>Hasil Penilaian Monev Kemajuan</a></li>
            <li><a href="{{ route('hasilakhir.index') }}"><i class="fa fa-circle-thin text-blue"></i>Hasil Penilaian Monev Hasil</a></li>
            <li><a href="{{ route('hasilakhirluaran.index') }}"><i class="fa fa-circle-thin text-blue"></i>Hasil Penilaian Luaran Lainnya</a></li>


           <!-- <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>Tahapan Penilaian</a></li>-->
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-eye"></i> <span>Pemantauan Kegiatan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('p_rancangan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Rancangan Pelaksanaan</a></li>
            <li><a href="{{ route('p_catatan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Catatan Harian</a></li>
            <li><a href="{{ route('p_luarankemajuan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Luaran Kemajuan</a></li>

            <li><a href="{{ route('p_laporankemajuan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Laporan Kemajuan</a></li>
            <li><a href="{{ route('p_laporanakhir.index') }}"><i class="fa fa-circle-thin text-blue"></i>Laporan Akhir</a></li>
            <li><a href="{{ route('p_anggaran.index') }}"><i class="fa fa-circle-thin text-blue"></i>Penggunaan Anggaran</a></li>
            <li><a href="{{ route('p_tanggungjawab.index') }}"><i class="fa fa-circle-thin text-blue"></i>Tanggungjawab Belanja</a></li>
            <li><a href="{{ route('p_berkasseminar.index') }}"><i class="fa fa-circle-thin text-blue"></i>Berkas Seminar Hasil</a></li>
            <li><a href="{{ route('p_hasilpenilaian.index') }}"><i class="fa fa-circle-thin text-blue"></i>Hasil Penilaian</a></li>
            <li><a href="{{ route('p_skseminar.index') }}"><i class="fa fa-circle-thin text-blue"></i>SK Seminar Hasil</a></li>
            <li><a href="{{ route('p_pengembaliandana.index') }}"><i class="fa fa-circle-thin text-blue"></i>Pengembalian Dana</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-archive"></i> <span>Data Pendukung</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('dp_dokumenrenstra.index') }}"><i class="fa fa-circle-thin text-blue"></i>Unggah Dokumen Renstra</a></li>
            <li><a href="{{ route('dp_bidangunggulan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Bidang Unggulan PT</a></li>
            <li><a href="{{ route('dp_topikunggulan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Topik Unggulan PT</a></li>
            <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>Pencarian User Password</a></li>
            <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>Sinkronisasi Dosen</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-cogs"></i> <span>Pengaturan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>TKT</a></li>
            <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>Lainnya</a></li>
          </ul>
        </li>
          <li class="treeview">
            <a href="#"><i class="fa fa-archive"></i> <span>Master</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
             <li><a href="{{ route('datapenelitian.index') }}"><i class="fa fa-circle-thin text-blue"></i>Data Penelitian Pengabdian</a></li>

              <li><a href="{{ route('dosen.index') }}"><i class="fa fa-circle-thin text-blue"></i>Aministrasi Dosen</a></li>
              <li><a href="{{ route('mataanggaran.index') }}"><i class="fa fa-circle-thin text-blue"></i>Aministrasi Anggaran</a></li>
              <li><a href="{{ route('bidangtkt.index') }}"><i class="fa fa-circle-thin text-blue"></i>Aministrasi Bidang TKT</a></li>
              <li><a href="{{ route('fakultas.index') }}"><i class="fa fa-circle-thin text-blue"></i>Aministrasi Fakultas</a></li>
              <li><a href="{{ route('fokus.index') }}"><i class="fa fa-circle-thin text-blue"></i>Aministrasi Fokus</a></li>
              <li><a href="{{ route('indikatortkt.index') }}"><i class="fa fa-circle-thin text-blue"></i>Aministrasi Indikator TKT</a></li>
              <li><a href="{{ route('keluaran.index') }}"><i class="fa fa-circle-thin text-blue"></i>Aministrasi Luaran </a></li>
              <li><a href="{{ route('pendidikan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Aministrasi Pendidikan</a></li>
              <li><a href="{{ route('periode.index') }}"><i class="fa fa-circle-thin text-blue"></i>Aministrasi Periode</a></li>
              <!--<li><a href="{{ route('prodi.index') }}"><i class="fa fa-circle-thin text-blue"></i>Aministrasi Prodi</a></li>-->
              <li><a href="{{ route('program.index') }}"><i class="fa fa-circle-thin text-blue"></i>Aministrasi Program</a></li>
              <li><a href="{{ route('rumpun.index') }}"><i class="fa fa-circle-thin text-blue"></i>Aministrasi Rumpun Ilmu</a></li>
              <li><a href="{{ route('skema2.index') }}"><i class="fa fa-circle-thin text-blue"></i>Aministrasi Skema</a></li>
              <li><a href="{{ route('struktural.index') }}"><i class="fa fa-circle-thin text-blue"></i>Aministrasi Struktural</a></li>
              <li><a href="{{ route('tema.index') }}"><i class="fa fa-circle-thin text-blue"></i>Aministrasi Tema</a></li>
              <li><a href="{{ route('topik.index') }}"><i class="fa fa-circle-thin text-blue"></i>Aministrasi Topik</a></li>

            </ul>
          </li>
        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); "><i class="fa fa-power-off text-red"></i>Sign out</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </li>
        @elseif(Auth::user()->level == 4)
        <li class="treeview">
          <a href="#"><i class="fa fa-list-ol"></i> <span>Daftar Usulan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('usulan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Daftar Usulan</a></li>
            <li><a href="{{ route('usulandana.index') }}"><i class="fa fa-circle-thin text-blue"></i>Daftar Usulan Didanai</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-book"></i> <span>Penilaian</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
 
           <li><a href="{{ route('hasilreviewer.index') }}"><i class="fa fa-circle-thin text-blue"></i>Hasil Penilaian Penilaian Proposal</a></li>
            <li><a href="{{ route('hasilmonev.index') }}"><i class="fa fa-circle-thin text-blue"></i>Hasil Penilaian Monev Kemajuan</a></li>
            <li><a href="{{ route('hasilakhir.index') }}"><i class="fa fa-circle-thin text-blue"></i>Hasil Penilaian Monev Hasil</a></li>

           <!-- <li><a href="#"><i class="fa fa-circle-thin text-blue"></i>Tahapan Penilaian</a></li>-->
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-eye"></i> <span>Pemantauan Kegiatan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('p_rancangan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Rancangan Pelaksanaan</a></li>
            <li><a href="{{ route('p_catatan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Catatan Harian</a></li>
            <li><a href="{{ route('p_luarankemajuan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Luaran Kemajuan</a></li>

            <li><a href="{{ route('p_laporankemajuan.index') }}"><i class="fa fa-circle-thin text-blue"></i>Laporan Kemajuan</a></li>
            <li><a href="{{ route('p_laporanakhir.index') }}"><i class="fa fa-circle-thin text-blue"></i>Laporan Akhir</a></li>
            <li><a href="{{ route('p_anggaran.index') }}"><i class="fa fa-circle-thin text-blue"></i>Penggunaan Anggaran</a></li>
            <li><a href="{{ route('p_tanggungjawab.index') }}"><i class="fa fa-circle-thin text-blue"></i>Tanggungjawab Belanja</a></li>
            <li><a href="{{ route('p_berkasseminar.index') }}"><i class="fa fa-circle-thin text-blue"></i>Berkas Seminar Hasil</a></li>
            <li><a href="{{ route('p_hasilpenilaian.index') }}"><i class="fa fa-circle-thin text-blue"></i>Hasil Penilaian</a></li>
            <li><a href="{{ route('p_skseminar.index') }}"><i class="fa fa-circle-thin text-blue"></i>SK Seminar Hasil</a></li>
            <li><a href="{{ route('p_pengembaliandana.index') }}"><i class="fa fa-circle-thin text-blue"></i>Pengembalian Dana</a></li>
          </ul>
        </li>
     
      
        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); "><i class="fa fa-power-off text-red"></i>Sign out</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </li>

        @endif
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('title')
      </h1>

      <ol class="breadcrumb">
        @section('breadcrumb')
        <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
        @show
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!-- | Your Page Content Here | -->
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      <small> LPPM - Universitas Riau</small>
    </div>
    <!-- Default to the left -->
    <small><strong>Copyright &copy; 2018 <a href="{{ route('home') }}">Simlitabmas UNRI</a>.</strong> <small>All rights reserved.</small></small>
  </footer>

  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="{{ asset('public/adminLTE/plugins/jQuery/jquery.min.js') }}"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('public/adminLTE/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('public/adminLTE/dist/js/adminlte.min.js') }}"></script>

<!-- <script src="{{ asset('public/adminLTE/dist/js/app.min.js') }}"></script> -->
<script src="{{ asset('public/adminLTE/plugins/chartjs/Chart.min.js') }}"></script>
<script src="{{ asset('public/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('public/adminLTE/plugins/datepicker/bootstrap-datepicker.js') }}"></script>

<script src="{{ asset('public/js/validator.min.js') }}"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->

@yield('script')

<!-- </body></html> -->
</body>
</html>

@section('script')
  <script type="text/javascript">

    "use strict";

    function tambahDosen() {
      window.location = "{{route('p_reviewer.create', '')}}";
    }

    function gantiPeran(id) {
      window.location = "{{route('home.destroy',Auth::user()->level)}}";
    }  </script>

@endsection