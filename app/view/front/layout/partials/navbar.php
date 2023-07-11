<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar" data-navbarbg="skin5">
  <nav class="navbar top-navbar navbar-expand-md navbar-dark">
    <div class="navbar-header" data-logobg="skin5">
      <!-- ============================================================== -->
      <!-- Logo -->
      <!-- ============================================================== -->
      <a class="navbar-brand" href="index.html">
        <!-- Logo icon -->
        <b class="logo-icon ps-2">
          <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
          <!-- Dark Logo icon -->
          <img src="<?= base_url() ?>/public/assets/images/logo-icon.png" alt="homepage" class="light-logo" width="25" />
        </b>
        <!--End Logo icon -->
        <!-- Logo text -->
        <span class="logo-text ms-2">
          <!-- dark Logo text -->
          <img src="<?= base_url() ?>/public/assets/images/logo-text.png" alt="homepage" class="light-logo" />
        </span>
        <!-- Logo icon -->
        <!-- <b class="logo-icon"> -->
        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
        <!-- Dark Logo icon -->
        <!-- <img src="../assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

        <!-- </b> -->
        <!--End Logo icon -->
      </a>
      <!-- ============================================================== -->
      <!-- End Logo -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Toggle which is visible on mobile only -->
      <!-- ============================================================== -->
      <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
    </div>
    <!-- ============================================================== -->
    <!-- End Logo -->
    <!-- ============================================================== -->
    <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
      <!-- ============================================================== -->
      <!-- toggle and nav items -->
      <!-- ============================================================== -->
      <ul class="navbar-nav float-start me-auto">
        <li class="nav-item d-none d-lg-block">
          <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a>
        </li>
        <!-- ============================================================== -->
        <!-- create new -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Search -->
        <!-- ============================================================== -->
        <li class="nav-item search-box">
          <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-magnify fs-4"></i></a>
          <form class="app-search position-absolute">
            <input type="text" class="form-control" placeholder="Search &amp; enter" />
            <a class="srh-btn"><i class="mdi mdi-window-close"></i></a>
          </form>
        </li>
      </ul>

      <!-- ============================================================== -->
      <!-- User profile and search -->
      <!-- ============================================================== -->
      <li class="nav-item dropdown">
        <a class="  nav-link
                    dropdown-toggle
                    text-muted
                    waves-effect waves-dark
                    pro-pic
                  " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="<?= base_url() ?>/public/assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31" />
        </a>
        <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="javascript:void(0)"><i class="mdi mdi-account me-1 ms-1"></i> My Profile</a>
          <a class="dropdown-item" href="javascript:void(0)"><i class="mdi mdi-wallet me-1 ms-1"></i> My Balance</a>
          <a class="dropdown-item" href="javascript:void(0)"><i class="mdi mdi-email me-1 ms-1"></i> Inbox</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="javascript:void(0)"><i class="mdi mdi-settings me-1 ms-1"></i> Account
            Setting</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-power-off me-1 ms-1"></i> Logout</a>
          <div class="dropdown-divider"></div>
          <div class="ps-4 p-10">
            <a href="javascript:void(0)" class="btn btn-sm btn-success btn-rounded text-white">View Profile</a>
          </div>
        </ul>
      </li>
      <!-- ============================================================== -->
      <!-- User profile and search -->
      <!-- ============================================================== -->
      </ul>
    </div>
  </nav>
  <?php
  $menu = [

    [ //gudang
      [
        'title' => 'Kelola Barang',
        'Icon' => 'mdi-cube-outline',
        'url' => base_url('/gudang/barang')
      ],
      [
        'title' => 'Catatan Stok',
        'Icon' => 'mdi-clipboard-text',
        'url' => base_url('/gudang/stok')
      ],
    ],
    [ //kasir
      [
        'title' => 'Kasir',
        'Icon' => 'mdi-clipboard-flow',
        'url' => base_url('/kasir')
      ]
    ]
  ];
  ?>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin5">
  <!-- Sidebar scroll-->
  <div class="scroll-sidebar">
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
      <ul id="sidebarnav" class="pt-4">
        <li class="sidebar-item <?= $active ?? ''?>">
          <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url() ?>" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a>
        </li>
        <?php
        if (((int)$sess->user->tipe_user) === 0) {
        ?>
          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('/admin/user') ?>" aria-expanded="false"><i class="mdi mdi-account-card-details"></i><span class="hide-menu">Kelola User</span></a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('/admin/laporan') ?>" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Kelola Laporan</span></a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('/admin/supplier') ?>" aria-expanded="false"><i class="mdi mdi-clipboard-flow"></i><span class="hide-menu">Kelola Supplier</span></a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('/admin/log') ?>" aria-expanded="false"><i class="mdi mdi-clock"></i><span class="hide-menu">Histori log</span></a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('/admin/log') ?>" aria-expanded="false"><i class="mdi mdi-clock"></i><span class="hide-menu">Histori log</span></a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('/auth/login/logout') ?>" aria-expanded="false"><i class="mdi mdi-export"></i><span class="hide-menu">Logout</span></a>
          </li>
        <?php
        }
        ?>
        <?php
        if (((int)$sess->user->tipe_user) === 1) {
        ?>
          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('/gudang/barang') ?>" aria-expanded="false"><i class="mdi mdi-cube-outline"></i><span class="hide-menu">Kelola Barang</span></a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-clipboard-text"></i><span class="hide-menu">Kelola Stok</span></a>
            <ul aria-expanded="false" class="collapse first-level">
              <li class="sidebar-item">
                <a href="<?= base_url('/gudang/stok') ?>" class="sidebar-link"><i class="mdi mdi-dropbox"></i><span class="hide-menu"> Stok Barang </span></a>
              </li>
              <li class="sidebar-item">
                <a href="<?= base_url('/gudang/stok/stok_masuk') ?>" class="sidebar-link"><i class="mdi mdi-inbox-arrow-down"></i><span class="hide-menu"> Histori Stok Masuk </span></a>
              </li>
              <li class="sidebar-item">
                <a href="<?= base_url('/gudang/stok/stok_keluar') ?>" class="sidebar-link"><i class="mdi mdi-inbox-arrow-up"></i><span class="hide-menu"> Histori Stok Keluar </span></a>
              </li>
            </ul>
          </li>
        <?php
        }
        ?>
        <?php
        if (((int)$sess->user->tipe_user) === 2) {
        ?>
          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('/admin/user') ?>" aria-expanded="false"><i class="mdi mdi-account-card-details"></i><span class="hide-menu">Kelola User</span></a>
          </li>
        <?php
        }
        ?>

      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>