<?php

class Online extends Auth_Controller
{

    private $_data;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('complaint_model');
        $this->load->model('common_settings_model', 'common');
        $this->load->model('complaint_model');
        $this->layout->setLayout('layout/complaint_layout');
        //$this->output->enable_profiler(TRUE);        
    }

    public function index()
    {
        
    }
    
    public function webcomplaint()
    {
		$this->layout->setLayout('layout/admin_layout');
        $this->_data['pageTitle'] = 'Web Survey';
        //$this->_data['get_complaint'] = $this->complaint_model->get_complain_category();
        //$this->_data['get_district'] = $this->common->get_district();
		$this->_data['get_district'] = $this->common->getDistricts();
		/*echo "<pre>";
		print_r($this->_data['districtList']);
		exit;*/
        $this->layout->view('complaint/newcomplaint_web', $this->_data);
    }
	
	 public function show_all_data()
    {
		 $this->layout->setLayout('layout/admin_layout');
        $this->_data['pageTitle'] = '';
        $this->_data['complaintInfo'] = $this->complaint_model->show_all_data();
        $this->layout->view('show_all_data', $this->_data);
    }
	
    public function upload_information ()
    { 
	
        $config[ 'upload_path' ] = './assets/csv';
        $config['allowed_types'] = '*';
        $config[ 'max_size' ] = '100';
        $config[ 'max_width' ] = '1024';
        $config[ 'max_height' ] = '768';



        $this->load->library ( 'upload' , $config );

        if ( ! $this->upload->do_upload () )
        {
            $error = array ( 'error' => $this->upload->display_errors () );
            print_r ( $error );
            exit();
        }
        else
        {
            $data = array ( 'upload_data' => $this->upload->data () );
           
            $this->uploadSpareCsv ( $data[ 'upload_data' ][ 'full_path' ] );
			 $this->session->set_flashdata ( 'message' , 'CSV Successfully Uploaded And Database Updated....' );
            redirect ( 'complaint/online/upload_data' , 'refresh' );
        }
   }

    public function uploadSpareCsv ( $fileName )
    {



        $row = 1;
        $incomeTitle = "";

        if ( ($handle = fopen ( $fileName , "r" )) !== FALSE )
        {
            while ( ($data = fgetcsv ( $handle , 1000 , "," )) !== FALSE )
            {
                $num = count ( $data );

                $break = false;

                $insertData = array ( );

                for ( $c = 0; $c < $num; $c ++  )
                {

                    if ( $row == 1 && $c == 0 )
                    {
                        $spareTitle = $data[ $c ];
                        $break = true;
                        break;
                    }
                    else if ( $row <= 3 )
                    {
                        $break = true;
                        break;
                    }
                    else
                    {
                        $break = false;

                        
                            $insertData[ $c ] = str_replace ( "," , "" , $data[ $c ] );
                        
                    }
                }

                $insertData[ $c ] = $spareTitle;
               
                if ( $break == false )
                {
				
                    $this->complaint_model->add_information( $insertData );
                }
                $row ++;
            }

            fclose ( $handle );
        }
    }
	
	public function upload_data()
    {
		$this->layout->setLayout('layout/admin_layout');
        $this->_data['pageTitle'] = 'Web Survey';        
        $this->layout->view('complaint/upload_information', $this->_data);
    }
	
    public function submit_web_complaint()
    {
        $this->form_validation->set_rules('complainant', 'Complainant', 'required');
        $this->form_validation->set_rules('complaint_name', 'Complaint name', 'trim|required|min_length[5]|max_length[25]|xss_clean');
        $this->form_validation->set_rules('complaint_sex', 'Complaint Sex', 'trim|required');
        $this->form_validation->set_rules('complaint_email', 'Email', 'trim|required|valid_email|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $this->webcomplaint();
        } else
        {
            $data = array();
            $data['complainant'] = $this->input->post('complainant');
            $data['complaint_name'] = $this->input->post('complaint_name');
            $data['father_name'] = $this->input->post('complaint_father_name');
            $data['mother_name'] = $this->input->post('complaint_mother_name');
            $data['sex'] = $this->input->post('complaint_sex');
            $data['present_address'] = $this->input->post('complaint_village');
            $data['present_district'] = $this->input->post('complaint_district');
            $data['present_sub_district'] = $this->input->post('complaint_sub_district');
            $data['present_phone'] = $this->input->post('complaint_phone');
            $data['present_fax'] = $this->input->post('complaint_fax');
            $data['present_email'] = $this->input->post('complaint_email');
            $data['description'] = $this->input->post('complaint_description');
            $data['complaint_received_date'] = date("Y-m-d");
            $data['traking_number'] = date('ymdhis') . substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 5)), 0, 5);

            $id = $this->complaint_model->submit_complaint_model($data);

            $data = array();
            $data['victims_name'] = $this->input->post('victims_name');
            $data['victims_father_name'] = $this->input->post('victims_father_name');
            $data['victims_mother_name'] = $this->input->post('victims_mother_name');
            $data['victims_spouse_name'] = $this->input->post('victims_spouse_name');
            $data['victims_sex'] = $this->input->post('victims_sex');
            $data['victims_age'] = $this->input->post('victims_age');
            $data['victims_religion'] = $this->input->post('victims_religion');
            $data['victims_indigenous_community'] = $this->input->post('victims_community');
            $data['disabled'] = $this->input->post('victims_disabled');
            $data['victims_present_village'] = $this->input->post('victims_village');
            $data['present_district'] = $this->input->post('present_district');
            $data['present_sub_district'] = $this->input->post('sub_district');
            $data['victims_present_phone'] = $this->input->post('victims_phone');
            $data['victims_present_fax'] = $this->input->post('victims_fax');
            $data['victims_present_email'] = $this->input->post('victims_email');
            $data['complaint_id'] = $id;
            $this->complaint_model->submit_victim_information($data);


            $data = array();
            $data['incident_date'] = $this->input->post('incident_date');
            $data['incident_time'] = $this->input->post('incident_time');
            $data['incident_address'] = $this->input->post('incident_village');
            $data['permanent_district'] = $this->input->post('permanent_district');
            $data['permanent_sub_district'] = $this->input->post('permanent_sub_district');
            $data['incident_description'] = $this->input->post('incident_summary');
            $data['case_court'] = $this->input->post('incident_case');
            $data['complaint_id'] = $id;
            $this->complaint_model->submit_incident_information($data);


            $data = array();
            $data['respondent_name'] = $this->input->post('respondent_name');
            $data['respondent_designation'] = $this->input->post('respondent_designation');
            $data['respondent_present_village'] = $this->input->post('respondent_village');
            $data['present_district'] = $this->input->post('present_district');
            $data['present_sub_district'] = $this->input->post('present_sub_district');
            $data['respondent_present_phone'] = $this->input->post('respondent_present_phone');
            $data['respondent_present_fax'] = $this->input->post('respondent_phone');
            $data['respondent_present_email'] = $this->input->post('respondent_email');
            $data['complaint_id'] = $id;
            $this->complaint_model->submit_respondent_information($data);

            redirect('complaint/success_full_entry_view/' . $id);
        }
    }

    
}