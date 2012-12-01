<?php

class Reports extends Auth_Controller
{
 
    private $_data;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('reports/reports_model');
        $this->load->model('common_settings_model');
       //$this->output->enable_profiler(TRUE);        
    }

    public function index()
    {
        $this->_data['pageTitle'] = 'Reports';
        $this->layout->setLayout('layout/complaint_layout');
        $this->layout->view('reports/reportsView', $this->_data);
    }

    public function showReports()
    {/*
		echo "<pre>";
		print_r($this->input->post('rbtReport', TRUE));
		exit;*/

        $type = $this->input->post('rbtReport', TRUE);
        switch ($type)
        {
            case "age":
                $this->_showVictimsAgeReport();
                break;
            case "gender":
                $this->_showVictimsGenderReport();
                break;
            case "respondentType":
                $this->_showrespondentTypeReport();
                break;
            case "ethnicity":
                $this->_showethnicityTypeReport();
                break;
            case "religion":
                $this->_showreligionTypeReport();
                break;
            case "receipt":
                $this->_showreceiptTypeReport();
                break;
            case "incidentPlace":
                $this->_showIncidentPlaceTypeReport();
                break;
            case "placeOfComplaint":
                $this->_showComplaintPlaceTypeReport();
                break;
            case "categoryOfViolation":
                $this->_showcategoryOfViolationTypeReport();
                break;
           case "action":
                $this->_showActionTakenTypeReport();
                break; 
           case "summary":
                $this->_showsummaryTypeReport();
                break; 
        }
    }

    private function _showVictimsAgeReport()
    {
        $dateFrom = date_time_format($this->input->post('date_from', true), 'dmy', 'ymd');
        $dateTO = date_time_format($this->input->post('date_to', true), 'dmy', 'ymd');
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Victim's Age Report";
        $this->_data['unknownAge'] = $this->reports_model->unknownAge($dateFrom, $dateTO);
        $this->_data['ageFirst'] = $this->reports_model->getAge(0, 17, $dateFrom, $dateTO);
        $this->_data['ageSecond'] = $this->reports_model->getAge(18, 40, $dateFrom, $dateTO);
        $this->_data['ageThird'] = $this->reports_model->getAge(40, 60, $dateFrom, $dateTO);
        $this->_data['ageFourth'] = $this->reports_model->getFouthAge(60, $dateFrom, $dateTO);
        $this->_data['ageTotal'] = $this->reports_model->getTotalAge($dateFrom, $dateTO);
        $this->_data['dateTO'] = $this->input->post('date_to', true);
        $this->_data['dateFrom'] = $this->input->post('date_from', true);
        $this->layout->view('reports/reportsByAge', $this->_data);
    }

    private function _showVictimsGenderReport()
    {
        $dateFrom = date_time_format($this->input->post('date_from', true), 'dmy', 'ymd');
        $dateTO = date_time_format($this->input->post('date_to', true), 'dmy', 'ymd');
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Literacy Rate Reports";
        $this->_data['gender'] = $this->reports_model->getgender($dateFrom, $dateTO);
        $this->_data['countGender'] = $this->reports_model->Allgetgender($dateFrom, $dateTO);
        $this->_data['dateTO'] = $this->input->post('date_to', true);
        $this->_data['dateFrom'] = $this->input->post('date_from', true);
        $this->layout->view('reports/reportsByGender', $this->_data);
    }
    
    public function view_chart()
    {
		$this->_data['reportTitle'] = "Chart View";
      	$this->layout->setLayout('layout/report_layout');
        $this->layout->view('reports/graph', $this->_data);
    }
    private function _showActionTakenTypeReport()
    {
        $dateFrom = date_time_format($this->input->post('date_from', true), 'dmy', 'ymd');
        $dateTO = date_time_format($this->input->post('date_to', true), 'dmy', 'ymd');
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Complaint Action Taken Report";
        $this->_data['action'] = $this->reports_model->getActionTaken($dateFrom, $dateTO);
        $this->_data['totaldata'] = $this->reports_model->getActionTakenAll($dateFrom, $dateTO);        
        $this->_data['dateTO'] = $this->input->post('date_to', true);
        $this->_data['dateFrom'] = $this->input->post('date_from', true);
        $this->layout->view('reports/reportsByActionTaken', $this->_data);
    }
    private function _showrespondentTypeReport()
    {
        $dateFrom = date_time_format($this->input->post('date_from', true), 'dmy', 'ymd');
        $dateTO = date_time_format($this->input->post('date_to', true), 'dmy', 'ymd');
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Respondent Report";
        $this->_data['DeciplineForce'] = $this->reports_model->getRespondentByDeciplineForce($dateFrom, $dateTO);
        $this->_data['NonDeciplineForce'] = $this->reports_model->getRespondentByNonDeciplineForce($dateFrom, $dateTO);
        $this->_data['countFource'] = $this->reports_model->countFource($dateFrom, $dateTO);
        $this->_data['countNonFource'] = $this->reports_model->countNonFource($dateFrom, $dateTO);
        $this->_data['dateTO'] = $this->input->post('date_to', true);
        $this->_data['dateFrom'] = $this->input->post('date_from', true);
        $this->layout->view('reports/reportsByRespondentType', $this->_data);
    }

    private function _showethnicityTypeReport()
    {
        $dateFrom = date_time_format($this->input->post('date_from', true), 'dmy', 'ymd');
        $dateTO = date_time_format($this->input->post('date_to', true), 'dmy', 'ymd');
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Victim's Ethnicity Report";
        $this->_data['ethnicityYes'] = $this->reports_model->getEthnicity($ethnicity = 'yes', $dateFrom, $dateTO);
        $this->_data['ethnicityNo'] = $this->reports_model->getEthnicity($ethnicity = 'no', $dateFrom, $dateTO);
        $this->_data['getAllEthnicity'] = $this->reports_model->getAllEthnicity($dateFrom, $dateTO);
        $this->_data['dateTO'] = $this->input->post('date_to', true);
        $this->_data['dateFrom'] = $this->input->post('date_from', true);
        $this->layout->view('reports/reportsByEthnicity', $this->_data);
    }

    private function _showreligionTypeReport()
    {
        $dateFrom = date_time_format($this->input->post('date_from', true), 'dmy', 'ymd');
        $dateTO = date_time_format($this->input->post('date_to', true), 'dmy', 'ymd');
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Victim's Religion Report";
        $this->_data['religiontype'] = $this->reports_model->getreligion($dateFrom, $dateTO);
        $this->_data['religionTotal'] = $this->reports_model->getreligionAll($dateFrom, $dateTO);
        $this->_data['dateTO'] = $this->input->post('date_to', true);
        $this->_data['dateFrom'] = $this->input->post('date_from', true);
        $this->layout->view('reports/reportsByReligion', $this->_data);
    }
    private function _showIncidentPlaceTypeReport()
    {
        $dateFrom = date_time_format($this->input->post('date_from', true), 'dmy', 'ymd');
        $dateTO = date_time_format($this->input->post('date_to', true), 'dmy', 'ymd');
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Place Of Occurrence Report";
        $this->_data['placeOfincident'] = $this->reports_model->getPlaceOfOccurrence($dateFrom, $dateTO);       
        $this->_data['totaldata'] = $this->reports_model->getPlaceOfOccurrenceAll($dateFrom, $dateTO);
        $this->_data['dateTO'] = $this->input->post('date_to', true);
        $this->_data['dateFrom'] = $this->input->post('date_from', true);
        $this->layout->view('reports/reportsByPlaceOfOccurrence', $this->_data);
    } 
    
    private function _showComplaintPlaceTypeReport()
    {
        $dateFrom = date_time_format($this->input->post('date_from', true), 'dmy', 'ymd');
        $dateTO = date_time_format($this->input->post('date_to', true), 'dmy', 'ymd');
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Vaccination Report";
        $this->_data['placeOfcomplaint'] = $this->reports_model->getPlaceOfcomplaint($dateFrom, $dateTO); 
		 $this->_data['placeOfcomplaint2'] = $this->reports_model->getPlaceOfcomplaint2($dateFrom, $dateTO);
		
        
        
        $this->_data['dateTO'] = $this->input->post('date_to', true);
        $this->_data['dateFrom'] = $this->input->post('date_from', true);
        $this->layout->view('reports/reportsByPlaceOfComplaint', $this->_data);
    }
    private function _showcategoryOfViolationTypeReport()
    {
        $dateFrom = date_time_format($this->input->post('date_from', true), 'dmy', 'ymd');
        $dateTO = date_time_format($this->input->post('date_to', true), 'dmy', 'ymd');
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Birth Rate Report";
        $this->_data['violationCategory'] = $this->reports_model->getViolationCategory($dateFrom, $dateTO);       
        $this->_data['totaldata'] = $this->reports_model->getViolationCategoryAll($dateFrom, $dateTO);
        $this->_data['dateTO'] = $this->input->post('date_to', true);
        $this->_data['dateFrom'] = $this->input->post('date_from', true);
        $this->layout->view('reports/reportsByViolationCategory', $this->_data);
    }
    

    private function _showreceiptTypeReport()
    {
        $dateFrom = date_time_format($this->input->post('date_from', true), 'dmy', 'ymd');
        $dateTO = date_time_format($this->input->post('date_to', true), 'dmy', 'ymd');
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Method Of Receipt Report";
        $this->_data['typeOFDelevery'] = $this->reports_model->deliveryMethod($dateFrom, $dateTO);
        $this->_data['totalDelivery'] = $this->reports_model->deliveryMethodAll($dateFrom, $dateTO);
        $this->_data['dateTO'] = $this->input->post('date_to', true);
        $this->_data['dateFrom'] = $this->input->post('date_from', true);
        $this->layout->view('reports/reportByDeliveryMethod', $this->_data);
    }
    private function _showsummaryTypeReport()
    {
      
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Summary Report";
        $this->_data['getTotal'] = $this->reports_model->getTotalComplaint();
        $this->_data['today'] = $this->reports_model->receivedToday(date('Y-m-d'));
        $this->_data['threeMonth'] = $this->reports_model->countByMonth(90, 180);
        $this->_data['sixMonth'] = $this->reports_model->countByMonth(180, 360);
        $this->_data['twelveMonth'] = $this->reports_model->countByMonth(360, 500000);
        $this->_data['referdngo'] = $this->reports_model->getConfigData($this->config->item('COMPLAINTS_REFERRED_NGO'));
        $this->_data['receivedToNgo'] = $this->reports_model->getConfigData($this->config->item('COMPLAINTS_RECEIVED_NGO'));        
        $this->_data['resolved'] = $this->reports_model->getConfigResolvedData($this->config->item('COMPLAIN_RESOLVED'));        
        $this->_data['response_ministryhomes'] = $this->reports_model->getConfigData($this->config->item('RESPONSE_PENDING_MINISRY_HOMES'));        
        $this->layout->view('reports/summaryReports', $this->_data);
    }

    public function getDetailsByAge($age, $dateFrom = "", $dateTO = "")
    {
        $dateFrom=date_time_format($dateFrom,'ymd', 'dmy' );
        $dateTO= date_time_format($dateTO, 'ymd','dmy' );
        if ($age == 1)
        {
            $ageFrom = 0;
            $ageTO = 17;
        }
        if ($age == 2)
        {
            $ageFrom = 18;
            $ageTO = 40;
        }
        if($age==3)
        {
        $ageFrom =41;
        $ageTO = 60;
        }
        if($age==4)
        {        
        $ageFrom =61;
        $ageTO = 999;        
        }
        if($age==5)
        {        
        $ageFrom ="";
        $ageTO = "";        
        }
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Details of Victim's Age Report";
        if($age ==5){
        $this->_data['Details'] = $this->reports_model->getDetailsByUnknownAge($ageFrom, $ageTO, $dateFrom, $dateTO);
        }  else
        {
         $this->_data['Details'] = $this->reports_model->getDetailsByAge($ageFrom, $ageTO, $dateFrom, $dateTO);   
        }
        $this->_data['dateTO'] = $dateTO;
        $this->_data['dateFrom'] = $dateFrom;
        $this->layout->view('reports/detailsViewByAge', $this->_data);
        
    }
    
    public function getDetailsByGender($gender, $dateFrom = "", $dateTO = "")
    {
        $dateFrom=date_time_format($dateFrom,'ymd', 'dmy' );
        $dateTO= date_time_format($dateTO, 'ymd','dmy' );        
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Details of Victim's Gender Report";
        $this->_data['Details'] = $this->reports_model->getDetailsByGender($gender, $dateFrom, $dateTO);        
        $this->_data['dateTO'] = $dateTO;
        $this->_data['dateFrom'] = $dateFrom; 
        $this->layout->view('reports/detailsViewByAge', $this->_data);
        
    }
   public function getDetailsByRespondentTypeYes($respondent, $dateFrom = "", $dateTO = "")
    {
        $dateFrom=date_time_format($dateFrom,'ymd', 'dmy' );
        $dateTO= date_time_format($dateTO, 'ymd','dmy' );        
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Details of Respondent Report";
        $this->_data['Details'] = $this->reports_model->getDetailsByRespondentTypeYes($respondent, $dateFrom, $dateTO);        
        $this->_data['dateTO'] = $dateTO;
        $this->_data['dateFrom'] = $dateFrom; 
        $this->layout->view('reports/detailsViewByAge', $this->_data);
        
    } 
    public function getDetailsByActionTaken($action, $dateFrom = "", $dateTO = "")
    {
        $dateFrom=date_time_format($dateFrom,'ymd', 'dmy' );
        $dateTO= date_time_format($dateTO, 'ymd','dmy' );        
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Details of Complaint Action Taken Report";
        $this->_data['Details'] = $this->reports_model->getDetailsByActionTaken($action, $dateFrom, $dateTO);        
        $this->_data['dateTO'] = $dateTO;
        $this->_data['dateFrom'] = $dateFrom; 
        $this->layout->view('reports/detailsViewByAge', $this->_data);
        
    } 
    
    public function getDetailsByViolationCategory($violationCategory, $dateFrom = "", $dateTO = "")
    {
        $dateFrom=date_time_format($dateFrom,'ymd', 'dmy' );
        $dateTO= date_time_format($dateTO, 'ymd','dmy' );        
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Details of Category of Violation Report";
        $this->_data['Details'] = $this->reports_model->getDetailsByViolationCategory($violationCategory, $dateFrom, $dateTO);        
        $this->_data['dateTO'] = $dateTO;
        $this->_data['dateFrom'] = $dateFrom; 
        $this->layout->view('reports/detailsViewByAge', $this->_data);
        
    }
    
    public function getDetailsByRespondentTypeNo($respondent, $dateFrom = "", $dateTO = "")
    {
        $dateFrom=date_time_format($dateFrom,'ymd', 'dmy' );
        $dateTO= date_time_format($dateTO, 'ymd','dmy' );        
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Details of Respondent Report";
        $this->_data['Details'] = $this->reports_model->getDetailsByRespondentTypeNo($respondent, $dateFrom, $dateTO);        
        $this->_data['dateTO'] = $dateTO;
        $this->_data['dateFrom'] = $dateFrom; 
        $this->layout->view('reports/detailsViewByAge', $this->_data);
        
    }
    public function getDetailsByReligion($religion, $dateFrom = "", $dateTO = "")
    {
        $dateFrom=date_time_format($dateFrom,'ymd', 'dmy' );
        $dateTO= date_time_format($dateTO, 'ymd','dmy' );        
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Details of Victim's Religion Report";
        $this->_data['Details'] = $this->reports_model->getDetailsByReligion($religion, $dateFrom, $dateTO);        
        $this->_data['dateTO'] = $dateTO;
        $this->_data['dateFrom'] = $dateFrom; 
        $this->layout->view('reports/detailsViewByAge', $this->_data);        
    }
    
    
