<div class="navbar-left" style="width: 115px;">
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
            @if($menu->getActive($menuItem) == 'active')

                <div class="aside-nav">
                    <ul>
                        @if (request()->route()->getName() != 'admin.configuration.index')
                            <?php $keys = explode('.', $menu->currentKey);  ?>

                            @if(isset($keys) && strlen($keys[0]))
                            @foreach (\Illuminate\Support\Arr::get($menu->items, current($keys) . '.children') as $item)
                                <li class="{{ $menu->getActive($item) }}">
                                    <a href="{{ $item['url'] }}">

                                        <?php //print_r($menu->getActive($item));exit(); ?>
                                        {{ trans($item['name']) }}

                                        @if ($menu->getActive($item))
                                            <i class="angle-right-icon"></i>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                            @endif
                        @else
                            @foreach ($config->items as $key => $item)
                                <li class="{{ $item['key'] == request()->route('slug') ? 'active' : '' }}">
                                    <a href="{{ route('admin.configuration.index', $item['key']) }}">
                                        {{ isset($item['name']) ? trans($item['name']) : '' }}

                                        @if ($item['key'] == request()->route('slug'))
                                            <i class="angle-right-icon"></i>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            @endif

        @endforeach
    </ul>
</div>