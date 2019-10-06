<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
        <div class="pull-left image">
            <?php $avatar = (Auth::user()->avatar!=null?'/img/user/'.Auth::user()->avatar:'/img/avatar/logo.jpeg') ?>
            <img src="{{asset($avatar)}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>Admin {{env('APP_NAME')}}</p>
            <!-- Status -->
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
        <?php $userPermissions = \Illuminate\Support\Facades\Auth::user()->getListPermissions();
            //dd($userPermissions);
        ?>
        @if (isset($backend_menus) && !empty($backend_menus))
            @php
                $currentRouteName = request()->route()->getName();
            @endphp
            @foreach($backend_menus as $menu)
                {{--<!--            --> //dd($backend_menus[3],$backend_menus[3]['sub'],$userPermissions);--}}
                @if (isset($menu['sub']) && !empty($menu['sub']))
                    <?php
                    $subHtml = '';
                    $active = false;
                    foreach ($menu['sub'] as $submenu) {
                        if (empty($submenu['permission']) || !empty(array_intersect($userPermissions, $submenu['permission']))) {
                            $class = '';
                            if ($currentRouteName == $submenu['route']) {
                                $class = 'active';
                                $active = true;
                            }
                            $subHtml .= '<li class="' . $class . '"><a href="' . route($submenu['route']) . '">' . trans($submenu['text']) . '</a></li>';
                        }
                    }
                    ?>
                    @if (empty($menu['permission']) || !empty(array_intersect($userPermissions, $menu['permission'])))
                        <li class="{{ $active ? 'active ' : '' }}{{ $menu['class'] }} @if (!empty($subHtml)) treeview @endif">
                            <a href="{{ isset($menu['route']) ? route($menu['route']) : '#' }}">
                                <i class="{{ isset($menu['icon']) ? $menu['icon'] : '' }}"></i> <span>{{ isset($menu['text']) ? trans($menu['text']) : '' }}</span>
                                @if(!empty($menu['sub']) && count($menu['sub']) >  0)
                                    <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                @endif
                            </a>
                            @if (!empty($subHtml))
                                <ul class="treeview-menu">
                                    {!! $subHtml !!}
                                </ul>
                            @endif
                        </li>
                    @endif
                @else
                    @if (empty($menu['permission']) || !empty(array_intersect($userPermissions, $menu['permission'])))
                        <li class="@if(request()->route()->getName() == $menu['route'])active @endif{{ isset($menu['class']) ? $menu['class'] : '' }}">
                            <a href="{{ isset($menu['route']) ? route($menu['route']) : '#' }}"><i class="{{ isset($menu['icon']) ? $menu['icon'] : '' }}"></i> <span>{{ isset($menu['text']) ? trans($menu['text']) : '' }}</span></a>
                        </li>
                    @endif
                @endif
            @endforeach
        @endif

    </ul>
    <!-- /.sidebar-menu -->
</section>
