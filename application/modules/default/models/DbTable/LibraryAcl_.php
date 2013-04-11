<?php

class Model_DbTable_LibraryAcl_ extends Zend_Acl
{
    public function __construct() {
        
        
        $this->addRole(new Zend_Acl_Role('invitado'));
        $this->addRole(new Zend_Acl_Role('personal'), 'invitado');
        $this->addRole(new Zend_Acl_Role('admin'), 'personal');

        $this->add( new Zend_Acl_Resource('posts'));
                $this->add( new Zend_Acl_Resource('posts:posts'), 'posts');
        
        $this->add( new Zend_Acl_Resource('admin'));
                $this->add( new Zend_Acl_Resource('admin:users'), 'admin');
        
        $this->add( new Zend_Acl_Resource('default'));
                $this->add( new Zend_Acl_Resource('default:authentication'), 'default');
                $this->add( new Zend_Acl_Resource('default:index'), 'default');
                $this->add( new Zend_Acl_Resource('default:error'), 'default');

        $this->allow('invitado', 'default:authentication', 'login');
        $this->allow('invitado', 'default:error', 'error');
        $this->allow('invitado', 'default:index', 'index');
        
        $this->deny('personal', 'default:authentication', 'login');
        $this->allow('personal', 'default:index', 'index');
        $this->allow('personal', 'default:authentication', 'logout');
        $this->allow('personal', 'posts:posts', 'index');
        $this->allow('personal', 'posts:posts', 'list');
        $this->allow('personal', 'posts:posts', 'add');
        $this->allow('personal', 'posts:posts', 'edit');
        
        $this->allow('admin', 'posts:posts', 'delete');
        $this->allow('admin', 'admin:users', array('index', 'add', 'edit', 'delete', 'list'));
    }
    
    
}