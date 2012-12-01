<?php

class Reports_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function unknownAge($dateFrom, $dateTO)
    {
        $sql = "SELECT COUNT(victim_information.victims_age) AS age , complaint.complaint_received_date						
	FROM					
	victim_information, complaint
	WHERE
        victim_information.complaint_id=complaint.complaint_id
        AND 
        victim_information.victims_age = ''        
        ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $rs = $this->db->query($sql, $binds)->row();
        return $rs->age;
    }

    public function getAge($ageFrom, $ageTO, $dateFrom, $dateTO)
    {
        $sql = "SELECT COUNT(victim_information.victims_age) AS age , complaint.complaint_received_date						
	FROM					
	victim_information, complaint
	WHERE
        victim_information.complaint_id=complaint.complaint_id
        AND
	victims_age BETWEEN ? AND ?        
        ";
        
        $binds = array($ageFrom, $ageTO);
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        if ($ageFrom == 0)
        {
            $sql .= " AND victims_age != '' ";
        }
        $rs = $this->db->query($sql, $binds)->row();
        return $rs->age;
    }

    public function getFouthAge($age, $dateFrom, $dateTO)
    {
        $sql = "SELECT COUNT(victim_information.victims_age) AS age , complaint.complaint_received_date						
	FROM					
	victim_information, complaint
	WHERE 
        victim_information.complaint_id=complaint.complaint_id
        AND
	victims_age > ?       
        ";
        $binds = array($age);
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $rs = $this->db->query($sql, $binds)->row();
        return $rs->age;
    }

    public function getTotalAge($dateFrom, $dateTO)
    {

        $sql = "SELECT COUNT(victim_information.victims_age)AS age, complaint.complaint_received_date						
	FROM					
	victim_information, complaint
        WHERE
        victim_information.complaint_id=complaint.complaint_id        
        ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $rs = $this->db->query($sql, $binds)->row();
        return $rs->age;
    }

    public function getgender($dateFrom, $dateTO)
    {
        $sql = "SELECT
            COUNT(complaint.complaint_id) AS `total_victims_gender`,
            victim_information.victims_sex
            FROM
            complaint
            INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
            WHERE
            victim_information.victims_sex IS NOT NULL
        ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }

        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY
                victim_information.victims_sex
                ORDER BY
                victim_information.victims_sex ASC";

        $rs = $this->db->query($sql, $binds)->result_array();
        return $rs;
    }

    public function Allgetgender($dateFrom, $dateTO)
    {

        $sql = "SELECT COUNT(complaint.complaint_id)AS sex, complaint.complaint_received_date						
	FROM					
	complaint
        INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
        WHERE        
        victim_information.victims_sex IS NOT NULL
        ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $rs = $this->db->query($sql, $binds)->row();
        return $rs->sex;
    }

    public function getRespondentByDeciplineForce($dateFrom, $dateTO)
    {
        $sql = "SELECT
        basic_data.varName,
        basic_data.id,
        respondent_info.respondent_name,
        COUNT(respondent_info.respondent_id) AS 'total_respondent'
        FROM
        basic_data
        INNER JOIN basic_category ON basic_category.id = basic_data.intBasicCategoryId
        RIGHT JOIN respondent_info ON basic_data.id = respondent_info.decipline_force_member_yes
        INNER JOIN complaint ON complaint.complaint_id = respondent_info.complaint_id
        INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
        WHERE
        basic_category.id IN ({$this->config->item('AGAINST_RESPONDENT_TYPE')}, {$this->config->item('DISCIPLINED_FORCE')})        
        ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }

        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY
                respondent_info.decipline_force_member_yes
                ORDER BY 
                basic_data.varName ASC
                ";

        $rs = $this->db->query($sql, $binds)->result_array();
        return $rs;
    }

    public function getRespondentByNonDeciplineForce($dateFrom, $dateTO)
    {
        $sql = "SELECT
        basic_data.varName,
        basic_data.id,
        respondent_info.respondent_name,
        COUNT(respondent_info.respondent_id) AS 'total_respondent'
        FROM
        basic_data
        INNER JOIN basic_category ON basic_category.id = basic_data.intBasicCategoryId
        RIGHT JOIN respondent_info ON basic_data.id = respondent_info.respondent_member_decipline_no
        INNER JOIN complaint ON complaint.complaint_id = respondent_info.complaint_id
        INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
        WHERE
        basic_category.id IN ({$this->config->item('AGAINST_RESPONDENT_TYPE')}, {$this->config->item('DISCIPLINED_FORCE')})        
        ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY
                respondent_info.respondent_member_decipline_no
                ORDER BY 
                basic_data.varName ASC
                ";

        $rs = $this->db->query($sql, $binds)->result_array();
        return $rs;
    }

    public function countFource($dateFrom, $dateTO)
    {

        $sql = "SELECT COUNT(respondent_info.decipline_force_member_yes) AS fource, complaint.complaint_received_date, victim_information.complaint_id						
	FROM					
	respondent_info, complaint, victim_information
        WHERE
        complaint.complaint_id = victim_information.complaint_id
        AND
        respondent_info.complaint_id = complaint.complaint_id  
        AND
	respondent_info.decipline_force_member_yes !=0
        ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $rs = $this->db->query($sql, $binds)->row();
        return $rs->fource;
    }

    public function countNonFource($dateFrom, $dateTO)
    {

        $sql = "SELECT COUNT(respondent_info.respondent_member_decipline_no) AS nonForce, complaint.complaint_received_date, victim_information.complaint_id						
	FROM					
	respondent_info, complaint, victim_information
        WHERE
        complaint.complaint_id = victim_information.complaint_id
        AND
        respondent_info.complaint_id = complaint.complaint_id
        AND
        respondent_info.respondent_member_decipline_no != 0
        ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $rs = $this->db->query($sql, $binds)->row();
        return $rs->nonForce;
    }

    public function getEthnicity($ethnicity, $dateFrom, $dateTO)
    {
        $sql = "SELECT COUNT(victim_information.victims_indigenous_community) AS ethnicity, complaint.complaint_received_date						
	FROM					
	victim_information, complaint
        WHERE
        complaint.complaint_id = victim_information.complaint_id
        AND
        victim_information.complaint_id = complaint.complaint_id
        AND
        victims_indigenous_community =?
        ";
        $binds = array($ethnicity);
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $rs = $this->db->query($sql, $binds)->row();
        return $rs->ethnicity;
    }

    public function getAllEthnicity($dateFrom, $dateTO)
    {
        $sql = "SELECT COUNT(victim_information.victims_indigenous_community) AS ethnicity, complaint.complaint_received_date						
	FROM					
	victim_information, complaint
        WHERE
        victim_information.complaint_id = complaint.complaint_id
        ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $rs = $this->db->query($sql, $binds)->row();
        return $rs->ethnicity;
    }

    public function getreligion($dateFrom, $dateTO)
    {
        $sql = "SELECT
            basic_data.varName,
            basic_data.id,
            victim_information.victims_religion,
            COUNT(victim_information.complaint_id) AS 'total_religion'
            FROM
            basic_data
            INNER JOIN basic_category ON basic_category.id = basic_data.intBasicCategoryId
            RIGHT JOIN victim_information ON basic_data.id = victim_information.victims_religion
            INNER JOIN complaint ON complaint.complaint_id = victim_information.complaint_id
            WHERE
            basic_category.id IN (6)
            ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY
              victim_information.victims_religion
              ";
        $rs = $this->db->query($sql, $binds)->result_array();
        return $rs;
    }

    public function getreligionAll($dateFrom, $dateTO)
    {
        $sql = "SELECT COUNT(victims_religion) AS religion, complaint.complaint_received_date						
	FROM					
	victim_information, complaint
        WHERE
        victim_information.complaint_id = complaint.complaint_id
        AND
        victims_religion !=0
        ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $rs = $this->db->query($sql, $binds)->row();
        return $rs->religion;
    }

    public function deliveryMethod($dateFrom, $dateTO)
    {
        $sql = "SELECT
            basic_data.varName,
            basic_data.id,
            COUNT(complaint_delivery_method.intDeliveryID) AS total_method
            FROM
            basic_data
            INNER JOIN basic_category ON basic_category.id = basic_data.intBasicCategoryId
            RIGHT JOIN complaint_delivery_method ON basic_data.id = complaint_delivery_method.intDeliveryID
            INNER JOIN complaint ON complaint.complaint_id = complaint_delivery_method.intComplaintID
            INNER JOIN victim_information ON victim_information.complaint_id = complaint.complaint_id
            WHERE
            basic_category.id IN (1)            
            ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY
              complaint_delivery_method.intDeliveryID
              ";
        $rs = $this->db->query($sql, $binds)->result_array();
        return $rs;
    }

    public function deliveryMethodAll($dateFrom, $dateTO)
    {
        $sql = "SELECT COUNT(intDeliveryID) AS delivery	, complaint.complaint_received_date				
	FROM					
	complaint_delivery_method , complaint
        INNER JOIN victim_information ON victim_information.complaint_id = complaint.complaint_id
        WHERE
        complaint_delivery_method.intComplaintID = complaint.complaint_id      
        ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $rs = $this->db->query($sql, $binds)->row();
        return $rs->delivery;
    }

    public function getTotalComplaint()
    {
        $sql = "SELECT COUNT(complaint_id) AS totalcomplaint				
	FROM					
	complaint        
        WHERE
        1 = 1
        ";

        $rs = $this->db->query($sql)->row();
        return $rs->totalcomplaint;
    }

    public function receivedToday($data)
    {

        $sql = "SELECT COUNT(complaint_id) AS TodayComplaint				
	FROM					
	complaint        
        WHERE
         DATE(complaint_received_date) = ?
        ";
        $binds[] = $data;
        $rs = $this->db->query($sql, $binds)->row();
        return $rs->TodayComplaint;
    }

    public function getConfigData($data)
    {
        $sql = "SELECT COUNT(complaint_id) AS complaint				
	FROM					
	complaint        
        WHERE
        1 = 1
        ";
        $sql .= " AND present_status = ?";
        $binds[] = $data;
        $rs = $this->db->query($sql, $binds)->row();
        return $rs->complaint;
    }

    public function getConfigResolvedData($data)
    {

        $sql = "SELECT COUNT(complaint_id) AS complaint				
	FROM					
	complaint        
        WHERE
         1 = 1
        ";
        $sql .= " AND present_status in($data)";
        $binds[] = $data;
        $rs = $this->db->query($sql, $binds)->row();
        return $rs->complaint;
    }

    public function countByMonth($dateFrom, $dateTO)
    {

        $sql = "SELECT count(complaint_id)as months
                FROM 
                complaint
                WHERE  
                complaint_received_date BETWEEN DATE_SUB(NOW(), INTERVAL {$dateTO} DAY) AND DATE_SUB(NOW(), INTERVAL {$dateFrom} DAY)
        ";

        $rs = $this->db->query($sql)->row();
        return $rs->months;
    }

    public function getDetailsByAge($ageFrom, $ageTO, $dateFrom, $dateTO)
    {

        $sql = "SELECT
            complaint.complaint_id,
            complaint.traking_number,
            complaint.complaint_name,
            users.varFullName,
            complaint.complaint_received_date,
            victim_information.victims_name,
            victim_information.victims_age,
            victim_information.victims_sex,
            `status`.`name` AS present_status,
            users.varFullName,
            users.varDesignation
            FROM
            complaint
            INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
            INNER JOIN `status` ON `status`.status_id = complaint.present_status
            INNER JOIN users ON users.id = complaint.last_opt_user_id
            WHERE
            victim_information.victims_age BETWEEN ? AND ?
            ";
        $binds = array($ageFrom, $ageTO);
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        if ($ageFrom == 0)
        {
            $sql .= " AND victims_age != '' ";
        }
        $sql .= "GROUP BY
              complaint.complaint_received_date DESC
              ";
        return $this->db->query($sql, $binds)->result_array();
    }

    public function getDetailsByUnknownAge($ageFrom, $ageTO, $dateFrom, $dateTO)
    {

        $sql = "SELECT
            complaint.complaint_id,
            complaint.traking_number,
            complaint.complaint_name,
            users.varFullName,
            complaint.complaint_received_date,
            victim_information.victims_name,
            victim_information.victims_age,
            victim_information.victims_sex,
            `status`.`name` AS present_status,
            users.varFullName,
            users.varDesignation
            FROM
            complaint
            INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
            INNER JOIN `status` ON `status`.status_id = complaint.present_status
            INNER JOIN users ON users.id = complaint.last_opt_user_id
            WHERE
           victims_age = '' 
            ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY
              complaint.complaint_received_date DESC
              ";
        return $this->db->query($sql, $binds)->result_array();
    }

    public function getDetailsByGender($gender, $dateFrom, $dateTO)
    {

        $sql = "SELECT
            complaint.complaint_id,
            complaint.traking_number,
            complaint.complaint_name,
            users.varFullName,
            complaint.complaint_received_date,
            victim_information.victims_name,
            victim_information.victims_age,
            victim_information.victims_sex,
            `status`.`name` AS present_status,            
            users.varDesignation
            FROM
            complaint
            INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
            INNER JOIN `status` ON `status`.status_id = complaint.present_status
            INNER JOIN users ON users.id = complaint.last_opt_user_id
            WHERE
            victim_information.victims_sex = ?            
            ";
        $binds = array($gender);
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY
              complaint.complaint_received_date DESC
              ";
        return $this->db->query($sql, $binds)->result_array();
    }

    public function getDetailsByPlaceOfComplaint($subDistrict, $dateFrom, $dateTO)
    {

        $sql = "SELECT
            complaint.complaint_id,
            complaint.traking_number,
            complaint.complaint_name,
            users.varFullName,
            complaint.complaint_received_date,
            victim_information.victims_name,
            victim_information.victims_age,
            victim_information.victims_sex,
            `status`.`name` AS present_status,
            users.varFullName,
            users.varDesignation
            FROM
            complaint
            INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
            INNER JOIN `status` ON `status`.status_id = complaint.present_status
            INNER JOIN users ON users.id = complaint.last_opt_user_id            
            WHERE
            complaint.present_sub_district=?
            ";
        $binds = array($subDistrict);
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY
              complaint.complaint_received_date DESC
              ";
        return $this->db->query($sql, $binds)->result_array();
    }

    public function getDetailsByPlaceOfOccurrence($subDistrict, $dateFrom, $dateTO)
    {

        $sql = "SELECT
            complaint.complaint_id,
            complaint.traking_number,
            complaint.complaint_name,
            users.varFullName,
            complaint.complaint_received_date,
            victim_information.victims_name,
            victim_information.victims_age,
            victim_information.victims_sex,
            `status`.`name` AS present_status,
            users.varFullName,
            users.varDesignation
            FROM
            complaint
            INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
            INNER JOIN `status` ON `status`.status_id = complaint.present_status
            INNER JOIN users ON users.id = complaint.last_opt_user_id 
            INNER JOIN incident_info ON complaint.complaint_id = incident_info.complaint_id
            WHERE
            incident_info.permanent_sub_district=?
            ";
        $binds = array($subDistrict);
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY
              complaint.complaint_received_date DESC
              ";
        return $this->db->query($sql, $binds)->result_array();
    }

    public function getDetailsByRespondentTypeYes($respondent, $dateFrom, $dateTO)
    {

        $sql = "SELECT
            complaint.complaint_id,
            complaint.traking_number,
            complaint.complaint_name,
            users.varFullName,
            complaint.complaint_received_date,
            victim_information.victims_name,
            victim_information.victims_age,
            victim_information.victims_sex,
            `status`.`name` AS present_status,
            users.varFullName,
            users.varDesignation
            FROM
            complaint
            INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
            INNER JOIN `status` ON `status`.status_id = complaint.present_status
            INNER JOIN users ON users.id = complaint.last_opt_user_id 
            INNER JOIN respondent_info ON complaint.complaint_id = respondent_info.complaint_id
            WHERE
            respondent_info.decipline_force_member_yes=?            
        ";
        $binds = array($respondent);
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }

        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY
                respondent_info.complaint_id
                ORDER BY
                complaint.traking_number DESC";

        $rs = $this->db->query($sql, $binds)->result_array();
        return $rs;
    }

    public function getPlaceOfOccurrence($dateFrom, $dateTO)
    {

        $sql = "SELECT
            COUNT(complaint.complaint_id) AS `total_placeOf_occurrence`,
            district.district_name,
	    sub_district.sub_district_id,
            sub_district.sub_district_name

            FROM
            complaint
            INNER JOIN incident_info ON complaint.complaint_id = incident_info.complaint_id
            INNER JOIN sub_district ON incident_info.permanent_sub_district = sub_district.sub_district_id
            INNER JOIN district ON sub_district.district_id = district.district_id  
            INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
            ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY
              district.district_name DESC
              ";
        return $this->db->query($sql, $binds)->result_array();
    }

    public function getPlaceOfOccurrenceAll($dateFrom, $dateTO)
    {

        $sql = "SELECT
            COUNT(incident_info.incident_id) AS place , complaint.complaint_received_date						
	FROM					
	incident_info, complaint
        INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
	WHERE
        incident_info.complaint_id=complaint.complaint_id 
        AND
        incident_info.permanent_sub_district != 0
            ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }


        $rs = $this->db->query($sql, $binds)->row();
        return $rs->place;
    }

    public function getPlaceOfcomplaint($dateFrom, $dateTO)
    {

        $sql = "SELECT COUNT( survey_detials.survay_detials_id ) AS total_child, district.district_name, sub_district.sub_district_name, COUNT(survey_detials.status_of_vaccination ) AS total_vaccination
FROM survey_detials
INNER JOIN survey_master ON survey_master.survay_master_id = survey_detials.survey_master_id
LEFT JOIN district ON district.district_id = survey_master.district_id
LEFT JOIN sub_district ON survey_master.sub_districtid = sub_district.sub_district_id
            ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        return $this->db->query($sql, $binds)->result_array();
    }
	
	 public function getPlaceOfcomplaint2($dateFrom, $dateTO)
    {

        $sql = "SELECT  COUNT(survey_detials.status_of_vaccination ) AS total_vaccination
FROM survey_detials
INNER JOIN survey_master ON survey_master.survay_master_id = survey_detials.survey_master_id
LEFT JOIN district ON district.district_id = survey_master.district_id
LEFT JOIN sub_district ON survey_master.sub_districtid = sub_district.sub_district_id
			where
			survey_detials.status_of_vaccination = 1
            ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        return $this->db->query($sql, $binds)->result_array();
    }
	
	

    public function getPlaceOfcomplaintAll($dateFrom, $dateTO)
    {

        $sql = "SELECT
            COUNT(complaint.present_sub_district) AS place , complaint.complaint_received_date						
	FROM					
	complaint
	INNER JOIN sub_district ON complaint.present_sub_district = sub_district.sub_district_id
            INNER JOIN district ON sub_district.district_id = district.district_id  
            INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
            ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }


        $rs = $this->db->query($sql, $binds)->row();
        return $rs->place;
    }

    public function getViolationCategory($dateFrom, $dateTO)
    {

        $sql = " SELECT COUNT(complaint_analysis_hrviolation.hrviolation_id) AS total_violation,
        basic_data.varName,
        basic_data.id
        FROM
        complaint
        INNER JOIN complaint_analysis_hrviolation ON complaint.complaint_id = complaint_analysis_hrviolation.complaint_id          
        INNER JOIN basic_data ON complaint_analysis_hrviolation.hrviolation_id = basic_data.id 
        INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id        
            ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY 
        complaint_analysis_hrviolation.hrviolation_id DESC
              ";

        return $this->db->query($sql, $binds)->result_array();
    }

    public function getViolationCategoryAll($dateFrom, $dateTO)
    {

        $sql = "SELECT COUNT(complaint_analysis_hrviolation.hrviolation_id) AS total_violation       
                FROM
                complaint
                INNER JOIN complaint_analysis_hrviolation ON complaint.complaint_id = complaint_analysis_hrviolation.complaint_id          
                INNER JOIN basic_data ON complaint_analysis_hrviolation.hrviolation_id = basic_data.id
                INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
                
            ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }


        $rs = $this->db->query($sql, $binds)->row();
        return $rs->total_violation;
    }

    public function getActionTaken($dateFrom, $dateTO)
    {

        $sql = " SELECT
            `status`.status_id,
            `status`.`name`,
            COUNT(`status`.status_id) AS totalComplaint
            FROM
            complaint
            INNER JOIN `status` ON `status`.status_id = complaint.present_status
            INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
            ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY `status`.status_id
                ORDER BY `status`.`name` ASC
              ";

        return $this->db->query($sql, $binds)->result_array();
    }

    public function getActionTakenAll($dateFrom, $dateTO)
    {

        $sql = "SELECT
                COUNT(`status`.status_id) AS totalComplaint
                FROM
                complaint
                INNER JOIN `status` ON `status`.status_id = complaint.present_status 
                INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
                ";
        $binds = array();
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $rs = $this->db->query($sql, $binds)->row();
        return $rs->totalComplaint;
    }

    public function getDetailsByRespondentTypeNo($respondent, $dateFrom, $dateTO)
    {

        $sql = "SELECT
            complaint.complaint_id,
            complaint.traking_number,
            complaint.complaint_name,
            users.varFullName,
            complaint.complaint_received_date,
            victim_information.victims_name,
            victim_information.victims_age,
            victim_information.victims_sex,
            `status`.`name` AS present_status,
            basic_data.varName,            
            users.varDesignation
            FROM
            complaint
            INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
            INNER JOIN `status` ON `status`.status_id = complaint.present_status
            INNER JOIN users ON users.id = complaint.last_opt_user_id
            INNER JOIN respondent_info ON respondent_info.complaint_id = complaint.complaint_id
            INNER JOIN basic_data ON basic_data.id = respondent_info.respondent_member_decipline_no 
            WHERE
            respondent_info.respondent_member_decipline_no=?
            ";
        $binds = array($respondent);
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY
              complaint.complaint_received_date DESC
              ";
        return $this->db->query($sql, $binds)->result_array();
    }

    public function getDetailsByActionTaken($action, $dateFrom, $dateTO)
    {

        $sql = "SELECT
            complaint.complaint_id,
            complaint.traking_number,
            complaint.complaint_name,
            users.varFullName,
            complaint.complaint_received_date,
            victim_information.victims_name,
            victim_information.victims_age,
            victim_information.victims_sex,
            `status`.`name` AS present_status,
            users.varFullName,
            users.varDesignation
            FROM
            complaint
            INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
            INNER JOIN `status` ON `status`.status_id = complaint.present_status
            INNER JOIN users ON users.id = complaint.last_opt_user_id            
            where
            complaint.present_status =?
            ";
        $binds = array($action);
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY
              complaint.complaint_received_date DESC
              ";
        return $this->db->query($sql, $binds)->result_array();
    }

    public function getDetailsByViolationCategory($violationCategory, $dateFrom, $dateTO)
    {

        $sql = "SELECT
            complaint.complaint_id,
            complaint.traking_number,
            complaint.complaint_name,
            users.varFullName,
            complaint.complaint_received_date,
            victim_information.victims_name,
            victim_information.victims_age,
            victim_information.victims_sex,
            `status`.`name` AS present_status,
            basic_data.varName,            
            users.varDesignation
            FROM
            complaint
            INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
            INNER JOIN `status` ON `status`.status_id = complaint.present_status
            INNER JOIN users ON users.id = complaint.last_opt_user_id
            INNER JOIN complaint_analysis_hrviolation ON complaint_analysis_hrviolation.complaint_id = complaint.complaint_id
            INNER JOIN basic_data ON basic_data.id = complaint_analysis_hrviolation.hrviolation_id 
            WHERE
            complaint_analysis_hrviolation.hrviolation_id = ?            
            ";
        $binds = array($violationCategory);
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY 
                complaint.complaint_received_date DESC
              ";
        return $this->db->query($sql, $binds)->result_array();
    }

    public function getDetailsByReligion($religion, $dateFrom, $dateTO)
    {

        $sql = "SELECT
            complaint.complaint_id,
            complaint.traking_number,
            complaint.complaint_name,
            users.varFullName,
            complaint.complaint_received_date,
            victim_information.victims_name,
            victim_information.victims_age,
            victim_information.victims_sex,
            `status`.`name` AS present_status,
            basic_data.varName,            
            users.varDesignation
            FROM
            complaint
            INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
            INNER JOIN `status` ON `status`.status_id = complaint.present_status
            INNER JOIN users ON users.id = complaint.last_opt_user_id            
            INNER JOIN basic_data ON basic_data.id = victim_information.victims_religion 
            WHERE
            victim_information.victims_religion=?
            ";
        $binds = array($religion);
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY
              complaint.complaint_received_date DESC
              ";
        return $this->db->query($sql, $binds)->result_array();
    }

    public function getDetailsByEthnicity($ethnicity, $dateFrom, $dateTO)
    {

        $sql = "SELECT
            complaint.complaint_id,
            complaint.traking_number,
            complaint.complaint_name,
            users.varFullName,
            complaint.complaint_received_date,
            victim_information.victims_name,
            victim_information.victims_age,
            victim_information.victims_sex,
            `status`.`name` AS present_status,
            users.varFullName,
            users.varDesignation
            FROM
            complaint
            INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
            INNER JOIN `status` ON `status`.status_id = complaint.present_status
            INNER JOIN users ON users.id = complaint.last_opt_user_id
            WHERE
            victim_information.victims_indigenous_community=?
            ";
        $binds = array($ethnicity);
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY
              complaint.complaint_received_date DESC
              ";
        return $this->db->query($sql, $binds)->result_array();
    }

    public function getDetailsByDelivaryMethod($method, $dateFrom, $dateTO)
    {

        $sql = "SELECT
            complaint.complaint_id,
            complaint.traking_number,
            complaint.complaint_name,
            users.varFullName,
            complaint.complaint_received_date,
            victim_information.victims_name,
            victim_information.victims_age,
            victim_information.victims_sex,
            `status`.`name` AS present_status,
            basic_data.varName,            
            users.varDesignation
            FROM
            complaint
            INNER JOIN victim_information ON complaint.complaint_id = victim_information.complaint_id
            INNER JOIN `status` ON `status`.status_id = complaint.present_status
            INNER JOIN users ON users.id = complaint.last_opt_user_id            
            INNER JOIN complaint_delivery_method ON complaint_delivery_method.intComplaintID = complaint.complaint_id 
            INNER JOIN basic_data ON basic_data.id = complaint_delivery_method.intDeliveryID 
            WHERE
            complaint_delivery_method.intDeliveryID=?
            ";
        $binds = array($method);
        if ($dateTO == "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateFrom;
        }
        if ($dateTO != "" && $dateFrom == "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) = ?";
            $binds[] = $dateTO;
        }
        if ($dateTO != "" && $dateFrom != "")
        {
            $sql .= " AND Date(complaint.complaint_received_date) BETWEEN ? AND ?";
            $binds[] = $dateFrom;
            $binds[] = $dateTO;
        }
        $sql .= "GROUP BY
              complaint_delivery_method.intComplaintID
              ";
        return $this->db->query($sql, $binds)->result_array();
    }

}

