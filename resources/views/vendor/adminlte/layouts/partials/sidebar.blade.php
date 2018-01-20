<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>

<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark m-aside-menu--dropdown" data-menu-vertical="true" data-menu-dropdown="true" data-menu-scrollable="true" data-menu-dropdown-timeout="500" >
        <ul class="m-menu__nav m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item m-menu__item--active" aria-haspopup="true" >
                <a href="{{ url('home') }}" class="m-menu__link">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-text">Dashboard</span>
                </a>
            </li>
            
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover">
                <a href="#" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">Reports</span>
                            <span class="m-menu__link-badge">
                                <span class="m-badge m-badge--danger">4</span>
                            </span>
                        </span>
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>

                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <!-- li class="m-menu__item m-menu__item--parent" aria-haspopup="true" >
                            <span class="m-menu__link">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">Reports</span>
                                        <span class="m-menu__link-badge">
                                            <span class="m-badge m-badge--danger">2</span>
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </li -->
                        <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover" data-redirect="true">
                            <a href="#" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon flaticon-line-graph"></i>
                                <span class="m-menu__link-text">Aset Jemaat</span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>

                            <div class="m-menu__submenu ">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                                        <a href="{{ url('aset-jemaat') }}" class="m-menu__link ">
                                            <!-- i class="m-menu__link-icon flaticon-computer"></i -->
                                            <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">Rekap Keseluruhan Sinode</span>
                                                    <!-- span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--warning m-badge--wide">
                                                            10
                                                        </span>
                                                    </span -->
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " aria-haspopup="true" data-redirect="true">
                                        <a href="{{ url('aset-jemaat') }}" class="m-menu__link ">   
                                            <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">List</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " aria-haspopup="true" data-redirect="true">
                                        <a href="{{ url('aset-jemaat/create') }}" class="m-menu__link ">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">Tambah Baru</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " aria-haspopup="true" data-redirect="true">
                                        <a href="{{ url('aset-jemaat/import') }}" class="m-menu__link ">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">Import Data Aset per Mupel</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " aria-haspopup="true" data-redirect="true">
                                        <a href="{{ url('aset-jemaat/import/sinode') }}" class="m-menu__link ">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">Import Data Aset Sinode</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    
                                </ul>

                            </div>
                        </li>
                        <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover" data-redirect="true">
                            <a href="#" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon flaticon-clipboard"></i>
                                <span class="m-menu__link-text">Jenis Aset</span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>

                            <div class="m-menu__submenu ">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item " aria-haspopup="true" data-redirect="true">
                                        <a href="{{ url('jenis-aset') }}" class="m-menu__link ">   
                                            <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">List</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " aria-haspopup="true" data-redirect="true">
                                        <a href="{{ url('jenis-aset/create') }}" class="m-menu__link ">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">Tambah Baru</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </li>
                        <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover" data-redirect="true">
                            <a href="#" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon flaticon-coins"></i>
                                <span class="m-menu__link-text">Jemaat Induk</span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>

                            <div class="m-menu__submenu ">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item " aria-haspopup="true" data-redirect="true">
                                        <a href="{{ url('form-jemaat-induk') }}" class="m-menu__link ">   
                                            <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">List</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " aria-haspopup="true" data-redirect="true">
                                        <a href="{{ url('form-jemaat-induk/create') }}" class="m-menu__link ">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">Tambah Baru</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " aria-haspopup="true" data-redirect="true">
                                        <a href="{{ url('form-jemaat-induk/import') }}" class="m-menu__link ">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">Import Data Jemaat Induk</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </li>
                        <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover" data-redirect="true">
                            <a href="#" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon flaticon-coins"></i>
                                <span class="m-menu__link-text">Mupel</span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>

                            <div class="m-menu__submenu ">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item " aria-haspopup="true" data-redirect="true">
                                        <a href="{{ url('form-mupel') }}" class="m-menu__link ">   
                                            <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">List</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " aria-haspopup="true" data-redirect="true">
                                        <a href="{{ url('form-mupel/create') }}" class="m-menu__link ">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">Tambah Baru</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover" >
                <a  href="#" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-lifebuoy"></i>
                    <span class="m-menu__link-text">Support</span>
                    <!-- i class="m-menu__ver-arrow la la-angle-right"></i -->
                </a>

                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <!-- li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"  data-redirect="true">
                            <span class="m-menu__link">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">Support</span>
                            </span>
                        </li -->

                        <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                            <a  href="#" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Reports</span>
                            </a>
                        </li>

                        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover" data-redirect="true">
                            <a  href="#" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Cases</span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu ">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                                        <a href="inner.html" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-computer"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">
                                                        Pending
                                                    </span>
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--warning m-badge--wide">
                                                            10
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                                        <a  href="inner.html" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-signs-2"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">
                                                        Urgent
                                                    </span>
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--danger m-badge--wide">
                                                            6
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                                        <a  href="inner.html" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-clipboard"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">
                                                        Done
                                                    </span>
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--success m-badge--wide">
                                                            2
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                                        <a  href="inner.html" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-multimedia-2"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">
                                                        Archive
                                                    </span>
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--info m-badge--wide">
                                                            245
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Clients</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Audit
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <li class="m-menu__item  m-menu__item--submenu m-menu__item--bottom-2" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="#" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-settings"></i>
                    <span class="m-menu__link-text">Settings</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu m-menu__submenu--up">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent m-menu__item--bottom-2" aria-haspopup="true" >
                            <span class="m-menu__link">
                                <span class="m-menu__link-text">
                                    Settings
                                </span>
                            </span>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                            <a href="{{ url('accounts') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Accounts</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                            <a href="{{ url('roles') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">User Roles</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="m-menu__item  m-menu__item--submenu m-menu__item--bottom-1" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="#" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-info"></i>
                    <span class="m-menu__link-text">
                        Help
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu m-menu__submenu--up">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent m-menu__item--bottom-1" aria-haspopup="true" >
                            <span class="m-menu__link">
                                <span class="m-menu__link-text">Help</span>
                            </span>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Support</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Blog</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Documentation</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Pricing</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Terms</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>
<!-- END: Left Aside -->