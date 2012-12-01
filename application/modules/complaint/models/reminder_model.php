<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reminder_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllCompalintReminder($params)
    {
        if(! is_array($params) && count($params) == 0)
        {
            return;
        }        
        
        $sql = "SELECT
                    reminder.id,
                    reminder.dtStartRemindDT,
                    reminder.dtEndRemindDT,
                    reminder.varRemindText,
                    reminder.enmRemindTo,
                    reminder.intComplaintID,
                    reminder.intUserID,
                    reminder.dtInsertDT,
                    reminder.enmStatus,
                    reminder.lastUDT,
                    users.varFullName,
                    users.varDesignation,
                    desk.`name` AS desk_name
                FROM
                    reminder
                    INNER JOIN users ON users.id = reminder.intUserID
                    INNER JOIN desk ON desk.desk_id = users.intDeskID
                WHERE
                    reminder.enmStatus = 'active'";

        $binds = array();
        if (isset($params['complaint_id']) && $params['complaint_id'] != "")
        {
            $sql .= " AND reminder.intComplaintID = ?";
            $binds[] = $params['complaint_id'];
        }
        
        if (isset($params['user_id']) && $params['user_id'] != "" &&
            isset($params['desk_id']) && $params['desk_id'] != "")
        {
            $sql .= " AND (reminder.intUserID = ? OR desk.desk_id = ?)";
            $binds[] = $params['user_id'];
            $binds[] = $params['desk_id'];    
        }
        
        if (isset($params['dashboard']) && $params['dashboard'] == "yes")
        {
            $sql .= " AND ((NOW() BETWEEN reminder.dtStartRemindDT AND reminder.dtEndRemindDT) 
                    OR (reminder.dtStartRemindDT BETWEEN DATE_SUB(NOW(), INTERVAL 24 HOUR) AND NOW()))";
        }

        $sql .= " ORDER BY  reminder.dtInsertDT DESC";

        return $this->db->query($sql, $binds)->result_array();
    }

    public function setReminderStatus($id)
    {
        $this->db->where('id', $id);
        $this->db->where('intUserID', $this->session->userdata('sess_nhrc_user_id'));
        $this->db->set('enmStatus', 'inactive');
        $this->db->update('reminder');
        return $this->db->affected_rows();
    }

}