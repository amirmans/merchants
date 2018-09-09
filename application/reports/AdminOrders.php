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
        ->query("SELECT
	order_id AS 'Order ID',
	b.`name` AS Merchant,
	c.nickname AS 'Nick Name',
	c.email1 AS Email,
	o.cc_last_4_digits AS 'Last 4 Digits',
	o.subtotal AS 'Sub Total',
	o.reject_reason AS 'Reject Reason',
	o.payment_processor_message AS 'Payment Error',
	c.sms_no AS 'Phone'
FROM
	`order` o
	LEFT JOIN business_customers b ON b.businessID = o.business_id
	LEFT JOIN consumer_profile c ON c.uid = o.consumer_id
WHERE
	o.STATUS = :status
	AND  FIND_IN_SET(o.business_id,(SELECT merchant_ids FROM `corp` WHERE corp_name = 'Nvoicepay'))
    and  ( (CAST(o.date AS DATE)) <= :endDate and (CAST(o.date AS DATE)) >= :startDate )
	ORDER BY
	o.date DESC;
	")
            ->params(array(
                ":status"=>$this->params["status"],
                ":startDate"=>$this->params["dateRange"][0],
                ":endDate"=>$this->params["dateRange"][1]
        ))
        ->pipe($this->dataStore("corp_orders"));
    }

    protected function defaultParamValues()
    {
        return array(
            "status"=>1,
            "dateRange"=>array(
                date("Y-m-d"),
                date("Y-m-d")
            )
        );
    }

    protected function bindParamsToInputs()
    {
        return array(
            "dateRange"=>"dateRange",
            "status"=>"statusInput"
        );
    }
}