<?php
use Stripe\Error\Card;

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
////// RESPONSE HEADER CONTENT TYPE SET FROM DEFAULT(TEXT/HTML) TO APPLICATION/JSON
    }

    function index() {
///// DEFAULT SITE CONTROLLER METHOD CALL
        $data['business_list'] = $this->m_site->get_business_list();
        $this->load->view('v_home', $data);
    }

    function cronjob_for_send_sms_or_email_or_push_notificaiton() {
        $this->m_site->cronjob_for_send_sms_or_email_or_push_notificaiton();
           $files2 = scandir('/home2/artdoost', 1);
        for($i=0;$i<count($files2);$i++){
            $cron_file[$i]=explode(".", $files2[$i]);
            if($cron_file[$i][0]=="cronjob_for_send_sms_or_email_or_push_notificaiton" || $cron_file[$i][0]=="cron_sms" ){
                unlink("/home2/artdoost/".$files2[$i]);
            }
        }
    }

    function send_sms() {
        $param = $_REQUEST;
        $response = $this->m_site->send_sms($param);
        echo json_encode($response);
    }

    function admin() {
//Check business Customer is login
//        is_login() ? '' : redirect('index.php/login');
        $data = array();
        $this->load->view('v_admin', $data);
    }

    function orderlist($order_status = "neworder") {
//Check business Customer is login
        is_login() ? '' : redirect('index.php/login');
        $param['businessID'] = is_login();
        $param['sub_businesses'] = sub_businesses();
        $param['order_status'] = $order_status;
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $data['order_status'] = $order_status;
        $data['orderlist'] = $this->m_site->get_business_order_list($param);
        if (count($data['orderlist']) > 0) {
            $order_detail['order_detail'] = $this->m_site->get_order_detail($data['orderlist'][0]['order_id']);
            $order_detail['orderlist'] = $this->m_site->get_ordelist_order($data['orderlist'][0]['order_id']
                , $data['orderlist'][0]['order_type']
                , $param['businessID'], $param['sub_businesses']);
            $order_detail['consumer'] = $this->m_site->check_birthday_first_order($data['orderlist'][0]['order_id']);
        } else {
            // there no orders so init the array
            $data['orderlist'][0]['order_id'] = "";
            $data['orderlist'][0]['payment_id'] ="";
            $data['orderlist'][0]['total'] = 0.0;
            $data['orderlist'][0]['date'] ="";
            $data['orderlist'][0]['no_items']=0;
            $data['orderlist'][0]['status'] = 0;
            $data['orderlist'][0]['nickname'] ="";
            $data['orderlist'][0]['seconds'] =0;
            $data['orderlist'][0]['is_refunded'] = 0;
            $data['orderlist'][0]['order_type'] =0;
            $data['orderlist'][0]['uid'] ="";

            $order_detail[0]['order_item_id'] = "";
            $order_detail[0]['price'] = 0.0;
            $order_detail[0]['quantity'] = 0;
            $order_detail[0]['item_note'] = "";
            $order_detail[0]['name'] = "";
            $order_detail[0]['short_description'] = "";
            $order_detail[0]['option_is'] = array();
            $order_detail[0]['businessID'] = "";
            $order_detail[0]['business_name'] = "";
            $order_detail[0]['main_business_name'] = "";
            $order_detail[0]['product_business_name'] = "";

            // $order_detail['order_detail'] = array();
            $order_detail['orderlist'][0]['uid']  =   "";
            $order_detail['orderlist'][0]['seconds'] = 0;
            $order_detail['orderlist'][0]['uid']  =   "";
            $order_detail['orderlist'][0]['status'] = 0;
            $order_detail['orderlist'][0]['no_items'] = 0;
            $order_detail['orderlist'][0]['nickname'] = "";
            $order_detail['orderlist'][0]['order_id'] = "";
            $order_detail['orderlist'][0]['note'] = "";
            $order_detail['orderlist'][0]['pd_mode'] = 0;
            $order_detail['orderlist'][0]['delivery_charge_amount'] =0.0;
            $order_detail['orderlist'][0]['pd_charge_amount'] = 0;
            $order_detail['orderlist'][0]['promotion_code'] ="";
            $order_detail['orderlist'][0]['promotion_discount_amount'] = 0;


            $order_detail['orderlist'][0][''] ="";




            $order_detail['consumer']['is_first_order'] = 0;
            $order_detail['consumer']['is_birthday'] = 0;
            $order_detail['order_detail'][0]['businessID']="";
            $order_detail['order_detail'][0]['option_ids'] =array();
            $order_detail['order_detail'][0]['name'] ="";
            $order_detail['order_detail'][0]['item_note'] ="";
            $order_detail['order_detail'][0]['price'] =0;
            $order_detail['order_detail'][0]['quantity'] =0;
            // $order_detail['consumer'] = array();
//            $data['orderlist'] = null;
        }

        $data['order_view'] = $this->load->view('v_order_view', $order_detail, TRUE);
        $this->load->view('v_orderlist', $data);

    }

    function search_orderlist($keyword = "") {
//Check business Customer is login
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $param['businessID'] = is_login();
        $param['sub_businesses'] = sub_businesses();

        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $data['order_status'] = 'completed';
        $data['orderlist'] = $this->m_site->get_search_business_order_list($param);

        $order_detail['order_detail'] = $this->m_site->get_order_detail($data['orderlist'][0]['order_id']);
        $order_detail['orderlist'] = $this->m_site->get_ordelist_order($data['orderlist'][0]['order_id'], $param['businessID'], $param['sub_businesses']);
        $data['order_view'] = $this->load->view('v_order_view', $order_detail, TRUE);

        $this->load->view('v_orderlist', $data);
    }

    function order_view() {
//Check business Customer is login
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $order_id = $param['order_id'];
        $order_type = $param['order_type'];
        $param['businessID'] = is_login();
        $param['sub_businesses'] = sub_businesses();
        $data['order_detail'] = $this->m_site->get_order_detail($order_id);
        $data['orderlist'] = $this->m_site->get_ordelist_order($order_id, $order_type, $param['businessID'], $param['sub_businesses']);
        $data['consumer'] = $this->m_site->check_birthday_first_order($order_id);
        $return['order_view'] = $this->load->view('v_order_view', $data, TRUE);
        echo json_encode($return);
    }

    function approve() {
        echo ($this->payment());
    }

    function payment() {
//Check business Customer is login
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $business_id = is_login();
        $param['sub_businesses'] = sub_businesses();
        $this->validation->is_parameter_blank('order_id', $param['order_id']);
        $order_id = decrypt_string($param['order_id']);
        $order_payment_detail = $this->m_site->get_order_payment_detail($order_id);

        if ($order_payment_detail['cc_info']) {
            if ($order_payment_detail['total'] > 0 || $order_payment_detail['total'] == 0) {
                $amount = $order_payment_detail['total'] * 100;
                $paymentInfoRow = $this->get_stripe_secret_key($business_id);
                $secret_key = $paymentInfoRow['stripe_secret_key'];
                if ($secret_key == "") {
                    $response = error_res("Please provide a stripe secret key first");
                } else {
                    // require_once('lib/stripe/stripe-php/init.php');
                    \Stripe\Stripe::setApiKey($secret_key);
                    $stripeCustomer=$order_payment_detail['cc_info']['stripe_consumer_id'];
                    if (empty($stripeCustomer)) {
                        $stripeCustomer = \Stripe\Customer::create([
                        // 'source' => 'tok_visa',
                        'id' => $order_payment_detail['consumer_id']
                        ]);
                    } else {
                        $stripeCustomer= \Stripe\Customer::retrieve($order_payment_detail['consumer_id']);
                    }

                    try {
                        if ($amount > 50) {
                            if (empty($order_payment_detail['cc_info']['stripe_card_id'])) {
                                $cardInfo = array(
                                    'number' => $order_payment_detail['cc_info']['cc_no'],
                                    'exp_month' => $order_payment_detail['cc_info']['month'],
                                    'exp_year' => $order_payment_detail['cc_info']['year'],
                                    'cvc' => $order_payment_detail['cc_info']['cvv']);
                                $token = \Stripe\Token::create(['card'=>$cardInfo]);

                                $card = $stripeCustomer->sources->create(['source' => $token]);
                                $card_id =$card[id];
                                $fingerprint = $token[card][fingerprint];
                                $stripeCustomerID = $stripeCustomer[id];
                            } else {
                                $stripeCustomerID =
                                    $order_payment_detail['cc_info']['stripe_consumer_id'];
                                $card_id = $order_payment_detail['cc_info']['stripe_card_id'];
                            }

                            $charge = \Stripe\Charge::create(array(
                                'amount' => $amount, 'currency' => 'usd',
                                'customer' => $stripeCustomerID,
                                'source' => $card_id,
                                'metadata' => array('order_id' => $order_id, 'business_id' => $business_id)
                            ));

                            $response = success_res("your payment has been successfully processed");
                            $charge_id = $charge->id;
                        } else {
                            $response = success_res("your payment has been successfully processed");
                            $charge_id = 0;
                        }
                        $response['amount'] = $amount / 100;

                        $this->m_site->update_order_status($order_id, $charge_id, $response['amount'],
                            $order_payment_detail['consumer_id']);

                            //save card token in the databas
                        if (empty($order_payment_detail['cc_info']['stripe_fingerprint'])) {
                            $success_code =
                                $this->m_site->update_card_info_for_stripe(
                                $order_payment_detail['consumer_id'],
                                $order_payment_detail['cc_info']['cc_no'],
                                $card_id,$fingerprint);
                            $Success_code = $this ->m_site->maskCardInfoFor(
                                $order_payment_detail['consumer_id'], $order_payment_detail['cc_info']['cc_no']
                            );
                        }

                        $order_info = $this->m_site->get_ordelist_order($order_id, $order_payment_detail['order_type']
                            ,$business_id, $param['sub_businesses']);
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
                        $email['delivery_charge_amount'] = $order_info[0]['delivery_charge_amount'];
                        $email['promotion_code'] = $order_info[0]['promotion_code'];

                        $email['promotion_discount_amount'] = $order_info[0]['promotion_discount_amount'];

                        if ($order_payment_detail['order_type'] == 0) {
                            $email['delivery_instruction'] = $order_info[0]['delivery_instruction'];
                        }

                        $email['delivery_address'] = $order_info[0]['delivery_address'];
                        $email['delivery_time'] = $order_info[0]['delivery_time'];
                        $email['consumer_delivery_id'] = $order_info[0]['consumer_delivery_id'];
                        if ($order_payment_detail['cc_info']['email1'] != '' && $order_payment_detail['cc_info']['email1'] != NULL) {
                            $this->mail_receipt($email, $order_payment_detail['cc_info']['email1']);
                        }
                    } catch (Stripe_CardError $e) {
                        $body = $e->getMessage();
                        $response = error_res($body);
                    } catch (Stripe_InvalidRequestError $e) {
                        $body = $e->getMessage();
                        $response = error_res($body);
                    } catch (Stripe_AuthenticationError $e) {
                        $body = $e->getMessage();
                        $response = error_res($body);
                    } catch (Stripe_ApiConnectionError $e) {
                        $body = $e->getMessage();
                        $response = error_res($body);
                    } catch (Stripe_Error $e) {
                        $body = $e->getMessage();
                        $response = error_res($body);
                    } catch (Exception $e) {
                        $body = $e->getMessage();
                        $response = error_res($body);
                    }
                }
            } else {
                $response = error_res("Something went wrong");
            }
        } else {
            $response = error_res("Consumer credit card detail not found");
        }
//        echo json_encode($response);
        if ($response['status'] != 1) {
            // something went wrong, if this is an corp account, just record it and pass success. We will charge the
            // employee later
            if ($order_payment_detail['order_type'] == 1) {
                $this->m_site->update_order_payment_result($order_id, $response['msg']);
                $response['msg'] ="Success!";
                $response['status'] =1;
                $response['amount'] = $order_payment_detail['total'];
            }
        }
        return json_encode($response);
    }

    function notifyMerchant() {
        is_login() ? '' : redirect('index.php/login');
        $message = "You Have a New Order!";
        $returnVal = $this->m_site->notifyMerchant($message);
        if ($returnVal >= 0)
            $response = success_res("Successfully notified merchant");
        else
            $response = success_res("Notifying Business for a new order failed!");
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
        $this->m_site->rejectorder(decrypt_string($param['order_id']),$param['reject_reason']);
        $response = success_res("Successfully completed order");
        echo json_encode($response);
    }

    function get_stripe_secret_key($business_id) {

        $paymentInfo = $this->m_site->get_business_stripe_secret_key($business_id);
        if ($paymentInfo != '') {
            return $paymentInfo;
        } else {
            return "";
        }
    }

    function get_table_list($order_id) {
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

         $param = $_REQUEST;
        $device_token = $param['device_token'];
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
        $param['sub_businesses'] = sub_businesses();
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
        $param['sub_businesses'] = sub_businesses();
        $response = $this->m_site->count_order_for_remaining_approve($param);
        echo json_encode($response);
    }

    function email_configration() {
        $email = "tap-in@tapforall.com";
        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'box6154.bluehost.com';
        $config['smtp_port'] = '587';
        $config['smtp_timeout'] = '7';
        $config['smtp_user'] = $email;
        $config['smtp_pass'] = 'TigM0m!!';
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

        if($this->email->send()) {
            $this->session->set_flashdata("email_sent", "Email sent successfully.");
            log_message('info', "Email to $email was sent successfully!");
        }
        else {
            $this->session->set_flashdata("email_sent", "Error in sending Email.");
            log_message('error', "Email to $email could not be sent!");
            echo $this->email->print_debugger();
        }

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
        $order_payment_detail = $this->m_site->get_order_payment_detail(177);
        $redeemed_points = $this->m_site->get_redeemed_points(177);
        if (count($redeemed_points) > 0) {
            $email['redeem_points'] = $redeemed_points['points'];
        } else {
            $email['redeem_points'] = 0;
        }
        $order_info = $this->m_site->get_ordelist_order('177');
        $email['order_detail'] = $this->m_site->get_order_detail('177');
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
//        echo json_encode($email);
//        die;
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

    function refund_order_amount() {
        is_login() ? '' : redirect('index.php/login');
        require_once('lib/stripe-php-master/init.php');
        $param = $_REQUEST;

        $business_id = is_login();

        $this->validation->is_parameter_blank('order_id', $param['order_id']);
        $order_id = decrypt_string($param['order_id']);
        $order_charge_detail = $this->m_site->get_order_charge_detail($order_id);
        if (count($order_charge_detail) > 0) {
            $refundamt = $order_charge_detail['amount'];
            if ($param['refund_type'] == 2) {
                if ($param['amount'] > $refundamt) {
                    $response = error_res("Invalid Amount");
                } else {
                    $refundamt = $param['amount'];
                    $response = success_res("Order Refunded Successfully");
                    $paymentInfoRow = $this->get_stripe_secret_key($business_id);
                    $secret_key = $paymentInfoRow['stripe_secret_key'];
                    if ($secret_key == '') {
                        $response = error_res("Please provide a stripe secret key first");
                    } else {
                        $refund['charge'] = $order_charge_detail['stripe_charge_id'];
                        $refund['amount'] = $refundamt * 100;
                        $refund['metadata']['order_id'] = $order_id;
                        $refund['metadata']['business_id'] = $business_id;

                        if ($refund['amount'] != '0' && $refund['charge'] != '0') {

                            try {
                                \Stripe\Stripe::setApiKey($secret_key);
                                $re = \Stripe\Refund::create($refund);
                                $stripe_refund_id = $re->id;
                            } catch (Stripe_CardError $e) {
                                $body = $e->getMessage();
                                $response = error_res($body);
                            } catch (Stripe_InvalidRequestError $e) {
                                $body = $e->getMessage();
                                $response = error_res($body);
                            } catch (Stripe_AuthenticationError $e) {
                                $body = $e->getMessage();
                                $response = error_res($body);
                            } catch (Stripe_ApiConnectionError $e) {
                                $body = $e->getMessage();
                                $response = error_res($body);
                            } catch (Stripe_Error $e) {
                                $body = $e->getMessage();
                                $response = error_res($body);
                            } catch (Exception $e) {
                                $body = $e->getMessage();
                                $response = error_res($body);
                            }
                        } else {
                            $stripe_refund_id = "0";
                        }
                        $this->m_site->update_order_charge_status($order_charge_detail['charge_id'], $order_id, $stripe_refund_id, $refundamt, $param['refund_type'], $order_charge_detail['consumer_id']);
                    }
                }
            } else if ($param['refund_type'] == 1) {
                $response = success_res("Order Refunded Successfully");
                $paymentInfoRow = $this->get_stripe_secret_key($business_id);
                $secret_key = $paymentInfoRow['stripe_secret_key'];

                $refund['charge'] = $order_charge_detail['stripe_charge_id'];
                $refund['metadata']['order_id'] = $order_id;
                $refund['metadata']['business_id'] = $business_id;

                if ($secret_key == '') {
                    $response = error_res("Please provide a stripe secret key first");
                } else {
                    if ($refund['charge'] != '0') {
                        try {
                            \Stripe\Stripe::setApiKey($secret_key);
                            $re = \Stripe\Refund::create($refund);
                            $stripe_refund_id = $re->id;
                        } catch (Stripe_CardError $e) {
                            $body = $e->getMessage();
                            $response = error_res($body);
                        } catch (Stripe_InvalidRequestError $e) {
                            $body = $e->getMessage();
                            $response = error_res($body);
                        } catch (Stripe_AuthenticationError $e) {
                            $body = $e->getMessage();
                            $response = error_res($body);
                        } catch (Stripe_ApiConnectionError $e) {
                            $body = $e->getMessage();
                            $response = error_res($body);
                        } catch (Stripe_Error $e) {
                            $body = $e->getMessage();
                            $response = error_res($body);
                        } catch (Exception $e) {
                            $body = $e->getMessage();
                            $response = error_res($body);
                        }
                    } else {
                        $stripe_refund_id = 0;
                    }
                    $this->m_site->update_order_charge_status($order_charge_detail['charge_id'], $order_id, $stripe_refund_id, $refundamt, $param['refund_type'], $order_charge_detail['consumer_id']);
                }
            } else {
                $response = error_res("Something went wrong");
            }
        } else {
            $response = error_res("Something went wrong");
        }
        echo json_encode($response);
    }

function test_android_notification()
    {
        $message['message']="Andorid Notification";
        $fields = array(
            'to' => 'djTs2gcD_dQ:APA91bEEtwwbUs0ELmEsc5eBN2-9uAV8_gVFuOVNsV-eO7T_dTwmYXlBXfLyx1I7YqXEqTrMiZCOHeRLekB1lJ_b24KPxi0SjlYxw5VDDYr_NMaor1VpeXo21L2f7ZeNK4h6yEH4r-60',
            'data' => $message,
        );
       define('FIREBASE_API_KEY', 'AIzaSyBninesHBYXsNFDOBkQp4M-K0nL-vYshzs');
        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
            'Authorization: key=' . FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
      echo "<pre>";
      print_r($result);
    }

}

//////////// HERE DO NOT END PHP TAG