public function getDetailsByEthnicity($ethnicity, $dateFrom = "", $dateTO = "")
    {
        $dateFrom=date_time_format($dateFrom,'ymd', 'dmy' );
        $dateTO= date_time_format($dateTO, 'ymd','dmy' );        
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Details of Victim's Ethnicity Report";
        $this->_data['Details'] = $this->reports_model->getDetailsByEthnicity($ethnicity, $dateFrom, $dateTO);        
        $this->_data['dateTO'] = $dateTO;
        $this->_data['dateFrom'] = $dateFrom; 
        $this->layout->view('reports/detailsViewByAge', $this->_data);        
    }
  
    public function getDetailsByDelivaryMethod($method, $dateFrom = "", $dateTO = "")
    {
        $dateFrom=date_time_format($dateFrom,'ymd', 'dmy' );
        $dateTO= date_time_format($dateTO, 'ymd','dmy' );        
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Details of Method of Receipt Report";
        $this->_data['Details'] = $this->reports_model->getDetailsByDelivaryMethod($method, $dateFrom, $dateTO);        
        $this->_data['dateTO'] = $dateTO;
        $this->_data['dateFrom'] = $dateFrom; 
        $this->layout->view('reports/detailsViewByAge', $this->_data);        
    }
    
    public function getDetailsByPlaceOfComplaint($subDistrict, $dateFrom="", $dateTO="")
    {
        $dateFrom=date_time_format($dateFrom,'ymd', 'dmy' );
        $dateTO= date_time_format($dateTO, 'ymd','dmy' );        
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Details of Place of Complaint Report";
        $this->_data['Details'] = $this->reports_model->getDetailsByPlaceOfComplaint($subDistrict, $dateFrom, $dateTO);        
        $this->_data['dateTO'] = $dateTO;
        $this->_data['dateFrom'] = $dateFrom; 
        $this->layout->view('reports/detailsViewByAge', $this->_data);        
    }
    public function getDetailsByPlaceOfOccurrence($subDistrict, $dateFrom="", $dateTO="")
    {
        $dateFrom=date_time_format($dateFrom,'ymd', 'dmy' );
        $dateTO= date_time_format($dateTO, 'ymd','dmy' );        
        $this->layout->setLayout('layout/report_layout');
        $this->_data['reportTitle'] = "Details of Place of Occurrence Report";
        $this->_data['Details'] = $this->reports_model->getDetailsByPlaceOfOccurrence($subDistrict, $dateFrom, $dateTO);        
        $this->_data['dateTO'] = $dateTO;
        $this->_data['dateFrom'] = $dateFrom; 
        $this->layout->view('reports/detailsViewByAge', $this->_data);        
    }
    
}

