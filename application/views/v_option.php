
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
                                    Option
                                    <a href="<?php echo base_url('index.php/option/add'); ?>" class="btn btn-primary add_product_btn"><i class="fa fa-plus"></i>Add</a>
                                </div>


                                <div class="panel-body table-responsive">

                                    <table class="table table-striped table-bordered ">
                                        <thead>
                                            <tr>
                                                <td>Option ID</td>
                                                <td>Name</td>
                                                <td>Price</td>
                                                <td>Description</td>
                                                <!--<td>Add</td>-->

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i = 0; $i < count($options); $i++) {
                                                ?>
                                                <tr>
                                                    <td># <b><?php echo $options[$i]['option_id']; ?></b></td>
                                                    <td><?php echo $options[$i]['name']; ?></td>
                                                    <td>$ <?php echo $options[$i]['price']; ?></td>
                                                    <td><?php echo $options[$i]['description']; ?></td>
                                                    <!--<td><a href="<?php // echo base_url('index.php/product/options/' . $products[$i]['product_id']); ?>" class="btn btn-info add_product_btn"><i class="fa fa-eye"></i>View</a></td>-->

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
            $("#option_tab").addClass('active_tab');
        </script>








    </body>
</html>