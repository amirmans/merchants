<?php

require_once(__DIR__ . '/BaseReport.php');

class CorpDriver extends BaseReport
{
    use \koolreport\clients\Bootstrap;
    use \koolreport\clients\jQuery;

    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\POSTBinding;

    protected function defaultParamValues()
    {
        return array(
            "dateRange"=>array(
                "2018-04-01",
                "2018-04-31",
            ),
        );
    }

    protected function bindParamsToInputs()
    {
        return array(
            "dateRange"=>"dateRange"
        );
    }


    function setup()
    {
        $this->src('Corp')
        ->query("select corp.corp_name as Corp, b.`name` as Merchant, cp.nickname as 'Nick Name', o.order_id as 'Order ID'
					, o.no_items as 'No. of Items', corp.location_abbr as 'Location', corp.delivery_time as 'Delivery Time'
					, o.note as 'Order Note', o.pd_instruction as 'Delivery Instruction' from `order` o
                    left join corp corp on corp.corp_id = o.consumer_delivery_id
                    left join consumer_profile cp on cp.uid = o.consumer_id
                    left join business_customers b on o.business_id = b.businessID
                where  (o.status = 1 or o.status = 2 or o.`status` = 3 or o.status = 5) 
                and o.business_id in (corp.merchant_ids)
                and (o.date > :startDate AND o.date <= :endDate)
                order by merchant, delivery_time;")
            ->params(array(
                ":startDate"=>$this->params["dateRange"][0],
                ":endDate"=>$this->params["dateRange"][1]
            ))
        ->pipe($this->dataStore("corp_orders"));
    }
}