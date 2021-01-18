<div class="aside-nav">
    <ul>
        <?php //echo"route name<pre>"; print_r(request()->route()->getName());
              //echo"<br/>menuItem['name']:<pre>"; print_r($menu->currentKey);
        //exit; ?>

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

<!-- <div class="close-nav-aside">
        <i class="icon angle-left-icon close-icon"></i>
    </div> -->
