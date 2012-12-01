<?php

class Reminder extends Auth_Controller
{

    private $_data;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('reminder_model', 'reminder');
        $this->layout->setLayout('layout/dashboard_layout');
        //$this->output->enable_profiler(TRUE);         
    }

    public function add($id)
    {
//        if (!$this->auth->havePermission('REMINDER'))
//        {
//            redirect(site_url());
//        }
        $this->load->model('complaint_model');
        $this->_data['complaint_id'] = $id;
        $params['complaint_id'] = $id;
        $this->_data['reminderList'] = $this->reminder->getAllCompalintReminder($params);
        $this->load->view('reminder_add', $this->_data);
    }

    public function saveReminder()
    {
//        if (!$this->auth->havePermission('REMINDER', $this->session->userdata('sess_nhrc_user_desg')))
//        {
//            redirect(site_url());
//        }
        $txtReminderNote = $this->input->post('txtReminderNote', TRUE);
        $txtAlertDT = $this->input->post('txtAlertDT', TRUE);
        $selAlertTimeHr = $this->input->post('selAlertTimeHr', TRUE);
        $selAlertTimeMin = $this->input->post('selAlertTimeMin', TRUE);
        $selAlertTimeAMPM = $this->input->post('selAlertTimeAMPM', TRUE);
        $txtEndDate = $this->input->post('txtEndDate', TRUE);
        $selEndTimeHr = $this->input->post('selEndTimeHr', TRUE);
        $selEndTimeMin = $this->input->post('selEndTimeMin', TRUE);
        $selEndTimeAMPM = $this->input->post('selEndTimeAMPM', TRUE);
        $selRemindTo = $this->input->post('selRemindTo', TRUE);
        $complaint_id = $this->input->post('complaint_id', TRUE);
        $txtReminderNote = array_unique($txtReminderNote);
        foreach ($txtReminderNote as $key => $values)
        {
            if ($values)
            {
                if ($values == "" || $txtAlertDT[$key] == "")
                {
                    continue;
                }
                if (isset($txtAlertDT[$key]) && $txtAlertDT[$key] != "")
                {
                    $alertDT = date_time_format($txtAlertDT[$key], 'ymd', 'dmy');
                    if ($selAlertTimeAMPM[$key] == 'PM')
                    {
                        $selAlertTimeHr[$key] += 12;
                    }
                    $alertTime = $selAlertTimeHr[$key] . ":" . $selAlertTimeMin[$key] . ":00 ";
                    $alertDT .= " " . $alertTime;
                }
                if (isset($txtEndDate[$key]) && $txtEndDate[$key] != "")
                {
                    $endDT = date_time_format($txtEndDate[$key], 'ymd', 'dmy');
                    if ($selEndTimeAMPM[$key] == 'PM')
                    {
                        $selEndTimeHr[$key] += 12;
                    }
                    $endAlertTime = $selEndTimeHr[$key] . ":" . $selEndTimeMin[$key] . ":00";
                    $endDT .= " " . $endAlertTime;
                    $this->db->set('dtEndRemindDT', $endDT);
                }
                $data = array(
                    'dtStartRemindDT' => $alertDT,
                    'varRemindText' => $txtReminderNote[$key],
                    'enmRemindTo' => $selRemindTo[$key],
                    'intComplaintID' => $complaint_id,
                    'intUserID' => $this->session->userdata('sess_nhrc_user_id'),
                    'dtInsertDT' => date("Y-m-d H:i:s")
                );
                if (is_array($data) && count($data) > 0)
                {
                    $this->db->insert('reminder', $data);
                }
            }
        }
        if ($this->db->insert_id())
        {
            echo "<div class='msg-success close'>Reminder Set Successfully</div>";
        } else
        {
            //echo "<div class='information close'>Reminder Set Failed</div>";
        }
    }

    public function removeReminder($id)
    {
        if (!$this->auth->havePermission('REMINDER'))
        {
            redirect(site_url());
        }
        $this->reminder->setReminderStatus($id);
    }

    public function show()
    {
        if (!$this->auth->havePermission('REMINDER'))
        {
            redirect(site_url());
        }
        $this->_data['pageTitle'] = 'My Reminders';
        $params['user_id'] = $this->session->userdata('sess_nhrc_user_id');
        $params['desk_id'] = $this->session->userdata('sess_nhrc_desk_id');
        $this->_data['reminderList'] = $this->reminder->getAllCompalintReminder($params);
        $this->layout->view('reminder_main_list', $this->_data);
    }

    public function addreminder()
    {
        if (!$this->auth->havePermission('REMINDER'))
        {
            redirect(site_url());
        }
        $this->_data['pageTitle'] = 'Add My Reminder';
        $this->_data['complaint_id'] = 0;
        $this->layout->view('reminder_main_add', $this->_data);
    }

    public function dashboardReminderList()
    {
        $params['user_id'] = $this->session->userdata('sess_nhrc_user_id');
        $params['desk_id'] = $this->session->userdata('sess_nhrc_desk_id');
        $params['dashboard'] = 'yes';
        $this->_data['reminderList'] = $this->reminder->getAllCompalintReminder($params);
        $this->load->view('reminder_list', $this->_data);
    }

}