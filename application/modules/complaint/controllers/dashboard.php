<?php

class Dashboard extends Auth_Controller
{

    private $_data;

    public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout('layout/complaint_layout');
        $this->load->model('common_settings_model', 'common');
        //$this->output->enable_profiler(TRUE);
        //date_default_timezone_set('Asia/dhaka');
    }

    public function index()
    {
        $this->_data['pageTitle'] = 'Dashboard';

        $this->layout->view('dashboard', $this->_data);
    }

    public function showTotalSubmission($type)
    {
        return $this->common->getTotalSubmittedComplaint($type);
    }

    public function getTotalMyDeskComplaint()
    {
        return $this->common->getTotalMyDeskComplaint($this->session->userdata('sess_nhrc_desk_id'));
    }

}
