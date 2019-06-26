<?php

class M_transfer extends CI_Model {
    public function __construct() {
        parent::__construct();
        //date_default_timezone_set("GMT");
        date_default_timezone_set('America/Los_Angeles');
    }
    
    function maskInfo() {
        $ccMaskSql = "
            update consumer_cc_info set cc_no = 
            concat (replace(
            substr(cc_no,1, LENGTH(cc_no)-4)
            , substr(cc_no,1, LENGTH(cc_no)-4) ,repeat('*',
            length(substr(cc_no,1, LENGTH(cc_no)-4))
            )), 
            substring(cc_no, -4)
        );";
        $query1 = $this->db->query($ccMaskSql);

        $stripeTestSql = 
            "update business_customers set stripe_secret_key = 'sk_test_mBTVbAuKGx5FDk8dXXSQCay4'";
        $query2 = $this->db->query($stripeTestSql);

        $sms_no = TestBusinessAlertSmsNo;
        $alertEmailSql = 
            "update business_internal_alert set email = 'amir+1@tap-in.co', sms_no ='$sms_no';";
        $query3 = $this->db->query($alertEmailSql);

        return ($query1 && $query2 && $query3);
    }
}
