<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('admin.home_page') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">{{ config('admin.short_title') }}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{ config('admin.title') }}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu" style="display: flex; justify-content: center; align-items: center; margin-top: 4px; gap: 10px;">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#createOrderModal">
                        <i class="fa fa-shopping-basket"></i> Yeni Kayıt Ekle
                    </button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#createPaymentModal">
                        <i class="fa fa-money"></i> Ödeme Gir
                    </button>
                </li>


                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/admin_files/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ Auth::guard('admin')->user()->full_name }}</span>

                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/admin_files/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                            <p>
                                {{ Auth::guard('admin')->user()->full_name }}
                                <small>Kayıt : {{ Auth::guard('admin')->user()->created_at }}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a target="_blank" href="{{ route('homeView') }}">Siteyi Görüntüle</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    @if(loggedAdminUser()->isSuperAdmin())
                                        <a href="{{ route('admin.clearCache') }}">Önbellek Temizle</a>
                                    @endif
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('admin.user.edit',Auth::guard('admin')->user()->id) }}"
                                   class="btn btn-default btn-flat">Profil</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">Çıkış yap</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
            </ul>
        </div>
    </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/admin_files/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::guard('admin')->user()->full_name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="" style="height: auto;">
                <a href="{{ route('admin.orders') }}">
                    <i class="fa fa-home"></i>
                    <span>Anasayfa</span>
                </a>
            </li>
            <li class="treeview menu-open" style="height: auto;">
                <a href="{{ route('admin.orders') }}">
                    <i class="fa fa-shopping-cart"></i>
                    <span>Siparişler</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu" style="display: block;">
                    <li><a href="{{route('admin.orders')}}"><i class="fa fa-circle-o"></i> Siparişler</a></li>
                    <li><a href="javascript:void(0)" data-toggle="modal" data-target="#createOrderModal"><i class="fa fa-circle-o"></i> Sipariş Oluştur</a></li>
                </ul>
            </li>
            <li class="treeview menu-open" style="height: auto;">
                <a href="{{ route('admin.payments') }}">
                    <i class="fa fa-money"></i>
                    <span>Ödemeler</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu" style="display: block;">
                    <li><a href="{{route('admin.payments')}}"><i class="fa fa-circle-o"></i> Ödemeler</a></li>
                    <li><a href="javascript:void(0)" data-toggle="modal" data-target="#createPaymentModal"><i class="fa fa-circle-o"></i> Ödeme Gir</a></li>
                </ul>
            </li>
            <li class="treeview menu-open" style="height: auto;">
                <a href="{{ route('admin.products') }}">
                    <i class="fa fa-list"></i>
                    <span>Ürünler</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu" style="display: block;">
                    <li><a href="{{route('admin.products')}}"><i class="fa fa-circle-o"></i> Ürünler</a></li>
                    <li><a href="{{route('admin.product.new')}}"><i class="fa fa-circle-o"></i> Ürün Oluştur</a></li>
                </ul>
            </li>
            <li class="treeview menu-open" style="height: auto;">
                <a href="{{ route('admin.users') }}">
                    <i class="fa fa-building"></i>
                    <span>Esnaflar</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu" style="display: block;">
                    <li><a href="{{route('admin.vendors')}}"><i class="fa fa-circle-o"></i> Esnaflar</a></li>
                    <li><a href="{{route('admin.vendors.reports')}}"><i class="fa fa-circle-o"></i> Rapor</a></li>
                    <li><a href="{{route('admin.vendors')}}"><i class="fa fa-circle-o"></i> Yeni Esnaf Oluştur</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
