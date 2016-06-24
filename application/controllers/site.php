<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Site extends CI_Controller {

    public function __construct() {
        parent::__construct();
////////////DEFAULT LOAD BELOW FUNCTIONLITY WHEN CALL V1 CONTROLLER
/////// LOAD LIBRARY VALIDATION CLASS
        $this->load->library('validation');
///// LOAD MODEL CLASS
        $this->load->model('m_site');
////// RESONSE HEADER CONTEN TYPRE SET FROM DEFAULT(TEXT/HTML) TO APPLICATION/JSON
    }

    function index() {
///// DEFULT SITE CONTROLLER MEHOD CALL 
        $data['business_list'] = $this->m_site->get_business_list();
        $this->load->view('v_home', $data);
    }

    function orderlist($order_status = "neworder") {
//Check business Customer is login
        is_login() ? '' : redirect('index.php/login');
        $param['businessID'] = is_login();
        $param['order_status'] = $order_status;
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $data['order_status'] = $order_status;
        $data['orderlist'] = $this->m_site->get_business_order_list($param);
        $order_detail['order_detail'] = $this->m_site->get_order_detail($data['orderlist'][0]['order_id']);
        $order_detail['orderlist'] = $this->m_site->get_ordelist_order($data['orderlist'][0]['order_id']);
        $data['order_view'] = $this->load->view('v_order_view', $order_detail, TRUE);

        $this->load->view('v_orderlist', $data);
    }

    function order_view() {
//Check business Customer is login
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $order_id = $param['order_id'];
        $data['order_detail'] = $this->m_site->get_order_detail($order_id);
        $data['orderlist'] = $this->m_site->get_ordelist_order($order_id);
        $return['order_view'] = $this->load->view('v_order_view', $data, TRUE);
        echo json_encode($return);
    }

    function payment() {

//Check business Customer is login
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $business_id = is_login();
        $this->validation->is_parameter_blank('order_id', $param['order_id']);
        $order_id = decrypt_string($param['order_id']);
        $order_payment_detail = $this->m_site->get_order_payment_detail($order_id);

        if ($order_payment_detail['cc_info']) {
            if ($order_payment_detail['total'] > 0 || $order_payment_detail['total'] == 0) {
                $amount = $order_payment_detail['total'] * 100;
                $secret_key = $this->get_stripe_secret_key($business_id);
                if ($secret_key == "") {
                    $response = error_res("Something went wrong");
                } else {

                    if ($amount != 0) {

                        require_once('lib/stripe-php-master/init.php');
                        \Stripe\Stripe::setApiKey($secret_key);
                        $myCard = array('number' => $order_payment_detail['cc_info']['cc_no'], 'exp_month' => $order_payment_detail['cc_info']['month'], 'exp_year' => $order_payment_detail['cc_info']['year']);
                        $charge = \Stripe\Charge::create(array('card' => $myCard, 'amount' => $amount, 'currency' => 'usd'));
                        $response = success_res("your payment has been successfully processed");
                        $charge_id = $charge->id;
                    } else {
                        $response = success_res("your payment has been successfully processed");
                        $charge_id = 0;
                    }
                    $response['amount'] = $amount / 100;

                    $this->m_site->update_order_status($order_id, $charge_id, $response['amount'], $order_payment_detail['consumer_id']);

                    $order_info = $this->m_site->get_ordelist_order($order_id);
                    $email['order_detail'] = $this->m_site->get_order_detail($order_id);
                    $redeemed_points = $this->m_site->get_redeemed_points($order_id);
                    if (count($redeemed_points) > 0) {
                        $email['redeem_points'] = $redeemed_points['points'];
                    } else {
                        $email['redeem_points'] = 0;
                    }
                    $email['order_id'] = $order_id;
                    $email['total'] = $order_payment_detail['total'];
                    $email['cc_no'] = $order_payment_detail['cc_info']['cc_no'];
                    $email['exp_month'] = $order_payment_detail['cc_info']['month'];
                    $email['exp_year'] = $order_payment_detail['cc_info']['year'];
                    $email['business_id'] = $business_id;
                    $email['business_name'] = $this->session->userdata('name');
                    $email['subtotal'] = $order_info[0]['subtotal'];
                    $email['tip_amount'] = $order_info[0]['tip_amount'];
                    $email['tax_amount'] = $order_info[0]['tax_amount'];
                    $email['points_dollar_amount'] = $order_info[0]['points_dollar_amount'];

                    if ($order_payment_detail['cc_info']['email1'] != '' && $order_payment_detail['cc_info']['email1'] != NULL) {
                        $this->mail_receipt($email, $order_payment_detail['cc_info']['email1']);
                    }
                }
            } else {
                $response = error_res("Something went wrong");
            }
        } else {
            $response = error_res("Consumer credit card detail not found");
        }
        echo json_encode($response);
    }

    function completedorder() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $this->validation->is_parameter_blank('order_id', $param['order_id']);
        $this->m_site->completedorder(decrypt_string($param['order_id']));
        $response = success_res("Successfully completed order");
        echo json_encode($response);
    }

    function rejectorder() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $this->validation->is_parameter_blank('order_id', $param['order_id']);
        $this->m_site->rejectorder(decrypt_string($param['order_id']));
        $response = success_res("Successfully completed order");
        echo json_encode($response);
    }

    function get_stripe_secret_key($business_id) {

        $stripe_token = $this->m_site->get_business_stripe_secret_key($business_id);
        if ($stripe_token != '') {
            return $stripe_token;
        } else {
            return "sk_test_HLQ9NIFofiiRukm1AZnjCfOe";
        }
    }

    function test_paymen() {
        require_once('lib/stripe-php-master/init.php');
        \Stripe\Stripe::setApiKey('sk_test_JQCcDe4RIqIq1IcmVfvLPyay ');
        $myCard = array('number' => '4242424242424242', 'exp_month' => 8, 'exp_year' => 2018);

        $charge = \Stripe\Charge::create(array('card' => $myCard, 'amount' => 10000, 'currency' => 'usd'));
        print_r($charge);
        die;
        echo '<pre>';
        print_r($charge);
    }

    function get_table_list() {
        echo '<pre>';
        $tables = $this->m_site->get_table_list($order_id);
        print_r($tables);
    }

    function create_cusomer() {
        require_once('lib/stripe-php-master/init.php');
        \Stripe\Stripe::setApiKey('sk_test_JQCcDe4RIqIq1IcmVfvLPyay ');
        $myCard = array('number' => '4242424242424242', 'exp_month' => 8, 'exp_year' => 2018);
        $abc = "0";
        $charge = \Stripe\Charge::create(array('card' => $myCard, 'amount' => 10000, 'currency' => 'usd'));
        print_r($charge);
        print_r($charge);
    }

    function test_notification() {
        $device_token = 'a80f300f10a38125ec6d1375276084495a6434306c7aa136c67f02d2340b8775';
        $message_body = array(
            'type' => 1,
            'alert' => "Distribution Notification Testing",
            'badge' => 0,
            'sound' => 'newMessage.wav'
        );
        $res = push_notification_ios($device_token, $message_body);
        echo json_encode($res);
    }

    function get_new_orders() {
        $param = $_REQUEST;
        $this->validation->is_parameter_blank('latest_order_id', $param['latest_order_id']);
        $param['businessID'] = is_login();
        $response = $this->m_site->get_new_orders($param);
        if (count($response) > 0) {
            $data['orderlist'] = $response;
            $return = success_res("New order found");
            $return['new_orderlist'] = $this->load->view('v_new_orderlist', $data, TRUE);
            $return['latest_order_id'] = $response[0]['order_id'];
            $return['count_new_order'] = count($response);
        } else {
            $return = error_res("New order not available");
        }
        echo json_encode($return);
    }

    function count_order_for_remaining_approve() {
        $param['businessID'] = is_login();
        $response = $this->m_site->count_order_for_remaining_approve($param);
        echo json_encode($response);
    }

    function email_configration() {


        $email = "info@artdoost.com";
        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.artdoost.com';
        $config['smtp_port'] = '26';
        $config['smtp_timeout'] = '7';
        $config['smtp_user'] = $email;
        $config['smtp_pass'] = 'Ankit123!!';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not      
        $this->email->initialize($config);
        $this->email->from($email, 'Tap-in');
    }

    function mail_receipt($data, $email) {
        $this->email_configration();
        $body = $this->load->view('v_email_receipt', $data, TRUE);
        $subject = "Your Order Receipt";
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($body);
        $this->email->send();
//        echo $this->email->print_debugger();
    }

    function send_mail_demo() {
//        $data['order_detail'] = [array('quantity' => 3, 'name' => 'test', 'short_description' => 'This is short description', 'price' => 6)];
//        $data['total'] = 10;
//        $data['order_id'] = 194;
//        $data['cc_no'] = 4242424242424242;
//        $data['exp_month'] = 12;
//        $data['exp_year'] = 2024;
//        $data['business_id'] = is_login();
//        $data['business_name'] = $this->session->userdata('name');
        $order_payment_detail = $this->m_site->get_order_payment_detail(420);
        $redeemed_points = $this->m_site->get_redeemed_points(420);
        if (count($redeemed_points) > 0) {
            $email['redeem_points'] = $redeemed_points['points'];
        } else {
            $email['redeem_points'] = 0;
        }
        $order_info = $this->m_site->get_ordelist_order('420');
        $email['order_detail'] = $this->m_site->get_order_detail('420');
        $email['order_id'] = '420';
        $email['total'] = $order_payment_detail['total'];
        $email['cc_no'] = $order_payment_detail['cc_info']['cc_no'];
        $email['exp_month'] = $order_payment_detail['cc_info']['month'];
        $email['exp_year'] = $order_payment_detail['cc_info']['year'];
        $email['subtotal'] = $order_info[0]['subtotal'];
        $email['tip_amount'] = $order_info[0]['tip_amount'];
        $email['tax_amount'] = $order_info[0]['tax_amount'];
        $email['points_dollar_amount'] = $order_info[0]['points_dollar_amount'];
        $email['business_id'] = 1;
        $email['business_name'] = $this->session->userdata('name');

        $this->load->view('v_email_receipt', $email);
    }

    function phpinfo() {
        echo phpinfo();
    }

    function send_simple_message() {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:key-f00e20caad2538b5d5f7f40892cdfb28');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //     curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/sandboxb5d83d4289364f3bb3100e1a1f20a1d3.mailgun.org/messages');
        curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/sandboxb5d83d4289364f3bb3100e1a1f20a1d3.mailgun.org/messages');
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => 'Ankit S<postmaster@sandboxb5d83d4289364f3bb3100e1a1f20a1d3.mailgun.org>',
            'to' => 'Lalit <lalit.appvolution@gmail.com>',
            'subject' => 'The Printer Caught Fire',
            'html' => 'Testing mail gun.'));
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        echo '<pre>';
        echo json_encode($result);
        echo 'ok';
    }

}

//////////// HERE DO NOT END PHP TAG  
