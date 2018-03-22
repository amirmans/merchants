<?php
use \koolreport\widgets\koolphp\Table;
?>
<html>
    <head>
        <title>Tap-in Drivers' Report</title>
        <style>
            .cssHeader
            {
                background-color:#FFA500;
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
            <h1>Drivers' Delivery Report</h1>
            <h3>Orders for <script> document.write(new Date().toLocaleDateString()); </script> </h3>
        </div>

        <h1>Salesforce</h1>


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
                "No. of Items"=>array(
                        "cssStyle"=>"width:80px",
                    "footer"=>"sum",
                    "footerText"=>"Total: @value"
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