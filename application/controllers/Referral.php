<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Referral extends CI_Controller {

    public function __construct() {
        parent::__construct();
////////////DEFAULT LOAD BELOW FUNCTIONALITY WHEN CALL V1 CONTROLLER
/////// LOAD LIBRARY VALIDATION CLASS
        $this->load->library('validation');
///// LOAD MODEL CLASS
        $this->load->model('m_site');
////// RESPONSE HEADER CONTENT TYPE SET FROM DEFAULT(TEXT/HTML) TO APPLICATION/JSON
    }

    function index() {
///// DEFAULT SITE CONTROLLER METHOD CALL
    }



    function email_configration() {
        $email = "tap-in@tapforall.com";
        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.tapforall.com';
        $config['smtp_port'] = 587;
        $config['smtp_timeout'] = '7';
        $config['smtp_user'] = $email;
        $config['smtp_pass'] = 'TigM0m!!';
        $config['charset'] = 'utf-8';
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not
        $config['wordwrap'] = TRUE;
        $config['smtp_crypto'] = '';

        $this->email->initialize($config);
        $this->email->from($email, 'tap-in');
    }

    function sendEmailTo($toEmail, $subject, $messageBody) {
        $this->email_configration();
        $this->email->to($toEmail);
        $this->email->subject($subject);
        $this->email->message($messageBody);
        $result = $this->email->send();
//        echo $this->email->print_debugger();
        if ($result != true) {
            log_message('error', "Email to $toEmail with subject $subject could not be sent!");
        }
    }

    function reward_referrer() {
        $email1 = $_REQUEST['email1'];
        $email2 = $_REQUEST['email2'];

        $referrer_info = $this->m_site->get_referrer_info($email1, $email2);
        if (empty($referrer_info["email1"])) {
            log_message('error', "Referrer with emails $email1 or $email2 could not be found!");
            return;
        }

        $referrer_email = $referrer_info["email1"];
        if ($referrer_email != "") {
            // first give him the awards
            $dollarAmountForRewards = DollarAmountForReferral;
            $business_id = 0;
            $pointReason = PointTypeForReferral;
            $this->m_site->insertReferralPointsFor($referrer_info['uid'], $business_id, $pointReason, $dollarAmountForRewards);

            // now notify him
            $messageBody = "Your friend with the email of $referrer_email just joined us. Thank you!";
            $this->sendEmailTo($referrer_email, "Reward Points for Referral", $messageBody);
        }

    }

}

//////////// HERE DO NOT END PHP TAG
