<?php
/*
 * dashboard page controller
 *
 * @package	NHRC
 * @subpackage	Reports 
 */

class Reports extends MX_Controller {

    private $_data;

    public function __construct()
    {
          parent::__construct();
        $this->load->library('layout');        
        $this->layout->setLayout('layout/main_layout');
        //$this->output->enable_profiler(TRUE);
    }
    function index()
    {
         $this->_data['pageTitle'] = 'Reports';
        
        //$this->layout->view('admin/findcomplaint', $this->_data);
    }
}    

