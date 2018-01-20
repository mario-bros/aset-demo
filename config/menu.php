<?php

use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Link;

//use Illuminate\Support\Facades\DB;
//use App\Models\Menu as MenuModel;
use Illuminate\Database\Capsule\Manager as DB;
Use \App\Models\Role;


//Menu::macro('fullsubmenuexample', function () {
//    return Menu::new()->prepend('<a href="#"><span> Multilevel PROVA </span> <i class="fa fa-angle-left pull-right"></i></a>')
//        ->addParentClass('treeview')
//        ->add(Link::to('/link1prova', 'Link1 prova'))->addClass('treeview-menu')
//        ->add(Link::to('/link2prova', 'Link2 prova'))->addClass('treeview-menu')
//        ->url('http://www.google.com', 'Google');
//});

Menu::macro('adminlteSubmenu', function ($submenuName) {
    return Menu::new()->prepend('<a href="#"><span> ' . $submenuName . '</span> <i class="fa fa-angle-left pull-right"></i></a>')
        ->addParentClass('treeview')->addClass('treeview-menu');
});

Menu::macro('adminlteMenu', function () {
    return Menu::new()
        ->addClass('m-menu__nav m-menu__nav--dropdown-submenu-arrow');
});

Menu::macro('adminlteSeparator', function ($title) {
    return Html::raw($title)->addParentClass('header');
});

Menu::macro('adminlteDefaultMenu', function ($content) {
    return Html::raw('<i class="fa fa-link"></i><span>' . $content . '</span>')->html();
});



