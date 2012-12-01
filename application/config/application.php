<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

date_default_timezone_set('Asia/Dhaka');


$config['site.title'] = "NHRC CMS";
$config['site.system_email.title'] = "NHRC SYSTEM";
$config['site.system_email'] = "amiya.saha@technovista.com.bd";
$config['site.status'] = 1;  // 0 = offline, 1 = online
$config['site.list_limit'] = 25;
$config['MYDESK_LIST'] = 15;
$config['SETTINGS_PAGING_LIMIT'] = 20;

$config['site.cache'] = TRUE;
$config['site.limit'] = 300; // 5*60 Sec

$config['ACTIVE'] = 1;
$config['UPLOAD_ROOT_DIR'] = "uploads/";
$config['MAX_ALLOWED_FILE_SIZE'] = 6000; // KB
$config['ALLOWED_FILE_TYPE'] = "gif|jpg|jpeg|pdf|doc|docx|png|avi|mp3|wav";

// Basic Setting IDS
$config['MATHOD_OF_COMP_DELIVERY'] = 1;
$config['COMPALINT_TYPE'] = 4;
$config['DISCIPLINED_FORCE'] = 3;
$config['AGAINST_RESPONDENT_TYPE'] = 2;
$config['KIND_OF_HR_VIOLATION'] = 5;
$config['RELIGION'] = 6;


// Status IDS
$config['STAT_COMPALINT_SUBMIT'] = 1;
$config['STAT_DATA_ENTRY'] = 2;
$config['COMPLAIN_RESOLVED'] = "5, 14";
$config['COMPLAINTS_REFERRED_NGO'] = 24;
$config['COMPLAINTS_RECEIVED_NGO'] = 25;
$config['RESPONSE_PENDING_MINISRY_HOMES'] = 18;

// Desk IDS
$config['FRONT_DESK'] = 3;
$config['DATA_ENTRY_DESK'] = 2;

//user ids
$config['online_user_id'] = 8;


