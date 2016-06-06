
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
            .add_product_btn{
                float: right;
                color: white !important;
            } 
        </style>

    </head>
    <body>
        <?php $this->load->view('v_header'); ?>


        <div class="content">
            <div class="container-mail">
                <div class="mailbox clearfix">
                    <div class="container-mailbox">



                        <div class="col-md-12">
                            <div class="panel panel-default">

                                <div class="panel-title">
                                    Prodcuts
                                    <a href="<?php echo base_url('index.php/product/add'); ?>" class="btn btn-primary add_product_btn"><i class="fa fa-plus"></i>Add</a>
                                </div>


                                <div class="panel-body table-responsive">

                                    <table class="table table-striped table-bordered ">
                                        <thead>
                                            <tr>
                                                <td>product ID</td>
                                                <td>Name</td>
                                                <td>Price</td>
                                                <td>Short information</td>
                                                <td>Availability Status</td>
                                                <td>Add</td>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i = 0; $i < count($products); $i++) {
                                                ?>
                                                <tr>
                                                    <td># <b><?php echo $products[$i]['product_id']; ?></b></td>
                                                    <td><?php echo $products[$i]['name']; ?></td>
                                                    <td>$ <?php echo $products[$i]['price']; ?></td>
                                                    <td><?php echo $products[$i]['short_description']; ?></td>
                                                    <td>
                                                        <?php
                                                            $checked='';
                                                            if($products[$i]['availability_status']==1)
                                                            {
                                                                $checked='checked';
                                                            }
                                                        ?>
                                                        <div class="col-sm-8">
                                                            <input type="checkbox"  data-toggle="toggle" data-onstyle="success" id="availability_status_<?php echo $products[$i]['product_id']; ?>" onchange="set_availailblity_status(<?php echo $products[$i]['product_id']; ?>)" <?php echo $checked;?> >
                                                        </div>

                                                    </td>
                                                    <td><a href="<?php echo base_url('index.php/product/options/' . $products[$i]['product_id']); ?>" class="btn btn-info add_product_btn"><i class="fa fa-eye"></i>View</a></td>

                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <?php $this->load->view('v_footer'); ?>

        </div>




        <?php $this->load->view('v_script'); ?>


        <script>
            window.history.forward(-1);
            $("#product_tab").addClass('active_tab');

            function set_availailblity_status(product_id) {
                var availability_status = $('#availability_status_' + product_id).prop('checked');
                var param = {availability_status: availability_status,product_id:product_id};
                $.post("<?php echo base_url('index.php/product/set_availailblity_status') ?>", param)
                        .done(function(data) {
                            data = jQuery.parseJSON(data);

                            if (data['status'] == '1')
                            {
                                swal("", data['msg'], "success");
                            }
                        });
            }
        </script>








    </body>
</html>