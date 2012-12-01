<?php
/*
 * dashboard page controller
 *
 * @package	NHRC
 * @subpackage	Main Content 
 */

class Main extends MX_Controller {

    private $_data;

    public function __construct()
    {
          parent::__construct();
        $this->load->library('layout');        
        $this->layout->setLayout('layout/main_layout');
        $this->load->model('admin/settings_model');
        $this->load->model('complaint/complaint_model');
        //$this->output->enable_profiler(TRUE);
    }
    function index()
    {
        $this->load->library('pagination');
	$config['base_url']         =   site_url('admin/main/index/');
	$config['total_rows']       =   $this->complaint_model->get_complaint_info(0,0)->num_rows();
	$config['per_page']         =   '5';
	$config['uri_segment']      =   '4';
	$this->pagination->initialize($config);
        $this->_data['get_info']    =   $this->complaint_model->get_complaint_info($config['per_page'],$this->uri->segment(4,0))->result_array();
	$this->_data['paginet']     =   $this->pagination->create_links();         
        $this->_data['pageTitle']   =   'Find Complaints';
        $this->layout->view('admin/findcomplaint', $this->_data);
    }
    
function search_complaint_data()
    {
    
    echo"<pre>";
    print_r($_POST);
    exit();
        $this->load->library('pagination');
	$config['base_url']         =   'http://localhost/nhrc_cms/admin/main/index/';
	$config['total_rows']       =   $this->settings_model->get_complaint_info(0,0)->num_rows();
	$config['per_page']         =   '5';
	$config['uri_segment']      =   '4';
	$this->pagination->initialize($config);
        $this->_data['get_info']    =   $this->settings_model->get_complaint_info($config['per_page'],$this->uri->segment(4,0))->result_array();
	$this->_data['paginet']     =   $this->pagination->create_links();         
        $this->_data['pageTitle']   =   'Find Complaints';
        $this->layout->view('admin/findcomplaint', $this->_data);
    }	
    
    
}    

