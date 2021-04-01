<?php

return [
    [
        'key' => 'blog',
        'name' => 'Blog',
        'route' => 'blog.index',
        'sort' => 7,
    ], [
        'key'   => 'blog.create',
        'name'  => 'blog::app.blogs.create',
        'route' => 'admin.blog.create',
        'sort'  => 1,
    ], [
        'key'   => 'blog.edit',
        'name'  => 'blog::app.blogs.edit',
        'route' => 'admin.blog.edit',
        'sort'  => 2,
    ], [
        'key'   => 'blog.delete',
        'name'  => 'blog::app.blogs.delete',
        'route' => 'admin.blog.delete',
        'sort'  => 3,
    ],
];