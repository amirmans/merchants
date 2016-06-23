
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
        <?php $this->load->view('v_header'); ?>


        <div class="content">
            <div class="container-mail">
                <div class="mailbox clearfix">
                    <div class="container-mailbox">



                        <div class="col-md-12  padding-0">
                            <div class="panel panel-default">

                                <div class="panel-title">
                                    Edit Product

                                </div>

                                <div class="panel-body">
                                    <form id="product_form" class="form-horizontal"  method="post" action="<?php echo base_url('index.php/product/update'); ?>"  enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Product Category</label>
                                            <div class="col-sm-10">
                                                <select class="selectpicker" id="order_status" style="margin: 10px 24px;" onchange="change_order_status()" name="product_category_id" >
                                                    <?php
                                                    for ($i = 0; $i < count($product_category); $i++) {

                                                        if ($product_category[$i]['table_id'] == $product['product_category_id']) {
                                                            ?>
                                                            <option value="<?php echo $product_category[$i]['table_id']; ?>"  selected><?php echo $product_category[$i]['category_name']; ?></option>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <option value="<?php echo $product_category[$i]['table_id']; ?>"  ><?php echo $product_category[$i]['category_name']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                                <a href="#" class=" btn btn-primary" data-toggle="modal" data-target="#addcategoryModal"  ><i class="fa fa-plus"></i>Add</a>


                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="name" name="name" required="" value="<?php echo $product['name']; ?>">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">SKU</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="SKU" name="SKU" value="<?php echo $product['SKU']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Short Description</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="short_description" name="short_description" value="<?php echo $product['short_description']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Long Description</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="long_description" name="long_description" value="<?php echo $product['long_description']; ?>">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Price</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="price" name="price" required="" value="<?php echo $product['price']; ?>">
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Detail Information</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="detail_information" name="detail_information" value="<?php echo $product['detail_information']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Runtime Filed</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="runtime_fields" name="runtime_fields"  value="<?php echo $product['runtime_fields']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Runtime Filed Detail</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="input002"  id="runtime_fields_detail" name="runtime_fields_detail"  value="<?php echo $product['runtime_fields_detail']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Sales price</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="sales_price" name="sales_price"  value="<?php echo $product['sales_price']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Has options</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="has_option" name="has_option" value="<?php echo $product['has_option']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Bought with rewards</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="bought_with_rewards" name="bought_with_rewards"  value="<?php echo $product['bought_with_rewards']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">More Information</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="more_information" name="more_information" value="<?php echo $product['more_information']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Product Image</label>
                                            <div class="col-sm-10">
                                                <?php if ($product['pictures'] != '') {
                                                    ?>
                                                    <label for="" class="control-label form-label"><?php echo $product['pictures']; ?></label>
                                                <?php }
                                                ?>

                                                <input type="file" class="form-control" id="pictures" name="pictures">
                                                <input type="hidden" class="form-control" id="old_pictures" name="old_pictures" value="<?php echo $product['pictures']; ?>">
                                                <input type="hidden" class="form-control" id="product_id" name="product_id" value="<?php echo $product['product_id']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-default">Submit</button>
                                            </div>
                                        </div>

                                    </form> 

                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <?php $this->load->view('v_footer'); ?>

        </div>

        <div class="modal fade" id="addcategoryModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" id="form_product_category" action="<?php echo base_url('index.php/product/add_category'); ?>" method="post" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Add Product Category</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="category_name" class="col-sm-4 control-label form-label">Category Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="category_name" name="category_name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="category_desc" class="col-sm-4 control-label form-label">Category Description</label>
                                        <div class="col-sm-8">
                                            <textarea  class="form-control" id="category_desc" name="desc"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">

                            <label id="category_error_text" class="pull-left color10"></label>
                            <button type="button" class="btn btn-white" data-dismiss="modal" >Close</button>
                            <button type="submit" class="btn btn-default" >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




        <?php $this->load->view('v_script'); ?>


        <script>

            var options = {
                success: processAddCategoryResponse
            }

            window.history.forward(-1);
            $("#product_tab").addClass('active_tab');
            $(document).ready(function() {
                // bind 'myForm' and provide a simple callback function 
                $('#form_product_category').ajaxForm(options);


            });

            function processAddCategoryResponse(data) {

                var data = JSON.parse(data);
                console.log(data)
                if (data.product_category.status)
                {
                    var newOption = $('<option value="' + data.product_category.category.table_id + '">' + data.product_category.category.category_name + '</option>');
                    $('#order_status').append(newOption);
                    $('#form_product_category').trigger("reset");
                    $('#category_error_text').html('');
                    $('#addcategoryModal').modal('toggle');

                } else {
                    console.log(data.product_category.message)
                    $('#category_error_text').html(data.product_category.message);
                }
            }

        </script>








    </body>
</html>