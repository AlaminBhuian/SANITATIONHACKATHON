<?php

class Find extends Auth_Controller
{

    private $_data;
    private $_searchParam = array();

    public function __construct()
    {
        parent::__construct();

        $this->load->model('complaint_model', 'complaint');
        $this->load->model('common_settings_model', 'common');
        $this->layout->setLayout('layout/complaint_layout');

        //$this->output->enable_profiler(TRUE);
    }

    public function index()
    {
        redirect('complaint/dashboard');
    }

    public function mydesk()
    {
        if (!$this->auth->havePermission('MYDESK'))
        {
            redirect(site_url());
        }

        $this->_data['pageTitle'] = 'My Desk';
        $this->session->unset_userdata('myDeskSearchParam');
        $this->_searchParam['deskID'] = $this->session->userdata('sess_nhrc_desk_id');
        $this->session->set_userdata('myDeskSearchParam', $this->_searchParam);
        $this->_data['complaintType'] = $this->common->getBasicData($this->config->item('COMPALINT_TYPE'));
        $this->myDeskList();

        $this->layout->view('complaint/mydesk', $this->_data);
    }

    public function myDeskList($mode = NULL, $page = 1)
    {
        if (!$this->auth->havePermission('MYDESK'))
        {
            redirect(site_url());
        }

        $this->_data['pageTitle'] = 'My Desk';
        $perPage = $this->config->item('MYDESK_LIST');

        $T = $this->complaint->getCompalintList('yes')->row();
        $totalRows = $T->total_rows;
        if ($perPage < $totalRows)
        {
            $this->load->library('pagination');
            $config['base_url'] = site_url("complaint/find/myDeskList/list/");
            $config['total_rows'] = $totalRows;
            $config['per_page'] = $perPage;
            $config['uri_segment'] = 5;
            $config['cur_tag_open'] = '<span class="selected">';
            $config['cur_tag_close'] = '</span>';
            $config['link_class'] = 'ajaxLink';

            $this->pagination->initialize($config);
            $this->_data['paging'] = $this->pagination->create_links();
            if ($page == 1)
            {
                $from = (($page - 1) / $config['per_page']) * $config['per_page'];
            } else
            {
                $from = ($page / $config['per_page']) * $config['per_page'];
            }
            $Q = $this->complaint->getCompalintList('no', $perPage, $from);
            $current_num_rows = $Q->num_rows();
            $this->_data['indListData'] = $Q->result_array();
        } else
        {
            $Q = $this->complaint->getCompalintList();
            $current_num_rows = $Q->num_rows();
            $this->_data['indListData'] = $Q->result_array();
        }

        // Paging row index
        $startRow = ($page == 1) ? 1 : $page + 1;
        $this->_data['rowFrom'] = $startRow;
        $this->_data['page'] = $startRow + $current_num_rows - 1;
        $this->_data['totalRows'] = $totalRows;

        //print_r($this->_searchParam);

        if ($mode == 'list')
        {
            $this->load->view('complaint/mydesk_list', $this->_data);
        } else
        {
            return;
        }
    }

    public function showComplaint()
    {
        $selCompalintType = $this->input->post('selCompalintType', TRUE);
        $txtDateFrom = $this->input->post('txtDateFrom', TRUE);
        $txtDateTo = $this->input->post('txtDateTo', TRUE);

        $this->_searchParam['deskID'] = $this->session->userdata('sess_nhrc_desk_id');

        if (isset($selCompalintType) && (int) $selCompalintType != "")
        {
            $this->_searchParam['complaintType'] = $selCompalintType;
        }

        if (isset($txtDateFrom) && $txtDateFrom != "")
        {
            $this->_searchParam['dateFrom'] = date_time_format($txtDateFrom, 'dmy', 'ymd');
        }

        if (isset($txtDateTo) && $txtDateTo != "")
        {
            $this->_searchParam['dateTo'] = date_time_format($txtDateTo, 'dmy', 'ymd');
        }
        $this->session->set_userdata('myDeskSearchParam', $this->_searchParam);
        $this->myDeskList('list');
    }

    public function findcomplaint()
    {
        if (!$this->auth->havePermission('FIND'))
        {
            redirect(site_url());
        }
        $this->_data['pageTitle'] = 'Find Complaint';
        $this->session->unset_userdata('myDeskSearchParam');
        $this->_data['complaintType'] = $this->common->getBasicData($this->config->item('COMPALINT_TYPE'));
        $this->_data['complaintStatus'] = $this->common->getAllComplaintStatus();
        $this->_data['complaintDesk'] = $this->common->getAllDesk();

        $this->layout->view('complaint/findcomplaint', $this->_data);
    }

    public function showFindComplaint()
    {
        if (!$this->auth->havePermission('FIND'))
        {
            redirect(site_url());
        }
        $selCompalintType = $this->input->post('selCompalintType', TRUE);
        $txtDateFrom = $this->input->post('txtDateFrom', TRUE);
        $txtDateTo = $this->input->post('txtDateTo', TRUE);
        $selCompalintStatus = $this->input->post('selCompalintStatus', TRUE);
        $selCompalintPresentDesk = $this->input->post('selCompalintPresentDesk', TRUE);
        $complaintName = $this->input->post('complaintName', TRUE);
        $victimsName = $this->input->post('victimsName', TRUE);

        if (isset($selCompalintType) && (int) $selCompalintType != "")
        {
            $this->_searchParam['complaintType'] = $selCompalintType;
        }

        if (isset($txtDateFrom) && $txtDateFrom != "")
        {
            $this->_searchParam['recDateFrom'] = date_time_format($txtDateFrom, 'dmy', 'ymd');
        }

        if (isset($txtDateTo) && $txtDateTo != "")
        {
            $this->_searchParam['recDateTo'] = date_time_format($txtDateTo, 'dmy', 'ymd');
        }

        if (isset($selCompalintStatus) && $selCompalintStatus != "")
        {
            $this->_searchParam['compalintStatus'] = $selCompalintStatus;
        }

        if (isset($selCompalintPresentDesk) && $selCompalintPresentDesk != "")
        {
            $this->_searchParam['deskID'] = $selCompalintPresentDesk;
        }
        if (isset($complaintName) && $complaintName != "")
        {
            $this->_searchParam['complaintName'] = $complaintName;
        }
        if (isset($victimsName) && $victimsName != "")
        {
            $this->_searchParam['victimsName'] = $victimsName;
        }

        $this->session->set_userdata('myDeskSearchParam', $this->_searchParam);

        $this->myDeskList('list');
    }

    public function searchTracking()
    {
        $txtTrackingNo = trim($this->input->post('txtTrackingNo', TRUE));
        if (isset($txtTrackingNo) && $txtTrackingNo != "")
        {
            $this->_searchParam['trackingNo'] = $txtTrackingNo;
        }
        $this->session->set_userdata('myDeskSearchParam', $this->_searchParam);

        $Q = $this->complaint->getCompalintList();
        if ($Q->num_rows() == 1)
        {
            $RS = $Q->result_array();
            echo $RS[0]['complaint_id'];
        }
        return FALSE;
    }

}