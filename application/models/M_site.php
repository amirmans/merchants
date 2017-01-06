<?php

class M_site extends CI_Model {

    public function __construct() {
        parent::__construct();
        //date_default_timezone_set("GMT");
        date_default_timezone_set('America/Los_Angeles');
    }

   function cron_sms() {

        $message = "There is a new order!";
        require_once APPPATH . 'libraries/Twilio/autoload.php'; // Loads the Twilio library
        $TapInServerConstsParentPath = APPPATH . "../" . "../" . staging_directory() . '/include/consts_server.inc';
        require_once $TapInServerConstsParentPath; // Loads our consts
//        use Twilio\Rest\Client;
        $query = "SELECT `o`.`order_id`,`o`.business_id,`bc`.`sms_no`,(TIMESTAMPDIFF(second ,date ,now())) as secound FROM (SELECT * FROM `order` ORDER BY `order`.`order_id` DESC ) as o LEFT JOIN business_internal_alert as bc on bc.business_id=o.business_id where (TIMESTAMPDIFF(second ,date ,now())) > 300 and `o`.`status`='1' group by `o`.`business_id` order by `o`.`order_id` DESC";
        $result = $this->db->query($query);
        $row = $result->result_array();
  
        for ($i = 0; $i < count($row); $i++) {
            $sms_numbers = $row[$i]["sms_no"];
            $business_id = $row[$i]["business_id"];
            if (!empty($sms_numbers)) {
                $sms_numbers = preg_replace('/\s/', '', $sms_numbers);
                $sms_numbers_array = explode(',', $sms_numbers);
            //    print_r($sms_numbers_array);
                foreach ($sms_numbers_array as $sms_no) {
                   
                    $this->smsMerchant("There is a new order!", $sms_no, $business_id);
                }
            }
        }
    }

    function do_login($param) {
        $this->db->select('businessID,name,username,sub_businesses');
        $this->db->from('business_customers');
        $this->db->limit(1);
        $this->db->where('username', $param['username']);
        $this->db->where('password', md5($param['password']));
        $this->db->where('active = 1 or beta = 1');
        $result = $this->db->get();
        $row = $result->result_array();

        if (count($row) > 0) {
            $return = success_res("");
            $this->session->set_userdata($row[0]);
            if ($param['business_url'] != '') {
                $this->session->set_userdata(array("business_url" => $param['business_url']));
            }
        } else {
            $return = error_res("Username or password incorrect");
            $this->session->set_flashdata('error1', 'Username or password incorrect');
        }
        return $return;
    }

    function do_authenticate($param) {
        $this->db->select('businessID,name,username');
        $this->db->from('business_customers');
        $this->db->limit(1);
        $this->db->where('stripe_username', $param['username']);
        $this->db->where('stripe_password', md5($param['password']));
        $this->db->where('businessID', $param['businessID']);
        $this->db->where('active = 1 or beta = 1');
        $result = $this->db->get();
        $row = $result->result_array();

        if (count($row) > 0) {
            $return = success_res("");
            $return["user"] = $row[0];
        } else {
            $return = error_res("Username or password incorrect");
        }
        return $return;
    }

    function get_table_list() {
        $query = "select * from information_schema.tables";
        $result = $this->db->query($query);
        $row = $result->result_array();
        return $row;
    }

    function get_business($businessID) {
        $this->db->select('businessID,name,username,email,website,businessTypes,phone,address,city,state,zipcode,stripe_secret_key,icon,marketing_statement,process_time,short_name,sms_no,pictures');
        $this->db->from('business_customers');
        $this->db->where('businessID', $businessID);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->result_array();


        $this->db->select('entry_id,from_date,to_date,weekday_id,opening_time,closing_time');
        $this->db->from('opening_hours');
        $this->db->where('businessID', $businessID);
        $this->db->order_by('weekday_id', 'asc');
        $openinghours_result = $this->db->get();
        $hours = $openinghours_result->result_array();
        $row[0]['hours'] = $hours;


        $this->db->select('email,sms_no');
        $this->db->from('business_internal_alert');
        $this->db->where('business_id', $businessID);
        $this->db->limit(1);
        $result_interal = $this->db->get();
        $row_interal = $result_interal->result_array();
        if (count($row_interal) > 0) {
            $internal = $row_interal[0];
        } else {
            $internal = array();
        }

        if (count($row) > 0) {
            $return = success_res("Business is available");
            $return['business_detail'] = $row[0];
            $return['internal'] = $internal;
        } else {
            $return = error_res("Business is not available");
            $return['business_detail'] = array();
            $return['business_detail'] = $internal;
        }
        return $return;
    }

    function get_business_list() {
        $this->db->select('businessID,name');
        $this->db->from('business_customers');
        $this->db->where('active = 1 or beta = 1');
        $this->db->order_by("businessID", "asc");
        $result = $this->db->get();
        $row = $result->result_array();
        return $row;
    }

    function get_business_stripe_secret_key($businessID) {

        $stripe_secret_key = '';
        $this->db->select('stripe_secret_key');
        $this->db->from('business_customers');
        $this->db->where('businessID', $businessID);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->result_array();
        if (count($row) > 0) {
            $stripe_secret_key = $row[0]['stripe_secret_key'];
            return $stripe_secret_key;
        } else {
            return $stripe_secret_key;
        }
    }

    function update_business_profile($param) {

        $data['businessID'] = $param['businessID'];
        $data['address'] = $param['address'];
        $data['email'] = $param['email'];
        $data['website'] = $param['website'];
        $data['phone'] = $param['phone'];
        $data['businessTypes'] = $param['businessTypes'];
        $data['marketing_statement'] = $param['marketing_statement'];
        $data['short_name'] = $param['short_name'];
        $data['sms_no'] = $param['sms_no'];
        $data['process_time'] = $param['process_time'];

        if ($param['icon'] != "") {
            $data['icon'] = $param['icon'];
        }

        $this->db->where('businessID', $param['businessID']);
        $this->db->update('business_customers', $data);
        $return = success_res("Stripe Token Updated Successfully");
        $return['address'] = $param['address'];
        $return['email'] = $param['email'];
        $return['website'] = $param['website'];
        $return['phone'] = $param['phone'];
        $return['businessTypes'] = $param['businessTypes'];
        $return['marketing_statement'] = $param['marketing_statement'];
        $return['short_name'] = $param['short_name'];
        $return['process_time'] = $param['process_time'];
        $return['sms_no'] = $param['sms_no'];

        return $return;
    }

    function edit_stripe_key($param) {

        $data['stripe_secret_key'] = $param['stripe_secret_key'];
        $this->db->where('businessID', $param['businessID']);
        $this->db->update('business_customers', $data);
        $return = success_res("Stripe Token Updated Successfully");
        $return['stripe_secret_key'] = $param['stripe_secret_key'];
        return $return;
    }

