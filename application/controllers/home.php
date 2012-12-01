<?php

class Home extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
    }

    /*
     * load home page
     */

    public function index()
    {
        Assets::add_js($this->load->view('home/login_validation_js', null, true), 'inline');
        Assets::add_js(array(
            base_url() . ASSETS_JS . 'jquery.validate.min.js',
                ), 'external', TRUE);
        $this->template->render();
    }

    public function login()
    {
        // input validation
        $this->form_validation->set_rules('txtUsername', 'Username', 'trim|min_length[5]|required|remove_sp_char');
        $this->form_validation->set_rules('txtPassword', 'Password', 'required|min_length[5]|max_length[30]|trim');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == false)
        {
            $this->template->current_view = 'home/index';
            $this->index();
            return FALSE;
        } else
        {
            $this->load->helper('string');
            $this->load->helper('email');

            $username = strip_quotes(trim($this->input->post('txtUsername', TRUE)));
            $password = $this->input->post('txtPassword', TRUE);

            if (valid_email($username))
            {
                $this->_checkExaminer($username, $password);
            } else
            {
                $this->_checkCandidate($username, $password);
            }
        }
    }

    private function _checkCandidate($username, $password)
    {
        $this->load->model('auth_model');

        $login = $this->auth_model->login($username, $password);
        if ($login)
        {
            redirect('applicant/dashboard');
        } else
        {
            $this->session->set_flashdata('errMsg', 'Login Failed. Please try again');
            $this->template->current_view = 'home/index';
            $this->index();
            return FALSE;
        }
    }

    private function _checkExaminer($username, $password)
    {
        $this->load->model('auth_model');

        $login = $this->auth_model->loginExaminer($username, $password);
        if ($login)
        {
            redirect('examiner/dashboard');
        } else
        {
            $this->session->set_flashdata('errMsg', 'Login Failed. Please try again');
            $this->template->current_view = 'home/index';
            $this->index();
            return FALSE;
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url());
    }

}
