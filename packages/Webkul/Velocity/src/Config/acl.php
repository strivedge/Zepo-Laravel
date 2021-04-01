<?php

return [
	[
        'key'        => 'velocity',
        'name'       => 'velocity::app.admin.layouts.velocity',
        'route'      => 'velocity.admin.content.index',
        'sort'       => 5,
    ], [
        'key'        => 'velocity.meta-data',
        'name'       => 'velocity::app.admin.layouts.meta-data',
        'route'      => 'velocity.admin.meta-data',
        'sort'       => 1,
    ], [
        'key'        => 'velocity.header',
        'name'       => 'velocity::app.admin.layouts.header-content',
        'route'      => 'velocity.admin.content.index',
        'sort'       => 2,
    ], [
        'key'        => 'velocity.tabsection',
        'name'       => 'velocity::app.admin.layouts.tab-section',
        'route'      => 'velocity.admin.tabsection.edit',
        'sort'       => 3,
    ],
    
];

?>