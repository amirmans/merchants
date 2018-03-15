<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\inputs\TextBox;
//use \koolreport\Select2;
?>
<html>
<head>
    <title>Tap-in Order Reports</title>
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
    <h1>Orders With Given Status </h1>
    <h3><script> document.write(new Date().toLocaleDateString()); </script> </h3>
</div>

<h1>Salesforce</h1>
<form method="post">
    <label>Order Status:</label>
    <?php TextBox::create(array(
        "name"=>"statusInput"
    ));?>
    <button>Submit</button>
</form>

<?php
Table::create(array(
    "dataStore"=>$this->dataStore("corp_orders"),
//    "showFooter"=>true,
    "paging"=>array(
        "pageSize"=>15,
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