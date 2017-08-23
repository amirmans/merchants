
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
            .delete_product_btn{
                float: right;
                color: white !important;
            }
            #image {
                display: inline-block;
                float: left;
                width: 100px;
                height: 150px;
                position: relative;
            }
            .del_picture {
                position: absolute;
                bottom: 40px;
                left: 150px;
                top: -13px;
            }
            .fa-item{

                border-radius: 0px; 
                border: 0px solid #fff; 
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
                                    Edit Product
                                    <a  class="btn btn-danger delete_product_btn" onclick="delete_product('<?php echo $product['product_id']; ?>')"><i class="fa fa-trash"></i>Delete Product</a>
                                </div>

                                <div class="panel-body">
                                    <form id="product_form" class="form-horizontal"  method="post" action="<?php echo base_url('index.php/product/update'); ?>"  enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">Product Category</label>
                                            <div class="col-sm-10">
                                                <select class="selectpicker" id="product_category_id" style="margin: 10px 24px;" name="product_category_id" >
                                                    <?php
                                                    for ($i = 0; $i < count($product_category); $i++) {

                                                        if ($product_category[$i]['table_id'] == $product['product_category_id']) {
                                                            ?>
                                                            <option value="<?php echo $product_category[$i]['product_category_id']; ?>"  selected="selected" ><?php echo $product_category[$i]['category_name']; ?></option>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <option value="<?php echo $product_category[$i]['product_category_id']; ?>"  ><?php echo $product_category[$i]['category_name']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                                <a href="#" class=" btn btn-primary" data-toggle="modal" data-target="#addcategoryModal"  ><i class="fa fa-plus"></i>Add</a>
                                                <a href="#" class=" btn btn-primary" data-toggle="modal" data-target="#managecategoryModal"  ></i>Manage</a>

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
                                            <!--                                            <div class="col-sm-10">
                                            
                                            
                                                                                            <input type="file" class="form-control" id="pictures" name="pictures">
                                                                                         
                                                                                        </div>-->
                                            <div class="col-sm-10" id="imgArea">
                                                <?php if ($product['pictures'] != '') {
                                                    ?>
                                                    <img height="150" width="100" id="image" src="../../../../<?php echo staging_directory(); ?>/customer_files/<?php echo $this->session->userdata('businessID'); ?>/products/<?php echo $product['pictures']; ?>">
                                                    <div id="imgChange"><span>Change Picture</span>
                                                        <input type="file" accept="image/*" name="pictures" id="pictures">
                                                    </div>
                                                    <a href="#" class="del_picture " id="del_picture"><i class="fa fa-times-circle" style="font-size: 20px;" onclick="delete_picture()"></i></a>

                                                <?php } else {
                                                    ?>  
                                                    <img height="150" width="100" id="image" src="">
                                                    <div id="imgChange"><span>Add Picture</span>
                                                        <input type="file" accept="image/*" name="pictures" id="pictures">
                                                    </div>
                                                    <a style="display:  none" href="#" class="del_picture " id="del_picture"><i class="fa fa-times-circle" style="font-size: 20px;" onclick="delete_picture()"></i></a>
                                                    <?php
                                                }
                                                ?>
                                                <input type="hidden" class="form-control" id="is_picture_deleted" name="is_picture_deleted" value="0">

                                                <input type="hidden" class="form-control" id="old_pictures" name="old_pictures" value="<?php echo $product['pictures']; ?>">
                                                <input type="hidden" class="form-control" id="product_id" name="product_id" value="<?php echo $product['product_id']; ?>">

                                                <br>
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
        <div class="modal fade" id="updatecategoryModal" tabindex="-1" role="dialog"  style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" id="form_edit_product_category" action="<?php echo base_url('index.php/product/update_category'); ?>" method="post" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Update Product Category</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="edit_category_name" class="col-sm-4 control-label form-label">Category Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="edit_category_name" name="edit_category_name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="edit_category_desc" class="col-sm-4 control-label form-label">Category Description</label>
                                        <div class="col-sm-8">
                                            <textarea  class="form-control" id="edit_category_desc" name="edit_desc"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="table_id" name="table_id" value="" >
                            <label id="edit_category_error_text" class="pull-left color10"></label>
                            <button type="button" class="btn btn-white" data-dismiss="modal" >Close</button>
                            <button type="submit" class="btn btn-default" >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="managecategoryModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Manage Category</h4>
                    </div>
                    <div class="modal-body">
                        <div class="panel panel-default">

                            <div class="panel-body table-responsive">

                                <table class="table table-striped table-bordered" id="product_category_table">
                                    <thead>
                                        <tr>
                                            <td>Category Name</td>
                                            <td>Category Description </td>
                                            <td>Edit</td>
                                            <td>Delete</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for ($i = 0; $i < count($product_category); $i++) {
                                            ?>
                                            <tr id="row_<?php echo $product_category[$i]['product_category_id']; ?>">
                                                <td id="categoryname_<?php echo $product_category[$i]['product_category_id']; ?>"><?php echo $product_category[$i]['category_name']; ?></td>
                                                <td id="categorydesc_<?php echo $product_category[$i]['product_category_id']; ?>"><?php echo $product_category[$i]['desc']; ?></td>
                                                <td><a  class="btn btn-info add_product_btn" onclick="show_edit_category_modal(<?php echo $product_category[$i]['product_category_id']; ?>)"><i class="fa fa-edit"></i>Edit</a></td>
                                                <td><a  class="btn btn-danger add_product_btn" onclick="delete_product_category(<?php echo $product_category[$i]['product_category_id']; ?>)"><i class="fa fa-trash"></i>Delete</a></td>                                            </tr>
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

            document.getElementById("pictures").onchange = function () {
                var reader = new FileReader();

                reader.onload = function (e) {
                    // get loaded data and render thumbnail.
                    document.getElementById("image").src = e.target.result;
                    $("#del_picture").show();
                    $("#is_picture_deleted").val('0');
                    $("#imgChange span").text('Change Picture');

                };
                // read the image file as a data URL.
                reader.readAsDataURL(this.files[0]);
            };

            var options = {
                success: processAddCategoryResponse
            }

            window.history.forward(-1);
            $("#product_tab").addClass('active_tab');
            $(document).ready(function () {
                // bind 'myForm' and provide a simple callback function 
                $('#form_product_category').ajaxForm(options);

                $('#form_edit_product_category').ajaxForm({success: processEditCategoryResponse});
            });

            function processAddCategoryResponse(data) {

                var data = JSON.parse(data);
         
                if (data.product_category.status)
                {

                    var tableid = data.product_category.category.product_category_id;
                    var newOption = $('<option value="' + data.product_category.category.table_id + '">' + data.product_category.category.category_name + '</option>');
                    $('#product_category_id').append(newOption);
                    var row = '<tr id="row_' + tableid + '"><td id="categoryname_' + tableid + '">' + data.product_category.category.category_name + '</td>' +
                            '<td id="categorydesc_' + tableid + '">' + data.product_category.category.desc + '</td>' +
                            '<td><a class="btn btn-info add_product_btn" onclick="show_edit_category_modal(' + tableid + ')"><i class="fa fa-edit"></i>Edit</a></td>' +
                            '<td><a href="" class="btn btn-danger add_product_btn" onclick="delete_product_category(' + tableid + ')"><i class="fa fa-trash"></i>Delete</a></td><tr>';

                    $('#product_category_table').append(row)
                    $('#form_product_category').trigger("reset");
                    $('#category_error_text').html('');
                    $('#addcategoryModal').modal('toggle');

                } else {
                    console.log(data.product_category.message)
                    $('#category_error_text').html(data.product_category.message);
                }
            }
            function processEditCategoryResponse(data) {

                var data = JSON.parse(data);
                console.log(data)
                if (data.product_category.status)
                {
                    var tableid = data.product_category.category.product_category_id;
                    $("#categoryname_" + tableid).text(data.product_category.category.category_name)
                    $("#categorydesc_" + tableid).text(data.product_category.category.desc)
                    $('#product_category_id option[value="' + tableid + '"]').text(data.product_category.category.category_name)
                    $('#form_edit_product_category').trigger("reset");
                    $('#edit_category_error_text').html('');
                    $('#updatecategoryModal').modal('toggle');
                    $('#managecategoryModal').modal('show');

                } else {
                    console.log(data.product_category.message)
                    $('#edit_category_error_text').html(data.product_category.message);
                }
            }

            function delete_product(product_id)
            {
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this product!",
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
                                location.href = '<?php echo base_url('index.php/product/delete/'); ?>/' + product_id
                            } else {
                                swal("Cancelled", "Your product is safe :)", "error");
                            }
                        });
            }
            function delete_picture()
            {
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this picture!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete picture!",
                    cancelButtonText: "No, cancel plz!",
                    closeOnConfirm: true,
                    closeOnCancel: false
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                document.getElementById("image").src = "";
                                $("#del_picture").hide();
                                $("#is_picture_deleted").val('1');
                                $("#pictures").val('');
                                $("#imgChange span").text('Add Picture');


                            } else {
                                swal("Cancelled", "Your product is safe :)", "error");
                            }
                        });
            }

            function show_edit_category_modal(tableid) {

                $("#edit_category_name").val($("#categoryname_" + tableid).text())
                $("#edit_category_desc").val($("#categorydesc_" + tableid).text())
                $("#table_id").val(tableid)
                $('#managecategoryModal').modal('toggle');
                $('#updatecategoryModal').modal('show');
            }

            function delete_product_category(tableid) {
                console.log(tableid)

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
                                var param = {table_id: tableid}
                                console.log(param)

                                $.post("<?php echo base_url('index.php/product/delete_category') ?>", param)
                                        .done(function (data) {
                                            data = jQuery.parseJSON(data);
                                            if (data['product_category']['status'] == '1')
                                            {
                                                $('#product_category_id option[value="' + tableid + '"]').remove();
                                                $('#product_category_table #row_' + tableid).remove();
                                                swal("", data['product_category']['msg'], "success");
                                            } else {
                                                swal("", "Delete product category failed", "error");
                                            }
                                        });
                            } else {
                                swal("Cancelled", "Your product category is safe :)", "error");
                            }
                        });
            }

            $('#updatecategoryModal').on('hidden.bs.modal', function () {
                $('#managecategoryModal').modal('show');
            })

        </script>








    </body>
</html>