

<style>
    .delivery_address,.delivery_time,.delivery_note{
        font-size: 17px;
    }
    .invoice .invoicename{
           right: 55px;
    }
    .text-right1{
        margin-top: 90px;
    }
</style>
<div class="invoice invoice-row" tabindex="1">

    <div class="invoicename"><a href="#" onclick="PrintDiv()" class=" btn btn-primary"><i class="fa fa-print"></i>Print</a></div>

    <div id="printDiv">
        <div class="line row">
            <div class="col-md-6 padding-0 text-left">
                <h4 id="order_view_h4" >

                    <?php if ($orderlist[0]['status'] == "1") {
                        ?>
                        <img   src="<?php echo base_url('assets/img/ic_error@3x.png'); ?>" alt="img" class="img order_view_icon">
                        NEW ORDER
                    <?php } elseif ($orderlist[0]['status'] == "2") {
                        ?>

                        <img src="<?php echo base_url('assets/img/ic_reload@3x.png'); ?>" alt="img" class="img order_view_icon">
                        In Progress
                    <?php } elseif ($orderlist[0]['status'] == "3") {
                        ?>

                        <img src="<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>" alt="img" class="img order_view_icon">
                        Completed
                        <?php
                    }
                    ?>
                    <input type="hidden" id="orderstatus" value="<?php echo $orderlist[0]['status']; ?>">


                </h4>
                <h2>#<?php echo $orderlist[0]['order_id']; ?> <span class="lowlighter">For</span> <?php echo $orderlist[0]['nickname']; ?></h2>
                <span class="time">Ordered <?php echo time_elapsed_string($orderlist[0]['seconds']); ?></span>

                <br>
                <span class="note">Note: <?php echo $orderlist[0]['note']; ?></span>


                <?php
                if ($consumer['is_first_order'] == 1) {
                    if ($orderlist[0]['nickname'] != '') {
                        ?>  <br><span class="firstorder"><?php echo ucfirst($orderlist[0]['nickname']); ?>'s First Order </span>
                        <?php
                    } else {
                        echo '<br><span class="firstorder">Consumer\'s First Order </span>';
                    }
                }
                if ($consumer['is_birthday'] == 1) {
                    if ($orderlist[0]['nickname'] != '') {
                        ?>  <br><span class="birthday">Today is <?php echo ucfirst($orderlist[0]['nickname']); ?>'s Birthday </span>
                        <?php
                    } else {
                        echo '<br><span class="birthday">Today is Consumer\'s Birthday </span>';
                    }
                }
                ?>
            </div>
            <div class="col-md-6  padding-0 text-right text-right1" >
                    <?php if ($orderlist[0]['consumer_delivery_id'] != 0) {
                    ?>

                <span class="delivery_time">Delivery Time : <b><?php echo date('h :i a', strtotime($orderlist[0]['delivery_time'])) ; ?> </b></span>
                    <br>
                    <span class="delivery_address">Delivery Address : <b><?php echo $orderlist[0]['delivery_address']; ?></b> </span>
                    <br>
                    <span class="delivery_note">Delivery Instruction : <b><?php echo $orderlist[0]['delivery_instruction']; ?></b> </span>

                <?php } ?>

            </div>
        </div>


        <input type="hidden" name="order_id" id="order_id" value="<?php echo encrypt_string($orderlist[0]['order_id']); ?>" />
        <table class="table" >
            <thead  class="title">
                <tr id="dashed_line">
                    <td colspan="4" height="1" style="border-collapse:collapse;border-top-color:rgb(103, 104, 105);border-top-style:dashed;border-top-width:2px;font-size:0;line-height:0;padding:0"></td>
                </tr>
                <tr>
                    <th class="th_product">PRODUCT</th>
                    <th class="th_price" >PRICE</th>
                    <th class="th_quantity">No.</th>
                    <th class="th_total text-right">TOTAL</th>
                </tr>
                <tr id="dashed_line">
                    <td colspan="4" height="1" style="border-collapse:collapse;border-top-color:rgb(103, 104, 105);border-top-style:dashed;border-top-width:2px;font-size:0;line-height:0;padding:0"></td>
                </tr>

            </thead>

            <tbody>


                <?php for ($i = 0; $i < count($order_detail); $i++) {
                    ?>
                    <tr>
                        <td class="th_product"><?php
                            echo $order_detail[$i]['name'];
                            if (sub_businesses() != "") {
                                echo '<p>' . $order_detail[$i]['business_name'] . "</p>";
                            }
                            foreach ($order_detail[$i]['option_ids'] as $option) {
                                ?>
                                <p class="product_description"><?php echo $option['name'] ?> </p>
                            <?php }
                            ?>
                                 <?php  if($order_detail[$i]['item_note']!=""){   echo '<p>Note : ' . $order_detail[$i]['item_note'] . "</p>";  } ?>
                        </td>
                        <td class="th_price" ><?php echo $order_detail[$i]['price']; ?></td>
                        <td class="th_quantity"><?php echo $order_detail[$i]['quantity']; ?></td>
                        <td class="th_total text-right"><?php
                            $per_item_total[$i] = $order_detail[$i]['price'] * $order_detail[$i]['quantity'];
                            echo number_format((float) $per_item_total[$i], 2, '.', '')
                            ?></td>
                    </tr>


                <?php }
                ?>
                <tr id="dashed_line">
                    <td colspan="4" height="1" style="border-collapse:collapse;border-top-color:rgb(103, 104, 105);border-top-style:dashed;border-top-width:2px;font-size:0;line-height:0;padding:0"></td>
                </tr>
                <tr>
                    <td class="th_product">Subtotal</td>
                    <td class="th_price"></td>
                    <td class="th_quantity"></td>
                    <td class="th_total text-right">$ <?php echo $orderlist[0]['subtotal']; ?></td>
                </tr>
                <tr>
                    <td class="th_product">Tax</td>
                    <td class="th_price"></td>
                    <td class="th_quantity"></td>
                    <td class="th_total text-right">$ <?php echo $orderlist[0]['tax_amount']; ?></td>
                </tr>
                <tr>
                    <td class="th_product">Tip</td>
                    <td class="th_price"></td>
                    <td class="th_quantity"></td>
                    <td class="th_total text-right">$ <?php echo $orderlist[0]['tip_amount']; ?></td>
                </tr>
                <tr>
                    <td class="th_product">Points</td>
                    <td class="th_price"></td>
                    <td class="th_quantity"></td>
                    <td class="th_total text-right">$ <?php echo $orderlist[0]['points_dollar_amount']; ?></td>
                </tr>
                <?php if ($orderlist[0]['consumer_delivery_id'] != 0) {
                    ?>
                    <tr>
                        <td class="th_product">Delivery Charges</td>
                        <td class="th_price"></td>
                        <td class="th_quantity"></td>
                        <td class="th_total text-right">$ <?php echo $orderlist[0]['delivery_charge_amount']; ?></td>
                    </tr>
                <?php } ?>

                <?php if ($orderlist[0]['promotion_code'] != "" && $orderlist[0]['promotion_discount_amount'] > 0.00) {
                    ?>
                    <tr>
                        <td class="th_product">Promotion Code</td>
                        <td class="th_price"></td>
                        <td class="th_quantity"></td>
                        <td class="th_total text-right"><?php echo $orderlist[0]['promotion_code']; ?></td>
                    </tr>
                <?php } ?>
                <?php if ($orderlist[0]['promotion_discount_amount'] > 0.00) {
                    ?>
                    <tr>
                        <td class="th_product">Promotion Discount</td>
                        <td class="th_price"></td>
                        <td class="th_quantity"></td>
                        <td class="th_total text-right">$ <?php echo $orderlist[0]['promotion_discount_amount']; ?></td>
                    </tr>
                <?php } ?>
                <tr id="dashed_line">
                    <td colspan="4" height="1" style="border-collapse:collapse;border-top-color:rgb(103, 104, 105);border-top-style:dashed;border-top-width:2px;font-size:0;line-height:0;padding:0"></td>
                </tr>
                <tr>
                    <td class="th_product">TOTAL</td>
                    <td class="th_price"></td>
                    <td class="th_quantity"></td>
                    <td class="th_total text-right" id="grand_total"><input type="hidden" name="order_amount" id="order_amount" value="<?php echo $orderlist[0]['total']; ?>"  /> $ <?php echo $orderlist[0]['total']; ?></td>
                </tr>
                <tr id="dashed_line">
                    <td colspan="4" height="1" style="border-collapse:collapse;border-top-color:rgb(103, 104, 105);border-top-style:dashed;border-top-width:2px;font-size:0;line-height:0;padding:0"></td>
                </tr>
            </tbody>
        </table>

    </div>
    <div>

        <div class="bottomtext" style="text-align: center ">
            <?php if ($orderlist[0]['status'] == "1") {
                ?>
                <a id="button_approve" href="#" class=" btn btn-primary " data-toggle="modal" data-target="#approveModal" style=" font-size: 20px;">
                    APPROVE
                </a>
                <script>
                    document.querySelector('#button_approve').onclick = function () {
                        $("#button_approve").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>APPROVE');
                        var order_id = $("#order_id").val();
                        var amout = $("#order_amount").val();
                        var param = {order_id: order_id};
                        $.post("<?php echo base_url('index.php/site/payment') ?>", param)
                                .done(function (data) {
                                    data = jQuery.parseJSON(data);
                                    if (data['status'] == '1')
                                    {
                                        $("#button_approve").remove();
                                        $("#button_reject").remove();
                                        $("#button_complete").show();
                                        $("#order_view_h4").html('<img src="<?php echo base_url('assets/img/ic_reload@3x.png'); ?>" alt="img" class="img order_view_icon"> In Progress');
                                        $("#order_id_" + order_id + " .img").remove("asasas");
                                        $("#order_id_<?php echo $orderlist[0]['order_id']; ?> img").attr('src', "<?php echo base_url('assets/img/ic_reload@3x.png'); ?>");
                                        $("#li_order_id_<?php echo $orderlist[0]['order_id']; ?>").removeClass('pending_order_color');
                                        $("#order_id_<?php echo $orderlist[0]['order_id']; ?> img").toggleClass('pending_order_img img');
                                        swal("$" + data['amount'], "Your payment has been successfully processed", "success");

                                    } else {
                                        $("#button_approve").html('APPROVE');
                                        swal("$" + amout, data['msg'], "error");
                                    }
                                });
                    };
                </script>
                &nbsp;
                &nbsp;
                &nbsp;

                <a id="button_reject" href="#" class=" btn btn-danger " style=" font-size: 20px;">
                    REJECT
                </a>
                <script>
                    document.querySelector('#button_reject').onclick = function () {
                        $("#button_reject").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>REJECT');
                        var order_id = $("#order_id").val();
                        var param = {order_id: order_id};
                        $.post("<?php echo base_url('index.php/site/rejectorder') ?>", param)
                                .done(function (data) {
                                    data = jQuery.parseJSON(data);

                                    if (data['status'] == '1')
                                    {
                                        $("#order_view").html('');
                                        $("#order_id_<?php echo $orderlist[0]['order_id']; ?>").remove();
                                        swal("Rejected", "Your order has been successfully rejected", "success");
                                    }
                                });
                    };
                </script>

                <a id="button_complete" href="#" class=" btn btn-primary " data-toggle="modal" data-target="#completeModal"    style=" font-size: 20px; display: none">
                    COMPLETE
                </a>
                <script>
                    document.querySelector('#button_complete').onclick = function () {
                        $("#button_complete").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>COMPLETE');
                        var order_id = $("#order_id").val();
                        var param = {order_id: order_id};
                        $.post("<?php echo base_url('index.php/site/completedorder') ?>", param)
                                .done(function (data) {
                                    data = jQuery.parseJSON(data);
                                    if (data['status'] == '1')
                                    {
                                        $("#button_complete").remove();
                                        swal("Completed order", "", "success");
                                        $("#order_view_h4").html('<img src="<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>" alt="img" class="img order_view_icon"> Completed');
                                        $("#order_id_<?php echo $orderlist[0]['order_id']; ?> img").attr('src', "<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>");
                                        setInterval(function () {
                                            $("#order_id_<?php echo $orderlist[0]['order_id']; ?>").remove();
                                        }, 2000)

                                    } else {
                                        $("#button_complete").html();
                                        swal("Completed order", data['msg'], "error");
                                    }
                                });


                    };
                </script>


            <?php } elseif ($orderlist[0]['status'] == "2") {
                ?>
                <a id="button_complete" href="#" class=" btn btn-primary " data-toggle="modal" data-target="#completeModal"    style=" font-size: 20px;">
                    COMPLETE
                </a>
                <script>
                    document.querySelector('#button_complete').onclick = function () {
                        $("#button_complete").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>COMPlETE');
                        var order_id = $("#order_id").val();
                        var param = {order_id: order_id};
                        $.post("<?php echo base_url('index.php/site/completedorder') ?>", param)
                                .done(function (data) {
                                    data = jQuery.parseJSON(data);
                                    if (data['status'] == '1')
                                    {
                                        $("#button_complete").remove();
                                        swal("Completed order", "", "success");
                                        $("#order_view_h4").html('<span><img src="<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>" alt="img" class="img order_view_icon"></span> Completed');
                                        $("#order_id_<?php echo $orderlist[0]['order_id']; ?> img").attr('src', "<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>");

                                        setInterval(function () {
                                            $("#order_id_<?php echo $orderlist[0]['order_id']; ?>").remove();
                                        }, 2000)

                                    } else {
                                        $("#button_complete").html();
                                        swal("Completed order", data['msg'], "error");
                                    }
                                });
                    };

                </script>



                <?php
            } elseif ($orderlist[0]['status'] == "3") {
                if ($orderlist[0]['is_refunded'] == "1") {
                    ?>
                    <span id="refunded_label"><label class="label label-primary padding-10" style="font-weight: normal;font-size: 20px;"><i class="fa fa-check"></i>REFUNDED</label></span>
                    <?php
                } else {
                    ?><a id="button_refund" href="#" class=" btn btn-primary " data-toggle="modal" data-target="#completeModal"    style=" font-size: 20px;">
                        REFUND
                    </a>
                    <span id="refunded_label" style="display: none"><label class="label label-primary padding-10" style="font-weight: normal;font-size: 20px;"><i class="fa fa-check"></i>REFUNDED</label></span>
                    <script>
                        document.querySelector('#button_refund').onclick = function () {
                            $("#refundModal").modal('show');
                        };
                    </script>
                    <?php
                }
                ?>





                <?php
            }
            ?>


        </div>

    </div>
