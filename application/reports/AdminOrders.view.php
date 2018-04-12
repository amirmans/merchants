
<link href="<?php echo base_url('assets/css/root.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/plugin/bootstrap-toggle/bootstrap-toggle.min.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/plugin/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/plugin/sweet-alert/sweet-alert.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/plugin/date-range-picker/daterangepicker.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/plugin/bootstrap-timepicker/bootstrap-datetimepicker.css'); ?>" rel="stylesheet">

<!-- <div class="loading"><img src="<?php echo base_url('assets/img/loading.gif'); ?>" alt="loading-img"></div> -->
        <div id="top" class="clearfix">

            <!-- Start App Logo -->
            <div class="applogo">
                <a href="<?php echo base_url(); ?>" class="logo">Tap-in</a>
            </div>
            <!-- End Top Right -->
            <ul class="topmenu"  style="display: block">
                    &nbsp;&nbsp; <li ><a id="orderlist_tab" href="<?php echo base_url('index.php/AdminOrderReport'); ?>">Admin Report</a></li>
                    <li ><a id="product_tab" href="<?php echo base_url('index.php/CorpDriverReport'); ?>">Driver Report</a></li>
                  </ul>
        </div>


<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\inputs\TextBox;
use \koolreport\inputs\DateRangePicker;
use \koolreport\Select2;
?>
<html>
<head>
    <title>Tap-in Order Reports</title>
    <style>
        .cssHeader
        {
            background-color:rgb(244, 118, 40);
            font-size: 15px;
        }
        .cssItem
        {
            background-color:#fdffe8;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div align="center">
    <h1>vTech Communication</h1>
    <h3>Orders With Given Status </h3>
</div>
<form method="post">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h4>Choose a date</h4>
            <div class="form-group">
                <?php
                DateRangePicker::create(array(
                    "name"=>"dateRange"
                ))
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <h4>Choose order status</h4>
                    <?php TextBox::create(array(
                        "name"=>"statusInput"
                    ));?>


<!--                --><?php
//                MultiSelect::create(array(
//                    "name"=>"customers",
//                    "dataStore"=>$this->dataStore("corp_orders"),
//                    "dataBind"=>array(
//                        "text"=>"customerName",
//                        "value"=>"customerNumber",
//                    ),
//                    "attributes"=>array(
//                        "class"=>"form-control",
//                        "size"=>10,
//                    )
//                ));
//                ?>


            </div>
            <div class="form-group text-center">
                <button class="btn btn-success">
                    <i class="glyphicon glyphicon-refresh"></i> Load</button>
            </div>
        </div>
    </div>
</form>


<?php
Table::create(array(
    "dataStore"=>$this->dataStore("corp_orders"),
    "showFooter"=>true,
    "paging"=>array(
        "pageSize"=>40,
        "pageIndex"=>0,
        "align"=>"center"
    ),
    "class"=>array(
        "table"=>"table table-hover"
    ),
    "cssClass"=>array(
        "table"=>"table table-bordered",
        "th"=>"cssHeader",
        "tr"=>"cssItem"
    ),
    "columns"=>array(
        "Merchant"=>array(
            "cssStyle"=>"width:200px"
        ),
        "Order ID"=>array(
//                    "cssStyle"=>"font-size: 11px",
        ),
        "Sub Total"=>array(
            "cssStyle"=>"width:80px",
            "type"=>"number",
            "label"=>"Amount in USD",
            "decimals"=>2,
            "prefix"=>"$ "
        ),
        "Reject Reason"=>array(
            "cssStyle"=>"width:200px"
        ),
        "Payment Error"=>array(
            "cssStyle"=>"width:200px"
        ),
        "Nick Name"=>array(
            "cssStyle"=>"width:100px"

        ),
        "Email"=>array(
            "cssStyle"=>"width:100px"

        ),
        "Phone"=>array(
            "cssStyle"=>"width:100px"

        ),
        "Last 4 Digits"=>array(
            "cssStyle"=>"width:80px"

        )
    )
));
?>
</body>
</html>