    function edit_internal_info($param) {
        $this->db->select('interal_business_alert_id');
        $this->db->from('business_internal_alert');
        $this->db->where('business_id', $param['businessID']);
        $this->db->limit(1);
        $result_interal = $this->db->get();
        $row_interal = $result_interal->result_array();
        $data = array();
        $data['email'] = $param['internal_email'];
        $data['sms_no'] = $param['internal_sms_no'];
        if (count($row_interal) > 0) {
            $this->db->where('business_id', $param['businessID']);
            $this->db->update('business_internal_alert', $data);
        } else {
            $data['business_id'] = $param['businessID'];
            $this->db->insert('business_internal_alert', $data);
        }
        $return = success_res("Successfully updated intrnal info");
        return $return;
    }

    function update_business_opening_hours($param) {

        $entryids = explode(',', $param['entryids']);

        foreach ($entryids as $entry_id) {
            $data = array();
            $data['from_date'] = $param['fromdate_' . $entry_id];
            $data['to_date'] = $param['todate_' . $entry_id];
            $data['opening_time'] = $param['openingtime_' . $entry_id];
            $data['closing_time'] = $param['closingtime_' . $entry_id];
            $this->db->where('entry_id', $entry_id);
            $this->db->update('opening_hours', $data);
        }
        $return = success_res("Opening hours updated successfully");
        return $return;
    }

    function get_business_order_list($param) {
        $this->db->select('o.order_id,o.payment_id,o.total,o.date,o.no_items,o.status,cp.nickname,TIMESTAMPDIFF(SECOND,o.date,now()) as seconds,oc.is_refunded');
        $this->db->from('order as o');
        $this->db->join('consumer_profile as cp', 'o.consumer_id = cp.uid', 'left');
        $this->db->join('order_charge as oc', 'oc.order_id = o.order_id', 'left');
        $this->db->where('o.status !=', 0);
        if ($param['order_status'] == "completed") {
            $this->db->where('o.status', 3);
        } else {
            $this->db->where('o.status !=', 3);
            $this->db->where('o.status !=', 4);
        }
        if ($param['sub_businesses'] == "") {
            $this->db->where('o.business_id', $param['businessID']);
        } else {
            $sub_businesses = explode(",", $param['sub_businesses']);
            $this->db->where_in('o.business_id', $sub_businesses);
        }
        $this->db->order_by("o.order_id", "desc");
        //$this->db->limit(10);
        $result = $this->db->get();
        $row = $result->result_array();
        return $row;
    }

    function get_search_business_order_list($param) {
        $this->db->select('o.order_id,o.payment_id,o.total,o.date,o.no_items,o.status,cp.nickname,TIMESTAMPDIFF(SECOND,o.date,now()) as seconds,oc.is_refunded', FALSE);
        $this->db->from('order as o');
        $this->db->join('consumer_profile as cp', 'o.consumer_id = cp.uid', 'left');
        $this->db->join('order_charge as oc', 'oc.order_id = o.order_id', 'left');
        $this->db->where('o.status !=', 0);
        $this->db->where('o.status', 3);
        $this->db->where('o.business_id', $param['businessID']);
        $this->db->where("o.order_id  LIKE '%" . $param['keyword'] . "%'");
        $this->db->order_by("o.order_id", "desc");
        //$this->db->limit(10);
        $result = $this->db->get();
        $row = $result->result_array();
        return $row;
    }

    function get_ordelist_order($order_id, $businessId, $p_sub_businesses) {
        $this->db->select('o.order_id,o.payment_id,o.total,o.date,cp.nickname,o.status,o.note,o.subtotal,o.tip_amount,o.tax_amount,o.points_dollar_amount,TIMESTAMPDIFF(SECOND,o.date,now()) as seconds,oc.is_refunded,o.delivery_charge_amount,o.promotion_code,o.promotion_discount_amount,cd.delivery_instruction,cd.delivery_address,cd.delivery_time,o.consumer_delivery_id');
        $this->db->from('order as o');
        $this->db->join('consumer_profile as cp', 'o.consumer_id = cp.uid', 'left');
        $this->db->join('order_charge as oc', 'oc.order_id = o.order_id', 'left');
        $this->db->join('consumer_delivery as cd', 'cd.consumer_delivery_id = o.consumer_delivery_id', 'left');
        $this->db->where('o.order_id', $order_id);
        if ($p_sub_businesses == "") {
            $this->db->where('o.business_id', $businessId);
        } else {
            $sub_businesses = explode(",", $p_sub_businesses);
            $this->db->where_in('o.business_id', $sub_businesses);
        }

        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->result_array();


        return $row;
    }

    function get_order_detail($order_id) {

        $this->db->select('o.order_item_id,o.price,o.quantity,o.item_note,p.name,p.short_description,o.option_ids,o.product_id,p.businessID,bc.short_name as business_name,bc.username as business_username');
        $this->db->from('order_item as o');
        $this->db->join('product as p', 'o.product_id = p.product_id', 'left');
        $this->db->join('business_customers as bc', 'bc.businessID = p.businessID', 'left');
        $this->db->where('o.order_id', $order_id);
        $result = $this->db->get();
        $row = $result->result_array();

        foreach ($row as &$r) {
            $optionsId = explode(',', $r['option_ids']);
            $this->db->select('name');
            $this->db->from('option');
            $this->db->where_in('option_id', $optionsId);
            $option_result = $this->db->get();
            $option_row = $option_result->result_array();
            $r['option_ids'] = $option_row;
        }

        return $row;
    }

    function check_birthday_first_order($order_id) {
        $this->db->select('consumer_id');
        $this->db->from('order o');
        $this->db->where('order_id', $order_id);
        $consumer_result = $this->db->get();
        $consumer_row = $consumer_result->row_array();
        $consumerId = $consumer_row['consumer_id'];

        $this->db->select('order_id');
        $this->db->from('order');
        $this->db->where('consumer_id', $consumerId);
        $count_orders = $this->db->get();
        $total_consumer_orders = $count_orders->num_rows();
        if ($total_consumer_orders == 1) {
            $row['is_first_order'] = "1";
        } else {
            $row['is_first_order'] = "0";
        }
        //SELECT * FROM consumer_profile  WHERE uid=1 AND MONTH(dob) = MONTH(NOW()) AND DAY(dob) = DAY(NOW());
        $this->db->select('*');
        $this->db->from('consumer_profile');
        $this->db->where('uid', $consumerId);
        $this->db->where('MONTH(dob) = MONTH(NOW()) AND DAY(dob) = DAY(NOW())', NULL);
        $birthday_result = $this->db->get();
        $birthday_row = $birthday_result->row_array();

        if (count($birthday_row) > 0) {
            $row['is_birthday'] = "1";
        } else {
            $row['is_birthday'] = "0";
        }

        return $row;
    }

