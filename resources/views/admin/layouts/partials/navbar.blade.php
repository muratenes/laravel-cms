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
                @if(config('admin.product.use_comment'))
                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">{{ $unreadCommentsCount }}</span>
                        </a>

                        <ul class="dropdown-menu">
                            <li class="header">Okunmamış {{ $unreadCommentsCount }} yeni yorum var</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    @foreach($lastUnreadComments as $uc)
                                        <li>
                                            <a href="{{ route('admin.product.comments.edit',$uc->id) }}">
                                                <i class="fa fa-comment text-aqua"></i> {{ $uc->message }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="footer"><a href="{{ route('admin.product.comments.list') }}">Tümünü Göster</a></li>
                        </ul>

                    </li>
                @endif

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
                                    <a href="{{ route('admin.clearCache') }}">Önbellek Temizle</a>
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
            @foreach($menus as $index=>$menu)
                <li class="header">{{ $menu['title'] }}</li>
                @foreach($menu as $subI=>$item)
                    @if($subI != 'title' && admin($item['status']))
                        <li class="{{ isset($item['subs']) ? 'treeview menu-open':'' }}">
                            <a href="{{route($item['routeName']) }}" {{ isset($item['key']) ? "id={$item['key']}" :''  }}>
                                <i class="{{ $item['icon'] }}"></i>
                                <span>{{ __("admin.navbar.{$item['title']}") }}</span>
                                <span class="pull-right-container">
                                 @if(isset($item['subs']))
                                        <i class="fa fa-angle-left pull-right"></i>
                                    @endif
                                </span>
                            </a>
                            @if(isset($item['subs']))

                                <ul class="treeview-menu" style="display: block">
                                    @foreach($item['subs'] as $sub)
                                        @if(admin($sub['status']))
                                            <li>
                                                <a href="{{ route($sub['routeName']) }}{{ $sub['param'] ?? '' }}" id="label_{{ $sub['key'] ?? $sub['routeName'] }}">
                                                    <i class="{{ $sub['icon'] }}"></i> {{ __("admin.navbar.{$sub['title']}") }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                @endif
            @endforeach
        @endforeach
        <!-- creator -->
            <li class="header">Creator</li>
            <li>
                <a href="{{ route('admin.builder.menus') }}">
                    <i class="fa fa-wrench"></i> Menü
                </a>
            </li>
            <li>
                <a href="{{ route('admin.builder.edit') }}">
                    <i class="fa fa-gavel"></i> Tema
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
