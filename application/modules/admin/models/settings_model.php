<?php

class Settings_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function submit_add_status($data)
    {

        $this->db->select('name');
        $this->db->from('status');
        $this->db->where('name', $data['name']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->insert('status', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }
    
    

    public function submit_reason_remarks($data)
    {

        $this->db->select('*');
        $this->db->from('reason_remarks');
        $this->db->where('name', $data['name']);
        $this->db->where('status_id', $data['status_id']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->insert('reason_remarks', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    public function submit_user_entry($data)
    {

        $this->db->select('varUserName');
        $this->db->from('users');
        $this->db->where('varUserName', $data['varUserName']);
        $this->db->where('intDeskID', $data['intDeskID']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->insert('users', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    public function submit_edit_user($data)
    {

        $this->db->select('varUserName');
        $this->db->from('users');
        $this->db->where('varUserName', $data['varUserName']);
        $this->db->where('intDeskID', $data['intDeskID']);
        $this->db->where('id !=', $data['id']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->where('id', $data['id']);
            $id = $this->db->update('users', $data);
            return $id;
        }
    }

    public function submit_edit_setup_besic_sub_data($data)
    {

        $this->db->select('intBasicCategoryId, varName');
        $this->db->from('basic_data');
        $this->db->where('intBasicCategoryId', $data['intBasicCategoryId']);
        $this->db->where('varName', $data['varName']);
        $this->db->where('id !=', $data['id']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->where('id', $data['id']);
            $id = $this->db->update('basic_data', $data);
            return $id;
        }
    }

    public function submit_edit_reason_remarks($data)
    {
        $this->db->select('*');
        $this->db->from('reason_remarks');
        $this->db->where('name', $data['name']);
        $this->db->where('reason_remarks_id !=', $data['reason_remarks_id']);
        $this->db->where('status_id', $data['status_id']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->where('reason_remarks_id', $data['reason_remarks_id']);
            $this->db->update('reason_remarks', $data);
            return true;
        }
    }

    public function submit_edit_desk($data)
    {
        $this->db->select('*');
        $this->db->from('desk');
        $this->db->where('name', $data['name']);
        $this->db->where('desk_id !=', $data['desk_id']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->where('desk_id', $data['desk_id']);
            $this->db->update('desk', $data);
            return true;
        }
    }

    public function submit_edit_sub_district($data)
    {

        $this->db->select('*');
        $this->db->from('sub_district');
        $this->db->where('sub_district_name', $data['sub_district_name']);
        $this->db->where('district_id', $data['district_id']);
        $this->db->where('sub_district_id !=', $data['sub_district_id']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->where('sub_district_id', $data['sub_district_id']);
            $this->db->update('sub_district', $data);
            return true;
        }
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

    public function get_sub_district_list($limit, $offset)
    {
        if (($limit > 0))
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by("district_id", "asc");
        $this->db->order_by("sub_district_name", "asc");
        return $this->db->get('sub_district');
    }

    public function submit_edit_district($data)
    {

        $this->db->select('*');
        $this->db->from('district');
        $this->db->where('district_name', $data['district_name']);
        $this->db->where('district_id !=', $data['district_id']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->where('district_id', $data['district_id']);
            $this->db->update('district', $data);
            return true;
        }
    }

    public function submit_status_path($data)
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('status_path');
        $this->db->where('present_status_id', $data['present_status_id']);
        $this->db->where('present_desk_id', $data['present_desk_id']);
        $this->db->where('next_status_id', $data['next_status_id']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->insert('status_path', $data);
            return true;
        }
    }

    public function submit_desk_path($data)
    {

        $result = array();
        $this->db->select('*');
        $this->db->from('desk_path');
        $this->db->where('status_id', $data['status_id']);
        $this->db->where('present_desk_id', $data['present_desk_id']);
        $this->db->where('next_desk_id', $data['next_desk_id']);
        $q = $this->db->get();

        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->insert('desk_path', $data);
            return true;
        }
    }

    public function submit_edit_status_path($data, $id)
    {
        $result = array();
        $this->db->from('status_path');
        $this->db->where('present_status_id', $data['present_status_id']);
        $this->db->where('present_desk_id', $data['present_desk_id']);
        $this->db->where('next_status_id', $data['next_status_id']);
        $this->db->where('next_status_id !=', $id);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->where('present_status_id', $data['present_status_id']);
            $this->db->where('present_desk_id', $data['present_desk_id']);
            $this->db->where('next_status_id', $id);
            $update = $this->db->update('status_path', $data);
            return $update;
        }
    }

    public function submit_edit_desk_path($data, $id)
    {

        $result = array();
        $this->db->from('desk_path');
        $this->db->where('status_id', $data['status_id']);
        $this->db->where('present_desk_id', $data['present_desk_id']);
        $this->db->where('next_desk_id', $data['next_desk_id']);
        $this->db->where('next_desk_id !=', $id);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->where('status_id', $data['status_id']);
            $this->db->where('present_desk_id', $data['present_desk_id']);
            $this->db->where('next_desk_id', $id);
            $update = $this->db->update('desk_path', $data);
            return $update;
        }
    }

    public function search_status_path($status_id, $desk_id, $limit, $offset)
    {
        $result = array();
        $sql = "SELECT
	status_path.present_status_id
	, status_path.present_desk_id
	, status_path.next_status_id
	, s1.name AS present_status
	, s2.name AS next_status
	, desk.name AS present_desk
	FROM
	`status` s1
	INNER JOIN status_path 
	ON (s1.status_id = status_path.present_status_id)
	INNER JOIN desk 
	ON (desk.desk_id = status_path.present_desk_id)
	INNER JOIN `status` s2
	ON (s2.status_id = status_path.next_status_id)
	";
        $binds = array();
        if ($status_id != 0 && $desk_id != 0)
        {
            $sql .= "Where status_path.present_status_id = ?";
            $sql .= " AND status_path.present_desk_id = ?";
            $binds[] = $status_id;
            $binds[] = $desk_id;
        } elseif ($status_id != 0 && $desk_id == 0)
        {
            $sql .= "Where status_path.present_status_id = ?";
            $binds[] = $status_id;
        } elseif ($status_id == 0 && $desk_id != 0)
        {
            $sql .= "WHERE status_path.present_desk_id = ?";
            $binds[] = $desk_id;
        }
        if (($limit > 0))
        {
            $sql .= " LIMIT $offset, $limit";
        }
        return $this->db->query($sql, $binds);
    }

    public function search_desk_path($status_id, $desk_id, $limit, $offset)
    {
        $result = array();
        $sql = "SELECT
        desk_path.status_id        
	, desk_path.present_desk_id
	, desk_path.next_desk_id
	, s1.name AS present_status
	, s2.name AS next_desk
	, desk.name AS present_desk
	FROM
	`status` s1
	INNER JOIN desk_path 
	ON (s1.status_id = desk_path.status_id)
	INNER JOIN desk 
	ON (desk.desk_id = desk_path.present_desk_id)
	INNER JOIN `desk` s2
	ON (s2.desk_id = desk_path.next_desk_id)	
	";
        $binds = array();
        if ($status_id != 0 && $desk_id != 0)
        {
            $sql .= "WHERE desk_path.`status_id` = ?";
            $sql .= "AND desk_path.`present_desk_id` = ?";
            $binds[] = $status_id;
            $binds[] = $desk_id;
        } elseif ($status_id != 0 && $desk_id == 0)
        {
            $sql .= "WHERE desk_path.`status_id` = ?";
            $binds[] = $status_id;
        } elseif ($status_id == 0 && $desk_id != 0)
        {
            $sql .= "WHERE desk_path.`present_desk_id` = ?";
            $binds[] = $desk_id;
        }
        $sql.="ORDER BY present_desk_id, sort_order ASC";
        if (($limit > 0))
        {
            $sql .= " LIMIT $offset, $limit";
        }
        return $this->db->query($sql, $binds);
    }

    public function get_all_besic_data($limit, $offset)
    {

        $sql = "SELECT
          basic_category.id
	, basic_category.varCategoryName
	, basic_data.id As besic_id
        , basic_data.intBasicCategoryId
        , basic_data.varName					
	FROM					
	basic_data, basic_category 
	WHERE 
	basic_category.id = basic_data.intBasicCategoryId
	ORDER BY basic_category.id ASC";

        if (($limit > 0))
        {
            $sql .= " LIMIT $offset, $limit";
        }


        $rs = $this->db->query($sql);
        $result = $rs->result_array();
        return $result;
    }

    public function search_besic_data($data, $limit, $offset)
    {

        $sql = "SELECT
          basic_category.id
	, basic_category.varCategoryName
	, basic_data.id As besic_id
        , basic_data.intBasicCategoryId
        , basic_data.varName
        , basic_data.enuStatus
        
	FROM					
	basic_data, basic_category 
	WHERE 
	basic_category.id = basic_data.intBasicCategoryId        
        ";
        $binds = array();
        if ($data != 0)
        {
            $sql .= "AND
	basic_data.intBasicCategoryId =?";
            $binds[] = $data;
        }
        $sql .= "ORDER BY basic_category.varCategoryName ASC,basic_data.sortOrder ASC";
        if (($limit > 0))
        {
            $sql .= " LIMIT $offset, $limit";
        }
        return $this->db->query($sql, $binds);
    }

   public function search_reason_remarks($status_id = 0 , $reason_remarks = "search", $limit, $offset)
    {
//       echo "<pre>";
//       print_r($status_id);
//       print_r($reason_remarks);
//       exit();
        $sql = "SELECT 
            reason_remarks.reason_remarks_id
            ,status.name AS statusName
            ,reason_remarks.name
            FROM					
            reason_remarks, status
            WHERE
            status.status_id = reason_remarks.status_id             
            
            ";
        $binds = array();
        if ($status_id != 0)
        {
            $sql .= "AND reason_remarks.status_id = ?";
            $binds[] = $status_id;
        }
        if ($reason_remarks !="search")
        {
            $sql .= "AND
            reason_remarks.name LIKE '%".addslashes($reason_remarks)."%'
                ";
            
        }
        
        $sql .= "ORDER BY status.name ASC";
        if (($limit > 0))
        {
            $sql .= " LIMIT $offset, $limit";
        }
        return $this->db->query($sql, $binds);
    }

    public function search_sub_district($data, $limit, $offset)
    {



        $sql = "SELECT
          district.district_name
	, sub_district.sub_district_name
	, sub_district.sub_district_id
        				
	FROM					
	district, sub_district 
	WHERE
        district.district_id = sub_district.district_id
        
        ";
        $binds = array();
        if ($data != 0)
        {
            $sql .= "AND
	district.district_id =?
        AND
        sub_district.district_id =? ";
            $binds[] = $data;
            $binds[] = $data;
        }
        $sql .= "ORDER BY sub_district.sub_district_name ASC";
        if (($limit > 0))
        {
            $sql .= " LIMIT $offset, $limit";
        }
        return $this->db->query($sql, $binds);
    }

    public function get_district1($limit, $offset)
    {
        if (($limit > 0))
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by("district_name", "asc");
        return $this->db->get('district');
    }

    public function delete_user($id)
    {
        if($id != 1){
        $this->db->where('id', $id);
        $id = $this->db->delete('users');
        return $id;
        }
        else
        {
            return FALSE;
        }
    }

    public function delete_desk($id)
    {
        if($id != 1){
        $this->db->where('desk_id', $id);
        $id = $this->db->delete('desk');
        return $id;
         }
        else
        {
            return FALSE;
        }
    }

    public function delete_reason_remarks($id)
    {
        $this->db->where('reason_remarks_id', $id);
        $id = $this->db->delete('reason_remarks');
        return $id;
    }

    public function delete_besic_data($id)
    {
        $this->db->where('id', $id);
        $id = $this->db->delete('basic_data');
        return $id;
    }

    public function delete_sub_district($id)
    {
        $this->db->where('sub_district_id', $id);
        $id = $this->db->delete('sub_district');
        return $id;
    }

    public function delete_district($id)
    {
        $this->db->select('district_id');
        $this->db->from('sub_district');
        $this->db->where('district_id', $id);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->where('district_id', $id);
            $id = $this->db->delete('district');
            return $id;
        }
    }

    public function delete_status($id)
    {
        $this->db->select('status_id');
        $this->db->from('reason_remarks');
        $this->db->where('status_id', $id);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->where('status_id', $id);
            $id = $this->db->delete('status');
            return $id;
        }
    }

    public function delete_status_path($present_status_id, $present_desk_id, $next_status_id)
    {
        $this->db->where('present_status_id', $present_status_id);
        $this->db->where('present_desk_id', $present_desk_id);
        $this->db->where('next_status_id', $next_status_id);
        $id = $this->db->delete('status_path');
        return $id;
    }

    public function delete_desk_path($status_id, $present_desk_id, $next_desk_id)
    {
        $this->db->where('status_id', $status_id);
        $this->db->where('present_desk_id', $present_desk_id);
        $this->db->where('next_desk_id', $next_desk_id);
        $id = $this->db->delete('desk_path');
        return $id;
    }

    public function search_user($desk = 0, $search = "", $status = "")
    {       
        $result = array();
        $sql = "SELECT * FROM users 
                WHERE                    
                varFullName LIKE '%" .addslashes($search) . "%'
                    ";
        $binds = array();
        
        if ($desk != 0)
        {
            $sql .= " AND intDeskID = ?";
            $binds[] = $desk;
        } 
        if ($status != "")
        {
            $sql .= " AND enmStatus = ?";
            $binds[] = $status;
        } 
        
        $rs = $this->db->query($sql, $binds);
        $result = $rs->result_array();
        return $result;
    }

    public function get_desk($limit, $offset)
    {
        if (($limit > 0))
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by("name", "asc");
        return $this->db->get('desk');
    }

    public function get_user($limit, $offset)
    {
        if (($limit > 0))
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by("id", "asc");
        return $this->db->get('users');
    }

    public function get_desk1()
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('desk');
        $this->db->order_by("name", "asc");
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

    public function get_role()
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('role');
        $this->db->order_by("id", "asc");
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
    public function searchDeskPathForAdd($present_status, $present_desk)
    {        
        $this->db->select('*');
        $this->db->from('desk_path');
        $this->db->where('present_desk_id', $present_desk);
        $this->db->where('status_id', $present_status);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return  $q->result_array();          
            
        } else
        {
            return false; 
        }
    }
    public function searchStatusPathForAdd($present_status, $present_desk)
    {        
        $this->db->select('*');
        $this->db->from('status_path');
        $this->db->where('present_desk_id', $present_desk);
        $this->db->where('present_status_id', $present_status);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return  $q->result_array();          
            
        } else
        {
            return false; 
        }
    }
    
    

    public function search_status($data, $limit, $offset)
    {
        if (($limit > 0))
        {
            $this->db->limit($limit, $offset);
        }
       if ($data != '0')
        {
            $this->db->like('name', $data);
        }
        $this->db->order_by("name", "asc");
        return $this->db->get('status');
    }

    public function searchRolePrevilizes($data)
    {
        $result = array();
        $this->db->from('role_previlizes');
        $this->db->where('intDeskID', $data);
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

    public function searchDistrict($district, $limit, $offset)
    {

        if (($limit > 0))
        {
            $this->db->limit($limit, $offset);
        }
        if ($district != '0')
        {
            $this->db->like('district_name', $district);
        }

        $this->db->order_by("district_name", "asc");
        return $this->db->get('district');
    }

    public function get_status1($limit, $offset)
    {
        if (($limit > 0))
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by("name", "asc");
        return $this->db->get('status');
    }
    
    
    

    public function get_complain_category()
    {
        $result = array();
        $this->db->select('varName, intBasicCategoryId');
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

    public function get_status()
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('status');
        $this->db->order_by("name", "asc");
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

    public function get_single_user($id)
    {

        $this->db->from('users');
        $this->db->where('id', $id);
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

    public function submit_district($data)
    {

        $this->db->select('district_name');
        $this->db->from('district');
        $this->db->where('district_name', $data['district_name']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->insert('district', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    public function submit_new_desk($data)
    {
        $this->db->select('name');
        $this->db->from('desk');
        $this->db->where('name', $data['name']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->insert('desk', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    public function submit_sub_district($data)
    {

        $this->db->select('*');
        $this->db->from('sub_district');
        $this->db->where('sub_district_name', $data['sub_district_name']);
        $this->db->where('district_id', $data['district_id']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->insert('sub_district', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    public function submit_setup_besic_data($data)
    {

        $this->db->select('*');
        $this->db->from('basic_category');
        $this->db->where('varCategoryName', $data['varCategoryName']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->insert('basic_category', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    public function submit_setup_besic_sub_data($data)
    {

        $this->db->select('*');
        $this->db->from('basic_data');
        $this->db->where('intBasicCategoryId', $data['intBasicCategoryId']);
        $this->db->where('varName', $data['varName']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->insert('basic_data', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    public function submit_edit_status($data)
    {
        $this->db->select('*');
        $this->db->from('status');
        $this->db->where('name', $data['name']);
        $this->db->where('status_id !=', $data['status_id']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            return false;
        } else
        {
            $this->db->where('status_id', $data['status_id']);
            $id = $this->db->update('status', $data);
            return $id;
        }
    }

    public function edit_district($data)
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('district');

        $this->db->where('district_id', $data);
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

    public function edit_besic_data($data)
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('basic_data');
        $this->db->where('id', $data);
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

    public function edit_sub_district($data)
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('sub_district');
        $this->db->where('sub_district_id', $data);
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

    public function edit_desk($data)
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('desk');
        $this->db->where('desk_id', $data);
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

    public function edit_status($data)
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('status');

        $this->db->where('status_id', $data);
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

    public function edit_reason_remarks($data)
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('reason_remarks');
        $this->db->where('reason_remarks_id', $data);
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

    public function get_besic_data()
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('basic_category');
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

    public function get_reason_remarks($id)
    {
        $this->db->select('*');
        $this->db->where('status_id', $id);
        $this->db->order_by("reason_remarks_id", "asc");
        return $this->db->get('reason_remarks')->result_array();
    }

    public function reason_remarks($limit, $offset)
    {
        if (($limit > 0))
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by("status_id", "asc");
        return $this->db->get('reason_remarks');
    }

}

//echo "<pre>";
//        print_r($_POST);
//        exit();

