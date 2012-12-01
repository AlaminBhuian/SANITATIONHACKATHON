<?php

class Online extends MX_Controller
{

    private $_data;

    public function __construct()
    {
        parent::__construct();


        $this->load->model('common_settings_model', 'common');
        $this->load->model('online_model');
        $this->layout->setLayout('online/online_layout');
        //
        //$this->output->enable_profiler(TRUE);        
    }

    public function index()
    {
       $this->load->helper('captcha');
        $vals = array(
            'img_path' => 'assets/captcha/',
            'img_url' => base_url() . 'assets/captcha/',
            'font_path' => './system/fonts/BRLNSR.TTF',
            'img_width' => '200',
            'img_height' => '60',
            'expiration' => 7200
        );
        $captcha = create_captcha($vals);
        $this->_data['captcha'] = $captcha;
        $this->session->set_userdata('captcha', $captcha);
        $this->_data['pageTitle'] = 'Web Complaint';
        $this->_data['get_complaint'] = $this->online_model->get_complain_category();
        $this->_data['get_district'] = $this->online_model->get_district();
        $this->_data['religionList'] = $this->online_model->getBasicData($this->config->item('RELIGION'));
        $this->layout->view('online/newcomplaint_web', $this->_data); 
    }

    public function webcomplaint()
    {
        
    }

    public function _validationWebComplaint()
    {
        $this->form_validation->set_rules('complainant', 'Complainant', 'required');
        $this->form_validation->set_rules('complaint_name', 'Complaint name', 'trim|required|min_length[5]|max_length[25]|xss_clean');
        $this->form_validation->set_rules('complaint_sex', 'Complaint Sex', 'trim|required');
        $this->form_validation->set_rules('complaint_village', 'Address', 'trim|required');
        $this->form_validation->set_rules('complaint_district', 'Complaint Sex', 'trim|required');
        $this->form_validation->set_rules('complaint_sub_district', 'Complaint Sex', 'trim|required');
        $this->form_validation->set_rules('complaint_phone', 'Complaint Sex', 'trim|required');
        $this->form_validation->set_rules('victims_name', 'Victims Name', 'trim|required');
        $this->form_validation->set_rules('victims_sex', 'Victims Sex', 'trim|required');
        $this->form_validation->set_rules('present_district', 'Victims District', 'trim|required');
        $this->form_validation->set_rules('present_sub_district', 'Victims Sub District', 'trim|required');
        $this->form_validation->set_rules('incident_date', 'Incident Date', 'trim|required');
        $this->form_validation->set_rules('incident_village', 'Incident Address', 'trim|required');
        $this->form_validation->set_rules('incident_district', 'Incident District', 'trim|required');
        $this->form_validation->set_rules('incident_sub_district', 'Incident Sub District', 'trim|required');
        $this->form_validation->set_rules('incident_summary', 'Incident Summary', 'trim|required');
        $this->form_validation->set_rules('respondent_name', 'Respondent Name', 'trim|required');
        $this->form_validation->set_rules('respondent_village', 'Respondent Village', 'trim|required');
        $this->form_validation->set_rules('respondent_district', 'Respondent District', 'trim|required');
        $this->form_validation->set_rules('respondent_sub_district', 'Respondent Sub District', 'trim|required');
    }

