<?php
require_once(__DIR__ . '/BaseReport.php');

class AdminOrders extends BaseReport
{
    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\POSTBinding;

    use \koolreport\clients\Bootstrap;
    use \koolreport\clients\jQuery;

    function setup()
    {
        $this->src('Corp')
        ->query("select order_id as 'Order ID', b.`name` as Merchant, c.nickname as 'Nick Name', c.email1 as Email
                    ,o.cc_last_4_digits as 'Last 4 Digits', o.subtotal as 'Sub Total', o.reject_reason as 'Reject Reason'
                    ,o.payment_processor_message as 'Payment Error', c.sms_no as 'Phone'
					from `order` o
					left join business_customers b on b.businessID = o.business_id
					left join consumer_profile c on c.uid = o.consumer_id
					where o.status=:status")
            ->params(array(
                ":status"=>$this->params["status"]
        ))
        ->pipe($this->dataStore("corp_orders"));
    }

    protected function defaultParamValues()
    {
        return array(
            "status"=>1,
        );
    }

    protected function bindParamsToInputs()
    {
        return array(
            "status"=>"statusInput",
        );
    }
}