</div>

<div class="modal fade" id="refundModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none; vertical-align: middle">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Refund Order</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <label class="col-sm-3 control-label form-label">Refund Type</label>
                    <div class="col-sm-6">
                        <div class="radio">
                            <input type="radio" name="refund_type" id="full" value="1" checked onchange="hideShow(1)">
                            <label for="full">
                                Full
                            </label>
                        </div>
                        <div class="radio radio-warning">
                            <input type="radio" name="refund_type" id="partial" value="2" onchange="hideShow(2)">
                            <label for="partial">
                                Partial
                            </label>
                        </div>

                        <div class="" style="display: none" id="refund_amt">

                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-usd"></i></div>
                                <input type="number" class="form-control" id="rfd_amount" name="rfd_amount"  placeholder="Refund Amount" required min="0">
                            </div>
                            <label class="margin-5">Ex. $3.25</label>

                        </div>
                    </div>
                    <div class="col-sm-3"></div>
                </div>

                <br>
            </div>
            <div class="modal-footer">
                <label id="category_error_text" class="pull-left color10"></label>
                <button type="button" class="btn btn-white" data-dismiss="modal" >Close</button>
                <button  class="btn btn-default" onclick="refund_order()" >Refund</button>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    function hideShow(sendto)
    {
        if (sendto == 1)
        {
            $('#refund_amt').hide();
        }
        else
        {
            $('#refund_amt').show();
        }
    }

    function PrintDiv() {

        var divToPrint = document.getElementById('printDiv');
        var content = divToPrint.innerHTML.replace(/<img[^>]*>/g, "");

        var order_status = $('#orderstatus').val();
        if (order_status == 1)
        {
            $("#button_approve").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>APPROVE');
            var order_id = $("#order_id").val();
            var amout = $("#order_amount").val();
            var param = {order_id: order_id};
            $.post("<?php echo base_url('index.php/site/payment') ?>", param)
                    .done(function (data) {
                        data = jQuery.parseJSON(data);
                        if (data['status'] == '1')
                        {
                            $("#button_approve").remove();
                            $("#button_reject").remove();
                            $("#button_complete").show();
                            $("#order_view_h4").html('<img src="<?php echo base_url('assets/img/ic_reload@3x.png'); ?>" alt="img" class="img order_view_icon"> In Progress');
                            $("#order_id_" + order_id + " .img").remove("asasas");
                            $("#order_id_<?php echo $orderlist[0]['order_id']; ?> img").attr('src', "<?php echo base_url('assets/img/ic_reload@3x.png'); ?>");
                            $("#li_order_id_<?php echo $orderlist[0]['order_id']; ?>").removeClass('pending_order_color');
                            $("#order_id_<?php echo $orderlist[0]['order_id']; ?> img").toggleClass('pending_order_img img');
                            swal("$" + data['amount'], "Your payment has been successfully processed", "success");
                            print_html(content)
                        } else {
                            $("#button_approve").html('APPROVE');
                            swal("$" + amout, data['msg'], "error");
                        }
                    });
        } else
        {
            print_html(content)
        }
        return false;

    }

    function print_html(content)
    {
        var frame1 = document.createElement('iframe');
        frame1.name = "frame1";
        frame1.style.position = "absolute";
        frame1.style.top = "-1000000px";
        document.body.appendChild(frame1);
        var frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
        frameDoc.document.open();
        frameDoc.document.write('<html><style> @media print { @page {size: 3.5in;margin:0;}}@media print {  * { margin: 0 !important; padding: 4px !important;text-transform: uppercase;font-family:monospace; }}@media print   { .text-right1{margin-top:0} .invoice .logo{ font-size:7pt;padding:0;text-align:center;}} @media print   { .time { font-size:8px;}} @media print   { .note{ font-size:8px;}.delivery_address,.delivery_time,.delivery_note {font-size:10pt; float:right} .birthday { font-size:8px;} .firstorder{ font-size:8px;}} @media print  {.invoice .line h2 { font-size:10pt;line-height:0} } @media print  {.invoice .line h4 { font-size:7px} } @media print  { table { page-break-inside : auto;width:100%; }}@media print  { table tr th,td{ font-size: 10pt;text-align:left;letter-spacing:0}}@media print  { table .th_total { white-space: nowrap;}}@media print  { table .th_price { white-space: nowrap;}}@media print   {.invoice .table p { font-size:8pt;}}  @media print   { #grand_total { font-weight:bold}} @media print  { table .th_quantity { font-weight:bold;}}  </style><body onload="window.print()"><div class="invoice invoice-row"><div class="logo"><h1><?php echo $this->session->userdata('name'); ?></h1> </div>' + content + '</div></html>');

        frameDoc.document.close();
    }

    window.history.forward(-1);

    function refund_order() {

        var order_id = $("#order_id").val();
        var refund_type = $("input[name=refund_type]:checked").val();
        var param = {order_id: order_id, refund_type: refund_type};
        if (refund_type == 2)
        {
            var amount = parseFloat($("#rfd_amount").val());
            ;
            var order_amount = parseFloat($("#order_amount").val());
            if ((amount < 0) || (amount > order_amount))
            {
                swal("", "Invalid  Amount", "error");
                return false;
            }
            param.amount = amount;
        }

        $.post("<?php echo base_url('index.php/site/refund_order_amount') ?>", param)
                .done(function (data) {
                    data = jQuery.parseJSON(data);
                    if (data['status'] == '1')
                    {
                        $('#refundModal').modal('toggle');
                        $("#button_refund").remove();
                        $("#refunded_label").show();
                        swal("Refunded order", "", "success");
                    } else {
                        $('#refundModal').modal('toggle');
                        swal("Refunded order", data['msg'], "error");
                    }
                });
    }


</script>