    function get_order_charge_detail($order_id) {

        $this->db->select('*');
        $this->db->from('order_charge');
        $this->db->where('order_id', $order_id);
        $result = $this->db->get();
        $row = $result->row_array();

        return $row;
    }

    function get_order_payment_detail($order_id) {
        $this->db->select('o.total,o.consumer_id,o.cc_last_4_digits');
        $this->db->from('order as o');
        //$this->db->join('product as p', 'o.product_id = p.product_id', 'left');
        $this->db->where('o.order_id', $order_id);
        $this->db->where('o.status', 1);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->result_array();
        $return['total'] = $row[0]['total'];
        $return['consumer_id'] = $row[0]['consumer_id'];

        $this->db->select('ci.cc_no,expiration_date,cp.email1');
        $this->db->from('consumer_cc_info as ci');
        $this->db->join('consumer_profile cp', 'cp.uid = ci.consumer_id', 'left');
        $this->db->where('ci.consumer_id', $row[0]['consumer_id']);
        $this->db->like('ci.cc_no', $row[0]['cc_last_4_digits'],"both");
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->result_array();
        if (count($row) > 0) {
            $date_pieces = explode("-", $row[0]['expiration_date']);
            $row[0]['month'] = $date_pieces[1];
            $row[0]['year'] = $date_pieces[0];
            $return['cc_info'] = $row[0];
        } else {
            $return['cc_info'] = FALSE;
        }

        return $return;
    }

    function get_order_info($order_id) {
        $this->db->select('*');
        $this->db->from('order');
        $this->db->where('order_id', $order_id);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->row_array();
        return $row;
    }

    function update_order_status($order_id, $charge_id, $amount, $consumer_id) {


        $data['order_id'] = $order_id;
        $data['stripe_charge_id'] = $charge_id;
        $data['amount'] = $amount;
        $data['consumer_id'] = $consumer_id;
        $data['created'] = date('Y-m-d H:i:s');
        $this->db->insert('order_charge', $data);
        $data = array();
        $data['status'] = '2';
        $this->db->where('order_id', $order_id);
        $this->db->update('order', $data);


//        $this->db->select('device_token');
//        $this->db->from('consumer_profile');
//        //$this->db->join('product as p', 'o.product_id = p.product_id', 'left');
//        $this->db->where('uid', $consumer_id);
//        $this->db->limit(1);
//        $result = $this->db->get();
//        $row = $result->result_array();
//        if (count($row) > 0) {
//            $device_token = $row[0]['device_token'];
//            $message_body = array(
//                'type' => "0",
//                'alert' => "Your order #" . $order_id . " is approved ",
//                'badge' => 0,
//                'sound' => 'newMessage.wav'
//            );
//            push_notification_ios($device_token, $message_body);
//
//            $notification['consumer_id'] = $consumer_id;
//            $notification['business_id'] = is_login();
//            $notification['message'] = "Your order #" . $order_id . " is approved ";
//            $notification['image'] = "";
//            $notification['time_sent'] = date("Y-m-d H:i:s");
//            $notification['notification_type_id'] = "5";
//            $this->db->insert('notification', $notification);
//        }
    }
    function smsMerchant($message, $businessSMS, $businessID) {
        require_once APPPATH.'libraries/Twilio/autoload.php'; // Loads the Twilio library
        $TapInServerConstsParentPath = APPPATH . "../" . "../" . staging_directory() . '/include/consts_server.inc';
        require_once $TapInServerConstsParentPath; // Loads our consts
//        use Twilio\Rest\Client;

        $this->db->select('username');
        $this->db->from('business_customers');
        $this->db->where('businessID', $businessID);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->result_array();
        if (count($row) > 0) {
            $merchantLink = BaseURL . "" . $row[0]["username"];
            $message = $message . " Refer to: " . $merchantLink;

        }
 
        $sid =    "AC425f4f32e8cc26b7cd3cca7122d59edb";
        $token =  "28c81ad67d2530aca9a947f785c54ef6";

        $client = new Twilio\Rest\Client($sid, $token);
        try {
            $client->messages->create(
                "$businessSMS",
                array(
                    'from' => '+15032785619',
                    'body' => "$message"
                    )
            );
        } catch (Services_Twilio_RestException $e) {
            log_message('Error', "Could send sms with this error: $e->getMessage()");
        }
        log_message('Info', "sent a message to $businessID");
    }


    function sendPushNotificationToMerchant($message, $businessUUID) {
        // now let's get the device token so we can send the notiication
        $this->db->select('device_token');
        $this->db->from('consumer_profile');
        $this->db->where('uuid', $businessUUID);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->result_array();
        if (count($row) > 0) {
            $device_token = $row[0]['device_token'];

            $message_body = array(
                'type' => "0",
                'alert' => $message,
                'badge' => 0,
                'sound' => 'newMessage.wav'
            );

            push_notification_ios($device_token, $message_body);
            log_message('info', "****Just notified $device_token that there is a new order!");
        }
    }

    function notifyMerchant($message) {
        // first get the uuid for the device that the business has setup for notifications
        $businessUUID = '';
        $businessID = is_login();
        $this->db->select('*');
        $this->db->from('business_internal_alert');
        $this->db->where('business_id', $businessID);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->result_array();

        if (empty($row[0]['uuid'])) {
            log_message('info', "Could not find device token for $businessID");
        } else {
            $businessUUID = $row[0]['uuid'];
            $this->sendPushNotificationToMerchant($message, $businessUUID);
        }

        if (empty($row[0]['sms_no'])) {
            log_message('info', "Could not find sms_no for business $businessID ");
        } else {
            $businessSMS = $row[0]['sms_no'];
            $this->smsMerchant($message, $businessSMS, $businessID);
        }
    }

