<?php
/*
 * dashboard page controller
 *
 * @package	NHRC
 * @subpackage	Dashboard 
 */

class Dashboard extends MX_Controller {

    private $_data;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('layout');        
        $this->layout->setLayout('layout/complaint_layout');
        //$this->output->enable_profiler(TRUE);
    }
    function index()
    {
        $this->_data['pageTitle'] = 'Dashboard';
        
        $this->layout->view('admin/dashboard_body', $this->_data);
    }
	
	//jkhkj hkjh kjh 
}    

