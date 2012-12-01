<?php

class Auth extends Auth_Controller
{

    private $_data;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model');
        //$this->output->enable_profiler(TRUE);              
    }

    public function havePermission($role, $chk_desk=NULL)
    {
        $prevRs = $this->auth_model->getRolePrivilizes($chk_desk);        
        if (!is_array($prevRs))
        {
            return FALSE;
        } else
        {
            $allowPrev = array();
            foreach ($prevRs as $item)
            {
                $allowPrev[] = trim($item['varRole']);
            }
        }         
        if (in_array($role, $allowPrev))
        {
            return TRUE;
        }
        return FALSE;
    }

    public function haveEditPermission($complaint_id)
    {
        // present complaint desk = login user desk        
        $this->load->model('complaint/complaint_model', 'complaint');
        $complaint = $this->complaint->getCompalintInfo($complaint_id);        

        //echo "p desk = ".(int)$complaint->present_desk;
        //echo "<br>U desk = ".(int)$this->session->userdata('sess_nhrc_desk_id');
        //exit;
        if ((int) $complaint->present_desk === (int) $this->session->userdata('sess_nhrc_desk_id'))
        {
            // if present status not 'close' mode
            if ($complaint->mode != 'Close')
            {
                return TRUE;
            }
        }
        return FALSE;
    }

}
