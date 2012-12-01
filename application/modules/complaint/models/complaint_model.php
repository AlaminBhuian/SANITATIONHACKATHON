<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * complaint_model
 */
class complaint_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
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
	
	public function add_information ( $arData )
    {
		/*echo "<pre>";
		print_r($arData);
		exit;*/
		
       $strMaster=sprintf("INSERT INTO survey_master (district_id,sub_districtid)  VALUES('%s','%s')", $arData[ 12 ] , $arData[ 13 ] );
			
			$query2 = $this->db->query ( $strMaster );
			

            $strSql = sprintf ( "INSERT INTO survey_detials 	(birth_id_number,
																 name,
																 father_name,
																 mother_name,
																 date_of_birth,
																 sex,
																 address,
																 survay_date,
																 literacy,
																 status_of_vaccination,
																 is_disable,
																 is_polio)
          					VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')" ,
                            $arData[ 0 ] , $arData[ 1 ] , $arData[ 2 ] , $arData[ 3 ] , $arData[ 4 ] , $arData[ 5 ] , 
							$arData[ 6 ] , $arData[ 7 ] , $arData[ 8 ] , $arData[ 9 ] , $arData[ 10 ] , $arData[ 11 ] );
            if($query = $this->db->query ( $strSql ))
			{
				return true;
			}
			
			
      
    }
	
    public function saveChild($data)
    {
		$childData = array(
                    'birth_id_number' => $data['birth_register_date'],
					'name'=>$data['name'],
					'father_name'=>$data['father_name'],
					'mother_name'=>$data['mother_name'],
					'date_of_birth'=>$data['date_of_birth'],
					'sex'=>$data['sex'],
					'address'=>$data['address'],
					'survay_date'=>$data['survey_date'],
					'literacy'=>$data['literacy'],
					'status_of_vaccination'=>$data['is_vaccination'],
					'is_disable'=>$data['disabled'],
					'is_polio'=>$data['is_polio_infected']
					                );
		$childMaster = array(
					 'district_id'=>$data['permanent_district'],
					'sub_districtid'=>$data['permanent_sub_district']
							 );
		$this->db->insert('survey_master', $childMaster);
        if ($this->db->insert_id())
        {
			$this->db->insert('survey_detials', $childData);
			if ($this->db->insert_id())
        		{
         	   		return $this->db->insert_id();
				}
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

    public function UpdateComplainant($data, $id)
    {        
        if (!$id)
        {
            return FALSE;
        }

        $this->db->where('complaint_id', $id);
        $this->db->update('complaint', $data);
        if ($this->db->affected_rows())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    public function updateComplaintData($data, $id)
    {        
        if (!$id)
        {
            return FALSE;
        }

        $this->db->where('complaint_id', $id);
        $this->db->update('complaint', $data);
        if ($this->db->affected_rows())
        {
            return TRUE;
        }
        return FALSE;
    }

    public function getCompalintMethodOfDelivery($id)
    {
        $this->db->select('intComplaintID, intDeliveryID');
        $this->db->where('intComplaintID', $id);
        return $this->db->get('complaint_delivery_method')->result_array();
    }

	public function show_all_data()
    {
        $this->db->select('*');
        $this->db->from('survey_detials');
        return $this->db->get()->result_array();
    }

    public function getVictimInfo($id)
    {
        $this->db->where('complaint_id', $id);
        return $this->db->get('victim_information')->result_array();
    }

    public function get_incident_information($id)
    {
        $this->db->where('complaint_id', $id);
        return $this->db->get('incident_info')->result_array();
    }

    public function getProcessStatus($status_id, $desk_id)
    {
        $sql = "SELECT
                    `status`.status_id,
                    `status`.`name`,
                    `status`.`mode`
                FROM
                    status_path
                    INNER JOIN `status` ON `status`.status_id = status_path.next_status_id
                WHERE
                    `status`.`status` = 'Active' AND
                    status_path.present_status_id = ? AND
                    status_path.present_desk_id = ?";
        $binds = array($status_id, $desk_id);
        return $this->db->query($sql, $binds)->result_array();
    }

    public function getProcessDesks($status_id, $desk_id)
    {
        $sql = "SELECT
                    desk.desk_id,
                    desk.`name`
                FROM
                    desk_path
                    INNER JOIN desk ON desk.desk_id = desk_path.next_desk_id
                WHERE
                    desk.`status` = 'Active' AND
                    desk_path.status_id = ? AND
                    desk_path.present_desk_id = ?
                ORDER BY desk_path.sort_order ASC";
        $binds = array($status_id, $desk_id);
        return $this->db->query($sql, $binds)->result_array();
    }

    public function getStatusReason($status_id)
    {
        $cacheData = "cacheStatusReason_" . $status_id;
        if (!$rs = $this->cache->get($cacheData))
        {
            $this->db->select('reason_remarks_id, name, status_id, is_value');
            $this->db->where("status_id", $status_id);
            $this->db->order_by("name", "ASC");
            $rs = $this->db->get('reason_remarks')->result_array();
            $this->cache->save($cacheData, $rs);
        }
        return $rs;
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

    public function saveVictimInformation($data, $id)
    {
        if (!$id)
        {
            return FALSE;
        }
        $this->db->where('complaint_id', $id);
        $Q = $this->db->get('victim_information')->num_rows();
        if ($Q > 0)
        {
            
            $this->db->where('complaint_id', $id);
            $this->db->set('varEditUser', $this->session->userdata('sess_nhrc_user_id'));
            $this->db->update('victim_information', $data);
            $F = $this->db->affected_rows();
            
        } else
        {
            $this->db->set('varInsertUser', $this->session->userdata('sess_nhrc_user_id'));
            $this->db->set('dtInsertDT', date("Y-m-d H:i:s"));
            $this->db->set('complaint_id', $id);
            $this->db->insert('victim_information', $data);
            $F = $this->db->insert_id();
        }

        if ($F)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function saveRespondentInformation($data, $id)
    {
        if (!$id)
        {
            return FALSE;
        }
        $this->db->where('complaint_id', $id);
        $Q = $this->db->get('respondent_info')->num_rows();
        if ($Q > 0)
        {
            $this->db->where('complaint_id', $id);
            $this->db->update('respondent_info', $data);
            $F = $this->db->affected_rows();
        } else
        {
            $this->db->set('complaint_id', $id);
            $this->db->insert('respondent_info', $data);
            $F = $this->db->insert_id();
        }

        if ($F)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function get_respondent_information($id)
    {
        $this->db->where('complaint_id', $id);
        return $this->db->get('respondent_info')->result_array();
    }

    public function saveIncidentInformation($data, $id)
    {
        if (!$id)
        {
            return FALSE;
        }
        $this->db->where('complaint_id', $id);

        $Q = $this->db->get('incident_info')->num_rows();
        if ($Q > 0)
        {
            $this->db->where('complaint_id', $id);
            $this->db->set('varEditUser', $this->session->userdata('sess_nhrc_user_id'));
            $this->db->update('incident_info', $data);
            $F = $this->db->affected_rows();
        } else
        {
            $this->db->set('varInsertUser', $this->session->userdata('sess_nhrc_user_id'));
            $this->db->set('dtInsertDT', date("Y-m-d H:i:s"));
            $this->db->set('complaint_id', $id);
            $this->db->insert('incident_info', $data);
            $F = $this->db->insert_id();
        }

        if ($F)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function saveComplaintAnalysis($data, $id)
    {
        if (!$id)
        {
            return FALSE;
        }
        $this->db->where('complaint_id', $id);

        $Q = $this->db->get('complaint_analysis')->num_rows();
        if ($Q > 0)
        {
            $this->db->where('complaint_id', $id);
            $this->db->set('varEditUser', $this->session->userdata('sess_nhrc_user_id'));
            $this->db->update('complaint_analysis', $data);
            $F = $this->db->affected_rows();
        } else
        {
            $this->db->set('complaint_id', $id);
            $this->db->set('varInsertUser', $this->session->userdata('sess_nhrc_user_id'));
            $this->db->set('dtInsertDT', date("Y-m-d H:i:s"));
            $this->db->insert('complaint_analysis', $data);
            $F = $this->db->insert_id();
        }

        if ($F)
        {
            return TRUE;
        }
        return FALSE;
    }
    
    public function getComplaintAnalysisHRViolation($complaint_id)
    {
        $this->db->where('complaint_id', $complaint_id);
        return $this->db->get('complaint_analysis_hrviolation')->result_array();
    }

    public function getComplaintDocument($complaint_id)
    {
        $this->db->where('intComplaintID', $complaint_id);
        return $this->db->get('complaint_document')->result_array();
    }

    public function getComplaintDocumentInfo($doc_id, $complaint_id)
    {
        $this->db->where('id', $doc_id);
        $this->db->where('intComplaintID', $complaint_id);
        return $this->db->get('complaint_document')->row();
    }

    /////////////////***************************************//////////////////////


    public function submit_complaint_doccument($data)
    {
        $this->db->insert('complaint_doccument', $data);
        $id = $this->db->insert_id();
        return true;
    }

    public function get_analysis_information($data)
    {
        //$result = array();
        //$this->db->select('*');
        //$this->db->from('complaint_analysis');
        $this->db->where('complaint_id', $data);
        $q = $this->db->get('complaint_analysis');
        if ($q->num_rows > 0)
        {
            return $q->result_array();
        } else
        {
            return FALSE;
        }
    }

    public function get_success_information($data)
    {
        $result = array();
        $this->db->select('traking_number');
        $this->db->from('complaint');
        $this->db->where('complaint_id', $data);
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

    public function get_complaint_info($limit, $offset)
    {
        if (($limit > 0))
        {
            $this->db->limit($limit, $offset);
        }
        // $this->db->order_by("order", "asc");
        return $this->db->get('complaint');
    }

    public function select_single_user_info($id)
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('complaint');
        $this->db->where('complaint_id', $id);
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


    public function getCompalintList($count = 'no', $limit = -1, $offset = NULL)
    {
        $sql = "SELECT ";
        //count total rows
        if ($count === 'yes')
        {
            $sql .= " COUNT(complaint.complaint_id) AS total_rows";
        } else
        {
            $sql .= "complaint.complaint_id,
                    complaint.complainant_id,
                    complaint.traking_number,
                    complaint.complaint_name,
                    complaint.complaint_received_date,
                    complaint.previous_status,
                    complaint.present_status,
                    complaint.previous_desk,
                    complaint.present_desk,
                    complaint.last_opt_user_id,
                    complaint.dtLastUDT as last_udt,
                    s1.`name` AS present_status,
                    s2.`name` AS previous_status,
                    d1.`name` AS previous_desk,
                    d2.`name` AS present_desk,
                    users.varFullName,
                    users.varDesignation,
                    victim_information.victims_name
                    ";
        }

        $sql .= " FROM
                    complaint
                    LEFT JOIN `status` AS s1 ON s1.status_id = complaint.present_status
                    LEFT JOIN `status` AS s2 ON s2.status_id = complaint.previous_status
                    LEFT JOIN desk AS d1 ON d1.desk_id = complaint.previous_desk
                    LEFT JOIN desk AS d2 ON d2.desk_id = complaint.present_desk
                    INNER JOIN users ON users.id = complaint.last_opt_user_id
                    LEFT JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
                WHERE 1=1";

        $binds = array();
        $params['filterParams'] = $this->session->userdata('myDeskSearchParam');
        // by present desk
        if (isset($params['filterParams']['deskID']) && $params['filterParams']['deskID'] != "")
        {
            $sql .= " AND complaint.present_desk = ?";
            $binds[] = $params['filterParams']['deskID'];
        }
        // by complaint type
        if (isset($params['filterParams']['complaintType']) && $params['filterParams']['complaintType'] != "")
        {
            $sql .= " AND complaint.complainant_id = ?";
            $binds[] = $params['filterParams']['complaintType'];
        }
        // by assign date
        if ((isset($params['filterParams']['dateFrom']) && $params['filterParams']['dateFrom'] != "") &&
                (isset($params['filterParams']['dateTo']) && $params['filterParams']['dateTo'] != ""))
        {
            $sql .= " AND DATE_FORMAT(complaint.dtLastUDT, '%Y-%m-%d') BETWEEN ? AND ?";
            $binds[] = $params['filterParams']['dateFrom'];
            $binds[] = $params['filterParams']['dateTo'];
        } else if (isset($params['filterParams']['dateFrom']) && $params['filterParams']['dateFrom'] != "")
        {
            $sql .= " AND DATE_FORMAT(complaint.dtLastUDT, '%Y-%m-%d') = ?";
            $binds[] = $params['filterParams']['dateFrom'];
        }
        // by present status
        if (isset($params['filterParams']['compalintStatus']) && $params['filterParams']['compalintStatus'] != "")
        {
            $sql .= " AND complaint.present_status = ?";
            $binds[] = $params['filterParams']['compalintStatus'];
        }
        // by compalint received date
        if ((isset($params['filterParams']['recDateFrom']) && $params['filterParams']['recDateFrom'] != "") &&
                (isset($params['filterParams']['recDateTo']) && $params['filterParams']['recDateTo'] != ""))
        {
            $sql .= " AND DATE_FORMAT(complaint.complaint_received_date, '%Y-%m-%d') BETWEEN ? AND ?";
            $binds[] = $params['filterParams']['recDateFrom'];
            $binds[] = $params['filterParams']['recDateTo'];
        } else if (isset($params['filterParams']['recDateFrom']) && $params['filterParams']['recDateFrom'] != "")
        {
            $sql .= " AND DATE_FORMAT(complaint.complaint_received_date, '%Y-%m-%d') = ?";
            $binds[] = $params['filterParams']['recDateFrom'];
        }

        // by complaint tracking number
        if (isset($params['filterParams']['trackingNo']) && $params['filterParams']['trackingNo'] != "")
        {
            $sql .= " AND complaint.traking_number = ?";
            $binds[] = $params['filterParams']['trackingNo'];
        }
        if (isset($params['filterParams']['complaintName']) && $params['filterParams']['complaintName'] != "")
        {
            $sql .= " AND complaint.complaint_name LIKE '%".addslashes($params['filterParams']['complaintName'])."%'";
            
        }
        if (isset($params['filterParams']['victimsName']) && $params['filterParams']['victimsName'] != "")
        {
            $sql .= " AND victim_information.victims_name LIKE '%".addslashes($params['filterParams']['victimsName'])."%'";
            
        }

        $sql .= " ORDER BY complaint.dtLastUDT DESC";

        if ($limit != -1)
        {
            $sql .= " LIMIT $offset, $limit";
        }

        return $this->db->query($sql, $binds);
    }

}