    public function submit_web_complaint()
    {
        if ($_POST['captcha_word'] == $_POST['captcha'])
        {
            $this->_validationWebComplaint();
            if ($this->form_validation->run() == FALSE)
            {
                $this->index();
                return;
            } else
            {
                $data = array();
                $data['complainant_id'] = $this->input->post('complainant', TRUE);
                $data['complaint_name'] = $this->input->post('complaint_name', TRUE);
                $data['father_name'] = $this->input->post('complaint_father_name', TRUE);
                $data['mother_name'] = $this->input->post('complaint_mother_name', TRUE);
                $data['sex'] = $this->input->post('complaint_sex', TRUE);
                $data['present_address'] = $this->input->post('complaint_village', TRUE);
                $data['present_district'] = $this->input->post('complaint_district', TRUE);
                $data['present_sub_district'] = $this->input->post('complaint_sub_district', TRUE);
                $data['present_phone'] = $this->input->post('complaint_phone', TRUE);
                $data['present_fax'] = $this->input->post('complaint_fax', TRUE);
                $data['present_email'] = $this->input->post('complaint_email', TRUE);
                $data['description'] = $this->input->post('complaint_description', TRUE);
                $data['complaint_received_date'] = date("Y-m-d");
                $data['last_opt_user_id'] = $this->config->item('online_user_id');
                $data['complaint_received_date'] = date("Y-m-d H:i:s");
                $data['present_status'] = $this->config->item('STAT_COMPALINT_SUBMIT');
                $data['present_desk'] = $this->config->item('FRONT_DESK');
                $data['varInsertUser'] = $this->config->item('online_user_id');
                $data['dtInsertDT'] = date("Y-m-d H:i:s");
                $data['traking_number'] = $this->online_model->buildComplaintTrackingNo("I");

                $id = $this->online_model->saveComplaint($data);

                $data = array();
                $data['victims_name'] = $this->input->post('victims_name', TRUE);
                $data['victims_father_name'] = $this->input->post('victims_father_name', TRUE);
                $data['victims_mother_name'] = $this->input->post('victims_mother_name', TRUE);
                $data['victims_spouse_name'] = $this->input->post('victims_spouse_name', TRUE);
                $data['victims_sex'] = $this->input->post('victims_sex', TRUE);
                $data['victims_age'] = $this->input->post('victims_age', TRUE);
                $data['victims_religion'] = $this->input->post('victims_religion', TRUE);
                $data['victims_indigenous_community'] = $this->input->post('victims_community', TRUE);
                $data['disabled'] = $this->input->post('victims_disabled', TRUE);
                $data['victims_present_village'] = $this->input->post('victims_village', TRUE);
                $data['present_district'] = $this->input->post('present_district', TRUE);
                $data['present_sub_district'] = $this->input->post('present_sub_district', TRUE);
                $data['victims_present_phone'] = $this->input->post('victims_phone', TRUE);
                $data['victims_present_fax'] = $this->input->post('victims_fax', TRUE);
                $data['victims_present_email'] = $this->input->post('victims_email', TRUE);
                $data['varInsertUser'] = $this->config->item('online_user_id');
                $data['varEditUser'] = $this->config->item('online_user_id');
                $data['dtInsertDt'] = date("Y-m-d H:i:s");
                $data['complaint_id'] = $id;
                $this->online_model->saveVictimInformation($data);

                $selTimeHr = $this->input->post('selTimeHr', TRUE);
                $selTimeMin = $this->input->post('selTimeMin', TRUE);
                $selTimeAMPM = $this->input->post('selTimeAMPM', TRUE);
                $incident_time = $selTimeHr . ":" . $selTimeMin . ":" . $selTimeAMPM;
                $data = array();
                $data['incident_date'] = date_time_format($this->input->post('incident_date', TRUE), 'dmy', 'ymd');
                $data['incident_time'] = $incident_time;
                $data['incident_address'] = $this->input->post('incident_village', TRUE);
                $data['permanent_district'] = $this->input->post('incident_district', TRUE);
                $data['permanent_sub_district'] = $this->input->post('incident_sub_district', TRUE);
                $data['incident_description'] = $this->input->post('incident_summary', TRUE);
                $data['case_court'] = $this->input->post('incident_case', TRUE);
                $data['varInsertUser'] = $this->config->item('online_user_id');
                $data['varEditUser'] = $this->config->item('online_user_id');
                $data['dtInsertDt'] = date("Y-m-d H:i:s");
                $data['complaint_id'] = $id;
                $this->online_model->saveIncidentInformation($data);


                $data = array();
                $data['respondent_name'] = $this->input->post('respondent_name', TRUE);
                $data['respondent_designation'] = $this->input->post('respondent_designation', TRUE);
                $data['respondent_present_village'] = $this->input->post('respondent_village', TRUE);
                $data['present_district'] = $this->input->post('respondent_district', TRUE);
                $data['present_sub_district'] = $this->input->post('respondent_sub_district', TRUE);
                $data['respondent_present_phone'] = $this->input->post('respondent_present_phone', TRUE);
                $data['respondent_present_fax'] = $this->input->post('respondent_phone', TRUE);
                $data['respondent_present_email'] = $this->input->post('respondent_email', TRUE);
                $data['varInsertUser'] = $this->config->item('online_user_id');
                $data['varEditUser'] = $this->config->item('online_user_id');
                $data['dtInsertDt'] = date("Y-m-d H:i:s");
                $data['complaint_id'] = $id;
                $this->online_model->saveRespondentInformation($data);

                if ($id)
                {
                    $data = array(
                        'complaint_id' => $id,
                        'previous_status_id' => 0,
                        'present_status_id' => $this->config->item('STAT_COMPALINT_SUBMIT'),
                        'previous_desk_id' => 0,
                        'present_desk_id' => $this->config->item('STAT_COMPALINT_SUBMIT'),
                        'operating_user_id' => $this->session->userdata('sess_nhrc_user_id')
                    );
                    $this->db->insert('compaint_details', $data);
                    redirect('online/success/' . $id);
                } else
                {
                    $this->session->set_flashdata('exception', '<div class= msg-error>Data Not Submit! Please chack all the field</div>');
                    redirect('online/index/');
                }
            }
        } else
        {
            $this->session->set_flashdata('exception', '<div class= msg-error>Input Your Captcha Correctly</div>');
            redirect('online/index');
        }
    }

