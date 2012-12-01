<?php

class Complaint extends Auth_Controller
{

    private $_data;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('complaint_model');
        $this->load->model('common_settings_model', 'common');

        $this->layout->setLayout('layout/complaint_layout');
        //$this->output->enable_profiler(TRUE);
    }

    public function index()
    {
        redirect('complaint/dashboard');
    }

    public function newcomplaint()
    {
        if (!$this->auth->havePermission('SUBMITION'))
        {
            redirect(site_url());
        }
        $this->_data['pageTitle'] = 'New Complaint';
        $this->_data['get_complaint'] = $this->common->getBasicData($this->config->item('COMPALINT_TYPE'));
        $this->layout->view('newcomplaint', $this->_data);
    }

    private function _validateNewComplaint()
    {
        $this->form_validation->set_rules('complainant', 'Complainant Type', 'required|trim');
        $this->form_validation->set_rules('complaint_name', 'Complaint name', 'trim|required|min_length[5]|max_length[200]|xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[5]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('sex', 'Sex', 'trim|required');
        $this->form_validation->set_rules('fax', 'Fax', 'min_length[5]|max_length[60]|trim');
        $this->form_validation->set_rules('email', 'Email', 'valid_email|min_length[5]|max_length[150]|trim');
        $this->form_validation->set_rules('description', 'Summarized Description of the Incident', 'trim|required|min_length[5]|xss_clean');
        $this->form_validation->set_error_delimiters('<li class="error">', '</li>');
    }

    public function saveNewComplaint()
    {
        if (!$this->auth->havePermission('SUBMITION'))
        {
            redirect(site_url());
        }

        $this->_validateNewComplaint();
        if ($this->form_validation->run() == FALSE)
        {
            $this->newcomplaint();
            return;
        } else
        {
            $data = array(
                'complainant_id' => $this->input->post('complainant', TRUE),
                'complaint_name' => $this->input->post('complaint_name', TRUE),
                'sex' => $this->input->post('sex', TRUE),
                'present_address' => $this->input->post('address', TRUE),
                'present_phone' => $this->input->post('phone', TRUE),
                'present_fax' => $this->input->post('fax', TRUE),
                'present_email' => $this->input->post('email', TRUE),
                'description' => $this->input->post('description', TRUE),
                'present_status' => $this->config->item('STAT_COMPALINT_SUBMIT'),
                'present_desk' => $this->config->item('FRONT_DESK'),
                'last_opt_user_id' => $this->session->userdata('sess_nhrc_user_id'),
                'complaint_received_date' => date("Y-m-d H:i:s"),
                'varInsertUser' => $this->session->userdata('sess_nhrc_user_id'),
                'dtInsertDT' => date("Y-m-d H:i:s")
            );

            $data['traking_number'] = $this->common->buildComplaintTrackingNo("D");
            $id = $this->complaint_model->saveComplaint($data);
            if ($id)
            {
                $data = array(
                    'complaint_id' => $id,
                    'previous_status_id' => 0,
                    'present_status_id' => $this->config->item('STAT_COMPALINT_SUBMIT'),
                    'previous_desk_id' => 0,
                    'present_desk_id' => $this->config->item('FRONT_DESK'),
                    'operating_user_id' => $this->session->userdata('sess_nhrc_user_id')
                );
                $this->db->insert('compaint_details', $data);

                redirect('complaint/success/' . $id);
            } else
            {
                $this->_data['errMsg'] = "Complaint Submission Failed.";
                $this->layout->view('newcomplaint', $this->_data);
            }
        }
    }
	
	public function submit_child_information()
	{
		
		$data['saveChild'] = $this->complaint_model->saveChild($this->input->post());
		 if ($data['saveChild'])
            {
                
                echo "<div class='msg-success close'>Data has been saved successfully</div>";
            } else
            {
                echo "<div class='msg-error close'>Document Information Saved Failed</div>";
            }
		
       	}

    public function success($id)
    {
        $this->_data['pageTitle'] = 'Complaint Submission &amp; Acknowledgement';
        $this->_data['complaintInfo'] = $this->complaint_model->getCompalintInfo($id);
        $this->layout->view('success', $this->_data);
    }

    public function acknowledgement($id)
    {
        $this->_data['complaintInfo'] = $this->complaint_model->getCompalintInfo($id);
        $this->load->view('complaint/acknowledgement', $this->_data);
    }

    public function printDetail($id)
    {
        $this->_data['complaintInfo'] = $this->complaint_model->getCompalintInfo($id);
        $this->load->view('complaint/printDetail', $this->_data);
    }

    public function complaintentry($id)
    {
        $this->_data['id'] = $id;
        $this->_data['pageTitle'] = 'Complaint Details';
        $this->layout->view('complaint/complaintentry', $this->_data);
    }

    public function tab_complaint($id)
    {
        $this->_data['districtList'] = $this->common->getDistricts();
        $this->_data['complaintType'] = $this->common->getBasicData($this->config->item('COMPALINT_TYPE'));
        $this->_data['methodOfComplaint'] = $this->common->getBasicData($this->config->item('MATHOD_OF_COMP_DELIVERY'));
        $complaintInfo = $this->complaint_model->getCompalintInfo($id);
        $this->_data['complaintInfo'] = $complaintInfo;
        $this->_data['permanentSubDistricts'] = $this->common->getSubDistricts($complaintInfo->permanent_district);
        $this->_data['presentSubDistricts'] = $this->common->getSubDistricts($complaintInfo->present_district);
        $selMethodOfDel = $this->complaint_model->getCompalintMethodOfDelivery($id);
        $selDelArr = array();
        foreach ($selMethodOfDel as $item)
        {
            $selDelArr[] = $item['intDeliveryID'];
        }
        $this->_data['selMethodOfDel'] = $selDelArr;

        $this->load->view('tab_for_complaint', $this->_data);
    }

    public function saveComplainant()
    {
        $this->form_validation->set_rules('complainant', 'Complainant', 'required');
        $this->form_validation->set_rules('complaint_id', 'complaint', 'required|integer');
        $this->form_validation->set_rules('complaint_name', 'Complaint name', 'trim|required|min_length[5]|max_length[150]|xss_clean');
        $this->form_validation->set_rules('sex', 'Sex', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');
        $this->form_validation->set_error_delimiters('<li class="red">', '</li>');

        if ($this->form_validation->run() == FALSE)
        {
            echo validation_errors();
            return FALSE;
        } else
        {
            $data = array();
            $data['complainant_id'] = $this->input->post('complainant', TRUE);
            $data['complaint_name'] = $this->input->post('complaint_name', TRUE);
            $data['sex'] = $this->input->post('sex', TRUE);
            $data['father_name'] = $this->input->post('father_name', TRUE);
            $data['mother_name'] = $this->input->post('mother_name', TRUE);
            $data['spouse_name'] = $this->input->post('spouse_name', TRUE);

            $data['permanent_village'] = $this->input->post('permanent_village', TRUE);
            $permanent_district = ($this->input->post('permanent_district', TRUE) == 0) ? NULL : $this->input->post('permanent_district', TRUE);
            $data['permanent_district'] = $permanent_district;
            $permanent_sub_district = ($this->input->post('permanent_sub_district', TRUE) == 0) ? NULL : $this->input->post('permanent_sub_district', TRUE);
            $data['permanent_sub_district'] = $permanent_sub_district;
            $data['permanent_phone'] = $this->input->post('permanent_phone', TRUE);
            $data['permanent_fax'] = $this->input->post('permanent_fax', TRUE);
            $data['permanent_email'] = $this->input->post('permanent_email', TRUE);

            $data['present_address'] = $this->input->post('present_village', TRUE);
            $present_district = ($this->input->post('present_district', TRUE) == 0) ? NULL : $this->input->post('present_district', TRUE);
            $data['present_district'] = $present_district;
            $present_sub_district = ($this->input->post('present_sub_district', TRUE) == 0) ? NULL : $this->input->post('present_sub_district', TRUE);
            $data['present_sub_district'] = $present_sub_district;
            $data['present_phone'] = $this->input->post('present_phone', TRUE);
            $data['present_fax'] = $this->input->post('present_fax', TRUE);
            $data['present_email'] = $this->input->post('present_email', TRUE);


            $data['varEditUser'] = $this->session->userdata('sess_nhrc_user_id');


            $id = $this->input->post('complaint_id', TRUE);

            if ($this->complaint_model->UpdateComplainant($data, $id))
            {


                echo "<div class='msg-success close'>Complainant Information Saved Successfully</div>";
            }
        }
    }

    private function _saveMethodOfDelivery($complaint_id)
    {
        $chkMethodOfDel = $this->input->post('chkMethodOfDel', TRUE);
        if (isset($chkMethodOfDel) && is_array($chkMethodOfDel))
        {
            $chkMethodOfDel = array_unique($chkMethodOfDel);
            foreach ($chkMethodOfDel as $key => $values)
            {
                if ($values)
                {
                    $data = array(
                        'intComplaintID' => $complaint_id,
                        'intDeliveryID' => $values
                    );
                    $this->db->insert('complaint_delivery_method', $data);
                }
            }
        }
    }

    public function datasupplier()
    {
        $district_id = $this->input->post('permanent_district');

        if ($district_id == '')
        {
            return FALSE;
        }

        $data = $this->common->getSubDistricts($district_id);

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
        $district_id = $this->input->post('present_district');

        if ($district_id == '')
        {
            return FALSE;
        }

        $data = $this->common->getSubDistricts($district_id);

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

    public function tab_victim_info($id)
    {
        $complaintInfo = $this->complaint_model->getCompalintInfo($id);
        $this->_data['religionList'] = $this->common->getBasicData($this->config->item('RELIGION'));
        $this->_data['methodOfComplaint'] = $this->common->getBasicData($this->config->item('MATHOD_OF_COMP_DELIVERY'));
        $this->_data['complaintInfo'] = $complaintInfo;
        $this->_data['complaint_id'] = $id;
        $this->_data['get_district'] = $this->common->getDistricts();
        $vic_info = $this->complaint_model->getVictimInfo($id);

        $this->_data['victims_name'] = '';
        $this->_data['victims_father_name'] = '';
        $this->_data['victims_mother_name'] = '';
        $this->_data['victims_spouse_name'] = '';
        $this->_data['victims_sex'] = '';
        $this->_data['victims_age'] = '';
        $this->_data['victims_religion'] = '';
        $this->_data['victims_number'] = '';
        $this->_data['victims_indigenous_community'] = '';
        $this->_data['disabled'] = '';
        $this->_data['victims_permanent_village'] = '';
        $this->_data['permanent_district'] = '';
        $this->_data['permanent_sub_district'] = '';
        $this->_data['victims_permanent_phone'] = '';
        $this->_data['victims_permanent_fax'] = '';
        $this->_data['victims_permanent_email'] = '';
        $this->_data['victims_present_village'] = '';
        $this->_data['present_district'] = '';
        $this->_data['present_sub_district'] = '';
        $this->_data['victims_present_phone'] = '';
        $this->_data['victims_present_fax'] = '';
        $this->_data['victims_present_email'] = '';

        if ($vic_info == true)
        {
            //print_r($vic_info);
            $this->_data['victims_name'] = $vic_info[0]['victims_name'];
            $this->_data['victims_father_name'] = $vic_info[0]['victims_father_name'];
            $this->_data['victims_mother_name'] = $vic_info[0]['victims_mother_name'];
            $this->_data['victims_spouse_name'] = $vic_info[0]['victims_spouse_name'];
            $this->_data['victims_sex'] = trim($vic_info[0]['victims_sex']);
            $this->_data['victims_age'] = $vic_info[0]['victims_age'];
            $this->_data['victims_religion'] = $vic_info[0]['victims_religion'];
            $this->_data['victims_number'] = $vic_info[0]['victims_number'];
            $this->_data['victims_indigenous_community'] = $vic_info[0]['victims_indigenous_community'];
            $this->_data['disabled'] = $vic_info[0]['disabled'];
            $this->_data['victims_permanent_village'] = $vic_info[0]['victims_permanent_village'];
            $this->_data['permanent_district'] = $vic_info[0]['permanent_district'];
            $this->_data['permanent_sub_district'] = $vic_info[0]['permanent_sub_district'];
            $this->_data['victims_permanent_phone'] = $vic_info[0]['victims_permanent_phone'];
            $this->_data['victims_permanent_fax'] = $vic_info[0]['victims_permanent_fax'];
            $this->_data['victims_permanent_email'] = $vic_info[0]['victims_permanent_email'];
            $this->_data['victims_present_village'] = $vic_info[0]['victims_present_village'];
            $this->_data['present_district'] = $vic_info[0]['present_district'];
            $this->_data['present_sub_district'] = $vic_info[0]['present_sub_district'];
            $this->_data['victims_present_phone'] = $vic_info[0]['victims_present_phone'];
            $this->_data['victims_present_fax'] = $vic_info[0]['victims_present_fax'];
            $this->_data['victims_present_email'] = $vic_info[0]['victims_present_email'];
            $this->_data['complaint_id'] = $vic_info[0]['complaint_id'];
            $this->_data['permanentSubDistricts'] = $this->common->getSubDistricts($this->_data['permanent_district']);
            $this->_data['presentSubDistricts'] = $this->common->getSubDistricts($this->_data['present_district']);
            $this->_data['methodOfComplaint'] = $this->common->getBasicData($this->config->item('MATHOD_OF_COMP_DELIVERY'));
        }
        $selMethodOfDel = $this->complaint_model->getCompalintMethodOfDelivery($id);
        $selDelArr = array();
        foreach ($selMethodOfDel as $item)
        {
            $selDelArr[] = $item['intDeliveryID'];
        }
        $this->_data['selMethodOfDel'] = $selDelArr;

        $this->load->view('tab_for_victim_info', $this->_data);
    }

    public function submit_victim_information()
    {
        $this->form_validation->set_rules('complaint_id', 'Complaint', 'required|integer');
        $this->form_validation->set_rules('victims_present_email', 'Victims Present Email', 'valid_email|trim');
        $this->form_validation->set_rules('victims_permanent_email', 'Victims Permanent Email', 'valid_email|trim');
        $this->form_validation->set_error_delimiters('<li class="red">', '</li>');

        if ($this->form_validation->run() == FALSE)
        {
            echo validation_errors();
            return FALSE;
        } else
        {
            $data = array(
                'victims_name' => $this->input->post('victims_name', TRUE),
                'victims_number' => $this->input->post('victims_number', TRUE),
                'victims_father_name' => $this->input->post('victims_father_name', TRUE),
                'victims_mother_name' => $this->input->post('victims_mother_name', TRUE),
                'victims_spouse_name' => $this->input->post('victims_spouse_name', TRUE),
                'victims_sex' => $this->input->post('victims_sex', TRUE),
                'victims_age' => $this->input->post('victims_age', TRUE),
                'victims_religion' => $this->input->post('victims_religion', TRUE),
                'victims_indigenous_community' => $this->input->post('victims_indigenous_community', TRUE),
                'disabled' => $this->input->post('disabled', TRUE),
                'victims_permanent_village' => $this->input->post('victims_permanent_village', TRUE),
                'permanent_district' => $this->input->post('permanent_district', TRUE),
                'permanent_sub_district' => $this->input->post('permanent_sub_district', TRUE),
                'victims_permanent_phone' => $this->input->post('victims_permanent_phone', TRUE),
                'victims_permanent_fax' => $this->input->post('victims_permanent_fax', TRUE),
                'victims_permanent_email' => $this->input->post('victims_permanent_email', TRUE),
                'victims_present_village' => $this->input->post('victims_present_village', TRUE),
                'present_district' => $this->input->post('present_district', TRUE),
                'present_sub_district' => $this->input->post('present_sub_district', TRUE),
                'victims_present_phone' => $this->input->post('victims_present_phone', TRUE),
                'victims_present_fax' => $this->input->post('victims_present_fax', TRUE),
                'victims_present_email' => $this->input->post('victims_present_email', TRUE)
            );

            $id = $this->input->post('complaint_id', TRUE);
            $this->complaint_model->saveVictimInformation($data, $id);

            $data1 = array(
                'attachment_page_number' => $this->input->post('attachment_page_number', TRUE),
                'description' => $this->input->post('description', TRUE)
            );
            $this->complaint_model->updateComplaintData($data1, $id);

            $this->db->delete('complaint_delivery_method', array('intComplaintID' => $id));
            $this->_saveMethodOfDelivery($id);
            echo "<div class='msg-success close'>Victim Information Saved Successfully</div>";
        }
    }

    public function tab_respondent_info($id)
    {
        $this->_data['complaint_id'] = $id;
        $complaintInfo = $this->complaint_model->getCompalintInfo($id);
        $this->_data['complaintInfo'] = $complaintInfo;

        $this->_data['get_district'] = $this->common->getDistricts();
        $vic_info = $this->complaint_model->get_respondent_information($id);
        $this->_data['respondent'] = $vic_info;

        $this->_data['desciplinedForce'] = $this->common->getBasicData($this->config->item('DISCIPLINED_FORCE'));
        $this->_data['againstRespondentType'] = $this->common->getBasicData($this->config->item('AGAINST_RESPONDENT_TYPE'));

        $this->load->view('tab_for_respondent_info', $this->_data);
    }

    public function submit_respondent_information()
    {
        $respondent_type = $this->input->post('rbtRespondentType', TRUE);
        $respondent_name = $this->input->post('respondent_name', TRUE);
        $respondent_designation = $this->input->post('respondent_designation', TRUE);
        $respondent_father_name = $this->input->post('father_name', TRUE);
        $respondent_mother_name = $this->input->post('mother_name', TRUE);
        $respondent_spouse_name = $this->input->post('spouse_name', TRUE);
        $respondent_member_decipline_force = $this->input->post('deciplin_force', TRUE);
        $decipline_force_member_yes = $this->input->post('decipline_force_member_yes', TRUE);
        $respondent_member_decipline_no = $this->input->post('respondent_member_decipline_no', TRUE);
        $others_respondent = $this->input->post('others_respondent', TRUE);
        $respondent_permanent_village = $this->input->post('respondent_permanent_village', TRUE);
        $permanent_district = $this->input->post('permanent_district', TRUE);
        $permanent_sub_district = $this->input->post('permanent_sub_district', TRUE);
        $respondent_permanent_phone = $this->input->post('respondent_permanent_phone', TRUE);
        $respondent_permanent_fax = $this->input->post('respondent_permanent_fax', TRUE);
        $respondent_permanent_email = $this->input->post('respondent_permanent_email', TRUE);
        $respondent_present_village = $this->input->post('respondent_present_village', TRUE);
        $present_district = $this->input->post('present_district', TRUE);
        $present_sub_district = $this->input->post('present_sub_district', TRUE);
        $respondent_present_phone = $this->input->post('respondent_present_phone', TRUE);
        $respondent_present_fax = $this->input->post('respondent_present_fax', TRUE);
        $respondent_present_email = $this->input->post('respondent_present_email', TRUE);
        $complaint_id = $this->input->post('complaint_id', TRUE);

        if (!isset($complaint_id) && $complaint_id == "")
        {
            return FALSE;
        }

        if (!is_array($respondent_name) && count($respondent_name) == 0)
        {
            return FALSE;
        } else
        {
            $this->db->where('complaint_id', $this->input->post('complaint_id', TRUE));
            $this->db->delete('respondent_info');
        }

        $respondent_name = array_unique($respondent_name);

        foreach ($respondent_name as $key => $values)
        {
            if ($values)
            {
                if ($values == "" || $respondent_type[$key] == "")
                {
                    continue;
                }

                $data = array(
                    'respondent_type' => $respondent_type[$key],
                    'complaint_id' => $this->input->post('complaint_id', TRUE),
                    'respondent_name' => $values,
                    'respondent_designation' => $respondent_designation[$key],
                    'respondent_father_name' => $respondent_father_name[$key],
                    'respondent_mother_name' => $respondent_mother_name[$key],
                    'respondent_spouse_name' => $respondent_spouse_name[$key],
                    'respondent_member_decipline_force' => $respondent_member_decipline_force[$key],
                    'decipline_force_member_yes' => $decipline_force_member_yes[$key],
                    'respondent_member_decipline_no' => $respondent_member_decipline_no[$key],
                    'others_respondent' => $others_respondent[$key],
                    'respondent_permanent_village' => $respondent_permanent_village[$key],
                    'permanent_district' => $permanent_district[$key],
                    'permanent_sub_district' => $permanent_sub_district[$key],
                    'respondent_permanent_phone' => $respondent_permanent_phone[$key],
                    'respondent_permanent_fax' => $respondent_permanent_fax[$key],
                    'respondent_permanent_email' => $respondent_permanent_email[$key],
                    'respondent_present_village' => $respondent_present_village[$key],
                    'present_district' => $present_district[$key],
                    'present_sub_district' => $present_sub_district[$key],
                    'respondent_present_phone' => $respondent_present_phone[$key],
                    'respondent_present_fax' => $respondent_present_fax[$key],
                    'respondent_present_email' => $respondent_present_email[$key],
                    'varInsertUser' => $this->session->userdata('sess_nhrc_user_id'),
                    'varEditUser' => $this->session->userdata('sess_nhrc_user_id'),
                    'dtInsertDt' => date("Y-m-d H:i:s")
                );
                if (is_array($data) && count($data) > 0)
                {
                    $this->db->insert('respondent_info', $data);
                }
            }
        }
        if ($this->db->insert_id())
        {
            echo "<div class='msg-success close'>Respondent Person(s)/Organization(s) Information Saved Successfully</div>";
        } else
        {
            echo "<div class='msg-success close'>Respondent Person(s)/Organization(s) Information Saved Successfully</div>";
        }
    }

    public function tab_incident_info($id)
    {
        $complaintInfo = $this->complaint_model->getCompalintInfo($id);
        $this->_data['complaintInfo'] = $complaintInfo;

        $this->_data['complaint_id'] = $id;
        $this->_data['get_district'] = $this->common->getDistricts();
        $vic_info = $this->complaint_model->get_incident_information($id);
        $this->_data['incident_date'] = '';
        $this->_data['incident_time'] = '';
        $this->_data['incident_address'] = '';
        $this->_data['permanent_district'] = '';
        $this->_data['permanent_sub_district'] = '';
        $this->_data['incident_description'] = '';
        $this->_data['case_court'] = '';
        $this->_data['incident_desired_remedy'] = '';
        $this->_data['selTimeHr'] = '';
        $this->_data['selTimeMin'] = '';
        $this->_data['selTimeAMPM'] = '';

        if ($vic_info == true)
        {
            $this->_data['incident_date'] = date_time_format($vic_info[0]['incident_date'], 'ymd', 'dmy');
            //$this->_data['incident_time'] = $vic_info[0]['incident_time'];
            $this->_data['incident_address'] = $vic_info[0]['incident_address'];
            $this->_data['permanent_district'] = $vic_info[0]['permanent_district'];
            $this->_data['permanent_sub_district'] = $vic_info[0]['permanent_sub_district'];
            $this->_data['incident_description'] = $vic_info[0]['incident_description'];
            $this->_data['case_court'] = $vic_info[0]['case_court'];
            $this->_data['incident_desired_remedy'] = $vic_info[0]['incident_desired_remedy'];
            list($hrs, $min, $ampm) = explode(":", $vic_info[0]['incident_time']);
            $this->_data['selTimeHr'] = $hrs;
            $this->_data['selTimeMin'] = $min;
            $this->_data['selTimeAMPM'] = $ampm;
            $this->_data['sub_district_info'] = $this->common->getSubDistricts($this->_data['permanent_district']);
        }

        $this->load->view('tab_for_incident_info', $this->_data);
    }

    public function submit_incident_information()
    {
        $this->form_validation->set_rules('complaint_id', 'Complaint', 'required|integer');
        $this->form_validation->set_rules('incident_date', 'Respondent Present Email', 'required|trim');
        $this->form_validation->set_error_delimiters('<li class="red">', '</li>');

        if ($this->form_validation->run() == FALSE)
        {
            echo validation_errors();
            return FALSE;
        } else
        {
            $selTimeHr = $this->input->post('selTimeHr', TRUE);
            $selTimeMin = $this->input->post('selTimeMin', TRUE);
            $selTimeAMPM = $this->input->post('selTimeAMPM', TRUE);
            $incident_time = $selTimeHr . ":" . $selTimeMin . ":" . $selTimeAMPM;

            $data = array(
                'incident_date' => date_time_format($this->input->post('incident_date', TRUE), 'dmy', 'ymd'),
                'incident_time' => $incident_time,
                'incident_address' => $this->input->post('incident_address', TRUE),
                'permanent_district' => $this->input->post('permanent_district', TRUE),
                'permanent_sub_district' => $this->input->post('permanent_sub_district', TRUE),
                'incident_description' => $this->input->post('incident_description', TRUE),
                'case_court' => $this->input->post('case_court', TRUE),
                'incident_desired_remedy' => $this->input->post('incident_desired_remedy', TRUE)
            );

            $id = $this->input->post('complaint_id', TRUE);
            if ($this->complaint_model->saveIncidentInformation($data, $id))
            {
                echo "<div class='msg-success close'>Incident Information Saved Successfully</div>";
            } else
            {
                //echo "<div class='information close'>Incident Information Saved Failed</div>";
            }
        }
    }

    public function tab_analysis($id)
    {
        $complaintInfo = $this->complaint_model->getCompalintInfo($id);
        $this->_data['complaintInfo'] = $complaintInfo;
        $vic_info = $this->complaint_model->get_analysis_information($id);
        //$this->_data['type_of_violation'] = '';
        $this->_data['identified_category'] = '';
        $this->_data['violet_constitution'] = '';
        $this->_data['permanent_district'] = '';
        $this->_data['human_rights_violation'] = '';

        if ($vic_info == true)
        {
            //$this->_data['type_of_violation'] = $vic_info[0]['type_of_violation'];
            $this->_data['identified_category'] = $vic_info[0]['identified_category'];
            $this->_data['violet_constitution'] = $vic_info[0]['violet_constitution'];
            $this->_data['human_rights_violation'] = $vic_info[0]['human_rights_violation'];
        }

        $this->_data['getVolutionList'] = $this->common->getBasicData($this->config->item('KIND_OF_HR_VIOLATION'));
        $this->_data['getAnalysisHRViolationList'] = $this->complaint_model->getComplaintAnalysisHRViolation($id);

        $this->load->view('tab_for_complaint_analysis', $this->_data);
    }

    public function submit_complaint_analysis()
    {
        $this->form_validation->set_rules('complaint_id', 'Complaint', 'required|integer');
        $this->form_validation->set_error_delimiters('<li class="red">', '</li>');

        if ($this->form_validation->run() == FALSE)
        {
            echo validation_errors();
            return FALSE;
        } else
        {
            $data = array(
                'human_rights_violation' => $this->input->post('human_rights_violation'),
                'identified_category' => $this->input->post('identified_category'),
                'violet_constitution' => $this->input->post('violet_constitution')
            );

            $id = $this->input->post('complaint_id', TRUE);
            if ($id)
            {
                $this->complaint_model->saveComplaintAnalysis($data, $id);
                $this->_saveAnalysisHRViolation();
                echo "<div class='msg-success close'>Complaint Analysis Information Saved Successfully</div>";
            } else
            {
                //echo "<div class='information close'>Complaint Analysis Information Saved Failed</div>";
            }
        }
    }

    private function _saveAnalysisHRViolation()
    {
        $type_of_violation = $this->input->post('type_of_violation', TRUE);
        if (isset($type_of_violation) && is_array($type_of_violation))
        {
            $type_of_violation = array_unique($type_of_violation);
            // del prev values
            $this->db->where('complaint_id', $this->input->post('complaint_id', TRUE));
            $this->db->delete('complaint_analysis_hrviolation');

            foreach ($type_of_violation as $key => $values)
            {
                if ($values)
                {
                    $data = array(
                        'complaint_id' => $this->input->post('complaint_id', TRUE),
                        'hrviolation_id' => $values,
                        'varInsertUser' => $this->session->userdata('sess_nhrc_user_id'),
                        'dtInsertDT' => date("Y-m-d H:i:s")
                    );
                    $this->db->insert('complaint_analysis_hrviolation', $data);
                }
            }
        }
    }

    public function removeHRVType($complaint_id, $type_id)
    {
        $this->db->where('complaint_id', $complaint_id);
        $this->db->where('hrviolation_id', $type_id);
        $this->db->delete('complaint_analysis_hrviolation');
    }

    public function tab_action_history($id)
    {
        $complaintInfo = $this->complaint_model->getCompalintInfo($id);
        $this->_data['complaintInfo'] = $complaintInfo;

        $this->_data['statusList'] = array();
        $this->_data['deskList'] = array();
        if ((int) $complaintInfo->present_desk === (int) $this->session->userdata('sess_nhrc_desk_id'))
        {
            $this->_data['statusList'] = $this->complaint_model->getProcessStatus($complaintInfo->present_status, $this->session->userdata('sess_nhrc_desk_id'));
            $this->_data['deskList'] = $this->complaint_model->getProcessDesks($complaintInfo->present_status, $this->session->userdata('sess_nhrc_desk_id'));
        }
        $this->_data['complaintHistory'] = $this->complaint_model->getComplaintHistory($id);

        $this->load->view('tab_for_action_history', $this->_data);
    }

    public function saveComplaintProcess()
    {
        $compID = $this->input->post('hidCompalintID', TRUE);
        $compStatus = $this->input->post('selCompalintStatus', TRUE);
        $compPrevStatus = $this->input->post('hidPresentStatus', TRUE);
        if ($compID == "" || $compStatus == "" || $compPrevStatus == "")
        {
            redirect('complaint/dashboard');
        }

        $this->db->trans_begin();
        // complaint details  
        $this->_saveCompalintDetails();
        $this->_saveStatusReasonRemarks();
        // update complaint info
        $data = array('previous_status' => $this->input->post('hidPresentStatus', TRUE),
            'present_status' => $this->input->post('selCompalintStatus', TRUE),
            'previous_desk' => $this->session->userdata('sess_nhrc_desk_id'),
            'present_desk' => $this->input->post('selDesk', TRUE),
            'last_opt_user_id' => $this->session->userdata('sess_nhrc_user_id'));
        $this->db->where('complaint_id', $this->input->post('hidCompalintID', TRUE));
        $this->db->update('complaint', $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            echo "<div class='msg-error close'>Complaint Process Failed</div>";
        } else
        {
            $this->db->trans_commit();
            echo "<div class='msg-success close'>Complaint Processed Successfully</div>";
            $this->tab_action_history($compID);
        }
    }

    private function _saveCompalintDetails()
    {
        $data = array(
            'complaint_id' => $this->input->post('hidCompalintID', TRUE),
            'previous_status_id' => $this->input->post('hidPresentStatus', TRUE),
            'present_status_id' => $this->input->post('selCompalintStatus', TRUE),
            'previous_desk_id' => $this->session->userdata('sess_nhrc_desk_id'),
            'present_desk_id' => $this->input->post('selDesk', TRUE),
            'operating_user_id' => $this->session->userdata('sess_nhrc_user_id'),
            'remarks' => $this->input->post('txtRemarks', TRUE),
        );
        $this->db->insert('compaint_details', $data);
    }

    public function getReasonsList($status_id = NULL)
    {
        if (!isset($status_id) || $status_id == "")
        {
            return FALSE;
        }
        $rs = $this->complaint_model->getStatusReason($status_id);
        if (count($rs) > 0)
        {
            $this->_data['statusReasons'] = $rs;
            $this->load->view('ajax_reasons', $this->_data);
        }
        return;
    }

    private function _saveStatusReasonRemarks()
    {
        $chkStatusReasons = $this->input->post('chkStatusReasons', TRUE);
        if (isset($chkStatusReasons) && is_array($chkStatusReasons))
        {
            $chkStatusReasons = array_unique($chkStatusReasons);

            foreach ($chkStatusReasons as $key => $values)
            {
                if ($values)
                {
                    $reasonValue = "txtReasonValue_" . $values;
                    $reasonValue = $this->input->post($reasonValue, TRUE);

                    $data = array(
                        'complaint_id' => $this->input->post('hidCompalintID', TRUE),
                        'status_id' => $this->input->post('selCompalintStatus', TRUE),
                        'reason_id' => $values,
                        'reason_value' => $reasonValue
                    );
                    $this->db->insert('save_reason_remarks', $data);
                }
            }
        }
    }

    public function tab_complaint_document($id)
    {
        $complaintInfo = $this->complaint_model->getCompalintInfo($id);
        $this->_data['complaintInfo'] = $complaintInfo;
        $this->_data['getDocuments'] = $this->complaint_model->getComplaintDocument($id);
        $this->_data['complaint_id'] = $id;
        $this->load->view('tab_for_complaint_document', $this->_data);
    }

    public function uploadDocument()
    {
        $this->form_validation->set_rules('document_title', 'Document Title', 'required|trim');
        $this->form_validation->set_rules('complaint_id', 'Complaint', 'required|integer');
        $this->form_validation->set_error_delimiters('<li class="red">', '</li>');

        if (!$_FILES['userfile']['name'])
        {
            echo "<li class='red'>File not selected</li>";
            return FALSE;
        }

        if ($this->form_validation->run() == FALSE)
        {
            echo validation_errors();
            return FALSE;
        } else
        {
            $id = $this->input->post('complaint_id', TRUE);
            $fileData = $this->_doUpload($id);
            //print_r($fileData);            
            if ($fileData)
            {
                $this->_saveDocInfo($fileData);
                echo "<div class='msg-success close'>Document Information Saved and Uploaded Successfully</div>";
            } else
            {
                echo "<div class='msg-error close'>Document Information Saved Failed</div>";
            }
        }
    }

    private function _doUpload($complaint_id)
    {
        $file_path = '';
        if ($_FILES['userfile']['name'])
        {
            // Build file upload path
            $dir_path = $this->config->item('UPLOAD_ROOT_DIR') . $complaint_id;
            $this->common->make_dir($dir_path, 0766);
            $upload_path = $this->config->item('UPLOAD_ROOT_DIR') . $complaint_id . "/";
            // image settings
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = $this->config->item('ALLOWED_FILE_TYPE');
            $config['max_size'] = $this->config->item('MAX_ALLOWED_FILE_SIZE');
            $config['overwrite'] = FALSE;
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload())
            {
                echo $this->upload->display_errors('<div class="msg-error close">', '</div>');
                return FALSE;
            } else
            {
                $data = array('upload_data' => $this->upload->data());
                $file_path .= $upload_path . $data['upload_data']['file_name'];
                $data['org_file_path'] = $file_path;
                return $data;
            }
        }
    }

    private function _saveDocInfo($file_data)
    {
        $data = array(
            'intComplaintID' => $this->input->post('complaint_id', TRUE),
            'varDocumentTitle' => $this->input->post('document_title', TRUE),
            'varDocumentDesc' => $this->input->post('document_other_note', TRUE),
            'varFileName' => $file_data['upload_data']['file_name'],
            'varFilePath' => $file_data['org_file_path'],
            'varFileType' => $file_data['upload_data']['file_type'],
            'varFileSize' => $file_data['upload_data']['file_size'],
            'varInsertUser' => $this->session->userdata('sess_nhrc_user_id'),
            'dtInsertDT' => date("Y-m-d H:i:s")
        );
        $this->db->insert('complaint_document', $data);
    }

    public function download($document_id, $complaint_id)
    {
        if ($this->auth->haveEditPermission($complaint_id))
        {
            $this->load->helper('download');
            $docInfo = $this->complaint_model->getComplaintDocumentInfo($document_id, $complaint_id);
            if (count($docInfo) == 1)
            {
                $data = file_get_contents($docInfo->varFilePath); // Read the file's contents
                $name = $docInfo->varFileName;
                force_download($name, $data);
            } else
            {
                return FALSE;
            }
        }
        return FALSE;
    }

    public function deleteDocument($document_id, $complaint_id)
    {
        if ($this->auth->haveEditPermission($complaint_id))
        {
            $this->db->where('id', $document_id);
            $this->db->delete('complaint_document');

            $this->_data['getDocuments'] = $this->complaint_model->getComplaintDocument($complaint_id);
            $this->_data['complaint_id'] = $complaint_id;
            $this->load->view('document_list', $this->_data);
        }
        return FALSE;
    }

    public function showDocList($complaint_id)
    {
        $this->_data['getDocuments'] = $this->complaint_model->getComplaintDocument($complaint_id);
        $this->_data['complaint_id'] = $complaint_id;
        $this->load->view('document_list', $this->_data);
    }

    public function getUpazillaLoad($numid)
    {
        $array["upazillas"] = $this->common->getSubDistricts($numid);
        echo json_encode($array);
    }

    public function getUpazilla($numId)
    {
        if ((int) $numId)
        {
            return $this->common->getSubDistricts($numId);
        }
        return FALSE;
    }

    public function printComplaint($id)
    {
        //for complaint page
        $this->layout->setLayout('layout/complaint_details_layout');
        $this->_data['pageTitle'] = "Print Detail's complaint";
        $this->_data['districtList'] = $this->common->getDistricts();
        $this->_data['complaintType'] = $this->common->getBasicData($this->config->item('COMPALINT_TYPE'));
        $this->_data['methodOfComplaint'] = $this->common->getBasicData($this->config->item('MATHOD_OF_COMP_DELIVERY'));
        $complaintInfo = $this->complaint_model->getCompalintInfo($id);
        $this->_data['complaintInfo'] = $complaintInfo;
        $this->_data['permanentSubDistricts'] = $this->common->getSubDistricts($complaintInfo->permanent_district);
        $this->_data['presentSubDistricts'] = $this->common->getSubDistricts($complaintInfo->present_district);
        //for victim page
        $this->_data['religionList'] = $this->common->getBasicData($this->config->item('RELIGION'));
        $vic_info = $this->_data['victimInformation'] = $this->complaint_model->getVictimInfo($id);
        if ($vic_info)
        {
            $this->_data['victims_name'] = $vic_info[0]['victims_name'];
            $this->_data['victims_father_name'] = $vic_info[0]['victims_father_name'];
            $this->_data['victims_mother_name'] = $vic_info[0]['victims_mother_name'];
            $this->_data['victims_spouse_name'] = $vic_info[0]['victims_spouse_name'];
            $this->_data['victims_sex'] = trim($vic_info[0]['victims_sex']);
            $this->_data['victims_age'] = $vic_info[0]['victims_age'];
            $this->_data['victims_religion'] = $vic_info[0]['victims_religion'];
            $this->_data['victims_number'] = $vic_info[0]['victims_number'];
            $this->_data['victims_indigenous_community'] = $vic_info[0]['victims_indigenous_community'];
            $this->_data['disabled'] = $vic_info[0]['disabled'];
            $this->_data['victims_permanent_village'] = $vic_info[0]['victims_permanent_village'];
            $this->_data['permanent_district'] = $vic_info[0]['permanent_district'];
            $this->_data['permanent_sub_district'] = $vic_info[0]['permanent_sub_district'];
            $this->_data['victims_permanent_phone'] = $vic_info[0]['victims_permanent_phone'];
            $this->_data['victims_permanent_fax'] = $vic_info[0]['victims_permanent_fax'];
            $this->_data['victims_permanent_email'] = $vic_info[0]['victims_permanent_email'];
            $this->_data['victims_present_village'] = $vic_info[0]['victims_present_village'];
            $this->_data['present_district'] = $vic_info[0]['present_district'];
            $this->_data['present_sub_district'] = $vic_info[0]['present_sub_district'];
            $this->_data['victims_present_phone'] = $vic_info[0]['victims_present_phone'];
            $this->_data['victims_present_fax'] = $vic_info[0]['victims_present_fax'];
            $this->_data['victims_present_email'] = $vic_info[0]['victims_present_email'];
            $this->_data['complaint_id'] = $vic_info[0]['complaint_id'];
        }
        $selMethodOfDel = $this->complaint_model->getCompalintMethodOfDelivery($id);
        $selDelArr = array();
        foreach ($selMethodOfDel as $item)
        {
            $selDelArr[] = $item['intDeliveryID'];
        }
        $this->_data['selMethodOfDel'] = $selDelArr;
        $this->_data['get_district'] = $this->common->getDistricts();
        // for analysis
        $vic_info = $this->_data['analysisData'] = $this->complaint_model->get_analysis_information($id);
        if ($vic_info)
        {
            $this->_data['identified_category'] = $vic_info[0]['identified_category'];
            $this->_data['violet_constitution'] = $vic_info[0]['violet_constitution'];
            $this->_data['human_rights_violation'] = $vic_info[0]['human_rights_violation'];
            $this->_data['getAnalysisHRViolationList'] = $this->complaint_model->getComplaintAnalysisHRViolation($id);
            $this->_data['getVolutionList'] = $this->common->getBasicData($this->config->item('KIND_OF_HR_VIOLATION'));
        }
        //for respondent info
        $this->_data['respondent'] = $this->complaint_model->get_respondent_information($id);
        $this->_data['desciplinedForce'] = $this->common->getBasicData($this->config->item('DISCIPLINED_FORCE'));
        $this->_data['againstRespondentType'] = $this->common->getBasicData($this->config->item('AGAINST_RESPONDENT_TYPE'));
        // for Incident Info

        $incident_info = $this->_data['incident_info'] = $this->complaint_model->get_incident_information($id);
        if ($incident_info)
        {
            $this->_data['incident_date'] = date_time_format($incident_info[0]['incident_date'], 'ymd', 'dmy');
            //$this->_data['incident_time'] = $vic_info[0]['incident_time'];
            $this->_data['incident_address'] = $incident_info[0]['incident_address'];
            $this->_data['permanent_district'] = $incident_info[0]['permanent_district'];
            $this->_data['permanent_sub_district'] = $incident_info[0]['permanent_sub_district'];
            $this->_data['incident_description'] = $incident_info[0]['incident_description'];
            $this->_data['case_court'] = $incident_info[0]['case_court'];
            $this->_data['incident_desired_remedy'] = $incident_info[0]['incident_desired_remedy'];
            list($hrs, $min, $ampm) = explode(":", $incident_info[0]['incident_time']);
            $this->_data['selTimeHr'] = $hrs;
            $this->_data['selTimeMin'] = $min;
            $this->_data['selTimeAMPM'] = $ampm;
            $this->_data['sub_district_info'] = $this->common->getSubDistricts($this->_data['permanent_district']);
        }
        // for complaint document

        $this->_data['getDocuments'] = $this->complaint_model->getComplaintDocument($id);

        //for total view
        $this->layout->view('printTotalComplaint', $this->_data);
    }

}