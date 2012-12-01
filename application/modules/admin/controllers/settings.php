<?php

class Settings extends Auth_Controller
{

    private $_data;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('layout', 'form_validation');
        $this->layout->setLayout('layout/admin_layout');

        //$this->output->enable_profiler(TRUE);

        $this->load->model('admin/settings_model');
        $this->load->model('common_settings_model');

        if (!$this->auth->havePermission('SETTINGS'))
        {
            redirect(site_url());
        }
    }

    public function index()
    {
        $this->_data['pageTitle'] = 'Settings';
        $this->layout->view('admin/settings_body', $this->_data);
    }

    public function addNewDistrict()
    {
        $this->_data['pageTitle'] = 'District/Zilla';
        $this->layout->view('admin/users/addNewDistrict', $this->_data);
    }

    public function user_list()
    {
        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/settings/user_list/');
        $config['total_rows'] = $this->settings_model->get_user(0, 0)->num_rows();
        $config['per_page'] = $this->config->item('SETTINGS_PAGING_LIMIT');
        $config['uri_segment'] = '4';
        $this->pagination->initialize($config);
        $this->_data['get_user'] = $this->settings_model->get_user($config['per_page'], $this->uri->segment(4, 0))->result_array();
        $this->_data['paginet'] = $this->pagination->create_links();
        $this->_data['pageTitle'] = 'User Account';
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->layout->view('admin/users/user_list', $this->_data);
    }

    public function search_user()
    {
        $data = array();
        $desk = $this->input->post('desk', TRUE);
        $search = $this->input->post('search', TRUE);
        $status = $this->input->post('status', TRUE);
        if ($search = $this->settings_model->search_user($desk, $search, $status))
        {
            $this->_data['pageTitle'] = 'Desk Path';
            $this->_data['search_data'] = $search;
            $this->_data['get_desk'] = $this->settings_model->get_desk1();
            $this->layout->view('admin/users/search_user', $this->_data);
        } else
        {
            $this->session->set_flashdata('exception', '<div class= msg-error>No Data Found</div>');
            redirect('admin/settings/user_list');
        }
    }

    public function search_status($status = 0)
    {

        if ($this->input->post('search', TRUE) != "")
        {
            $status = $this->input->post('search', TRUE);
        }
        $this->load->library('pagination');
        $config['base_url'] = site_url("admin/settings/search_status/$status/");
        $config['total_rows'] = $this->settings_model->search_status($status, 0, 0)->num_rows();
        $config['per_page'] = $this->config->item('SETTINGS_PAGING_LIMIT');
        $config['uri_segment'] = '5';
        $this->pagination->initialize($config);
        $this->_data['search_data'] = $this->settings_model->search_status($status, $config['per_page'], $this->uri->segment(5, 0))->result_array();
        $this->_data['paginet'] = $this->pagination->create_links();
        $this->_data['pageTitle'] = 'Status';
        $this->layout->view('admin/users/search_status', $this->_data);
        if ($config['total_rows'] <= 0)
        {
            $this->session->set_flashdata('exception', '<div class= msg-error>No Data Found</div>');
            redirect('admin/settings/complaint_status');
        }
    }

    public function add_user()
    {
        $this->_data['pageTitle'] = 'User Account';
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->layout->view('admin/users/add_user', $this->_data);
    }
	
	public function add_information()
    {
        $this->_data['pageTitle'] = 'Sanitation || Hackathon';
        $this->_data['get_district'] = $this->settings_model->get_district();
        $this->layout->view('admin/users/add_user', $this->_data);
    }


    public function role_previlizes()
    {
        $this->_data['pageTitle'] = 'Role Privileges';
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->_data['search_data'] = "";
        $this->_data['get_role'] = $this->settings_model->get_role();
        $this->layout->view('admin/users/RolePrevilizes', $this->_data);
    }

    public function addRolePrevilizes()
    {
        $this->_data['pageTitle'] = 'Role Privileges';
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->_data['get_role'] = $this->settings_model->get_role();
        $this->layout->view('admin/users/addRolePrevilizes', $this->_data);
    }

    public function searchRolePrevilizes()
    {


        $this->_data['pageTitle'] = 'Role Privileges';
        $this->_data['search_data'] = $this->settings_model->searchRolePrevilizes($this->input->post('desk', TRUE));
        $this->_data['desk'] = $this->input->post('desk', TRUE);
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->_data['get_role'] = $this->settings_model->get_role();
        $this->layout->view('admin/users/RolePrevilizes', $this->_data);
    }

    public function searchRolePrevilizes2($desk)
    {
        $this->_data['pageTitle'] = 'Role Privileges';
        $this->_data['search_data'] = $this->settings_model->searchRolePrevilizes($desk);
        $this->_data['desk'] = $desk;
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->_data['get_role'] = $this->settings_model->get_role();
        $this->layout->view('admin/users/RolePrevilizes', $this->_data);
    }

    public function submitAddRolePrevilizes()
    {

        $this->form_validation->set_rules('desk', 'Desk', 'required|trim|xss_clean');
        $this->form_validation->set_rules('role[]', 'Role', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('exception', '<div class=msg-error>At least one check is required</div>');
            redirect('admin/settings/searchRolePrevilizes2/' . $this->input->post('desk', TRUE));
        } else
        {
            $desk = $this->input->post('desk', TRUE);
            $role = $this->input->post('role', TRUE);
            $this->addEditRolePrevilizer($desk, $role);
            $this->session->set_flashdata('exception', '<div class= msg-success>Data has been inserted successfully</div>');
            redirect('admin/settings/searchRolePrevilizes2/' . $desk);
        }
    }

    function addEditRolePrevilizer($desk, $role)
    {
        $this->db->where('intDeskID', $desk);
        $this->db->delete('role_previlizes');

        foreach ($role as $key => $values)
        {
            if ($values)
            {
                $data = array(
                    'intDeskID' => $desk,
                    'intRoleID' => $values
                );
                $this->db->insert('role_previlizes', $data);
            }
        }
    }

    public function add_reason_remarks()
    {
        $this->_data['pageTitle'] = 'Status Reason';
        $this->_data['get_status'] = $this->settings_model->get_status();
        $this->layout->view('admin/users/addNewReasonRemarks', $this->_data);
    }

    public function addnewstatus()
    {
        $this->_data['pageTitle'] = 'Status';
        $this->layout->view('admin/users/addNewStatus', $this->_data);
    }

    public function delete_user($id)
    {
        if ($this->settings_model->delete_user($id))
        {
            $this->session->set_flashdata('exception', '<div class= msg-success>Data Deleted Successfully</div>');
            redirect('admin/settings/user_list');
        } else
        {
            $this->session->set_flashdata('exception', '<div class= msg-error>Data Not Deleted</div>');
            redirect('admin/settings/user_list');
        }
    }

    public function delete_status_path($present_status_id, $present_desk_id, $next_status_id)
    {
        if ($this->settings_model->delete_status_path($present_status_id, $present_desk_id, $next_status_id))
        {
            $this->session->set_flashdata('exception1', '<div class= msg-success>Data Deleted Successfully</div>');
            redirect('admin/settings/status_path');
        } else
        {
            $this->session->set_flashdata('exception1', '<div class=msg-error>Data Not Deleted</div>');
            redirect('admin/settings/status_path');
        }
    }

    public function delete_desk_path($status_id, $present_desk_id, $next_desk_id)
    {
        if ($this->settings_model->delete_desk_path($status_id, $present_desk_id, $next_desk_id))
        {
            $this->session->set_flashdata('exception1', '<div class= msg-success>Data Deleted Successfully</div>');
            redirect('admin/settings/desk_path');
        } else
        {
            $this->session->set_flashdata('exception1', '<div class= msg-error>Data Not Deleted</div>');
            redirect('admin/settings/desk_path');
        }
    }

    public function delete_desk($id)
    {
        if ($this->settings_model->delete_desk($id))
        {
            $this->session->set_flashdata('exception', '<div class= msg-success>Data Deleted Successfully</div>');
            redirect('admin/settings/add_desk');
        } else
        {
            $this->session->set_flashdata('exception', '<div class= msg-error>Data Not Deleted</div>');
            redirect('admin/settings/add_desk');
        }
    }

    public function delete_besic_data($id)
    {

        if ($this->settings_model->delete_besic_data($id))
        {
            return true;
            //$this->session->set_flashdata('exception', '<div class= msg-success>Data Deleted Successfully</div>');
//            redirect('admin/settings/search_besic_data/'.$category);
        } else
        {
//            $this->session->set_flashdata('exception', '<div class= msg-error>Data Not Deleted</div>');
//            redirect('admin/settings/search_besic_data/'.$category);
        }
    }

    public function delete_district($id)
    {
        if ($this->settings_model->delete_district($id))
        {
            return true;
//            $this->session->set_flashdata('exception', '<div class= msg-success>Data Deleted Successfully</div>');
//            redirect('admin/settings/add_district');
        } else
        {
            return false;
//            $this->session->set_flashdata('exception', "<div class= msg-error>You Can't Delete The Data</div>");
//            redirect('admin/settings/add_district');
        }
    }

    public function delete_sub_district($id)
    {
        if ($this->settings_model->delete_sub_district($id))
        {
            return true;
        } else
        {
            return false;
        }
    }

    public function delete_status($id)
    {
        if ($this->settings_model->delete_status($id))
        {
            return true;
        } else
        {
            return true;
        }
    }

    public function delete_reason_remarks($id)
    {
        if ($this->settings_model->delete_reason_remarks($id))
        {
            $this->session->set_flashdata('exception', '<div class= msg-success>Data Deleted Successfully</div>');
            redirect('admin/settings/reason_remarks');
        } else
        {
            $this->session->set_flashdata('exception', "<div class= msg-error>You Can't Delete The Data</div>");
            redirect('admin/settings/reason_remarks');
        }
    }

    public function edit_user($id)
    {
        $this->_data['pageTitle'] = 'User Account';
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->_data['get_single_user'] = $this->settings_model->get_single_user($id);
        $this->layout->view('admin/users/edit_user', $this->_data);
    }

    public function search_status_path($present_status_id = 0, $present_desk_id = 0)
    {
        if ($this->input->post('present_status_search', TRUE) != "")
        {
            $present_status_id = $this->input->post('present_status_search');
        }
        if ($this->input->post('present_desk_search', TRUE) != "")
        {
            $present_desk_id = $this->input->post('present_desk_search');
        }
        $this->load->library('pagination');
        $config['base_url'] = site_url("admin/settings/search_status_path/$present_status_id/$present_desk_id/");
        $config['total_rows'] = $this->settings_model->search_status_path($present_status_id, $present_desk_id, 0, 0)->num_rows();
        $config['per_page'] = $this->config->item('SETTINGS_PAGING_LIMIT');
        $config['uri_segment'] = '6';
        $this->pagination->initialize($config);
        $this->_data['search_data'] = $this->settings_model->search_status_path($present_status_id, $present_desk_id, $config['per_page'], $this->uri->segment(6, 0))->result_array();
        $this->_data['paginet'] = $this->pagination->create_links();
        $this->_data['pageTitle'] = 'Status Path';
        $this->_data['get_status'] = $this->settings_model->get_status();
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->layout->view('admin/users/search_status_path', $this->_data);
        if ($config['total_rows'] <= 0)
        {
            $this->session->set_flashdata('exception1', '<div class=msg-error>No Data Found</div>');
            redirect('admin/settings/status_path');
        }
    }

    public function search_reason_remarks($status_id = 0, $reason_remarks = "search")
    {
        if ($this->input->post('reason_status', TRUE) != "")
        {
            $status_id = $this->input->post('reason_status', TRUE);
        }
        if ($this->input->post('reason', TRUE) != "")
        {
            $reason_remarks = $this->input->post('reason', TRUE);
        }
        $this->load->library('pagination');
        $config['base_url'] = site_url("admin/settings/search_reason_remarks/$status_id/$reason_remarks");
        $config['total_rows'] = $this->settings_model->search_reason_remarks($status_id, $reason_remarks, 0, 0)->num_rows();
        $config['per_page'] = $this->config->item('SETTINGS_PAGING_LIMIT');
        $config['uri_segment'] = '6';
        $this->pagination->initialize($config);
        $this->_data['search_data'] = $this->settings_model->search_reason_remarks($status_id, $reason_remarks, $config['per_page'], $this->uri->segment(6, 0))->result_array();
        $this->_data['paginet'] = $this->pagination->create_links();
        $this->_data['pageTitle'] = 'Search Status Reason';
        $this->_data['get_status'] = $this->settings_model->get_status();
        $this->layout->view('admin/users/SearchReasonRemarks', $this->_data);
        if ($config['total_rows'] <= 0)
        {
            $this->session->set_flashdata('exception', '<div class= msg-error>No Data Found</div>');
            redirect('admin/settings/reason_remarks');
        }
    }

    public function searchDistrict($district = 0)
    {
        if ($this->input->post('district_name', TRUE) != "")
        {
            $district = $this->input->post('district_name', TRUE);
        }
        $this->load->library('pagination');
        $config['base_url'] = site_url("admin/settings/searchDistrict/$district/");
        $config['total_rows'] = $this->settings_model->searchDistrict($district, 0, 0)->num_rows();
        $config['per_page'] = $this->config->item('SETTINGS_PAGING_LIMIT');
        $config['uri_segment'] = '5';
        $this->pagination->initialize($config);
        $this->_data['get_district'] = $this->settings_model->searchDistrict($district, $config['per_page'], $this->uri->segment(5, 0))->result_array();
        $this->_data['paginet'] = $this->pagination->create_links();
        $this->_data['data'] = 1;
        $this->_data['pageTitle'] = 'District/Zilla';
        $this->layout->view('admin/users/add_district', $this->_data);
        if ($config['total_rows'] <= 0)
        {
            $this->session->set_flashdata('exception', '<div class=msg-error>No Data Found</div>');
            redirect('admin/settings/add_district');
        }
    }

    public function search_desk_path($present_status_id = 0, $present_desk_id = 0)
    {
        if ($this->input->post('present_status_search', TRUE) != "")
        {
            $present_status_id = $this->input->post('present_status_search');
        }
        if ($this->input->post('present_desk_search', TRUE) != "")
        {
            $present_desk_id = $this->input->post('present_desk_search');
        }
        $this->load->library('pagination');
        $config['base_url'] = site_url("admin/settings/search_desk_path/$present_status_id/$present_desk_id");
        $config['total_rows'] = $this->settings_model->search_desk_path($present_status_id, $present_desk_id, 0, 0)->num_rows();
        $config['per_page'] = $this->config->item('SETTINGS_PAGING_LIMIT');
        $config['uri_segment'] = '6';
        $this->pagination->initialize($config);
        $this->_data['search_data'] = $this->settings_model->search_desk_path($present_status_id, $present_desk_id, $config['per_page'], $this->uri->segment(6, 0))->result_array();
        $this->_data['paginet'] = $this->pagination->create_links();
        $this->_data['pageTitle'] = 'Desk Path';
        $this->_data['get_status'] = $this->settings_model->get_status();
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->layout->view('admin/users/search_desk_path', $this->_data);
        if ($config['total_rows'] <= 0)
        {
            $this->session->set_flashdata('exception1', '<div class=msg-error>No Data Found</div>');
            redirect('admin/settings/desk_path');
        }
    }

    public function add_district()
    {

        $this->_data['data'] = "";
        $this->_data['pageTitle'] = 'District/Zilla';
        $this->layout->view('admin/users/add_district', $this->_data);
    }

    public function submit_district()
    {

        $this->form_validation->set_rules('district_name', 'District Name', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            $this->addNewDistrict();
        } else
        {
            $data = array();
            $data['district_name'] = $this->input->post('district_name');
            $data['varInsertUser'] = $this->session->userdata('sess_nhrc_user_id');
            $data['dtInsertDT'] = date('Y-m-d h:i:s');
            if ($this->settings_model->submit_district($data))
            {
                $this->session->set_flashdata('exception', '<div class= msg-success>Data has been inserted successfully</div>');
                redirect('admin/settings/addNewDistrict');
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/addNewDistrict');
            }
        }
    }

    public function add_sub_district()
    {
        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/settings/add_sub_district/');
        $config['total_rows'] = $this->settings_model->get_sub_district_list(0, 0)->num_rows();
        $config['per_page'] = $this->config->item('SETTINGS_PAGING_LIMIT');
        $config['uri_segment'] = '4';
        $this->pagination->initialize($config);
        $this->_data['sub_distict'] = $this->settings_model->get_sub_district_list($config['per_page'], $this->uri->segment(4, 0))->result_array();
        $this->_data['paginet'] = $this->pagination->create_links();
        $this->_data['pageTitle'] = 'Upazilla/Thana';
        $this->_data['get_district'] = $this->settings_model->get_district();
        $this->layout->view('admin/users/add_sub_district', $this->_data);
    }

    public function add_new_sub_district()
    {
        $this->_data['pageTitle'] = 'Upazilla/Thana';
        $this->_data['get_district'] = $this->settings_model->get_district();
        $this->layout->view('admin/users/add_new_sub_district', $this->_data);
    }

    public function add_desk()
    {
        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/settings/add_desk/');
        $config['total_rows'] = $this->settings_model->get_desk(0, 0)->num_rows();
        $config['per_page'] = $this->config->item('SETTINGS_PAGING_LIMIT');
        $config['uri_segment'] = '4';
        $this->pagination->initialize($config);
        $this->_data['get_desk'] = $this->settings_model->get_desk($config['per_page'], $this->uri->segment(4, 0))->result_array();
        $this->_data['paginet'] = $this->pagination->create_links();
        $this->_data['pageTitle'] = 'Desk';
        $this->layout->view('admin/users/add_desk', $this->_data);
    }

    public function complaint_status()
    {
        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/settings/complaint_status/');
        $config['total_rows'] = $this->settings_model->get_status1(0, 0)->num_rows();
        $config['per_page'] = $this->config->item('SETTINGS_PAGING_LIMIT');
        $config['uri_segment'] = '4';
        $this->pagination->initialize($config);
        $this->_data['get_status'] = $this->settings_model->get_status1($config['per_page'], $this->uri->segment(4, 0))->result_array();
        $this->_data['paginet'] = $this->pagination->create_links();
        $this->_data['pageTitle'] = 'Status';
        $this->layout->view('admin/users/complaint_status', $this->_data);
    }

    public function reason_remarks()
    {
//        $this->load->library('pagination');
//        $config['base_url'] = site_url('admin/settings/reason_remarks/');
//        $config['total_rows'] = $this->settings_model->reason_remarks(0, 0)->num_rows();
//        $config['per_page'] = $this->config->item('SETTINGS_PAGING_LIMIT');
//        $config['uri_segment'] = '4';
//        $this->pagination->initialize($config);
//        $this->_data['reason_remarks'] = $this->settings_model->reason_remarks($config['per_page'], $this->uri->segment(4, 0))->result_array();
//        $this->_data['paginet'] = $this->pagination->create_links();
        $this->_data['pageTitle'] = 'Status Reason';
        $this->_data['get_status'] = $this->settings_model->get_status();
        $this->layout->view('admin/users/add_reason_remarks', $this->_data);
    }

    public function submit_sub_district()
    {

        $this->form_validation->set_rules('district', 'District', 'required');
        $this->form_validation->set_rules('sub_district_name', 'Sub District', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            $this->add_new_sub_district();
        } else
        {
            $data = array();
            $data['district_id'] = $this->input->post('district');
            $data['sub_district_name'] = $this->input->post('sub_district_name');
            $data['varInsertUser'] = $this->session->userdata('sess_nhrc_user_id');
            $data['dtInsertDT'] = date('Y-m-d h:i:s');
            if ($this->settings_model->submit_sub_district($data))
            {
                $this->session->set_flashdata('exception', '<div class= msg-success>Data has been inserted successfully</div>');
                redirect('admin/settings/add_new_sub_district');
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/add_new_sub_district');
            }
        }
    }

    public function submit_new_desk()
    {

        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('desk_name', 'Deks Name', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            $this->add_desk();
        } else
        {
            $data = array();
            $data['name'] = $this->input->post('desk_name');
            $data['status'] = $this->input->post('status');
            $data['varInsertUser'] = $this->session->userdata('sess_nhrc_user_id');
            $data['dtInsertDT'] = date('Y-m-d h:i:s');
            if ($this->settings_model->submit_new_desk($data))
            {

                $this->session->set_flashdata('exception', '<div class= msg-success>Data has been inserted successfully</div>');
                redirect('admin/settings/add_desk');
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/add_desk');
            }
        }
    }

    public function setup_besic_data()
    {
        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/settings/setup_besic_data/');
        $config['total_rows'] = count($this->settings_model->get_all_besic_data(0, 0));
        $config['per_page'] = $this->config->item('SETTINGS_PAGING_LIMIT');
        $config['uri_segment'] = '4';
        $this->pagination->initialize($config);
        $this->_data['get_all'] = $this->settings_model->get_all_besic_data($config['per_page'], $this->uri->segment(4, 0));
        $this->_data['paginet'] = $this->pagination->create_links();
        $this->_data['get_besic_data'] = $this->settings_model->get_besic_data();
        $this->_data['pageTitle'] = 'Basic Data';
        $this->layout->view('admin/users/setup_besic_data', $this->_data);
    }

    public function add_sub_category()
    {
        $this->_data['pageTitle'] = 'Basic Data';
        $this->_data['get_besic_data'] = $this->settings_model->get_besic_data();
        $this->layout->view('admin/users/add_sub_category', $this->_data);
    }

    public function search_besic_data($data = 0)
    {

        if ($this->input->post('category', TRUE) != "")
        {
            $data = $this->input->post('category');
        }
        $this->load->library('pagination');
        $config['base_url'] = site_url("admin/settings/search_besic_data/$data/");
        $config['total_rows'] = $this->settings_model->search_besic_data($data, 0, 0)->num_rows();
        $config['per_page'] = $this->config->item('SETTINGS_PAGING_LIMIT');
        $config['uri_segment'] = '5';
        $this->pagination->initialize($config);
        $this->_data['search_data'] = $this->settings_model->search_besic_data($data, $config['per_page'], $this->uri->segment(5, 0))->result_array();
        $this->_data['paginet'] = $this->pagination->create_links();
        $this->_data['pageTitle'] = 'Basic Data';
        $this->_data['get_besic_data'] = $this->settings_model->get_besic_data();
        $this->layout->view('admin/users/search_besic_data', $this->_data);
        if ($config['total_rows'] <= 0)
        {
            $this->session->set_flashdata('exception', '<div class= msg-error>No Data Found<div>');
            redirect('admin/settings/setup_besic_data');
        }
    }

    public function search_sub_district($district = 0)
    {
        if ($this->input->post('district', TRUE) != "")
        {
            $district = $this->input->post('district', TRUE);
        }


        $this->load->library('pagination');
        $config['base_url'] = site_url("admin/settings/search_sub_district/$district/");
        $config['total_rows'] = $this->settings_model->search_sub_district($district, 0, 0)->num_rows();
        $config['per_page'] = $this->config->item('SETTINGS_PAGING_LIMIT');
        $config['uri_segment'] = '5';
        $this->pagination->initialize($config);
        $this->_data['search_data'] = $this->settings_model->search_sub_district($district, $config['per_page'], $this->uri->segment(5, 0))->result_array();
        $this->_data['paginet'] = $this->pagination->create_links();
        $this->_data['pageTitle'] = 'Upazilla/Thana';
        $this->_data['get_district'] = $this->settings_model->get_district();
        $this->layout->view('admin/users/search_sub_district', $this->_data);
        if ($config['total_rows'] <= 0)
        {
            $this->session->set_flashdata('exception', '<div class= msg-error>No Data Found</div>');
            redirect('admin/settings/add_sub_district');
        }
    }

    public function submit_setup_besic_data()
    {

        $this->form_validation->set_rules('category', 'Category', 'required|trim|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $this->setup_besic_data();
        } else
        {
            $data = array();
            $data['varCategoryName'] = $this->input->post('category');
            $data['varInsertUser'] = $this->session->userdata('sess_nhrc_user_id');
            $data['dtInsertDT'] = date('Y-m-d h:i:s');

            if ($this->settings_model->submit_setup_besic_data($data))
            {

                $this->session->set_flashdata('exception1', '<div class= msg-success>Data has been inserted successfully</div>');
                redirect('admin/settings/add_category');
            } else
            {
                $this->session->set_flashdata('exception1', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/add_category');
            }
        }
    }

    public function submit_setup_besic_sub_data()
    {

        $this->form_validation->set_rules('dropdown_category', 'Category', 'required|trim|xss_clean');
        $this->form_validation->set_rules('sub_category', 'Sub Category', 'required|trim|xss_clean');
        $this->form_validation->set_rules('short_order', 'Sort Order', 'trim|xss_clean|max_length[9]|integer');
        if ($this->form_validation->run() == FALSE)
        {
            $this->add_sub_category();
        } else
        {
            $data = array();
            $data['intBasicCategoryId'] = $this->input->post('dropdown_category');
            $data['varName'] = $this->input->post('sub_category');
            $data['enuStatus'] = $this->input->post('enustatus');
            $data['sortOrder'] = $this->input->post('short_order');
            $data['varInsertUser'] = $this->session->userdata('sess_nhrc_user_id');
            $data['dtInsertDT'] = date('Y-m-d h:i:s');

            if ($this->settings_model->submit_setup_besic_sub_data($data))
            {

                $this->session->set_flashdata('exception', '<div class= msg-success>Data has been inserted successfully</div>');
                redirect('admin/settings/add_sub_category');
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/add_sub_category');
            }
        }
    }

    public function submit_edit_setup_besic_sub_data()
    {

        $this->form_validation->set_rules('dropdown_category', 'Category', 'required|trim|xss_clean');
        $this->form_validation->set_rules('sub_category', 'Sub Category', 'required|trim|xss_clean');
        $this->form_validation->set_rules('short_order', 'Sort Order', 'trim|xss_clean|max_length[9]|integer');
        if ($this->form_validation->run() == FALSE)
        {
            $this->edit_besic_data($this->input->post('id'));
        } else
        {
            $data = array();
            $data['intBasicCategoryId'] = $this->input->post('dropdown_category');
            $data['varName'] = $this->input->post('sub_category');
            $data['enuStatus'] = $this->input->post('enustatus');
            $data['sortOrder'] = $this->input->post('short_order');
            $data['id'] = $this->input->post('id');
            $data['varEditUser'] = $this->session->userdata('sess_nhrc_user_id');
            $data['dtInsertDT'] = date('Y-m-d h:i:s');

            if ($this->settings_model->submit_edit_setup_besic_sub_data($data))
            {

                $this->session->set_flashdata('exception', '<div class= msg-success>Data has been updated successfully</div>');
                redirect('admin/settings/edit_besic_data/' . $_POST['id']);
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/edit_besic_data/' . $_POST['id']);
            }
        }
    }

    public function submit_add_status()
    {

        $this->form_validation->set_rules('status', 'Status', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            $this->complaint_status();
        } else
        {
            $data = array();
            $data['name'] = $this->input->post('status');
            $data['mode'] = $this->input->post('mode');
            $data['status'] = $this->input->post('enmstatus');
            $data['varInsertUser'] = $this->session->userdata('sess_nhrc_user_id');
            $data['dtInsertDT'] = date('Y-m-d h:i:s');
            if ($this->settings_model->submit_add_status($data))
            {
                $this->session->set_flashdata('exception', '<div class= msg-success>Data has been inserted successfully</div>');
                redirect('admin/settings/addnewstatus');
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/addnewstatus');
            }
        }
    }

    public function submit_reason_remarks()
    {

        $this->form_validation->set_rules('reason_status', 'Status', 'required|trim|xss_clean');
        $this->form_validation->set_rules('reason', 'Reason', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->add_reason_remarks();
        } else
        {
            $data = array();
            $data['name'] = $this->input->post('reason');
            $data['is_value'] = $this->input->post('is_value');
            $data['status_id'] = $this->input->post('reason_status');
            $data['varInsertUser'] = $this->session->userdata('sess_nhrc_user_id');
            $data['dtInsertDT'] = date('Y-m-d h:i:s');
            if ($this->settings_model->submit_reason_remarks($data))
            {
                $this->session->set_flashdata('exception', '<div class= msg-success>Data has been inserted successfully</div>');
                redirect('admin/settings/add_reason_remarks');
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/add_reason_remarks');
            }
        }
    }

    public function submit_edit_reason_remarks()
    {

        $this->form_validation->set_rules('reason_status', 'Status', 'required|trim|xss_clean');
        $this->form_validation->set_rules('reason', 'Reason Remarks', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->edit_reason_remarks($_POST['reason_remarks_id']);
        } else
        {
            $data = array();
            $data['name'] = $this->input->post('reason');
            $data['is_value'] = $this->input->post('is_value');
            $data['status_id'] = $this->input->post('reason_status');
            $data['reason_remarks_id'] = $this->input->post('reason_remarks_id');
            $data['varEditUser'] = $this->session->userdata('sess_nhrc_user_id');

            if ($this->settings_model->submit_edit_reason_remarks($data))
            {

                $this->session->set_flashdata('exception', '<div class= msg-success>Data has been updated successfully</div>');
                redirect('admin/settings/edit_reason_remarks/' . $_POST['reason_remarks_id']);
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/edit_reason_remarks/' . $_POST['reason_remarks_id']);
            }
        }
    }

    public function edit_district($id)
    {

        $this->_data['pageTitle'] = 'Distirct/Zilla';
        $this->_data['edit_district'] = $this->settings_model->edit_district($id);
        $this->layout->view('admin/users/edit_district', $this->_data);
    }

    public function edit_besic_data($id)
    {
        $this->_data['pageTitle'] = 'Basic data';
        $this->_data['edit_besic_data'] = $this->settings_model->edit_besic_data($id);
        $this->_data['get_besic_data'] = $this->settings_model->get_besic_data();
        $this->layout->view('admin/users/edit_besic_data', $this->_data);
    }

    public function edit_desk($id)
    {

        $this->_data['pageTitle'] = 'Desk';
        $this->_data['edit_desk'] = $this->settings_model->edit_desk($id);
        $this->layout->view('admin/users/edit_desk', $this->_data);
    }

    public function edit_sub_district($id)
    {

        $this->_data['pageTitle'] = 'Upazilla/Thana';
        $this->_data['edit_sub_dis'] = $this->settings_model->edit_sub_district($id);
        $this->_data['get_district'] = $this->settings_model->get_district();
        $this->layout->view('admin/users/edit_sub_district', $this->_data);
    }

    public function edit_status($id)
    {


        $this->_data['pageTitle'] = 'Status';
        $this->_data['edit_status'] = $this->settings_model->edit_status($id);
        $this->layout->view('admin/users/edit_status', $this->_data);
    }

    public function edit_reason_remarks($id)
    {


        $this->_data['pageTitle'] = 'Status Reason';
        $this->_data['get_status'] = $this->settings_model->get_status();
        $this->_data['edit_reason'] = $this->settings_model->edit_reason_remarks($id);
        $this->layout->view('admin/users/edit_reason_remarks', $this->_data);
    }

    public function submit_edit_district()
    {

        $this->form_validation->set_rules('district_name', 'District Name', 'required|xss_clean|trim');
        if ($this->form_validation->run() == FALSE)
        {
            $this->edit_district($_POST['district_id']);
        } else
        {

            $data = array();
            $data['district_name'] = $this->input->post('district_name', true);
            $data['district_id'] = $this->input->post('district_id', true);
            $data['varEditUser'] = $this->session->userdata('sess_nhrc_user_id');
            if ($this->settings_model->submit_edit_district($data))
            {
                $this->session->set_flashdata('exception', '<div class= msg-success>Data has been updated successfully</div>');
                redirect('admin/settings/edit_district/' . $_POST['district_id']);
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/edit_district/' . $_POST['district_id']);
            }
        }
    }

    public function submit_edit_desk()
    {
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('desk_name', 'Desk Name', 'required|trim|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $this->edit_desk($_POST['desk_id']);
        } else
        {
            $data = array();
            $data['name'] = $this->input->post('desk_name');
            $data['status'] = $this->input->post('status');
            $data['varEditUser'] = $this->session->userdata('sess_nhrc_user_id');
            $data['desk_id'] = $this->input->post('desk_id');
            if ($this->settings_model->submit_edit_desk($data))
            {
                $this->session->set_flashdata('exception', '<div class=msg-success 
>Data has been updated successfully</div>');
                redirect('admin/settings/edit_desk/' . $_POST['desk_id']);
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/edit_desk/' . $_POST['desk_id']);
            }
        }
    }

    public function submit_edit_sub_district()
    {

        $this->form_validation->set_rules('district', 'District Name', 'required');
        $this->form_validation->set_rules('sub_district_name', 'Sub District Name', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            $this->edit_sub_district($_POST['sub_district_id']);
        } else
        {
            $data = array();
            $data['sub_district_name'] = $this->input->post('sub_district_name');
            $data['district_id'] = $this->input->post('district');
            $data['varEditUser'] = $this->session->userdata('sess_nhrc_user_id');
            $data['sub_district_id'] = $this->input->post('sub_district_id');
            if ($this->settings_model->submit_edit_sub_district($data))
            {
                $this->session->set_flashdata('exception', '<div class=msg-success>Data has been updated successfully</div>');
                redirect('admin/settings/edit_sub_district/' . $_POST['sub_district_id']);
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/edit_sub_district/' . $_POST['sub_district_id']);
            }
        }
    }

    public function submit_edit_status()
    {
        $this->form_validation->set_rules('name', 'Status Name', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            $this->edit_status($_POST['status_id']);
        } else
        {

            $data = array();
            $data['status_id'] = $this->input->post('status_id', true);
            $data['name'] = $this->input->post('name', true);
            $data['mode'] = $this->input->post('mode', true);
            $data['status'] = $this->input->post('enmstatus', true);
            $data['varEditUser'] = $this->session->userdata('sess_nhrc_user_id');
            if ($this->settings_model->submit_edit_status($data))
            {

                $this->session->set_flashdata('exception', '<div class=msg-success>Data has been updated successfully</div>');
                redirect('admin/settings/edit_status/' . $_POST['status_id']);
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/edit_status/' . $_POST['status_id']);
            }
        }
    }

    public function desk_path()
    {
        $this->_data['pageTitle'] = 'Desk Path';
        $this->_data['get_status'] = $this->settings_model->get_status();
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->layout->view('admin/users/add_desk_path', $this->_data);
    }

    public function add_desk_path()
    {
        $this->_data['pageTitle'] = 'Desk Path';
        $this->_data['searchPage'] = 0;
        $this->_data['get_status'] = $this->settings_model->get_status();
        $this->_data['get_desk'] = $this->settings_model->get_desk1();


        $this->layout->view('admin/users/submit_desk_path', $this->_data);
    }

    public function search_desk_path_for_add()
    {
        $this->form_validation->set_rules('present_status', 'Present Status', 'required|trim|xss_clean');
        $this->form_validation->set_rules('present_desk', 'present Desk', 'required|trim|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $this->add_desk_path();
        } else
        {
            $present_desk = $this->input->post('present_desk', TRUE);
            $present_status = $this->input->post('present_status', TRUE);
            $this->_data['searchPage'] = 1;
            $this->_data['edit'] = 0;
            $searchData = $this->settings_model->searchDeskPathForAdd($present_status, $present_desk);

            $saveDesk = array();
            $saveSort = array();
            //$searchData = array();
            foreach ($searchData as $key => $value)
            {
                $saveDesk[] = $value['next_desk_id'];
                $saveSort[$value['next_desk_id']] = $value['sort_order'];
            }
            $this->_data['saveDesk'] = $saveDesk;
            $this->_data['saveSort'] = $saveSort;

            $this->_data['pageTitle'] = 'Desk Path';
            $this->_data['a'] = $present_desk;
            $this->_data['b'] = $present_status;
            $this->_data['searchData'] = $searchData;
            $this->_data['get_status'] = $this->settings_model->get_status();
            $this->_data['get_desk'] = $this->settings_model->get_desk1();
            $this->layout->view('admin/users/submit_desk_path', $this->_data);
        }
    }

    public function search_status_path_for_add()
    {
        $this->form_validation->set_rules('present_status', 'Present Status', 'required|trim|xss_clean');
        $this->form_validation->set_rules('present_desk', 'present Desk', 'required|trim|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $this->add_desk_path();
        } else
        {
            $present_status = $this->input->post('present_status', TRUE);
            $present_desk = $this->input->post('present_desk', TRUE);
            $searchData = $this->settings_model->searchStatusPathForAdd($present_status, $present_desk);
            $this->_data['search'] = 1;
            $this->_data['edit'] = 0;
            $this->_data['pageTitle'] = 'Status Path';
            $this->_data['a'] = $present_desk;
            $this->_data['b'] = $present_status;
            $this->_data['searchData'] = $searchData;
            $this->_data['get_status'] = $this->settings_model->get_status();
            $this->_data['get_desk'] = $this->settings_model->get_desk1();
            $this->layout->view('admin/users/submit_status_path', $this->_data);
        }
    }

    public function searchStatusPathForAdd($present_status, $present_desk)
    {
        $searchData = $this->settings_model->searchStatusPathForAdd($present_status, $present_desk);
        $this->_data['search'] = 1;
        $this->_data['edit'] = 0;
        $this->_data['pageTitle'] = 'Status Path';
        $this->_data['a'] = $present_desk;
        $this->_data['b'] = $present_status;
        $this->_data['searchData'] = $searchData;
        $this->_data['get_status'] = $this->settings_model->get_status();
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->layout->view('admin/users/submit_status_path', $this->_data);
    }

    public function searchStatusPathForEdit($present_status, $present_desk)
    {
        $searchData = $this->settings_model->searchStatusPathForAdd($present_status, $present_desk);
        $this->_data['search'] = 1;
        $this->_data['pageTitle'] = 'Status Path';
        $this->_data['edit'] = 1;
        $this->_data['a'] = $present_desk;
        $this->_data['b'] = $present_status;
        $this->_data['searchData'] = $searchData;
        $this->_data['get_status'] = $this->settings_model->get_status();
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->layout->view('admin/users/submit_status_path', $this->_data);
    }

    public function searchDeskPathForAdd($present_status, $present_desk)
    {
        $searchData = $this->settings_model->searchDeskPathForAdd($present_status, $present_desk);
      
        $saveDesk = array();
        $saveSort = array();
        foreach ($searchData as $key => $value)
        {
            $saveDesk[] = $value['next_desk_id'];
            $saveSort[$value['next_desk_id']] = $value['sort_order'];
        }
        $this->_data['saveDesk'] = $saveDesk;
        $this->_data['saveSort'] = $saveSort;
        $this->_data['pageTitle'] = 'Desk Path';
        $this->_data['searchPage'] = 1;
        $this->_data['edit'] = 0;
        $this->_data['a'] = $present_desk;
        $this->_data['b'] = $present_status;
        $this->_data['searchData'] = $searchData;
        $this->_data['get_status'] = $this->settings_model->get_status();
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->layout->view('admin/users/submit_desk_path', $this->_data);
    }

    public function searchDeskPathForEdit($present_status, $present_desk)
    {
        $searchData = $this->settings_model->searchDeskPathForAdd($present_status, $present_desk);
          
        $saveDesk = array();
        $saveSort = array();
        //$searchData = array();
        foreach ($searchData as $key => $value)
        {
            $saveDesk[] = $value['next_desk_id'];
            $saveSort[$value['next_desk_id']] = $value['sort_order'];
        }        
        $this->_data['saveDesk'] = $saveDesk;
        $this->_data['saveSort'] = $saveSort;
        $this->_data['pageTitle'] = 'Desk Path';
        $this->_data['searchPage'] = 1;
        $this->_data['edit'] = 1;
        $this->_data['a'] = $present_desk;
        $this->_data['b'] = $present_status;
        $this->_data['searchData'] = $searchData;
        $this->_data['get_status'] = $this->settings_model->get_status();
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->layout->view('admin/users/submit_desk_path', $this->_data);
    }

    public function status_path()
    {
        $this->_data['pageTitle'] = 'Status Path';
        $this->_data['get_status'] = $this->settings_model->get_status();
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->layout->view('admin/users/add_status_path', $this->_data);
    }

    public function add_status_path()
    {
        $this->_data['pageTitle'] = 'Status Path';
        $this->_data['search'] = 0;
        $this->_data['get_status'] = $this->settings_model->get_status();
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->layout->view('admin/users/submit_status_path', $this->_data);
    }

    public function submit_status_path()
    {
        $this->form_validation->set_rules('present_status', 'Present Status', 'required|trim|xss_clean');
        $this->form_validation->set_rules('present_desk', 'present Desk', 'required|trim|xss_clean');
        $this->form_validation->set_rules('next_status[]', 'Next Status', 'required|trim|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('exception', '<div class=msg-error>At least one check is required</div>');
            redirect('admin/settings/searchStatusPathForAdd/' . $this->input->post('present_status', TRUE) . '/' . $this->input->post('present_desk', TRUE));
        } else
        {
            $present_status = $this->input->post('present_status', TRUE);
            $present_desk = $this->input->post('present_desk', TRUE);
            $next_status = $this->input->post('next_status');
            // del 1st
            $this->db->where('present_status_id', $present_status);
            $this->db->where('present_desk_id', $present_desk);
            $this->db->delete('status_path');


            foreach ($next_status as $values)
            {
                if ($values)
                {
                    $data = array(
                        'present_status_id' => $present_status,
                        'present_desk_id' => $present_desk,
                        'next_status_id' => $values,
                        'varInsertUser' => $this->session->userdata('sess_nhrc_user_id'),
                        'dtInsertDT' => date('Y-m-d h:i:s')
                    );
                    $this->db->insert('status_path', $data);
                }
            }

            $this->session->set_flashdata('exception', '<div class=msg-success>Data has been inserted successfully</div>');
            redirect('admin/settings/searchStatusPathForAdd/' . $present_status . '/' . $present_desk);
        }
    }

    public function update_status_path()
    {

        $this->form_validation->set_rules('present_status', 'Present Status', 'required|trim|xss_clean');
        $this->form_validation->set_rules('present_desk', 'present Desk', 'required|trim|xss_clean');
        $this->form_validation->set_rules('next_status[]', 'Next Status', 'required|trim|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('exception', '<div class=msg-error>At least one check is required</div>');
            redirect('admin/settings/searchStatusPathForEdit/' . $this->input->post('present_status', TRUE) . '/' . $this->input->post('present_desk', TRUE));
        } else
        {
            $present_status = $this->input->post('present_status', TRUE);
            $present_desk = $this->input->post('present_desk', TRUE);
            $next_status = $this->input->post('next_status');
            // del 1st
            $this->db->where('present_status_id', $present_status);
            $this->db->where('present_desk_id', $present_desk);
            $this->db->delete('status_path');


            foreach ($next_status as $values)
            {
                if ($values)
                {
                    $data = array(
                        'present_status_id' => $present_status,
                        'present_desk_id' => $present_desk,
                        'next_status_id' => $values,
                        'varInsertUser' => $this->session->userdata('sess_nhrc_user_id'),
                        'dtInsertDT' => date('Y-m-d h:i:s')
                    );
                    $this->db->insert('status_path', $data);
                }
            }

            $this->session->set_flashdata('exception', '<div class=msg-success>Data has been updated successfully</div>');
            redirect('admin/settings/searchStatusPathForEdit/' . $present_status . '/' . $present_desk);
        }
    }

    public function submit_desk_path()
    {

        $this->form_validation->set_rules('present_status', 'Present Status', 'required|trim|xss_clean');
        $this->form_validation->set_rules('present_desk', 'present Desk', 'required|trim|xss_clean');
        $this->form_validation->set_rules('next_desk[]', 'Next Desk', 'required|trim|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('exception', '<div class=msg-error>At least one check is required</div>');
            redirect('admin/settings/searchDeskPathForAdd/' . $this->input->post('present_status', TRUE) . '/' . $this->input->post('present_desk', TRUE));
        } else
        {
            $present_status = $this->input->post('present_status', TRUE);
            $present_desk = $this->input->post('present_desk', TRUE);
            $next_desk = $this->input->post('next_desk', TRUE);

            $this->db->where('status_id', $present_status);
            $this->db->where('present_desk_id', $present_desk);
            $this->db->delete('desk_path');


            foreach ($next_desk as $key => $values)
            {
                if ($values)
                {
                    $sort_order = "sort_order_" . $values;
                    $sort_order2 = $this->input->post($sort_order, TRUE);

                    $data = array(
                        'status_id' => $present_status,
                        'present_desk_id' => $present_desk,
                        'next_desk_id' => $values,
                        'sort_order' => $sort_order2,
                        'varInsertUser' => $this->session->userdata('sess_nhrc_user_id'),
                        'dtInsertDT' => date('Y-m-d h:i:s'),
                        'varEditUser' => $this->session->userdata('sess_nhrc_user_id')
                    );
                    $this->db->insert('desk_path', $data);
                }
            }
            $this->session->set_flashdata('exception', '<div class=msg-success>Data has been inserted successfully</div>');
            redirect('admin/settings/searchDeskPathForAdd/' . $present_status . '/' . $present_desk);
        }
    }

    public function update_desk_path()
    {

        $this->form_validation->set_rules('present_status', 'Present Status', 'required|trim|xss_clean');
        $this->form_validation->set_rules('present_desk', 'present Desk', 'required|trim|xss_clean');
        $this->form_validation->set_rules('next_desk[]', 'Next Desk', 'required|trim|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {

            $this->session->set_flashdata('exception', '<div class=msg-error>At least one check is required</div>');
            redirect('admin/settings/searchDeskPathForEdit/' . $this->input->post('present_status', TRUE) . '/' . $this->input->post('present_desk', TRUE));
        } else
        {
            $present_status = $this->input->post('present_status', TRUE);
            $present_desk = $this->input->post('present_desk', TRUE);
            $next_desk = $this->input->post('next_desk', TRUE);

            $this->db->where('status_id', $present_status);
            $this->db->where('present_desk_id', $present_desk);
            $this->db->delete('desk_path');


            foreach ($next_desk as $key => $values)
            {
                if ($values)
                {
                    $sort_order = "sort_order_" . $values;
                    $sort_order = $this->input->post($sort_order, TRUE);

                    $data = array(
                        'status_id' => $present_status,
                        'present_desk_id' => $present_desk,
                        'next_desk_id' => $values,
                        'sort_order' => $sort_order,
                        'varInsertUser' => $this->session->userdata('sess_nhrc_user_id'),
                        'dtInsertDT' => date('Y-m-d h:i:s'),
                        'varEditUser' => $this->session->userdata('sess_nhrc_user_id')
                    );
                    $this->db->insert('desk_path', $data);
                }
            }
            $this->session->set_flashdata('exception', '<div class=msg-success>Data has been updated successfully</div>');
            redirect('admin/settings/searchDeskPathForEdit/' . $present_status . '/' . $present_desk);
        }
    }

    public function edit_status_path($a, $b, $c)
    {
        $this->_data['pageTitle'] = 'Status Path';
        $this->_data['a'] = $a;
        $this->_data['b'] = $b;
        $this->_data['c'] = $c;
        $this->_data['get_status'] = $this->settings_model->get_status();
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->layout->view('admin/users/edit_status_path', $this->_data);
    }

    public function edit_desk_path($a, $b, $c)
    {
        $this->_data['pageTitle'] = 'Desk Path';
        $this->_data['a'] = $a;
        $this->_data['b'] = $b;
        $this->_data['c'] = $c;
        $this->_data['get_status'] = $this->settings_model->get_status();
        $this->_data['get_desk'] = $this->settings_model->get_desk1();
        $this->layout->view('admin/users/edit_desk_path', $this->_data);
    }

    public function submit_edit_status_path()
    {


        $this->form_validation->set_rules('next_status', 'Next Status', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            $this->edit_status_path($data['present_status_id'], $data['present_desk_id'], $data['next_status_id']);
        } else
        {

            $data = array();
            $data['next_status_id'] = $this->input->post('next_status', true);
            $data['present_status_id'] = $this->input->post('present_status_id', true);
            $data['present_desk_id'] = $this->input->post('present_desk_id', true);
            $data['varEditUser'] = $this->session->userdata('sess_nhrc_user_id');
            $id = $this->input->post('pre_next_status_id', true);
            if ($this->settings_model->submit_edit_status_path($data, $id))
            {

                $this->session->set_flashdata('exception', '<div class=msg-success>Data has been updated successfully</div>');
                redirect('admin/settings/edit_status_path/' . $data['present_status_id'] . '/' . $data['present_desk_id'] . '/' . $data['next_status_id']);
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/edit_status_path/' . $data['present_status_id'] . '/' . $data['present_desk_id'] . '/' . $data['next_status_id']);
            }
        }
    }

    public function submit_edit_desk_path()
    {


        $this->form_validation->set_rules('next_desk_id', 'Next Desk', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            $this->desk_path();
        } else
        {

            $data = array();
            $data['status_id'] = $this->input->post('status_id', true);
            $data['present_desk_id'] = $this->input->post('present_desk_id', true);
            $data['next_desk_id'] = $this->input->post('next_desk_id', true);
            $data['varEditUser'] = $this->session->userdata('sess_nhrc_user_id');
            $id = $this->input->post('pre_next_desk_id', true);
            if ($this->settings_model->submit_edit_desk_path($data, $id))
            {

                $this->session->set_flashdata('exception', '<div class=msg-success>Data has been updated successfully</div>');
                redirect('admin/settings/edit_desk_path/' . $data['status_id'] . '/' . $data['present_desk_id'] . '/' . $data['next_desk_id']);
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/edit_desk_path/' . $data['status_id'] . '/' . $data['present_desk_id'] . '/' . $data['next_desk_id']);
            }
        }
    }

    public function submit_user_entry()
    {

        $this->form_validation->set_rules('user_name', 'User Name', 'required|trim|xss_clean|min_length[4]');        
        $this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
        $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|xss_clean');
        $this->form_validation->set_rules('desk', 'Desk Name', 'required|trim|xss_clean');
        $this->form_validation->set_error_delimiters('<li class="error">', '</li>');
        if ($this->form_validation->run() == FALSE)
        {
            $this->add_user();
            return;
        } else
        {
            $data = array();
            $data['varUserName'] = $this->input->post('user_name', True);
            $data['enmStatus'] = $this->input->post('enmStatus', True);
            $data['varPassword'] = md5($this->input->post('password', True));
            $data['varFullName'] = $this->input->post('full_name', True);
            $data['varAddress'] = $this->input->post('address', True);
            $data['varMoblie'] = $this->input->post('mobile', True);
            $data['varEmail'] = $this->input->post('email', True);
            $data['varDesignation'] = $this->input->post('designation', True);
            $data['intDeskID'] = $this->input->post('desk', True);
            $data['varDepartment'] = $this->input->post('department', True);
            $data['varInsertUser'] = $this->session->userdata('sess_nhrc_user_id', True);
            $data['dtInsertDT'] = date('Y-m-d h:i:s');
            if ($this->settings_model->submit_user_entry($data))
            {
                $this->session->set_flashdata('exception', '<div class=msg-success>Data has been inserted successfully</div>');
                redirect('admin/settings/add_user');
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/add_user');
            }
        }
    }

    public function submit_edit_user()
    {

        $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|xss_clean');
        $this->form_validation->set_rules('desk', 'Desk Name', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            $this->user_list();
        } else
        {
            $data = array();
            $data['enmStatus'] = $this->input->post('enmStatus', True);
            if ($this->input->post('password', True) != "")
            {
                $data['varPassword'] = md5($this->input->post('password', True));
            }
            $data['varFullName'] = $this->input->post('full_name', True);
            $data['varUserName'] = $this->input->post('varUserName', True);
            $data['varAddress'] = $this->input->post('address', True);
            $data['varMoblie'] = $this->input->post('mobile', True);
            $data['varEmail'] = $this->input->post('email', True);
            $data['varDesignation'] = $this->input->post('designation', True);
            $data['intDeskID'] = $this->input->post('desk', True);
            $data['varDepartment'] = $this->input->post('department', True);
            $data['varEditUser'] = $this->session->userdata('sess_nhrc_user_id', True);
            $data['id'] = $this->input->post('id', True);
            if ($this->settings_model->submit_edit_user($data))
            {
                $this->session->set_flashdata('exception', '<div class=msg-success>Data has been updated successfully</div>');
                redirect('admin/settings/edit_user/' . $data['id']);
            } else
            {
                $this->session->set_flashdata('exception', '<div class= msg-error>Duplicate Entry</div>');
                redirect('admin/settings/edit_user/' . $data['id']);
            }
        }
    }

}
