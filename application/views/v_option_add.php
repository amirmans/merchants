
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
            .modal-dialog {
                position: relative;
                width: auto;
                max-width: 600px;
                margin: 10px;
            }
            .modal-sm {
                max-width: 300px;
            }
            .modal-lg {
                max-width: 900px;
            }
            @media (min-width: 768px) {
                .modal-dialog {
                    margin: 30px auto;
                }
            }
            @media (min-width: 320px) {
                .modal-sm {
                    margin-right: auto;
                    margin-left: auto;
                }
            }
            @media (min-width: 620px) {
                .modal-dialog {
                    margin-right: auto;
                    margin-left: auto;
                }
                .modal-lg {
                    margin-right: 10px;
                    margin-left: 10px;
                }
            }
            @media (min-width: 920px) {
                .modal-lg {
                    margin-right: auto;
                    margin-left: auto;
                }
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
                                    Add Option
                                </div>
                                <div class="panel-body">
                                    <form id="product_option_form" class="form-horizontal"  method="post" action="<?php echo base_url('index.php/option/insert_option'); ?>" >
                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Product Option Category</label>
                                            <div class="col-sm-10">
                                                <select class="selectpicker" id="product_option_category" style="margin: 10px 24px;" onchange="change_order_status()" name="product_option_category_id"  >
                                                    <?php for ($i = 0; $i < count($product_option_category); $i++) {
                                                        ?>

                                                        <option value="<?php echo $product_option_category[$i]['product_option_category_id']; ?>"  ><?php echo $product_option_category[$i]['name']; ?></option>
                                                    <?php } ?>

                                                </select>
                                                <a href="#" class=" btn btn-primary" data-toggle="modal" data-target="#addoptioncategoryModal"  ><i class="fa fa-plus"></i>Add</a>
                                                <a href="#" class=" btn btn-primary" data-toggle="modal" data-target="#manageoptioncategoryModal"  ></i>Manage</a>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="name" name="name" required="" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Price</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="price" name="price" required="" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Description</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="short_description" name="description">
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

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="only_choose_one" class="col-sm-4 control-label form-label">Type</label>
                                        <div class="col-sm-8">
                                            <select class="selectpicker" id="only_choose_one"  name="only_choose_one"  >
                                                <option value="0">Multiple</option>
                                                <option value="1">One</option>

                                            </select>
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

        <div class="modal fade" id="updateoptioncategoryModal" tabindex="-1" role="dialog"  style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" id="form_edit_option_category" action="<?php echo base_url('index.php/product/edit_option_category'); ?>" method="post" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Update Option Category</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="edit_option_category_name" class="col-sm-4 control-label form-label">Option Category Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="edit_option_category_name" name="edit_option_category_name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="only_choose_one" class="col-sm-4 control-label form-label">Type</label>
                                        <div class="col-sm-8">
                                            <select class="selectpicker" id="edit_only_choose_one"  name="edit_only_choose_one"  >
                                                <option value="0">Multiple</option>
                                                <option value="1">One</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="edit_desc" class="col-sm-4 control-label form-label">Option Category Description</label>
                                        <div class="col-sm-8">
                                            <textarea  class="form-control" id="edit_desc" name="edit_desc"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="product_option_category_id" name="product_option_category_id" value="" >
                            <label id="edit_category_error_text" class="pull-left color10"></label>
                            <button type="button" class="btn btn-white" data-dismiss="modal" >Close</button>
                            <button type="submit" class="btn btn-default" >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="manageoptioncategoryModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Manage Option Category</h4>
                    </div>
                    <div class="modal-body">
                        <div class="panel panel-default">

                            <div class="panel-body table-responsive">

                                <table class="table table-striped table-bordered" id="option_category_table">
                                    <thead>
                                        <tr>
                                            <td>Option Category Name</td>
                                            <td>Type</td>
                                            <td>Option Category Description </td>
                                            <td>Edit</td>
                                            <td>Delete</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for ($i = 0; $i < count($product_option_category); $i++) {
                                            ?>
                                            <tr id="row_<?php echo $product_option_category[$i]['product_option_category_id']; ?>">
                                                <td id="categoryname_<?php echo $product_option_category[$i]['product_option_category_id']; ?>"><?php echo $product_option_category[$i]['name']; ?></td>
                                                <td id="only_choose_one_<?php echo $product_option_category[$i]['product_option_category_id']; ?>"><?php echo $product_option_category[$i]['only_choose_one']; ?></td>
                                                <td id="categorydesc_<?php echo $product_option_category[$i]['product_option_category_id']; ?>"><?php echo $product_option_category[$i]['desc']; ?></td>
                                                <td><a  class="btn btn-info add_product_btn" onclick="show_edit_category_modal(<?php echo $product_option_category[$i]['product_option_category_id']; ?>)"><i class="fa fa-edit"></i></a></td>
                                                <td><a  class="btn btn-danger add_product_btn" onclick="delete_option_category(<?php echo $product_option_category[$i]['product_option_category_id']; ?>)"><i class="fa fa-trash"></i></a></td></tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">


                    </div>

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
            $(document).ready(function () {
                // bind 'myForm' and provide a simple callback function 
                $('#form_product_option_category').ajaxForm(options);
                $('#form_edit_option_category').ajaxForm({success: processEditOptionCategoryResponse});

                $('#product_option_form').ajaxForm({
                    success: processAddProductOptionResponse
                });

            });

            function processAddOptionCategoryResponse(data) {

                var data = JSON.parse(data);
                console.log(data)
                if (data.product_option_category.status)
                {
                    var product_option_category_id = data.product_option_category.option_category.product_option_category_id;
                    var newOption = $('<option value="' + data.product_option_category.option_category.product_option_category_id + '">' + data.product_option_category.option_category.name + '</option>');
                    $('#product_option_category').append(newOption);

                    var row = '<tr id="row_' + product_option_category_id + '"><td id="categoryname_' + product_option_category_id + '">' + data.product_option_category.option_category.name + '</td>' +
                            '<td id="categorydesc_' + product_option_category_id + '">' + data.product_option_category.option_category.desc + '</td>' +
                            '<td><a class="btn btn-info add_product_btn" onclick="show_edit_category_modal(' + product_option_category_id + ')"><i class="fa fa-edit"></i>Edit</a></td>' +
                            '<td><a  class="btn btn-danger add_product_btn" onclick="delete_option_category(' + product_option_category_id + ')"><i class="fa fa-trash"></i>Delete</a></td><tr>';

                    $('#option_category_table').append(row)
                    $('#form_product_option_category').trigger("reset");
                    $('#category_error_text').html('');
                    $('#addoptioncategoryModal').modal('toggle');

                } else {
                    console.log(data.product_option_category.message)
                    $('#category_error_text').html(data.product_option_category.message);
                }
            }
            function processAddProductOptionResponse(data) {

                var data = JSON.parse(data);
                console.log(data)
                if (data.status)
                {
                    swal('', data.msg)
                    $('#product_option_form').trigger("reset");
                } else {
                    console.log(data.msg)
                    swal('', data.msg)
                }
            }
            function processEditOptionCategoryResponse(data) {

                var data = JSON.parse(data);
              //  console.log(data)
                if (data.product_option_category.status)
                {
                    var product_option_category_id = data.product_option_category.option_category.product_option_category_id;
                    $("#categoryname_" + product_option_category_id).text(data.product_option_category.option_category.name);
                    $("#categorydesc_" + product_option_category_id).text(data.product_option_category.option_category.desc);
                    $("#only_choose_one_" + product_option_category_id).text(data.product_option_category.option_category.only_choose_one);
                    $('#product_option_category option[value="' + product_option_category_id + '"]').text(data.product_option_category.option_category.name)
                    $('#form_edit_option_category').trigger("reset");
                    $('#edit_category_error_text').html('');
                    $('#updateoptioncategoryModal').modal('toggle');
                    $('#manageoptioncategoryModal').modal('show');

                } else {
                 //   console.log(data.product_option_category.message)
                    $('#edit_category_error_text').html(data.product_option_category.message);
                }
            }

            function show_edit_category_modal(product_option_category_id) {

                $("#edit_option_category_name").val($("#categoryname_" + product_option_category_id).text())
                $("#edit_desc").val($("#categorydesc_" + product_option_category_id).text());
                $("#edit_only_choose_one").val($("#only_choose_one_" + product_option_category_id).text())
                $("#product_option_category_id").val(product_option_category_id);

                $('#manageoptioncategoryModal').modal('toggle');
                $('#updateoptioncategoryModal').modal('show');
            }

            function delete_option_category(product_option_category_id) {

                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this product category!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plz!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        var param = {product_option_category_id: product_option_category_id}

                        $.post("<?php echo base_url('index.php/product/delete_option_category') ?>", param)
                                .done(function (data) {
                                    data = jQuery.parseJSON(data);
                                    if (data['option_category']['status'] == '1')
                                    {
                                        $('#product_option_category option[value="' + product_option_category_id + '"]').remove();
                                        $('#option_category_table #row_' + product_option_category_id).remove();
                                        swal("", data['option_category']['msg'], "success");
                                    } else {
                                        swal("", "Delete product category failed", "error");
                                    }
                                });
                    } else {
                        swal("Cancelled", "Your option category is safe :)", "error");
                    }
                });
            }

            $('#updateoptioncategoryModal').on('hidden.bs.modal', function () {
                $('#manageoptioncategoryModal').modal('show');
            })

        </script>








    </body>
</html>