    public function success($id)
    {
        $this->_data['pageTitle'] = 'Complaint Submission &amp; Acknowledgement';
        $this->_data['complaintInfo'] = $this->online_model->getCompalintInfo($id);
        $this->layout->view('success', $this->_data);
    }

    public function datasupplier()
    { 
        $district_id = $this->input->post('complaint_district', TRUE);

        if ($district_id == '')
        {
            return FALSE;
        }

        $data = $this->online_model->getSubDistricts($district_id);

        $listData = array();
        foreach ($data as $item)
        {
            $val = $item['sub_district_id'];
            $listData[$district_id][$val] = $item['sub_district_name'];
        }
        // build json data
        if ($listData)
        {
            echo json_encode($listData[$district_id]);
        } else
        {
            echo '{}';
        }
    }

    public function datasupplier2()
    {
        $district_id = $this->input->post('present_district', TRUE);

        if ($district_id == '')
        {
            return FALSE;
        }

        $data = $this->online_model->getSubDistricts($district_id);

        $listData = array();
        foreach ($data as $item)
        {
            $val = $item['sub_district_id'];
            $listData[$district_id][$val] = $item['sub_district_name'];
        }
        // build json data
        if ($listData)
        {
            echo json_encode($listData[$district_id]);
        } else
        {
            echo '{}';
        }
    }

    public function datasupplier3()
    {
        $district_id = $this->input->post('incident_district', TRUE);

        if ($district_id == '')
        {
            return FALSE;
        }

        $data = $this->online_model->getSubDistricts($district_id);

        $listData = array();
        foreach ($data as $item)
        {
            $val = $item['sub_district_id'];
            $listData[$district_id][$val] = $item['sub_district_name'];
        }
        // build json data
        if ($listData)
        {
            echo json_encode($listData[$district_id]);
        } else
        {
            echo '{}';
        }
    }

    public function datasupplier4()
    {
        $district_id = $this->input->post('respondent_district', TRUE);

        if ($district_id == '')
        {
            return FALSE;
        }

        $data = $this->online_model->getSubDistricts($district_id);

        $listData = array();
        foreach ($data as $item)
        {
            $val = $item['sub_district_id'];
            $listData[$district_id][$val] = $item['sub_district_name'];
        }
        // build json data
        if ($listData)
        {
            echo json_encode($listData[$district_id]);
        } else
        {
            echo '{}';
        }
    }

    public function searchStatusOnline()
    {

        $this->load->helper('captcha');
        $vals = array(
            'img_path' => 'assets/captcha/',
            'img_url' => base_url() . 'assets/captcha/',
            'font_path' => './system/fonts/BRLNSR.TTF',
            'img_width' => '200',
            'img_height' => '60',
            'expiration' => 7200
        );
        $captcha = create_captcha($vals);
        $this->_data['captcha'] = $captcha;
        $this->session->set_userdata('captcha', $captcha);
        $this->_data['pageTitle'] = 'Search Online Status';
        $this->layout->view('online/searchStatusOnline', $this->_data);
    }

    public function searchResult()
    {
        if ($_POST['captcha_word'] == $_POST['captcha'])
        {
            $this->form_validation->set_rules('tracking_number', 'Tracking Number', 'trim|required|xss_clean');            
            if ($this->form_validation->run() == FALSE)
            {
                $this->searchStatusOnline();
                return;
            } else
            {
                $trakingNumber = $this->input->post('tracking_number', true);                
                $data = $this->online_model->chackValidation($trakingNumber);
                if ($data)
                {
                    $id = $data[0]['id'];
                    $this->_data['pageTitle'] = 'Search Online Status Result';
                    $this->_data['complaintInfo'] = $data;
                    $this->_data['complaintHistory'] = $this->online_model->getComplaintHistory($id);
                    $this->layout->view('online/searchResult', $this->_data);
                } else
                {
                    $this->session->set_flashdata('exception', '<div class= msg-error>No Data Found</div>');
                    redirect('online/searchStatusOnline');
                }
            }
        } else
        {
            $this->session->set_flashdata('exception', '<div class= msg-error>Input Your Captcha Correctly</div>');
            redirect('online/searchStatusOnline');
        }
    }

}