# START templates
Menu::macro('templateRootTagContent', function ($menuName, $menuIconClass) {
    return Html::raw('<span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon '. $menuIconClass .'"></i>
                    <span class="m-menu__link-text">' . $menuName . '</span>')->html();
});

Menu::macro('templateListActionTagContent', function ($menuName) {
    return Html::raw('
                    <i class="m-menu__link-bullet m-menu__link-bullet--line">
                        <span></span>
                    </i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">' . $menuName . '</span>
                        </span>
                    </span>')->html();
});

Menu::macro('templateDotTagContent', function ($menuName) {
    return Html::raw('<i class="m-menu__link-bullet m-menu__link-bullet--dot">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">' . $menuName . '</span>')->html();
});

Menu::macro('templateBadgeTagContent', function ($menuName, $menuIconClass, $menuBadgeClass, $menuBadgeNumberCount) {
    return Html::raw('<i class="m-menu__link-icon ' . $menuIconClass . '"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">' . $menuName . '</span>
                            <span class="m-menu__link-badge">
                                <span class="m-badge ' . $menuBadgeClass . ' m-badge--wide">' . $menuBadgeNumberCount . '</span>
                            </span>
                        </span>
                    </span>')->html();
});

Menu::macro('menuItemDisplayBadgeNumberTemplate', function ($menuName, $menuIconClass) {
    return Html::raw('
                    <a href="#" class="m-menu__link m-menu__toggle">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon '. $menuIconClass .'"></i>
                        <span class="m-menu__link-title">
                            <span class="m-menu__link-wrap">
                                <span class="m-menu__link-text">' . $menuName . '</span>
                                <span class="m-menu__link-badge">
                                    <span class="m-badge m-badge--danger">0</span>
                                </span>
                            </span>
                        </span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>')
                    ->html();
});

Menu::macro('menuItemLinkTemplate', function ($menuName, $menuIconClass) {
    return Html::raw('
                    <a href="#" class="m-menu__link m-menu__toggle">' .
                        Menu::templateRootTagContent($menuName, $menuIconClass)
                    . '</a>')->html();
});

Menu::macro('menuItemDisplayAppContentTemplate', function ($menuName, $menuIconClass) {
    return Html::raw('
                    <a href="#" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon '. $menuIconClass .'"></i>
                        <span class="m-menu__link-text">'. $menuName .'</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>')
                    ->html();
});

Menu::macro('menuItemDotDisplayAppContentTemplate', function ($menuName) {
    return Html::raw('
                    <a href="#" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                            <span></span>
                        </i>
                        <span class="m-menu__link-text">'. $menuName .'</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>')
                    ->html();
});
# END templates



Menu::macro('rootMenuActive', function ($url, $menuName, $menuIconClass) {
    return Link::to($url, Menu::templateRootTagContent($menuName, $menuIconClass) )
                    ->addClass('m-menu__link')
                    ->addParentClass('m-menu__item m-menu__item--active')
                    ->setParentAttribute('aria-haspopup', "true");
});

Menu::macro('menuItemLinkSubMenuListAction', function ($url, $menuName) {
    return Link::to($url, Menu::templateListActionTagContent($menuName) )
                    ->addClass('m-menu__link')
                    ->addParentClass('m-menu__item')
                    ->setParentAttribute('aria-haspopup', "true")
                    ->setParentAttribute('data-redirect', "true");
});

Menu::macro('menuItemLinkDotList', function ($url, $menuName) {
    return Link::to($url, Menu::templateDotTagContent($menuName) )
                    ->addClass('m-menu__link')
                    ->addParentClass('m-menu__item')
                    ->setParentAttribute('aria-haspopup', "true")
                    ->setParentAttribute('data-redirect', "true");
});

Menu::macro('menuItemLinkBadgeList', function ($url, $menuName, $menuIconClass, $menuBadgeClass, $menuBadgeNumberCount) {
    return Link::to($url, Menu::templateBadgeTagContent($menuName, $menuIconClass, $menuBadgeClass, $menuBadgeNumberCount) )
                    ->addClass('m-menu__link')
                    ->addParentClass('m-menu__item')
                    ->setParentAttribute('aria-haspopup', "true")
                    ->setParentAttribute('data-redirect', "true");
});


Menu::macro('rootMenuWithBadge', function ($menuName, $menuIconClass) {
    return Menu::new()
                    ->prepend( Menu::menuItemDisplayBadgeNumberTemplate( $menuName, $menuIconClass ) . '<div class="m-menu__submenu ">' . '<span class="m-menu__arrow"></span>')
                    ->addClass('m-menu__subnav')
                    ->addParentClass('m-menu__item  m-menu__item--submenu')
                    ->setParentAttribute('aria-haspopup', "true")
                    ->setParentAttribute('data-menu-submenu-toggle', "hover")
                    ->append('</div>');
                    
});

Menu::macro('rootMenuPlain', function ($menuName, $menuIconClass) {
    return Menu::new()
                    ->prepend( Menu::menuItemLinkTemplate( $menuName, $menuIconClass ) . '<div class="m-menu__submenu ">' . '<span class="m-menu__arrow"></span>')
                    ->addClass('m-menu__subnav')
                    ->addParentClass('m-menu__item  m-menu__item--submenu')
                    ->setParentAttribute('aria-haspopup', "true")
                    ->setParentAttribute('data-menu-submenu-toggle', "hover")
                    ->append('</div>');                 
});

Menu::macro('submenuWithArrowContainMenus', function ($menuName, $menuIconClass) {
    return Menu::new()
                    ->prepend( Menu::menuItemDisplayAppContentTemplate( $menuName, $menuIconClass ) . '<div class="m-menu__submenu ">' . '<span class="m-menu__arrow"></span>')
                    ->addClass('m-menu__subnav')
                    ->addParentClass('m-menu__item m-menu__item--submenu')
                    ->setParentAttribute('aria-haspopup', "true")
                    ->setParentAttribute('data-menu-submenu-toggle', "hover")
                    ->setParentAttribute('data-redirect', "true")
                    ->append('</div>');
                    
});

Menu::macro('submenuWithArrowContainDotMenus', function ($menuName) {
    return Menu::new()
                    ->prepend( Menu::menuItemDotDisplayAppContentTemplate( $menuName ) . '<div class="m-menu__submenu ">' . '<span class="m-menu__arrow"></span>')
                    ->addClass('m-menu__subnav')
                    ->addParentClass('m-menu__item m-menu__item--submenu')
                    ->setParentAttribute('aria-haspopup', "true")
                    ->setParentAttribute('data-menu-submenu-toggle', "hover")
                    ->setParentAttribute('data-redirect', "true")
                    ->append('</div>');
                    
});





# START menu categories
/*
    1. rootMenuWithBadge -> 2 params
    2. rootMenuPlain -> 2 params
    3. submenuWithArrowContainMenus -> 2 params
    4. submenuWithArrowContainDotMenus -> 1 param
    5. menuItemLinkSubMenuListAction -> 2 params
    6. menuItemLinkDotList -> 2 params
    7. menuItemLinkBadgeList -> 5 params
*/
# END menu categories





Menu::macro('sidebar', function () {

    if (!function_exists('getMenuItems'))  {

        function getMenuItems($dbInstance, $parentID = null) {
            $results = $dbInstance::table('menus')
                            ->select('id', 'caption', 'url_link', 'category', 'parent_id', 'attributes')
                            ->where('parent_id', $parentID)
                            ->orderBy('order')
                            ->get();
                            //->first();
    
            /*$results = MenuModel::where('parent_id', $parentID)
                            ->orderBy('order')
                            ->get();*/
            $items = [];
    
            if (empty($results)) return $items;
    
            foreach ($results as $result) {
                //dd($result);
                $childItems = getMenuItems($dbInstance, $result->id);
                $items = [
                    'label' => $result->caption,
                    'url' => $result->url_link,
                    'itemAttr' => $result->attributes,
                    'items' => $childItems,
                ];
            }
    
            return $items;
        }
    }
    
    $dbConfig = [
        'driver' => env('DB_CONNECTION'),
        'host' => env('DB_HOST'), 
        'database' => env('DB_DATABASE'),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD')
    ];
    $CapsuleInstance = new DB;
    //$Capsule->addConnection(config::get('database'));
    $CapsuleInstance->addConnection($dbConfig);
    $CapsuleInstance->setAsGlobal();  //this is important
    //$CapsuleInstance->bootEloquent();
    //dd($Capsule);

    $menuItems = getMenuItems($CapsuleInstance, null);
    //dd($menuItems);

    /*Menu::build($menuItems, function ($menu, $label, $link) {

        //dd($menuItems);
        print_r($menuItems); exit(' bye ');
        //$menu->link($link, $label);
    });*/

    return Menu::adminlteMenu()
        ->add( Menu::rootMenuActive('/aset-jemaat', 'Dashboard', 'flaticon-line-graph' ) )

        /*->submenu( '<h2>Basic Usage</h2>', function (Menu $menu) {
            //Menu::submenuWithArrow()
            $menu
                ->prepend('<span class="m-menu__arrow"></span>')
                ->addClass('m-menu__subnav')
                ->wrap('div', ['class' => 'm-menu__submenu'])
                ->addParentClass('m-menu__item  m-menu__item--submenu')
                ->setParentAttribute('aria-haspopup', "true")
                ->setParentAttribute('data-menu-submenu-toggle', "hover");
        })*/

        ->add( Menu::rootMenuWithBadge('Reports', 'flaticon-layers')
            ->addIf( ( Auth::user()->roles()->first()->id <= ROLE::ROLE_SINODE ), Menu::submenuWithArrowContainMenus('Aset Jemaat', 'flaticon-line-graph')
                ->add( Menu::menuItemLinkSubMenuListAction(url('aset-jemaat/list'), 'List Aset Jemaat'))
                ->addIf( ( Auth::user()->roles()->first()->id <= ROLE::ROLE_SINODE ), Menu::menuItemLinkSubMenuListAction(url('aset-jemaat'), 'Rekap Keseluruhan Sinode'))
                ->addIf( ( Auth::user()->roles()->first()->id <= ROLE::ROLE_SINODE ), Menu::menuItemLinkSubMenuListAction(url('aset-jemaat/create'), 'Tambah Baru'))
                ->addIf( ( Auth::user()->roles()->first()->id <= ROLE::ROLE_ADMIN ), Menu::menuItemLinkSubMenuListAction(url('aset-jemaat/import'), 'Import Data Aset per Mupel'))
                ->addIf( ( Auth::user()->roles()->first()->id <= ROLE::ROLE_ADMIN ), Menu::menuItemLinkSubMenuListAction(url('aset-jemaat/import/sinode'), 'Import Data Aset Sinode'))
                ->addIf( ( Auth::user()->roles()->first()->id <= ROLE::ROLE_ADMIN ), Menu::menuItemLinkSubMenuListAction(url('aset-jemaat/export'), 'Download Semua Data Aset Jemaat'))
            )
            ->add( Menu::submenuWithArrowContainMenus('Jemaat Induk', 'flaticon-coins')
                ->add( Menu::menuItemLinkSubMenuListAction(url('form-jemaat-induk'), 'List'))
                ->addIf( ( Auth::user()->roles()->first()->id <= ROLE::ROLE_MUPEL ), Menu::menuItemLinkSubMenuListAction(url('form-jemaat-induk/create'), 'Tambah Baru'))
                ->addIf( ( Auth::user()->roles()->first()->id == ROLE::ROLE_ADMIN ), Menu::menuItemLinkSubMenuListAction(url('form-jemaat-induk/import'), 'Import Data Jemaat Induk'))
            ) 
            ->addIf( ( Auth::user()->roles()->first()->id <= ROLE::ROLE_SINODE ), Menu::submenuWithArrowContainMenus('Mupel', 'flaticon-coins')
                ->add( Menu::menuItemLinkSubMenuListAction(url('form-mupel'), 'List'))
                ->add( Menu::menuItemLinkSubMenuListAction(url('form-mupel/create'), 'Tambah Baru'))
            )
            ->addIf( ( Auth::user()->roles()->first()->id <= ROLE::ROLE_ADMIN ), Menu::submenuWithArrowContainMenus('User', 'flaticon-coins')
                ->add( Menu::menuItemLinkSubMenuListAction(url('users'), 'List'))
                ->add( Menu::menuItemLinkSubMenuListAction(url('users/create'), 'Tambah Baru'))
                ->add( Menu::menuItemLinkSubMenuListAction(url('users/generate-random-password'), 'Generate Random Password'))
                ->add( Menu::menuItemLinkSubMenuListAction(url('users/import'), 'Import'))                                    
            )
        )

        ->add( Menu::rootMenuPlain('User Guide', 'flaticon-file-1')
            ->add( Menu::menuItemLinkSubMenuListAction(url('/users/user-guide-download'), 'Download'))
            ->add( Menu::menuItemLinkSubMenuListAction(url('/users/user-guide'), 'Display'))
        )

        /*->each( function (Link $link) {
            $link->addParentClass('m-menu__item m-menu__item--active');
            $link->setParentAttribute('aria-haspopup', "true");
        })*/
        /*->add(Html::raw('HEADER')->addParentClass('header'))
        ->action('HomeController@index', '<i class="fa fa-home"></i><span>Home</span>')
        ->link('http://www.acacha.org', Menu::adminlteDefaultMenu('Another link'))
//        ->url('http://www.google.com', 'Google')
        ->add(Menu::adminlteSeparator('Acacha Adminlte'))
        #adminlte_menu
        ->add(Link::toUrl('/jenis-aset', '<i class="fa fa-link"></i><span>jenis-aset</span>'))
        ->add(Link::toUrl('/form-jemaat-induk', '<i class="fa fa-link"></i><span>form jemaat induk</span>'))
        ->add(Menu::adminlteSeparator('SECONDARY MENU'))
        ->add(Menu::new()->prepend('<a href="#"><i class="fa fa-share"></i><span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>')
            ->addParentClass('treeview')
            ->add(Link::to('/link1', 'Link1'))->addClass('treeview-menu')
            ->add(Link::to('/link2', 'Link2'))
            ->url('http://www.google.com', 'Google')
            ->add(Menu::new()->prepend('<a href="#"><span>Multilevel 2</span> <i class="fa fa-angle-left pull-right"></i></a>')
                ->addParentClass('treeview')
                ->add(Link::to('/link21', 'Link21'))->addClass('treeview-menu')
                ->add(Link::to('/link22', 'Link22'))
                ->url('http://www.google.com', 'Google')
            )
        )*/
//        ->add(
//            Menu::fullsubmenuexample()
//        )
//        ->add(
//            Menu::adminlteSubmenu('Best menu')
//                ->add(Link::to('/acacha', 'acacha'))
//                ->add(Link::to('/profile', 'Profile'))
//                ->url('http://www.google.com', 'Google')
//        )

        ->setActiveFromRequest();
});