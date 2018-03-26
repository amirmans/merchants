
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

    </head>
    <body>

        <div class="loading"><img src="<?php echo base_url('assets/img/loading.gif'); ?>" alt="loading-img"></div>
        <div class="content">
            <div class="container-mail">
                <div class="mailbox clearfix">
                    <div class="container-mailbox">

                        <div class="col-md-12">
                            <h4>Quick Menu</h4>

                            <!-- Start Quick Menu -->
                            <ul class="panel quick-menu clearfix">
                                <li class="col-sm-2">
                                    <a href="<?php echo base_url('index.php/site/orderlist'); ?>"><i class="fa fa-life-ring"></i>Order</a>
                                </li>
                           
                                <li class="col-sm-2">
                                    <a href="<?php echo base_url('index.php/product'); ?>"><i class="fa fa-cogs"></i>Product</a>
                                </li>
                              
                            </ul>
                            <!-- End Quick Menu -->

                        </div>



                    </div>

                </div>

            </div>
            <?php $this->load->view('v_footer'); ?>

        </div>




        <?php $this->load->view('v_script'); ?>


        <script>
            window.history.forward(-1);
            function display_order_detail(order_id, order_type)
            {
                var param = {order_id: order_id, order_type:order_type};
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
        </script>








    </body>
</html>