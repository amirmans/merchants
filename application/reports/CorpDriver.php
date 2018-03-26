<?php

require_once(__DIR__ . '/BaseReport.php');

class CorpDriver extends BaseReport
{
    use \koolreport\clients\Bootstrap;
    use \koolreport\clients\jQuery;

    function setup()
    {
        $this->src('Corp')
        ->query("select  b.`name` as Merchant, cp.nickname as 'Nick Name', o.order_id as 'Order ID'
					, o.no_items as 'No. of Items', corp.location_abbr as 'Location', corp.delivery_time as 'Delivery Time'
					, o.note as 'Order Note', o.pd_instruction as 'Delivery Instruction' from `order` o
left join corp corp on corp.corp_id = o.consumer_delivery_id
left join consumer_profile cp on cp.uid = o.consumer_id
left join business_customers b on o.business_id = b.businessID
where  (o.status = 2 or o.`status` = 3 or o.status = 5)  
	and corp.corp_name = \"Vtech Communications\" order by merchant, delivery_time;")
        ->pipe($this->dataStore("corp_orders"));
    }
}