    function completedorder($order_id) {
        $data = array();
        $data['status'] = '3';
        $this->db->where('business_id', is_login());
        $this->db->where('order_id', $order_id);
        $this->db->update('order', $data);
        $order_detail = $this->get_order_info($order_id);

        $this->db->select('consumer_delivery_id');
        $this->db->from('order');
        $this->db->where('order_id', $order_id);
        $this->db->limit(1);
        $result1 = $this->db->get();
        $row1 = $result1->result_array();
        if (count($row1) > 0) {

            if ($row1[0]['consumer_delivery_id'] == 0) {
                $this->db->select('business_delivery_id');
                $this->db->from('business_delivery');
                $this->db->where('business_id', $row1[0]['business_id']);
                $this->db->limit(1);
                $result2= $this->db->get();
                $row2 = $result2->result_array();
                if(count($row2)>0)
                {
                      $alert="Order #" . $order_id . " is ready.   For delivery, please email amir@tap-in.co with delivery info.";
                }else{
                    $alert="Your order #" . $order_id . " is completed ";
                }
            } else {
                $alert = "Your order #" . $order_id . " is ready and it is being delivered";
            }
        }


        $this->db->select('device_token');
        $this->db->from('consumer_profile');
        //$this->db->join('product as p', 'o.product_id = p.product_id', 'left');
        $this->db->where('uid', $order_detail['consumer_id']);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->result_array();

        if (count($row) > 0) {
            $device_token = $row[0]['device_token'];

            $message_body = array(
                'type' => "0",
                'alert' => $alert,
                'badge' => 0,
                'sound' => 'newMessage.wav'
            );
            push_notification_ios($device_token, $message_body);

            $notification['consumer_id'] = $order_detail['consumer_id'];
            $notification['business_id'] = is_login();
            $notification['message'] = $alert;
            $notification['image'] = "";
            $notification['time_sent'] = date("Y-m-d H:i:s");
            $notification['notification_type_id'] = "6";
            $this->db->insert('notification', $notification);
        }
    }

    function rejectorder($order_id) {

        $data = array();
        $data['status'] = '0';
        $this->db->where('business_id', is_login());
        $this->db->where('order_id', $order_id);
        $this->db->update('order', $data);

        $order_detail = $this->get_order_info($order_id);

        $this->db->where('order_id', $order_id);
        $this->db->where('consumer_id', $order_detail['consumer_id']);
        $this->db->delete('points');

        $this->db->select('device_token');
        $this->db->from('consumer_profile');
        $this->db->where('uid', $order_detail['consumer_id']);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->result_array();

        if (count($row) > 0) {
            $device_token = $row[0]['device_token'];
            $messageToConsumer = "Your order #" . $order_id . " could not be fulfilled at this time.";
            $message_body = array(
                'type' => "0",
                'alert' => $messageToConsumer,
                'badge' => 0,
                'sound' => 'newMessage.wav'
            );
            push_notification_ios($device_token, $message_body);

            log_message('info', "****Rejected  order: $order_id for $device_token");

            $notification['consumer_id'] = $order_detail['consumer_id'];
            $notification['business_id'] = is_login();
            $notification['message'] = $messageToConsumer;
            $notification['image'] = "";
            $notification['time_sent'] = date("Y-m-d H:i:s");
            $notification['notification_type_id'] = "4";
            $this->db->insert('notification', $notification);
        }
    }

    function get_business_internal_alerts($businessID) {
        $this->db->select('*');
        $this->db->from('business_internal_alert');
        $this->db->where('business_id', $businessID);
        $result = $this->db->get();
        $row = $result->result_array();
        return $row;
    }

    function get_business_products($param) {
        $this->db->select('p.*,pc.category_name');
        $this->db->from('product as p');
        $this->db->join('product_category as  pc', 'p.product_category_id = pc.product_category_id', 'left');
        $this->db->where('p.businessID', $param['businessID']);
        $this->db->order_by("p.product_id", "desc");
        $result = $this->db->get();
        $row = $result->result_array();
        return $row;
    }

    function get_business_options($param) {
        $this->db->select('o.*,poc.name as product_option_category_name');
        $this->db->from('option as o');
        $this->db->join('product_option_category as poc', 'o.product_option_category_id = poc.product_option_category_id', 'left');
        $this->db->where('o.business_id', $param['businessID']);
        $this->db->order_by("o.option_id", "desc");
        $result = $this->db->get();
        $row = $result->result_array();
        return $row;
    }

    function get_business_product_category($param) {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('business_id', $param['businessID']);
        $result = $this->db->get();
        $row = $result->result_array();
        return $row;
    }

    function add_product_category($param) {

        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('category_name', $param['category_name']);
        $this->db->where('business_id', $param['businessID']);
        $category_result = $this->db->get();
        $category_row = $category_result->row_array();
        if (count($category_row) == 0) {
            $data['category_name'] = $param['category_name'];
            $data['desc'] = $param['desc'];
            $data['business_id'] = $param['businessID'];
            $this->db->insert('product_category', $data);
            $categoryId = $this->db->insert_id();

            $updatedata = array();
            $updatedata['product_category_id'] = $categoryId;
            $this->db->where('table_id', $categoryId);
            $this->db->update('product_category', $updatedata);

            $this->db->select('*');
            $this->db->from('product_category');
            $this->db->where('table_id', $categoryId);
            $result = $this->db->get();
            $row = $result->row_array();
            $return['status'] = 1;
            $return['category'] = $row;
        } else {
            $return['status'] = 0;
            $return['message'] = 'Category already exist';
        }
        return $return;
    }

    function update_product_category($param) {

        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('category_name', $param['edit_category_name']);
        $this->db->where('table_id !=', $param['table_id']);
        $this->db->where('business_id', $param['businessID']);
        $category_result = $this->db->get();
        $category_row = $category_result->row_array();
        if (count($category_row) == 0) {
            $data['category_name'] = $param['edit_category_name'];
            $data['desc'] = $param['edit_desc'];
            $data['business_id'] = $param['businessID'];
            $this->db->where('table_id', $param['table_id']);
            $this->db->update('product_category', $data);

            $this->db->select('*');
            $this->db->from('product_category');
            $this->db->where('table_id', $param['table_id']);
            $result = $this->db->get();
            $row = $result->row_array();
            $return['status'] = 1;
            $return['category'] = $row;
        } else {
            $return['status'] = 0;
            $return['message'] = 'Category already exist';
        }
        return $return;
    }

    function delete_product_category($param) {

        $this->db->where('business_id', $param['businessID']);
        $this->db->where('table_id', $param['table_id']);
        $this->db->delete('product_category');

        $return['status'] = 1;
        $return['msg'] = "Category Deleted Successfully";
        return $return;
    }

    function add_product_option_category($param) {

        $this->db->select('*');
        $this->db->from('product_option_category');
        $this->db->where('name', $param['option_category_name']);
        $this->db->where('business_id', $param['businessID']);
        $category_result = $this->db->get();
        $category_row = $category_result->row_array();
        if (count($category_row) == 0) {
            $data['name'] = $param['option_category_name'];
            $data['only_choose_one'] = $param['only_choose_one'];
            $data['desc'] = $param['desc'];
            $data['business_id'] = $param['businessID'];
            $this->db->insert('product_option_category', $data);
            $categoryId = $this->db->insert_id();

            $this->db->select('*');
            $this->db->from('product_option_category');
            $this->db->where('product_option_category_id', $categoryId);
            $result = $this->db->get();
            $row = $result->row_array();
            $return['status'] = 1;
            $return['option_category'] = $row;
        } else {
            $return['status'] = 0;
            $return['message'] = 'Option Category already exist';
        }
        return $return;
    }

