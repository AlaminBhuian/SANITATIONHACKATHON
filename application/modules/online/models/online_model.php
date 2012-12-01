<?php

class Online_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function buildComplaintTrackingNo($preStr = "")
    {
        //build tracking# prefix                
        $preStr .= date("ymd") . "-";
        // get last tracking number
        $query = $this->db->select('traking_number')
                ->like('traking_number', $preStr, 'after')
                ->limit(1)
                ->order_by("traking_number", "DESC")
                ->get('complaint');
        $result = $query->row();
        if ($query->num_rows() == 1)
        {
            $preStr .= $this->increaseNumber($result->{'traking_number'}, strlen($preStr));
        } else
        {
            $preStr .= "0001";
        }
        return $preStr;
    }

    public function increaseNumber($str, $len)
    {

        // split post number and increase 1
        $number = (int) substr($str, $len) + 1;
        // zero fill
        if (strlen((string) $number) == 1)
        {
            return '000' . $number;
        } else if (strlen((string) $number) == 2)
        {
            return '00' . $number;
        } else if (strlen((string) $number) == 3)
        {
            return '0' . $number;
        } else
        {
            return $number;
        }
    }

    public function getCompalintInfo($id)
    {
        $this->db->select('*');
        $this->db->from('complaint');
        $this->db->join('status', 'complaint.present_status = status.status_id');
        $this->db->where('complaint_id', $id);
        return $this->db->get()->row();
    }

    public function get_complain_category()
    {
        $result = array();
        $this->db->select('varName, intBasicCategoryId, id');
        $this->db->from('basic_data');
        $this->db->where('intBasicCategoryId', 4);
        $this->db->or_where('intBasicCategoryId', 1);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            $result = $q->result_array();
            return $result;
        } else
        {
            return $result;
        }
    }

    public function getSubDistricts($district_id)
    {
        //$cacheData = "cacheSubDistricts_" . $district_id;
        //if (!$rs = $this->cache->get($cacheData))
        //{
        $this->db->select('sub_district_id, sub_district_name, district_id');
        $this->db->where("district_id", $district_id);
        $this->db->order_by("sub_district_name", "ASC");
        $rs = $this->db->get('sub_district')->result_array();
        //$this->cache->save($cacheData, $rs);
        //}
        return $rs;
    }

    public function get_district()
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('district');
        $this->db->order_by("district_name", "asc");
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            $result = $q->result_array();
            return $result;
        } else
        {
            return $result;
        }
    }

    public function get_sub_district()
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('sub_district');
        $this->db->order_by("sub_district_name", "asc");
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            $result = $q->result_array();
            return $result;
        } else
        {
            return $result;
        }
    }

    public function chackValidation($trackingNumber)
    {
        $result = array();
        $sql = "SELECT complaint.present_status as status,
            complaint.present_desk as desk,
            complaint.complaint_id as id,
            complaint.complaint_name as name,
            complaint.sex,
            complaint.present_address as address,            
            district.district_name as district,
            sub_district.sub_district_name as sub_district,
            complaint.present_phone as phone,
            complaint.complaint_received_date as date
            
	FROM					
	complaint
        INNER JOIN district ON district.district_id = complaint.present_district
        INNER JOIN sub_district ON sub_district.sub_district_id = complaint.present_sub_district
	WHERE
        traking_number = ?              
        ";
        $binds = array($trackingNumber);
        $rs = $this->db->query($sql, $binds);
        if ($rs->num_rows > 0)
        {
            $result = $rs->result_array();
            return $result;
        } else
        {
            return $result;
        }
    }

    public function saveComplaint($data)
    {
        $this->db->insert('complaint', $data);
        if ($this->db->insert_id())
        {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function saveVictimInformation($data)
    {
        $this->db->insert('victim_information', $data);
        if ($this->db->insert_id())
        {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function saveIncidentInformation($data)
    {
        $this->db->insert('incident_info', $data);
        if ($this->db->insert_id())
        {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function saveRespondentInformation($data)
    {
        $this->db->insert('respondent_info', $data);
        if ($this->db->insert_id())
        {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function getComplaintHistory($complaint_id)
    {
        $sql = "SELECT
                    compaint_details.previous_status_id,
                    s1.`name` AS previous_status,
                    compaint_details.present_status_id,
                    s2.`name` AS present_status,
                    compaint_details.previous_desk_id,
                    d1.`name` AS previous_desk,
                    compaint_details.present_desk_id,
                    d2.`name` AS present_desk,
                    compaint_details.operating_user_id,
                    users.varFullName,
                    users.varDesignation,
                    compaint_details.remarks,
                    compaint_details.complaint_id,
                    compaint_details.lastUDT,
                    compaint_details.complaint_details_id
                 FROM
                    compaint_details
                    LEFT JOIN `status` AS s1 ON s1.status_id = compaint_details.previous_status_id
                    LEFT JOIN `status` AS s2 ON s2.status_id = compaint_details.present_status_id
                    LEFT JOIN desk AS d1 ON d1.desk_id = compaint_details.previous_desk_id
                    LEFT JOIN desk AS d2 ON d2.desk_id = compaint_details.present_desk_id
                    INNER JOIN users ON users.id = compaint_details.operating_user_id
                 WHERE
                    compaint_details.complaint_id = ?
                 ORDER BY
                    compaint_details.lastUDT DESC";
        $binds = array($complaint_id);
        return $this->db->query($sql, $binds)->result_array();
    }

    public function getBasicData($type_id)
    {
       
            $this->db->select('id, intBasicCategoryId, varName');
            $this->db->where("intBasicCategoryId", $type_id);
            $this->db->where("enuStatus", 'active');
            $this->db->order_by("sortOrder", "DESC");
            $this->db->order_by("varName", "ASC");
            $rs = $this->db->get('basic_data')->result_array();           
        return $rs;
    }

}

