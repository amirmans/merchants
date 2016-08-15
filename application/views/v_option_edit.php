
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
            .back-button{
                color: white !important; 
            }
            
            .delete_product_btn{
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

                        <div class="col-md-12  padding-0">
                            <div class="panel panel-default">

                                <div class="panel-title">
                                    Edit Option
                                    <a  class="btn btn-danger delete_product_btn" onclick="delete_option('<?php echo $option['option_id']; ?>')"><i class="fa fa-trash"></i>Delete Option</a>
                                </div>
                                <div class="panel-body">
                                    <form id="edit_product_option_form" class="form-horizontal"  method="post" action="<?php echo base_url('index.php/option/edit_option'); ?>" >
                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Product Option Category</label>
                                            <div class="col-sm-10">
                                                <select class="selectpicker" id="product_option_category" style="margin: 10px 24px;" onchange="change_order_status()" name="product_option_category_id"  >
                                                    <?php
                                                    for ($i = 0; $i < count($product_option_category); $i++) {
                                                        if ($product_option_category[$i]['product_option_category_id'] == $option['product_option_category_id']) {
                                                            ?>
                                                            <option value="<?php echo $product_option_category[$i]['product_option_category_id']; ?>" selected ><?php echo $product_option_category[$i]['name']; ?></option>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <option value="<?php echo $product_option_category[$i]['product_option_category_id']; ?>"  ><?php echo $product_option_category[$i]['name']; ?></option>
                                                            <?php
                                                        }
                                                        ?>

                                                    <?php } ?>

                                                </select>
                                                <a href="#" class=" btn btn-primary" data-toggle="modal" data-target="#addoptioncategoryModal"  ><i class="fa fa-plus"></i>Add</a>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="name" name="name" required="" value="<?php echo $option['name']; ?>" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Price</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="price" name="price" required=""  value="<?php echo $option['price']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Description</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="short_description" name="description" value="<?php echo $option['description']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="hidden" class="form-control" id="option_id" name="option_id" value="<?php echo $option['option_id']; ?>">
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

        <div class="modal fade" id="addoptioncategoryModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" id="form_product_option_category" action="<?php echo base_url('index.php/product/add_option_category'); ?>" method="post" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Add product option category</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="category_name" class="col-sm-4 control-label form-label">Option Category Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="category_name" name="option_category_name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="category_desc" class="col-sm-4 control-label form-label">Option Category Description</label>
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
                success: processAddOptionCategoryResponse
            }

            window.history.forward(-1);
            $("#option_tab").addClass('active_tab');
            $(document).ready(function() {
                // bind 'myForm' and provide a simple callback function 
                $('#form_product_option_category').ajaxForm(options);

            });

            function processAddOptionCategoryResponse(data) {

                var data = JSON.parse(data);
                
                if (data.product_option_category.status)
                {
                    var newOption = $('<option value="' + data.product_option_category.option_category.product_option_category_id + '">' + data.product_option_category.option_category.name + '</option>');
                    $('#product_option_category').append(newOption);
                    $('#form_product_option_category').trigger("reset");
                    $('#category_error_text').html('');
                    $('#addoptioncategoryModal').modal('toggle');

                } else {
                    console.log(data.product_option_category.message)
                    $('#category_error_text').html(data.product_option_category.message);
                }
            }
            
            function delete_option(option_id)
            {
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this option!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plz!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        location.href='<?php echo base_url('index.php/option/delete/'); ?>/'+option_id
                    } else {
                        swal("Cancelled", "Your option is safe :)", "error");
                    }
                });
            }
            
        </script>








    </body>
</html>