    function edit_product_option_category($param) {

        $this->db->select('*');
        $this->db->from('product_option_category');
        $this->db->where('name', $param['edit_option_category_name']);
        $this->db->where('product_option_category_id !=', $param['product_option_category_id']);
        $this->db->where('business_id', $param['businessID']);
        $category_result = $this->db->get();
        $category_row = $category_result->row_array();
        if (count($category_row) == 0) {
            $data['name'] = $param['edit_option_category_name'];
            $data['desc'] = $param['edit_desc'];
            $data['only_choose_one'] = $param['edit_only_choose_one'];
            $data['business_id'] = $param['businessID'];
            $this->db->where('product_option_category_id ', $param['product_option_category_id']);
            $this->db->update('product_option_category', $data);

            $this->db->select('*');
            $this->db->from('product_option_category');
            $this->db->where('product_option_category_id', $param['product_option_category_id']);
            $result = $this->db->get();
            $row = $result->row_array();
            $return['status'] = 1;
            $return['option_category'] = $row;
        } else {
            $return['status'] = 0;
            $return['message'] = 'Option Category already exist';
        }
        return $return;
    }

    function delete_product_option_category($param) {

        $this->db->where('business_id', $param['businessID']);
        $this->db->where('product_option_category_id', $param['product_option_category_id']);
        $this->db->delete('product_option_category');

        $return['status'] = 1;
        $return['msg'] = "Option Category Deleted Successfully";
        return $return;
    }

    function insert_product($param) {

        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('name', $param['name']);
        $this->db->where('businessID', $param['businessID']);
        $product_result = $this->db->get();
        $product_row = $product_result->row_array();
        if (count($product_row) == 0) {

            $data['businessID'] = $param['businessID'];
            $data['name'] = $param['name'];
            $data['price'] = $param['price'];
            $data['product_category_id'] = $param['product_category_id'];
            $data['SKU'] = $param['SKU'];
            $data['short_description'] = $param['short_description'];
            $data['long_description'] = $param['long_description'];
            $data['price'] = $param['price'];
            $data['detail_information'] = $param['detail_information'];
            $data['runtime_fields'] = $param['runtime_fields'];
            $data['runtime_fields_detail'] = $param['runtime_fields_detail'];
            $data['sales_price'] = $param['sales_price'];
            $data['has_option'] = $param['has_option'];
            $data['bought_with_rewards'] = $param['bought_with_rewards'];
            $data['more_information'] = $param['more_information'];
            $data['pictures'] = $param['pictures'];

            $this->db->insert('product', $data);
            $productId = $this->db->insert_id();
            $return['status'] = 1;
            $return['msg'] = 'Product added successfully';
        } else {
            $return['status'] = 0;
            $return['msg'] = 'Product name already exist';
        }
        return $return;
    }

//    function insert_product_option($param) {
//
//        $this->db->select('*');
//        $this->db->from('product_option');
//        $this->db->where('name', $param['name']);
//        $product_result = $this->db->get();
//        $product_row = $product_result->row_array();
//        if (count($product_row) == 0) {
//
//            $data['name'] = $param['name'];
//            $data['price'] = $param['price'];
//            $data['description'] = $param['price'];
//            $data['product_id'] = $param['product_id'];
//            $data['product_option_category_id'] = $param['product_option_category_id'];
//
//            $this->db->insert('product_option', $data);
//            $productId = $this->db->insert_id();
//            $return['status'] = 1;
//            $return['msg'] = 'Product option added successfully';
//        } else {
//            $return['status'] = 0;
//            $return['msg'] = 'Product option name already exist';
//        }
//        return $return;
//    }

    function insert_option($param) {

        $data['name'] = $param['name'];
        $data['price'] = $param['price'];
        $data['description'] = $param['description'];
        $data['product_option_category_id'] = $param['product_option_category_id'];
        $data['business_id'] = $param['businessID'];
        $this->db->insert('option', $data);
        $return['status'] = 1;
        $return['msg'] = 'Option added successfully';
        return $return;
    }

    function insert_options($param) {
        $checkedOptionIds = array();
        $uncheckedOptionIds = array();
        if ($param['checked'] != '') {
            $checkedOptionIds = explode(',', $param['checked']);
        }
        if ($param['unchecked'] != '') {
            $uncheckedOptionIds = explode(',', $param['unchecked']);
        }

        for ($i = 0; $i < count($checkedOptionIds); $i++) {
            $this->db->select('*');
            $this->db->from('option');
            $this->db->where('option_id', $checkedOptionIds[$i]);
            $option_result = $this->db->get();
            $option_row = $option_result->row_array();

            $this->db->select('option_id,name');
            $this->db->from('product_option');
            $this->db->where('product_id', $param['product_id']);
            $this->db->where('option_id', $option_row['option_id']);
            $this->db->order_by("option_id", "desc");
            $product_result = $this->db->get();
            $product_row = $product_result->row_array();
            if (count($product_row) == 0) {
                $data = array();
                $data['option_id'] = $option_row['option_id'];
                $data['product_option_category_id'] = $option_row['product_option_category_id'];
                $data['name'] = $option_row['name'];
                $data['price'] = $option_row['price'];
                $data['description'] = $option_row['description'];
                $data['product_id'] = $param['product_id'];

                $this->db->insert('product_option', $data);
            }
//            else {
//                if ($product_row['availability_status'] == 0) {
//                    $data = array();
//                    $data['availability_status'] = 1;
//                    $this->db->where('option_id', $product_row['option_id']);
//                    $this->db->update('product_option', $data);
//                }
//            }
        }
        for ($i = 0; $i < count($uncheckedOptionIds); $i++) {
//            $this->db->select('*');
//            $this->db->from('business_option');
//            $this->db->where('option_id', $uncheckedOptionIds[$i]);
//            $option_result = $this->db->get();
//            $option_row = $option_result->row_array();


            $this->db->where('product_id', $param['product_id']);
            $this->db->where('option_id', $uncheckedOptionIds[$i]);
            $this->db->delete('product_option');

//            $this->db->select('option_id,name');
//            $this->db->from('product_option');
//            $this->db->where('product_id', $param['product_id']);
//            $this->db->where('name', $option_row['name']);
//            $this->db->order_by("option_id", "desc");
//            $product_result = $this->db->get();
//            $product_row = $product_result->row_array();
//            if (count($product_row) > 0) {
//                $data = array();
//                $data['availability_status'] = 0;
//                $this->db->where('option_id', $product_row['option_id']);
//                $this->db->update('product_option', $data);
//            }
        }

//        $this->db->select('name');
//        $this->db->from('business_option');
//        $this->db->where('option_id', $checkedOptionIds[$i]);
//        $option_result = $this->db->get();
//        $option_row = $option_result->row_array();
//        if (count($option_row) == 0) {
//            $data['business_id'] = $param['businessID'];
//            $data['name'] = $param['name'];
//            $data['price'] = $param['price'];
//            $data['description'] = $param['description'];
//            $data['product_option_category_id'] = $param['product_option_category_id'];
//            $this->db->insert('business_option', $data);
//            $return['status'] = 1;
//            $return['msg'] = 'Option added successfully';
//        } else {
//            $return['status'] = 0;
//            $return['msg'] = 'Option name already exist';
//        }
        $return['status'] = 1;
        $return['msg'] = 'Option Saved successfully';
        return $return;
    }

