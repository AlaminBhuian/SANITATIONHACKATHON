<?php

class Users extends MX_Controller
{

    private $_data;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('layout');
        $this->layout->setLayout('layout/login_layout');

        $this->load->model('users_model', 'users');
        //$this->output->enable_profiler(TRUE);        
    }

    function index()
    {
        $this->_data['pageTitle'] = 'Login';
        $this->layout->view('users/login', $this->_data);
    }

    /**
     * login
     *
     * @return void
     * */
    public function login()
    {
        // input validation
        $this->form_validation->set_rules('txtUserName', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('txtPassword', 'Password', 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == false)
        {
            $this->layout->view('users/login');
        } else
        {
            $username = $this->input->post('txtUserName');
            $password = $this->input->post('txtPassword');

            $login = $this->users->login($username, $password);
            if ($login)
            {
                $this->pageRedirect();
            } else
            {
                $this->_data['msg'] = 'Wrong Account. Try Again.';
                $this->layout->view('users/login', $this->_data);
            }
        }
    }

    public function pageRedirect()
    {
        if ($this->session->userdata('sess_nhrc_desk_id'))
        {
            redirect('complaint/dashboard');
        } else
        {
            redirect(site_url('users/login'));
        }
    }

    /**
     * logout
     *
     * @return void
     * */
    public function signout()
    {
        $this->users->logout();
        redirect(site_url('users/login'));
    }

    public function account()
    {
        $this->layout->setLayout('layout/dashboard_layout');
        $account = $this->users->account($this->session->userdata('sess_nhrc_user_id'));
        $this->_data['pageTitle'] = 'User Account';
        $this->_data['get_desk'] = $this->users->get_desk();
        $this->_data['search_data'] = $account;
        $this->layout->view('users/user_account', $this->_data);
    }
    
    public function submitEditUser()
    {
        $data = array();
            
       
            $data['varFullName'] = $this->input->post('full_name');
            $data['varAddress'] = $this->input->post('address');
            $data['varMoblie'] = $this->input->post('mobile');
            $data['varEmail'] = $this->input->post('email');
            $data['varDesignation'] = $this->input->post('designation');           
            $data['varDepartment'] = $this->input->post('department');
            $data['varEditUser'] = $this->session->userdata('sess_nhrc_user_name');
            $data['id'] = $this->input->post('id');
            if ($this->users->submitEditUser($data))
            {
                $this->session->set_flashdata('exception', '<div class= msg-success>Data Edit Successfully</div>');
                redirect('users/account/'.$_POST['id']);
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('users/account/'.$_POST['id']);
            }
    }
    
    public function change_passowrd()
    {
        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim|xss_clean');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|trim|xss_clean');
        $this->form_validation->set_rules('re_new_password', 'Re-Type Password', 'required|trim|xss_clean|matches[new_password]');        
        if ($this->form_validation->run() == FALSE)
        {
            $this->account();
        } else
        {
            $data = array();
            $data['varCurrentPassword'] = md5($this->input->post('current_password'));           
            $data['varPassword'] = md5($this->input->post('new_password'));
            $data['id'] = $this->session->userdata('sess_nhrc_user_id');
            if ($this->users->change_password($data))
            {
                $this->session->set_flashdata('exception1', '<div class= msg-success>Password Change Successfully</div>');
                redirect('users/account/'.$this->session->userdata('sess_nhrc_user_id'));
            } else
            {
                $this->session->set_flashdata('exception1', '<div class= msg-error>Invalid Password</div>');
                redirect('users/account/'.$this->session->userdata('sess_nhrc_user_id'));
            }
        }
    }

}

