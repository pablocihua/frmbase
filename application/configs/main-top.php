<?php

$pages = array(
        array(
            'label' => 'Inicio',
            'module' => 'default',
            'controller' => 'index',
            'action' => 'index',
            'resource' => 'default:index',
            'privilege' => 'index'
        ),
        array(
            'label' => 'Usuarios',
            'module' => 'users',
            'controller' => 'users',
            'action' => 'index',
            'resource' => 'users:index'
        ),
        array(
            'label' => 'Posts',
            'module' => 'posts',
            'controller' => 'posts',
            'action' => 'index',
            'resource' => 'posts:index',
            'privilege' => 'index'
        )
 
    );
 
return $pages;