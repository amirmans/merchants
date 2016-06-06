
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="keywords" content="" />
        <title>Tap In </title>
        <?php $this->load->view('v_head'); ?>
        <style>
            a.logout_btn{
                color: black;
                border: 1px solid black;
                padding: 5px;
            }
            a.menu_btn{
                color: black;
                border: 1px solid black;
                padding: 5px;  
            }

            .th_price{
                width:65px;
            }
            .th_quantity{
                width: 30px;
                text-align: center;
            }
            .th_total
            {
                width: 100px;
            }
            .product_description{
                width: 92%;
            }
            .total_price{
                width: 200px;
            }
            .order_view_icon{
                background: grey;
                border-radius: 33px;
                width: 28px;
                border: 2px solid gray;

            }
            .note{
                color: #FD7D6F;
                font-size: 15px;

            }
            .pending_order_color{
                background: #FF7C7C;
            }
            .pending_order_img{
                width: 40px;
                height: 40px;
                border-radius: 999px;
                float: left;
                margin-right: 10px;
                border: 2px solid #FF7C7C;
                background: #FF7C7C;
            }
            .alert6-light{
                background: #FF9898;
            }
            .invoice .invoicename{
                top:90px;
            }


        </style>
    </head>
    <body>
        <?php $this->load->view('v_header'); ?>

        <form id="new_order_form" name="new_order_form" action="<?php echo base_url(); ?>index.php/site/get_new_orders" method="post">

            <input type="hidden" name="latest_order_id" id="latest_order_id" value="<?php
            if (count($orderlist)) {
                echo $orderlist[0]['order_id'];
            } else {
                echo '0';
            }
            ?>" />
        </form>
        <div class="content">
            <div class="container-mail">
                <div class="mailbox clearfix">
                    <div class="container-mailbox">

                        <div class="col-lg-3 col-md-4 padding-0">
                            <div class="row order-menu">

                                <div class="col-md-2"><span class="order_text"><h5>&nbsp;&nbsp;&nbsp;ORDERS</h5></span></div> 
                                <div class="col-md-10 text-right">

                                    <select class="selectpicker" id="order_status" style="margin: 10px 24px;" onchange="change_order_status()" >
                                        <option value="neworder"  >New Order</option>
                                        <option value="completed" selected >Completed</option>
                                    </select>

                                </div> 
                            </div>
                            <ul class="order-list" id="ui_orderlist">

                                <?php for ($i = 0; $i < count($orderlist); $i++) {
                                    ?>
                                    <li onclick="display_order_detail('<?php echo $orderlist[$i]['order_id']; ?>')" class="<?php
                                    if ($orderlist[$i]['status'] == "1") {
                                        echo 'pending_order_color';
                                    }
                                    ?>" id="li_order_id_<?php echo $orderlist[$i]['order_id']; ?>">
                                        <a href="javascript:void(0)"  id="order_id_<?php echo $orderlist[$i]['order_id']; ?>"  class="item clearfix <?php
                                        if ($i == 0) {
                                            echo 'active_detail_order';
                                        }
                                        ?>" >

                                            <?php if ($orderlist[$i]['status'] == "1") {
                                                ?>
                                                <img src="<?php echo base_url('assets/img/ic_error@3x.png'); ?>" alt="img" class="pending_order_img" >
                                            <?php } elseif ($orderlist[$i]['status'] == "2") {
                                                ?>
                                                <img src="<?php echo base_url('assets/img/ic_reload@3x.png'); ?>" alt="img" class="img">

                                            <?php } elseif ($orderlist[$i]['status'] == "3") {
                                                ?>
                                                <img src="<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>" alt="img" class="img">
                                                <?php
                                            }
                                            ?>

                                            <span class="from">#<?php echo $orderlist[$i]['order_id']; ?></span>
                                            <span class="from" ><?php echo $orderlist[$i]['nickname']; ?></span>
                                            <span class="date"><?php echo $orderlist[$i]['no_items']; ?> items</span>
                                            <span class="time"><?php echo time_elapsed_string($orderlist[$i]['date']); ?></span>
                                        </a>
                                    </li>
                                <?php } ?>


                            </ul>
                        </div>

                        <div class="chat col-lg-9 col-md-8 padding-0 order-detail_view" id="order_view" >
                            <?php echo $order_view; ?>
                        </div>

                    </div>

                </div>

            </div>
            <?php $this->load->view('v_footer'); ?>

        </div>

        <div id="alertbottom" class="kode-alert kode-alert-icon alert7 kode-alert-top-right" style="z-index: 99;" >

            <i class="fa fa-info"></i>
            <a href="#" class="closed">×</a>
            <h4>You have a new <span id="count_new_order"></span> Order!</h4>
        </div>

        <div id="alertPendingOrder" class="kode-alert kode-alert-icon  kode-alert-top-right alert6-light" style="z-index: 99;" >

            <i class="fa fa-info"></i>
            <a href="#" class="closed">×</a>
            <h4>You have new <span id="count_pending_order"></span> orders remaining for approval!</h4>
        </div>



        <?php $this->load->view('v_script'); ?>


        <script>
            window.history.forward(-1);
            function display_order_detail(order_id)
            {
                var param = {order_id: order_id};
                $.post("<?php echo base_url('index.php/site/order_view') ?>", param)
                        .done(function (data) {
                            data = jQuery.parseJSON(data);
                            $("#order_view").html(data['order_view']);

                            $(".active_detail_order").removeClass("active_detail_order");
                            $("#order_id_" + order_id).addClass("active_detail_order")

                        });
            }

            function change_order_status()
            {
                var order_status = $("#order_status").val();
                if (order_status == "completed")
                {
                    window.location = "<?php echo base_url('index.php/site/orderlist/completed'); ?>";
                } else {
                    window.location = "<?php echo base_url('index.php/site/orderlist'); ?>";
                }
            }

            $("#order_status").val('<?php echo $order_status; ?>')
            $("#orderlist_tab").addClass('active_tab');

            var interval = 60000; // where X is your every X minutes
            interval_1 = setInterval(get_new_orders, interval);

            function get_new_orders()
            {
                $("#new_order_form").submit();
            }
            $(document).ready(function () {
                // bind 'myForm' and provide a simple callback function 
                $('#new_order_form').ajaxForm({
                    success: displayneworder
                });
            });

            function displayneworder(data)
            {
                var data = JSON.parse(data);

                if (data['status'] == 1)
                {

                    $("#ui_orderlist").prepend(data['new_orderlist']);
                    $("#latest_order_id").val(data['latest_order_id']);
                    $("#count_new_order").html(data['count_new_order']);
                    $("#alertbottom").show();
                }


            }
            interval_2 = setInterval(get_remaining_approval_order, 60000)
            function get_remaining_approval_order()
            {
                var parm
                $.get("<?php echo base_url('index.php/site/count_order_for_remaining_approve') ?>")
                        .done(function (data) {
                            data = jQuery.parseJSON(data);
                            if (data)
                            {

                                $("#count_pending_order").html(data);
                                $("#alertPendingOrder").show();

                            }
                        });

            }

            $(document).ready(function () {
                $('.order-list li ').dblclick(function () {
                    setTimeout(function () {
                        $('.invoice').focus();
                    }, 1000);

                });
            });
        </script>








    </body>
</html>