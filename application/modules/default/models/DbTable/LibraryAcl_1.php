<?php

class Model_LibraryAcl extends Zend_Acl
{
    public function __construct() {
        $this->add( new Zend_Acl_Resource('index') );
        $this->add( new Zend_Acl_Resource('error') );
        
        $this->add( new Zend_Acl_Resource('authentication') );
        $this->add( new Zend_Acl_Resource('login'), 'authentication' );
        $this->add( new Zend_Acl_Resource('logout'), 'authentication' );
        
        $this->add( new Zend_Acl_Resource('posts') );
        $this->add( new Zend_Acl_Resource('delete'), 'posts' );
        $this->add( new Zend_Acl_Resource('edit'), 'posts' );
        $this->add( new Zend_Acl_Resource('add'), 'posts' );
        
        $this->addRole(new Zend_Acl_Role('invitado'));
        $this->addRole(new Zend_Acl_Role('personal'), 'invitado');
        $this->addRole(new Zend_Acl_Role('admin'), 'personal');
        
        $this->deny();
        
        $this->allow('invitado', 'index');
//        $this->allow('invitado', 'authentication');
        $this->allow('invitado', 'authentication', 'login');
        $this->allow('personal', 'authentication', 'logout');
        $this->allow('personal', 'posts', 'list');
        $this->allow('personal', 'posts', 'add');
        $this->allow('personal', 'posts', 'edit');
        $this->allow('admin', 'posts', 'delete');
        
        
        $this->addRole( new Zend_Acl_Role('invitado'));
        $this->addRole( new Zend_Acl_Role('personal'), 'invitado');
        $this->addRole( new Zend_Acl_Role('admin'), 'personal');
        
        $this->add( new Zend_Acl_Resource('posts'))
                ->add( new Zend_Acl_Resource('posts:posts'), 'posts');
        
        $this->add( new Zend_Acl_Resource('admin'))
                ->add( new Zend_Acl_Resource('admin:users'), 'admin');
        
        $this->add( new Zend_Acl_Resource('default'))
                ->add( new Zend_Acl_Resource('default:authentication'), 'default')
                ->add( new Zend_Acl_Resource('default:index'), 'default')
                ->add( new Zend_Acl_Resource('default:error'), 'default');
        
        $this->allow('invitado', 'default:authentication', 'login');
        $this->allow('invitado', 'default:error', 'error');
        
        $this->deny('personal', 'default:authentication', 'login');
        $this->allow('personal', 'default:index', 'index');
        $this->allow('personal', 'default:authentication', 'logout');
        $this->allow('personal', 'posts:posts', array('index', 'add', 'edit', 'list'));
        
        $this->allow('admin', 'posts:posts', 'delete');
        $this->allow('admin', 'admin:users', array('index', 'add', 'edit', 'delete', 'list'));
    }
}