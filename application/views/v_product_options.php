
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
                                    Prodcuts Options
                                    <a href="javacript:void(0)" class="btn btn-success add_product_btn" onclick="save(<?php echo $product_id; ?>)"><i class="fa fa-save"></i>Save</a>
                                </div>


                                <div class="panel-body table-responsive">

                                    <table class="table table-striped table-bordered ">
                                        <thead>
                                            <tr>
                                                <td></td>
                                                <td>Option ID</td>
                                                <td>Name</td>
                                                <td>Price</td>
                                                <td>Description</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i = 0; $i < count($options); $i++) {
                                                ?>
                                                <tr>
                                                    <td><div class="checkbox">
                                                            <?php
                                                            if ($options[$i]['is_add'] == 1) {
                                                                ?>
                                                                <input id="option_<?php echo $options[$i]['option_id']; ?>" type="checkbox" name="chk" checked>

                                                                <?php
                                                            } else {
                                                                ?>
                                                                <input id="option_<?php echo $options[$i]['option_id']; ?>" type="checkbox" name="chk">
                                                                <?php
                                                            }
                                                            ?>
                                                            <label for="option_<?php echo $options[$i]['option_id']; ?>">
                                                            </label>
                                                        </div></td>
                                                    <td># <b><?php echo $options[$i]['option_id']; ?></b></td>
                                                    <td><?php echo $options[$i]['name']; ?></td>
                                                    <td>$ <?php echo $options[$i]['price']; ?></td>
                                                    <td><?php echo $options[$i]['description']; ?></td>
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

            function save(product_id) {
                var uncheckedOptionId = [];
                $("input:checkbox:not(:checked)").each(function() {
                    var id = $(this).attr("id").split('_');
                    uncheckedOptionId.push(id[1])
                });
                uncheckedOptionId = uncheckedOptionId.join();
                var checkedOptionId = [];
                $("input:checkbox[name=chk]:checked").each(function() {
                    var id = $(this).attr("id").split('_');
                    checkedOptionId.push(id[1])
                });
                checkedOptionId = checkedOptionId.join();
                var param={checked:checkedOptionId,unchecked:uncheckedOptionId,product_id:product_id}
                console.log(param)
                
                $.post("<?php echo base_url('index.php/product/insert_product_options') ?>", param)
                        .done(function(data) {
                            data = jQuery.parseJSON(data);
                            if (data['status'] == '1')
                            {
                                
                                swal("", data['msg'], "success");
                            } else {
                                
                                swal("",data['msg'], "error");
                            }
                        });


            }

        </script>








    </body>
</html>