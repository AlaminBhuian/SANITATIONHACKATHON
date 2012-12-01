<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getRolePrivilizes($desk_id = NULL)
    {
        $cacheData = "cacheUserPrev_" . $this->session->userdata('sess_nhrc_user_id');
        if (!$rs = $this->cache->get($cacheData))
        {
            $sql = "SELECT
                        role_previlizes.intRoleID
                        , role_previlizes.intDeskID
                        , role.varRole
                    FROM
                        role
                        INNER JOIN role_previlizes 
                            ON (role.id = role_previlizes.intRoleID)
                    WHERE (role_previlizes.intDeskID = ?)";            
            if($desk_id == "") {$desk_id = $this->session->userdata('sess_nhrc_desk_id');}
            
            $binds = array($desk_id);
            $rs = $this->db->query($sql, $binds)->result_array();
            $this->cache->save($cacheData, $rs);
        }
        return $rs;
    }

}