    function get_products_options($param) {
        $this->db->select('o.*,CASE WHEN po.product_id IS NOT NULL THEN 1 ELSE 0 END AS is_add', false);
        $this->db->from('option o');
        $this->db->join('product_option po', 'o.option_id=po.option_id and po.product_id=' . $param['product_id'], 'left');
        $this->db->where("o.business_id", $param['businessID']);
        $this->db->order_by("option_id", "desc");
        $result = $this->db->get();
        $row = $result->result_array();


//        $this->db->select('option_id');
//        $this->db->from('product_option');
//        $this->db->where('product_id', $param['product_id']);
//        $this->db->order_by("option_id", "desc");
//        $product_result = $this->db->get();
//        $product_row = $product_result->result_array();
//
//        foreach ($row as &$r) {
//            foreach ($product_row as $p) {
//                if ($p[''] == $r['name']) {
//                    $r['is_add'] = 1;
//                }
//            }
//        }
        return $row;
    }

    function get_products_option_category($param) {
        $this->db->select('*');
        $this->db->from('product_option_category');
        $this->db->where('business_id', $param['businessID']);
        $result = $this->db->get();
        $row = $result->result_array();
        return $row;
    }

    function get_new_orders($param) {
        $this->db->select('o.order_id,o.payment_id,o.total,o.date,o.no_items,o.status,TIMESTAMPDIFF(SECOND,o.date,now()) as seconds,cp.nickname');
        $this->db->from('order as o');
        $this->db->join('consumer_profile as cp', 'o.consumer_id = cp.uid', 'left');
        $this->db->where('o.status !=', 0);
        $this->db->where('o.status !=', 3);
        $this->db->where('o.status !=', 4);
        $this->db->where('o.order_id >', $param['latest_order_id']);
        if ($param['sub_businesses'] == "") {
            $this->db->where('o.business_id', $param['businessID']);
        } else {
            $sub_businesses = explode(",", $param['sub_businesses']);
            $this->db->where_in('o.business_id', $sub_businesses);
        }
        $this->db->order_by("o.order_id", "desc");
        //$this->db->limit(10);
        $result = $this->db->get();
        $row = $result->result_array();
        return $row;
    }

    function count_order_for_remaining_approve($param) {

        if ($param['sub_businesses'] == "") {
            $this->db->where('business_id', $param['businessID']);
        } else {
            $sub_businesses = explode(",", $param['sub_businesses']);
            $this->db->where_in('business_id', $sub_businesses);
        }

        $this->db->where('status', 1);
        $this->db->from('order');
        return $this->db->count_all_results();
    }

    function set_product_availailblity_status($param) {
        if ($param['availability_status'] == "true") {
            $param['availability_status'] = 1;
        } else {
            $param['availability_status'] = 0;
        }
        $data['availability_status'] = $param['availability_status'];
        $this->db->where('product_id', $param['product_id']);
        $this->db->update('product', $data);
    }

   function set_option_availailblity_status($param) {
        if ($param['availability_status'] == "true") {
            $param['availability_status'] = 1;
        } else {
            $param['availability_status'] = 0;
        }
        $data['availability_status'] = $param['availability_status'];
        $this->db->where('option_id', $param['option_id']);
        $this->db->update('option', $data);
    }

    function get_product_info($product_id) {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('product_id', $product_id);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->row_array();
        return $row;
    }

    function update_product($param) {




        $data['businessID'] = $param['businessID'];
        $data['name'] = $param['name'];
        $data['price'] = $param['price'];
        $data['product_category_id'] = $param['product_category_id'];
        $data['SKU'] = $param['SKU'];
        $data['short_description'] = $param['short_description'];
        $data['long_description'] = $param['long_description'];
        $data['price'] = $param['price'];
        $data['detail_information'] = $param['detail_information'];
        $data['runtime_fields'] = $param['runtime_fields'];
        $data['runtime_fields_detail'] = $param['runtime_fields_detail'];
        $data['sales_price'] = $param['sales_price'];
        $data['has_option'] = $param['has_option'];
        $data['bought_with_rewards'] = $param['bought_with_rewards'];
        $data['more_information'] = $param['more_information'];
        $data['pictures'] = $param['pictures'];

        $this->db->where('product_id', $param['product_id']);
        $this->db->update('product', $data);

        $return['status'] = 1;
        $return['msg'] = 'Product updated successfully';

        return $return;
    }

