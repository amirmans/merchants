
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
use \koolreport\inputs\DateRangePicker;

?>
<html>
    <head>
        <title>Tap-in Drivers' Report</title>
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
            <h2>Drivers' Delivery Report</h2>
<!--            <h3>Orders for <script> document.write(new Date().toLocaleDateString()); </script> </h3>-->
        </div>



        <div class="text-center">
        <h1>List of order</h1>
        <h4>Choose a date to view orders</h4>
        </div>
        <form method="post">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="form-group">
                        <?php
                        DateRangePicker::create(array(
                            "name"=>"dateRange"
                        ))
                        ?>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-success"><i class="glyphicon glyphicon-refresh"></i> Load</button>
                    </div>
                </div>
            </div>
        </form>
        <hr/>



        <?php
        Table::create(array(
            "dataStore"=>$this->dataStore("corp_orders"),
            "showFooter"=>true,
            "removeDuplicate"=>array("Corp"),
            "paging"=>array(
                "pageSize"=>20,
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
                "Corp"=>array(
                    "cssStyle"=>"width:120px;font-weight:bold;font-size:19"


                ),
                "Merchant"=>array(
                    "cssStyle"=>"width:200px"

                ),
                "No. of Items"=>array(
                        "cssStyle"=>"width:80px",
                    "footer"=>"sum",
                    "footerText"=>"Total: @value"
                ),
                "Delivery Time"=>array(
                    "cssStyle"=>"width:70px"
                ),
                "Location"=>array(
                    "cssStyle"=>"width:150px"
                ),
                "Order Note"=>array(
//                    "cssStyle"=>"font-size: 11px",
                ),
                "Delivery Instruction"=>array(
//                    "cssStyle"=>"font-size: 11px",
                ),
                "Nick Name"=>array(
                    "cssStyle"=>"width:100px"

                ),
                "Order ID"=>array(
                        "cssStyle"=>"width:90px",
                    "footer"=>"count",
                    "footerText"=>"Count: @value"
                )
            )
        ));
        ?>
    </body>
</html>