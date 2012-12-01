<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function login($username, $password)
    {
        $this->db->where('varUserName', $username);
        $this->db->where('varPassword', md5($password));
        $this->db->where('enmStatus', 'active');
        $this->db->limit(1);
        $RS = $this->db->get('users')->row();

        if (count($RS) == 1)
        {
            $this->_setLoginSession($RS);
            $this->_getUserPrivilizes();
            $this->entryAccessLog();
            $this->_setUserLastLogin();
            return TRUE;
        } else
        {
            return FALSE;
        }
    }

    private function _setLoginSession($data)
    {
        $sessUserData = array(
            'sess_nhrc_user_id' => $data->id,
            'sess_nhrc_user_name' => $data->varFullName,
            'sess_nhrc_user_desg' => $data->varDesignation,
            'sess_nhrc_last_login' => $data->dtLastLogin,
            'sess_nhrc_desk_id' => $data->intDeskID
        );

        $this->session->set_userdata($sessUserData);
    }

    private function _getUserPrivilizes()
    {
        return TRUE;
    }

    public function logout()
    {
        $this->entryAccessLogout();
        if ($this->config->item('site.cache'))
        {
            $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            if (!$this->cache->apc->is_supported())
            {
                $this->load->driver('cache', array('adapter' => 'file'));
            }
            
            $cacheData = "cacheUserPrev_" . $this->session->userdata('sess_nhrc_user_id');
            $this->cache->delete($cacheData);            
        }
        $this->session->sess_destroy();
    }

    /*
     * Access log entry
     */

    public function entryAccessLog()
    {
        // access_log table.
        $data = array('user_id' => $this->session->userdata('sess_nhrc_user_id'),
            'login_ip' => $this->input->ip_address(),
            'login_dt' => date("Y-m-d H:i:s"),
            'browser_info' => $this->input->user_agent()
        );

        $this->db->insert('access_log', $data);
        $this->session->set_userdata('sess_nhrc_access_log_id', $this->db->insert_id());
    }

    public function entryAccessLogout()
    {
        $this->db->set('logout_dt', date("Y-m-d H:i:s"));
        $this->db->where('id', $this->session->userdata('sess_nhrc_access_log_id'));
        $this->db->update('access_log');
    }

    private function _setUserLastLogin()
    {
        $this->db->set('dtLastLogin', date("Y-m-d H:i:s"));
        $this->db->where('id', $this->session->userdata('sess_nhrc_user_id'));
        $this->db->update('users');
    }

    /*
     * login check
     */

    public function logincheck()
    {
        if ($this->session->userdata('sess_nhrc_user_id') &&
                $this->session->userdata('sess_nhrc_user_name'))
        {
            return TRUE;
        } else
        {
            redirect(site_url(), 'refresh');
        }
    }

    /*
     * check is seller login
     */

    public function checkAdminLoged()
    {
        if ($this->session->userdata('sess_user_type') === 'admin')
        {
            return TRUE;
        } else
        {
            return FALSE;
        }
    }

    public function account($id)
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

    public function get_desk()
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('desk');
        $this->db->order_by("desk_id", "asc");
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

    public function submitEditUser($data)
    {
        $this->db->where('id', $data['id']);
        $id = $this->db->update('users', $data);
        return $id;
    }

    public function change_password($data)
    {
        $data1 = array(
            'varPassword' => $data['varPassword']
        );
        $this->db->select('id, varPassword');
        $this->db->from('users');
        $this->db->where('id', $data['id']);
        $this->db->where('varPassword', $data['varCurrentPassword']);
        $q = $this->db->get();
        if ($q->num_rows > 0)
        {
            $this->db->where('id', $data['id']);
            $this->db->update('users', $data1);
            $id = $this->db->insert_id();
            return true;
        } else
        {
            return false;
        }
    }

}