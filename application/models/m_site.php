<?php

class M_site extends CI_Model {

    public function __construct() {
        parent::__construct();
        //date_default_timezone_set("GMT");
        date_default_timezone_set('America/Los_Angeles');
    }

    function do_login($param) {
        $this->db->select('businessID,name,username');
        $this->db->from('business_customers');
        $this->db->limit(1);
        $this->db->where('username', $param['username']);
        $this->db->where('password', md5($param['password']));
        $this->db->where('active', 1);
        $result = $this->db->get();
        $row = $result->result_array();

        if (count($row) > 0) {
            $return = success_res("");
            $this->session->set_userdata($row[0]);
        } else {
            $return = error_res("Username or password incorrect");
            $this->session->set_flashdata('error1', 'Username or password incorrect');
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
        $this->db->select('businessID,name,username,email,website,businessTypes,phone,address,city,state,zipcode,stripe_secret_key,icon,marketing_statement,process_time,short_name,sms_no');
        $this->db->from('business_customers');
        $this->db->where('businessID', $businessID);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->result_array();
        if (count($row) > 0) {
            $return = success_res("Business is available");
            $return['business_detail'] = $row[0];
        } else {
            $return = error_res("Business is not available");
            $return['business_detail'] = array();
        }
        return $return;
    }

    function get_business_list() {
        $this->db->select('businessID,name');
        $this->db->from('business_customers');
        $this->db->where('active', 1);
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

        $data['stripe_secret_key'] = $param['stripe_secret_key'];
        $data['businessID'] = $param['businessID'];
        $data['address'] = $param['address'];
        $data['email'] = $param['email'];
        $data['website'] = $param['website'];
        $data['phone'] = $param['phone'];
        $data['businessTypes'] = $param['businessTypes'];
        $data['marketing_statement'] = $param['marketing_statement'];
        $data['short_name'] = $param['short_name'];
        $data['sms_no'] = $param['sms_no'];
        if ($param['process_time'] != '') {
            $data['process_time'] = $param['process_time'];
        }
        if ($param['icon'] != "") {
            $data['icon'] = $param['icon'];
        }

        $this->db->where('businessID', $param['businessID']);
        $this->db->update('business_customers', $data);
        $return = success_res("Stripe Token Updated Successfully");
        $return['stripe_secret_key'] = $param['stripe_secret_key'];
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

    function get_business_order_list($param) {
        $this->db->select('o.order_id,o.payment_id,o.total,o.date,o.no_items,o.status,cp.nickname,TIMESTAMPDIFF(SECOND,o.date,now()) as seconds');
        $this->db->from('order as o');
        $this->db->join('consumer_profile as cp', 'o.consumer_id = cp.uid', 'left');
        $this->db->where('o.status !=', 0);
        if ($param['order_status'] == "completed") {
            $this->db->where('o.status', 3);
        } else {
            $this->db->where('o.status !=', 3);
        }
        $this->db->where('o.business_id', $param['businessID']);
        $this->db->order_by("o.order_id", "desc");
        //$this->db->limit(10);
        $result = $this->db->get();
        $row = $result->result_array();
        return $row;
    }

    function get_ordelist_order($order_id) {
        $this->db->select('o.order_id,o.payment_id,o.total,o.date,cp.nickname,o.status,o.note,o.subtotal,o.tip_amount,o.tax_amount,o.points_dollar_amount,TIMESTAMPDIFF(SECOND,o.date,now()) as seconds');
        $this->db->from('order as o');
        $this->db->join('consumer_profile as cp', 'o.consumer_id = cp.uid', 'left');
        $this->db->where('o.order_id', $order_id);
        $this->db->where('o.business_id', is_login());
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->result_array();

        return $row;
    }

    function get_order_detail($order_id) {

        $this->db->select('o.order_item_id,o.price,o.quantity,p.name,p.short_description,o.option_ids,o.product_id');
        $this->db->from('order_item as o');
        $this->db->join('product as p', 'o.product_id = p.product_id', 'left');
        $this->db->where('o.order_id', $order_id);
        $result = $this->db->get();
        $row = $result->result_array();

        foreach ($row as &$r) {
            $optionsId = explode(',', $r['option_ids']);
            $this->db->select('name');
            $this->db->from('product_option');
            $this->db->where_in('option_id', $optionsId);
            $option_result = $this->db->get();
            $option_row = $option_result->result_array();
            $r['option_ids'] = $option_row;
        }
        return $row;
    }

    function get_order_payment_detail($order_id) {
        $this->db->select('o.total,o.consumer_id');
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

    function completedorder($order_id) {
        $data = array();
        $data['status'] = '3';
        $this->db->where('business_id', is_login());
        $this->db->where('order_id', $order_id);
        $this->db->update('order', $data);

        $order_detail = $this->get_order_info($order_id);


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
                'alert' => "Your order #" . $order_id . " is completed ",
                'badge' => 0,
                'sound' => 'newMessage.wav'
            );
            push_notification_ios($device_token, $message_body);

            $notification['consumer_id'] = $order_detail['consumer_id'];
            $notification['business_id'] = is_login();
            $notification['message'] = "Your order #" . $order_id . " is completed ";
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

        $this->db->select('device_token');
        $this->db->from('consumer_profile');
        $this->db->where('uid', $order_detail['consumer_id']);
        $this->db->limit(1);
        $result = $this->db->get();
        $row = $result->result_array();

        if (count($row) > 0) {
            $device_token = $row[0]['device_token'];

            $message_body = array(
                'type' => "0",
                'alert' => "Your order #" . $order_id . " is rejected ",
                'badge' => 0,
                'sound' => 'newMessage.wav'
            );
            push_notification_ios($device_token, $message_body);
            $notification['consumer_id'] = $order_detail['consumer_id'];
            $notification['business_id'] = is_login();
            $notification['message'] = "Your order #" . $order_id . " is rejected ";
            $notification['image'] = "";
            $notification['time_sent'] = date("Y-m-d H:i:s");
            $notification['notification_type_id'] = "4";
            $this->db->insert('notification', $notification);
        }
    }

    function get_business_products($param) {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('businessID', $param['businessID']);
        $this->db->order_by("product_id", "desc");
        $result = $this->db->get();
        $row = $result->result_array();
        return $row;
    }

    function get_business_options($param) {
        $this->db->select('*');
        $this->db->from('business_option');
        $this->db->where('business_id', $param['businessID']);
        $this->db->order_by("option_id", "desc");
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

    function add_product_option_category($param) {

        $this->db->select('*');
        $this->db->from('product_option_category');
        $this->db->where('name', $param['option_category_name']);
        $category_result = $this->db->get();
        $category_row = $category_result->row_array();
        if (count($category_row) == 0) {
            $data['name'] = $param['option_category_name'];
            $data['desc'] = $param['desc'];

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

        $this->db->select('*');
        $this->db->from('business_option');
        $this->db->where('name', $param['name']);
        $option_result = $this->db->get();
        $option_row = $option_result->row_array();
        if (count($option_row) == 0) {
            $data['business_id'] = $param['businessID'];
            $data['name'] = $param['name'];
            $data['price'] = $param['price'];
            $data['description'] = $param['description'];
            $data['product_option_category_id'] = $param['product_option_category_id'];
            $this->db->insert('business_option', $data);
            $return['status'] = 1;
            $return['msg'] = 'Option added successfully';
        } else {
            $return['status'] = 0;
            $return['msg'] = 'Option name already exist';
        }
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
            $this->db->from('business_option');
            $this->db->where('option_id', $checkedOptionIds[$i]);
            $option_result = $this->db->get();
            $option_row = $option_result->row_array();

            $this->db->select('option_id,name');
            $this->db->from('product_option');
            $this->db->where('product_id', $param['product_id']);
            $this->db->where('name', $option_row['name']);
            $this->db->order_by("option_id", "desc");
            $product_result = $this->db->get();
            $product_row = $product_result->row_array();
            if (count($product_row) == 0) {
                $data = array();
                $data['product_option_category_id'] = $option_row['product_option_category_id'];
                $data['name'] = $option_row['name'];
                $data['price'] = $option_row['price'];
                $data['description'] = $option_row['description'];
                $data['product_id'] = $param['product_id'];

                $this->db->insert('product_option', $data);
            } else {
                if ($product_row['availability_status'] == 0) {
                    $data = array();
                    $data['availability_status'] = 1;
                    $this->db->where('option_id', $product_row['option_id']);
                    $this->db->update('product_option', $data);
                }
            }
        }
        for ($i = 0; $i < count($uncheckedOptionIds); $i++) {
            $this->db->select('*');
            $this->db->from('business_option');
            $this->db->where('option_id', $uncheckedOptionIds[$i]);
            $option_result = $this->db->get();
            $option_row = $option_result->row_array();

            $this->db->select('option_id,name');
            $this->db->from('product_option');
            $this->db->where('product_id', $param['product_id']);
            $this->db->where('name', $option_row['name']);
            $this->db->order_by("option_id", "desc");
            $product_result = $this->db->get();
            $product_row = $product_result->row_array();
            if (count($product_row) > 0) {
                $data = array();
                $data['availability_status'] = 0;
                $this->db->where('option_id', $product_row['option_id']);
                $this->db->update('product_option', $data);
            }
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
        $this->db->select('*');
        $this->db->from('business_option');
        $this->db->where('business_id', $param['businessID']);
        $this->db->order_by("option_id", "desc");
        $result = $this->db->get();
        $row = $result->result_array();


        $this->db->select('name');
        $this->db->from('product_option');
        $this->db->where('product_id', $param['product_id']);
        $this->db->where('availability_status', 1);
        $this->db->order_by("option_id", "desc");
        $product_result = $this->db->get();
        $product_row = $product_result->result_array();

        foreach ($row as &$r) {
            foreach ($product_row as $p) {
                if ($p['name'] == $r['name']) {
                    $r['is_add'] = 1;
                }
            }
        }
        return $row;
    }

    function get_products_option_category() {
        $this->db->select('*');
        $this->db->from('product_option_category');
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
        $this->db->where('o.order_id >', $param['latest_order_id']);

        $this->db->where('o.business_id', $param['businessID']);
        $this->db->order_by("o.order_id", "desc");
        //$this->db->limit(10);
        $result = $this->db->get();
        $row = $result->result_array();
        return $row;
    }

    function count_order_for_remaining_approve($param) {

        $this->db->where('business_id', $param['businessID']);
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

        if ($param['pictures'] != '') {
            $data['pictures'] = $param['pictures'];
        }
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
        $this->db->select('*');
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('date > DATE_SUB(NOW(), INTERVAL 1 DAY)');
        $result = $this->db->get();
        $rowcount = $result->num_rows();
        $return['today']=$rowcount;
        
        $this->db->select('*');
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('date > DATE_SUB(NOW(), INTERVAL 1 WEEK)');
        $weekresult = $this->db->get();
        $weekcount = $weekresult->num_rows();
        $return['week']=$weekcount;
        
        
        $this->db->select('*');
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $this->db->where('date > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
        $monthresult = $this->db->get();
        $monthcount = $monthresult->num_rows();
        $return['month']=$monthcount;
        
        $this->db->select('*');
        $this->db->from('order');
        $this->db->where('business_id', $param['businessID']);
        $totalresult = $this->db->get();
        $totalcount = $totalresult->num_rows();
        $return['total']=$totalcount;
        return $return;
    }

}