    function file_upload($file_key, $folder_path) {

        if ($_FILES[$file_key]["name"] !== "") {
            $temp = explode(".", $_FILES[$file_key]["name"]);
            $extension = end($temp);

            $temp_name = date('YmdHis');
            $file_name = $temp_name . "." . $extension;
            $file_path = $folder_path . "/" . $file_name;
            if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $file_path)) {
                return $file_name;
            } else {
                return "";
            }
        } else {

            return "";
        }
    }

    function business_rating($param) {
        $orderId = decrypt_string($param['orderId']);
        $order_info = $this->get_order_info($orderId);
        $avg_rating = 0.0;
        if ($param['is_positive'] == '1') {
            $avg_rating = 5.0;
        } else if ($param['is_positive'] == '0') {
            $avg_rating = 1.0;
        }
        $this->db->select('*');
        $this->db->from('business_rating');
        $this->db->where('consumer_id', $order_info['consumer_id']);
        $this->db->where('businessID', $order_info['business_id']);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->result_array();
        if (count($row) > 0) {
            $data['avg_rating'] = $avg_rating;
            $this->db->where('consumer_id', $order_info['consumer_id']);
            $this->db->where('businessID', $order_info['business_id']);
            $this->db->update('business_rating', $data);
        } else {
            $data['avg_rating'] = $avg_rating;
            $data['consumer_id'] = $order_info['consumer_id'];
            $data['businessID'] = $order_info['business_id'];
            $this->db->insert('business_rating', $data);
        }
    }

    function product_rating($param) {
        $orderId = decrypt_string($param['orderId']);
        $productId = decrypt_string($param['productId']);
        $order_info = $this->get_order_info($orderId);
        $avg_rating = 5.0;

        $this->db->select('*');
        $this->db->from('rating');
        $this->db->where('consumer_id', $order_info['consumer_id']);
        $this->db->where('type', 2);
        $this->db->where('id', $productId);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->result_array();
        if (count($row) > 0) {
            $data['avg'] = $avg_rating;
            $this->db->where('consumer_id', $order_info['consumer_id']);
            $this->db->where('type', 2);
            $this->db->where('id', $productId);
            $this->db->update('rating', $data);
        } else {
            $data['consumer_id'] = $order_info['consumer_id'];
            $data['avg'] = $avg_rating;
            $data['type'] = 2;
            $data['id'] = $productId;
            $this->db->insert('rating', $data);
        }
    }

    function get_redeemed_points($order_id) {
        $this->db->select('points');
        $this->db->from('points');
        $this->db->where('order_id', $order_id);
        $this->db->where('time_redeemed IS NOT NULL', null, FALSE);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->row_array();

        return $row;
    }

    function total_orders_count($param) {
        $this->db->select('count(order_id) as total_orders,ifnull(sum(subtotal),"0.00") as total_subtotal,ifnull(sum(tip_amount),"0.00") as total_tip, ifnull(sum(points_dollar_amount),"0.00") as total_points', FALSE);
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('date > DATE_SUB(NOW(), INTERVAL 1 DAY)');
        $this->db->where('(status=2 or status=3)', NULL);
        $result = $this->db->get();
        $row = $result->row_array();
        $return['today']['orders'] = $row['total_orders'];
        $return['today']['subtotals'] = $row['total_subtotal'];
        $return['today']['tips'] = $row['total_tip'];
        $return['today']['points'] = $row['total_points'];
        $return['sql'] = $this->db->last_query();

        $this->db->select('count(order_id) as total_orders,ifnull(sum(subtotal),"0.00") as total_subtotal,ifnull(sum(tip_amount),"0.00") as total_tip, ifnull(sum(points_dollar_amount),"0.00") as total_points', FALSE);
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('date > DATE_SUB(NOW(), INTERVAL 1 WEEK)');
        $this->db->where('(status=2 or status=3)', NULL);
        $weekresult = $this->db->get();
        $weekrow = $weekresult->row_array();
        $return['week']['orders'] = $weekrow['total_orders'];
        $return['week']['subtotals'] = $weekrow['total_subtotal'];
        $return['week']['tips'] = $weekrow['total_tip'];
        $return['week']['points'] = $weekrow['total_points'];

        $this->db->select('count(order_id) as total_orders,ifnull(sum(subtotal),"0.00") as total_subtotal,ifnull(sum(tip_amount),"0.00") as total_tip, ifnull(sum(points_dollar_amount),"0.00") as total_points', FALSE);
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('date > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
        $this->db->where('(status=2 or status=3)', NULL);
        $monthresult = $this->db->get();
        $monthrow = $monthresult->row_array();
        $monthcount = $monthresult->num_rows();
        $return['month']['orders'] = $monthrow['total_orders'];
        $return['month']['subtotals'] = $monthrow['total_subtotal'];
        $return['month']['tips'] = $monthrow['total_tip'];
        $return['month']['points'] = $monthrow['total_points'];

        $this->db->select('count(order_id) as total_orders,ifnull(sum(subtotal),"0.00") as total_subtotal,ifnull(sum(tip_amount),"0.00") as total_tip, ifnull(sum(points_dollar_amount),"0.00") as total_points', FALSE);
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('(status=2 or status=3)', NULL);
        $totalresult = $this->db->get();
        $totalrow = $totalresult->row_array();
        $totalcount = $totalresult->num_rows();
        $return['total']['orders'] = $totalrow['total_orders'];
        $return['total']['subtotals'] = $totalrow['total_subtotal'];
        $return['total']['tips'] = $totalrow['total_tip'];
        $return['total']['points'] = $totalrow['total_points'];



        $this->db->select('count(order_id) as rejected_orders', FALSE);
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('status', 0);
        $this->db->where('date > DATE_SUB(NOW(), INTERVAL 1 DAY)');
        $rejectedresult = $this->db->get();
        $rejectedrow = $rejectedresult->row_array();
        $return['today']['rejected'] = $rejectedrow['rejected_orders'];


        $this->db->select('count(order_id) as rejected_orders', FALSE);
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('status', 0);
        $this->db->where('date > DATE_SUB(NOW(), INTERVAL 1 WEEK)');
        $rejectedresult = $this->db->get();
        $rejectedrow = $rejectedresult->row_array();
        $return['week']['rejected'] = $rejectedrow['rejected_orders'];

        $this->db->select('count(order_id) as rejected_orders', FALSE);
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('status', 0);
        $this->db->where('date > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
        $rejectedresult = $this->db->get();
        $rejectedrow = $rejectedresult->row_array();
        $return['month']['rejected'] = $rejectedrow['rejected_orders'];

        $this->db->select('count(order_id) as rejected_orders', FALSE);
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('status', 0);
        $rejectedresult = $this->db->get();
        $rejectedrow = $rejectedresult->row_array();
        $return['total']['rejected'] = $rejectedrow['rejected_orders'];


        $this->db->select('ifnull(sum(total),"0.00") as total_processingfee', FALSE);
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('status', 3);
        $this->db->where('date > DATE_SUB(NOW(), INTERVAL 1 DAY)');
        $processingFeeresult = $this->db->get();
        $processingFeerow = $processingFeeresult->row_array();
        $return['today']['processing_fee'] = ($processingFeerow['total_processingfee'] / 100) * 3;


        $this->db->select('ifnull(sum(total),"0.00") as total_processingfee', FALSE);
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('status', 3);
        $this->db->where('date > DATE_SUB(NOW(), INTERVAL 1 WEEK)');
        $processingFeeresult = $this->db->get();
        $processingFeerow = $processingFeeresult->row_array();
        $return['week']['processing_fee'] = ($processingFeerow['total_processingfee'] / 100) * 3;

        $this->db->select('ifnull(sum(total),"0.00") as total_processingfee', FALSE);
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('status', 3);
        $this->db->where('date > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
        $processingFeeresult = $this->db->get();
        $processingFeerow = $processingFeeresult->row_array();
        $return['month']['processing_fee'] = ($processingFeerow['total_processingfee'] / 100) * 3;

        $this->db->select('ifnull(sum(total),"0.00") as total_processingfee', FALSE);
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('status', 3);
        $processingFeeresult = $this->db->get();
        $processingFeerow = $processingFeeresult->row_array();
        $return['total']['processing_fee'] = ($processingFeerow['total_processingfee'] / 100) * 3;

        $this->db->select('ifnull(sum(ro.amount),"0.00") as total_refund', FALSE);
        $this->db->from('refund_order ro');
        $this->db->join('order o', 'o.order_id=ro.order_id', 'left');
        $this->db->where('o.business_id', $param['businessID']);
        $this->db->where('ro.created > DATE_SUB(NOW(), INTERVAL 1 DAY)');
        $refundresult = $this->db->get();
        $refundrow = $refundresult->row_array();
        $return['today']['refund'] = $refundrow['total_refund'];



        $this->db->select('ifnull(sum(ro.amount),"0.00") as total_refund', FALSE);
        $this->db->from('refund_order ro');
        $this->db->join('order o', 'o.order_id=ro.order_id', 'left');
        $this->db->where('o.business_id', $param['businessID']);
        $this->db->where('ro.created > DATE_SUB(NOW(), INTERVAL 1 WEEK)');
        $refundresult = $this->db->get();
        $refundrow = $refundresult->row_array();
        $return['week']['refund'] = $refundrow['total_refund'];

        $this->db->select('ifnull(sum(ro.amount),"0.00") as total_refund', FALSE);
        $this->db->from('refund_order ro');
        $this->db->join('order o', 'o.order_id=ro.order_id', 'left');
        $this->db->where('o.business_id', $param['businessID']);
        $this->db->where('ro.created > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
        $refundresult = $this->db->get();
        $refundrow = $refundresult->row_array();
        $return['month']['refund'] = $refundrow['total_refund'];

        $this->db->select('ifnull(sum(ro.amount),"0.00") as total_refund', FALSE);
        $this->db->from('refund_order ro');
        $this->db->join('order o', 'o.order_id=ro.order_id', 'left');
        $this->db->where('o.business_id', $param['businessID']);
        $refundresult = $this->db->get();
        $refundrow = $refundresult->row_array();
        $return['total']['refund'] = $refundrow['total_refund'];

        return $return;
    }

    function search_orders_count($param) {
        $date = explode(" - ", $param['hiddendate']);
        $start_date = $date[0];
        $end_date = $date[1];
        $this->db->select('count(order_id) as total_orders,ifnull(sum(subtotal),"0.00") as total_subtotal,ifnull(sum(tip_amount),"0.00") as total_tip, ifnull(sum(points_dollar_amount),"0.00") as total_points', FALSE);
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('date >=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->where('(status=2 or status=3)', NULL);
        $result = $this->db->get();
        $row = $result->row_array();

        $this->db->select('count(order_id) as rejected_orders', FALSE);
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('status', 0);
        $this->db->where('date >=', $start_date);
        $this->db->where('date <=', $end_date);
        $rejectedresult = $this->db->get();
        $rejectedrow = $rejectedresult->row_array();


        $this->db->select('ifnull(sum(total),"0.00") as total_processingfee', FALSE);
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('status', 3);
        $this->db->where('date >=', $start_date);
        $this->db->where('date <=', $end_date);
        $processingFeeresult = $this->db->get();
        $processingFeerow = $processingFeeresult->row_array();

        $this->db->select('ifnull(sum(ro.amount),"0.00") as total_refund', FALSE);
        $this->db->from('refund_order ro');
        $this->db->join('order o', 'o.order_id=ro.order_id', 'left');
        $this->db->where('o.business_id', $param['businessID']);
        $this->db->where('ro.created >=', $start_date);
        $this->db->where('ro.created <=', $end_date);
        $refundresult = $this->db->get();
        $refundrow = $refundresult->row_array();

        $row['rejected_orders'] = $rejectedrow['rejected_orders'];
        $row['total_processingfee'] = ($processingFeerow['total_processingfee'] / 100) * 3;
        $row['total_refund'] = $refundrow['total_refund'];
        return $row;
    }

    function update_order_charge_status($charge_id, $order_id, $stripe_refund_id, $refundamt, $refund_type, $consumer_id) {
        $data['order_id'] = $order_id;
        $data['stripe_refund_id'] = $stripe_refund_id;
        $data['amount'] = $refundamt;
        $data['refund_type'] = $refund_type;
        $data['created'] = date('Y-m-d H:i:s');
        $this->db->insert('refund_order', $data);
        $data = array();
        $data['is_refunded'] = '1';
        $this->db->where('charge_id', $charge_id);
        $this->db->update('order_charge', $data);

        $data = array();
        $data['status'] = '4';
        $this->db->where('order_id', $order_id);
        $this->db->update('order', $data);

        $this->db->where('order_id', $order_id);
        $this->db->where('consumer_id', $consumer_id);
        $this->db->delete('points');
    }

    function get_products_option($optionId) {
        $this->db->select('*');
        $this->db->from('option');
        $this->db->where('option_id', $optionId);
        $result = $this->db->get();
        $row = $result->row_array();
        return $row;
    }

    function edit_option($param) {

        $data['name'] = $param['name'];
        $data['price'] = $param['price'];
        $data['description'] = $param['description'];
        $data['product_option_category_id'] = $param['product_option_category_id'];
        $data['business_id'] = $param['businessID'];
        $this->db->where('option_id', $param['option_id']);
        $this->db->update('option', $data);
    }

    function delete_product($product_id) {
        $this->db->where('product_id', $product_id);
        $this->db->delete('product');
    }

    function delete_option($option_id) {
        $this->db->where('option_id', $option_id);
        $this->db->delete('option');
    }

    function insert_business_image($param) {
        $this->db->select('pictures');
        $this->db->from('business_customers');
        $this->db->where('businessID', $param['businessId']);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->row_array();

        if ($row['pictures'] != '') {
            $data["pictures"] = $row["pictures"] . "," . $param["picture"];
        } else {
            $data["pictures"] = $param["picture"];
        }
        $this->db->where("businessID", $param['businessId']);
        $this->db->update("business_customers", $data);
        $return = success_res("Business Picture added successfully");
        return $return;
    }

    function delete_business_image($param) {


        $this->db->select('pictures');
        $this->db->from('business_customers');
        $this->db->where('businessID', $param['businessId']);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->row_array();

        $pictures = explode(",", $row["pictures"]);

        for ($i = 0; $i < count($pictures); $i++) {
            $pictures[$i] = trim($pictures[$i]);

            if ($pictures[$i] == $param['picture']) {
                unset($pictures[$i]);
            }
        }


        if (count($pictures) > 0) {
            $data["pictures"] = implode(",", $pictures);
        } else {
            $data["pictures"] = "";
        }

        $this->db->where("businessID", $param['businessId']);
        $this->db->update("business_customers", $data);
        $return = success_res("Business Picture deleted successfully");
        return $return;
    }

}
