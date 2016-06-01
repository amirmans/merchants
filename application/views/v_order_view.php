
<div class="invoice invoice-row">

    <div class="line row">
        <div class="col-md-6 col-xs-6 padding-0 text-left">
            <h4 id="order_view_h4" >

                <?php if ($orderlist[0]['status'] == "1") {
                    ?>     <span class="">
                        <img   src="<?php echo base_url('assets/img/ic_error@3x.png'); ?>" alt="img" class="img order_view_icon">
                    </span> NEW ORDER                 
                <?php } elseif ($orderlist[0]['status'] == "2") {
                    ?>
                    <span class="">
                        <img src="<?php echo base_url('assets/img/ic_reload@3x.png'); ?>" alt="img" class="img order_view_icon">
                    </span> In Progress
                <?php } elseif ($orderlist[0]['status'] == "3") {
                    ?>
                    <span class="">
                        <img src="<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>" alt="img" class="img order_view_icon">
                    </span> Completed
                    <?php
                }
                ?> 


            </h4>
            <h2>#<?php echo $orderlist[0]['order_id']; ?> <span class="lowlighter">For</span> <?php echo $orderlist[0]['nickname']; ?></h2>
            <span class="time">Ordered <?php echo time_elapsed_string($orderlist[0]['date']); ?></span>
            <br>
            <span class="note">Note: <?php echo $orderlist[0]['note']; ?></span>
        </div>
        <div class="col-md-6 col-xs-6 padding-0 text-right">


        </div>
    </div>


    <input type="hidden" name="order_id" id="order_id" value="<?php echo encrypt_string($orderlist[0]['order_id']); ?>" />
    <table class="table">
        <thead  class="title">
            <tr>
                <td class="th_product">PRODUCT</td>
                <td class="th_price" >PRICE</td>
                <td class="th_quantity">QUANTITY</td>
                <td class="th_total text-right">TOTAL</td>
            </tr>
        </thead>
        <tbody>

            <?php for ($i = 0; $i < count($order_detail); $i++) {
                ?>
                <tr>
                    <td class="th_product"><?php
                        echo $order_detail[$i]['name'];
                        foreach ($order_detail[$i]['option_ids'] as $option) {
                            ?>
                            <p class="product_description"><?php echo $option['name'] ?> </p>   
                        <?php }
                        ?>  
                    </td>
                    <td class="th_price" >$ <?php echo $order_detail[$i]['price']; ?></td>
                    <td class="th_quantity"><?php echo $order_detail[$i]['quantity']; ?></td>
                    <td class="th_total text-right">$ <?php echo ($per_item_total[$i] = $order_detail[$i]['price'] * $order_detail[$i]['quantity']); ?></td>
                </tr>


            <?php } ?>

            <tr>
                <td></td>
                <td></td>
                <td class="text-right"></td>
                <td class="text-right total_price">TOTAL<h4 class="total"><input type="hidden" name="order_amount" id="order_amount" value="<?php echo $orderlist[0]['total']; ?>"  /> $ <?php echo $orderlist[0]['total']; ?></h4></td>
            </tr>
        </tbody>
    </table>

    <div class="bottomtext" style="text-align: center ">
        <?php if ($orderlist[0]['status'] == "1") {
            ?>    
            <a id="button_approve" href="#" class=" btn btn-primary " data-toggle="modal" data-target="#approveModal" style=" font-size: 20px;">
                APPROVE
            </a>
            <script>
                document.querySelector('#button_approve').onclick = function() {
                    $("#button_approve").html('APPROVE..');
                    var order_id = $("#order_id").val();
                    var amout = $("#order_amount").val();
                    var param = {order_id: order_id};
                    $.post("<?php echo base_url('index.php/site/payment') ?>", param)
                            .done(function(data) {
                                data = jQuery.parseJSON(data);
                                if (data['status'] == '1')
                                {
                                    $("#button_approve").remove();
                                    $("#button_reject").remove();
                                    $("#button_complete").show();
                                    $("#order_view_h4").html('<span><img src="<?php echo base_url('assets/img/ic_reload@3x.png'); ?>" alt="img" class="img order_view_icon"></span> In Progress');
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
                document.querySelector('#button_reject').onclick = function() {
                    $("#button_reject").html('REJECT..');
                    var order_id = $("#order_id").val();
                    var param = {order_id: order_id};
                    $.post("<?php echo base_url('index.php/site/rejectorder') ?>", param)
                            .done(function(data) {
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
                Complete
            </a>
            <script>
                document.querySelector('#button_complete').onclick = function() {
                    $("#button_complete").html('COMPlETE..');
                    var order_id = $("#order_id").val();
                    var param = {order_id: order_id};
                    $.post("<?php echo base_url('index.php/site/completedorder') ?>", param)
                            .done(function(data) {
                                data = jQuery.parseJSON(data);
                                if (data['status'] == '1')
                                {
                                    $("#button_complete").remove();
                                    swal("Completed order", "", "success");
                                    $("#order_view_h4").html('<span><img src="<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>" alt="img" class="img order_view_icon"></span> Completed');
                                    $("#order_id_<?php echo $orderlist[0]['order_id']; ?> img").attr('src', "<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>");

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
                document.querySelector('#button_complete').onclick = function() {
                    $("#button_complete").html('COMPlETE..');
                    var order_id = $("#order_id").val();
                    var param = {order_id: order_id};
                    $.post("<?php echo base_url('index.php/site/completedorder') ?>", param)
                            .done(function(data) {
                                data = jQuery.parseJSON(data);
                                if (data['status'] == '1')
                                {
                                    $("#button_complete").remove();
                                    swal("Completed order", "", "success");
                                    $("#order_view_h4").html('<span><img src="<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>" alt="img" class="img order_view_icon"></span> Completed');
                                    $("#order_id_<?php echo $orderlist[0]['order_id']; ?> img").attr('src', "<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>");
                                    
                                    setInterval(function() {
                                        $("#order_id_<?php echo $orderlist[0]['order_id']; ?>").remove();
                                    }, 2000)

                                } else {
                                    $("#button_complete").html();
                                    swal("Completed order", data['msg'], "error");
                                }
                            });
                };

            </script>



        <?php }
        ?>


    </div>

</div>