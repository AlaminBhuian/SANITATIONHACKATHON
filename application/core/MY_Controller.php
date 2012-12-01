<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_Controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('users/users_model', 'users');
        $this->users->logincheck();
        $this->load->module('auth');    // load auth controller
        
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        if (!$this->cache->apc->is_supported())
        {
            $this->load->driver('cache', array('adapter' => 'file'));
        }

        if (!$this->config->item('site.cache'))
        {
            $this->cache->clean();
        }
        //$this->cache->clean(); 
        //$this->output->enable_profiler(TRUE);      
    }

}