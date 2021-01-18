<div class="navbar-left" style="width: 251px;">
    <ul class="menubar">
        @foreach ($menu->items as $menuItem)

         <?php //echo"menuItem<pre>"; print_r($menu->getActive($menuItem));
              //echo"<br/>menuItem children': <pre>"; print_r(current($menuItem['children']));
        //exit; ?>

            <li class="menu-item {{ $menu->getActive($menuItem) }}">
                <a href="{{ count($menuItem['children']) ? current($menuItem['children'])['url'] : $menuItem['url'] }}">
                    <span class="icon {{ $menuItem['icon-class'] }}"></span>
                    
                    <span>{{ trans($menuItem['name']) }}</span>
                </a>
            </li>
            

        @endforeach
    </ul>
</div>