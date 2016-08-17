
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
            .edit_icon {
                right: 0px; 
            }
        </style>
    </head>
    <body>
        <?php $this->load->view('v_header');
        ?>


        <div class="content">
            <a  class="btn btn-primary" onclick="show_add_image_modal()"><i class="fa fa-plus"></i>Add Picture</a>
            <!--<pre>-->
            <?php // print_r($picutres);
            ?>
            <!--</pre>-->
            <!--            <div class="container-mailbox">
            
                             Start Invoice 
                            <div class="invoice row" style="min-height: 870px">
                                <div class="invoicename">Business Images</div>
                                
                                
                            </div>
                             End Invoice 
                        </div>-->
            <br>
            <br>

            <div class="row">
                <?php
                foreach ($picutres as $p) {
                    ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-body status">
                                <div class="image">
                                    <img id="icon_url" src="../../../<?php echo staging_directory(); ?>/customer_files/<?php echo $this->session->userdata('businessID'); ?>/<?php echo $p; ?>" alt="logo"  ><br>
                                    <!--<img id="icon_url" src="../../<?php // echo staging_directory();                    ?>/customer_files/1/koi.jpg" alt="logo" width="150" ><br>-->
                                </div>
                                <ul class="links">
                                    <li><a href="#" class="" onclick="show_replace_image_modal('<?php echo $p; ?>')" ><i class="fa fa-edit"></i>Replace</a></li>
                                    <li><a href="#" class="" onclick="delete_image('<?php echo $p; ?>')" ><i class="fa fa-trash"></i>Delete</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <?php
                }
                ?>
                <!-- Start Chart -->

            </div>
            <?php $this->load->view('v_footer'); ?>
        </div>

        <div class="modal fade" id="replaceImageModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" id="replace_image_form" action="<?php echo base_url('index.php/profile/replace_business_image'); ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Replace Business Picture</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label form-label">Replace Picture:</label>
                                        <div class="col-sm-8" >
                                            <input type="file" name="picture1" class="form-control" id="picture1" onchange="validate_image('picture1')">
                                            <input type="hidden" name="file_name"  id="replace_picture">
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <label id="category_error_text" class="pull-left color10"></label>
                            <button type="button" class="btn btn-white" data-dismiss="modal" >Close</button>
                            <button type="submit" class="btn btn-default" onclick="return validate_form1()" >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addImageModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" id="add_image_form" action="<?php echo base_url('index.php/profile/insert_business_image'); ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Add Business Picture</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label form-label">Picture:</label>
                                        <div class="col-sm-8" >
                                            <input type="file" name="picture" class="form-control" id="picture" onchange="validate_image('picture')">
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <label id="category_error_text" class="pull-left color10"></label>
                            <button type="button" class="btn btn-white" data-dismiss="modal" >Close</button>
                            <button type="submit" class="btn btn-default" onclick="return validate_form()" >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php $this->load->view('v_script'); ?>
        <script>
            window.history.forward(-1);

            $(document).ready(function () {
                $('#add_image_form').ajaxForm({
                    success: processAddImageResponse
                });
                $('#replace_image_form').ajaxForm({
                    success: processreplcaeImageResponse
                });
            });
            function show_add_image_modal()
            {
                $('#addImageModal').modal('show');
            }
            function show_replace_image_modal(filename)
            {

                $('#replace_picture').val(filename);
                $('#replaceImageModal').modal('show');
            }
            function processAddImageResponse(data)
            {
                var data = JSON.parse(data);
                if (data.status)
                {
                    $('#editProfileModal').modal('toggle');
                    swal('', "Profile updated successfully", 'success')
                    location.reload();

                } else {
                    $('#addImageModal').modal('toggle');
                    swal('', "Profile updated unsuccessfully", 'error')
                }
            }

            function processreplcaeImageResponse(data)
            {
                var data = JSON.parse(data);
                if (data.status)
                {
                    $('#editProfileModal').modal('toggle');
                    swal('', "Profile updated successfully", 'success')
                    location.reload();

                } else {
                    $('#addImageModal').modal('toggle');
                    swal('', "Profile updated unsuccessfully", 'error')
                }
            }

            function validate_form()
            {

                var isImage = $("#picture").val();

                if (isImage)
                {
                    return true;
                }
                else
                {
                    swal('', "Please Select Image", 'error')
                    return false
                }
            }
            function validate_form1()
            {

                var isImage = $("#picture1").val();

                if (isImage)
                {
                    return true;
                }
                else
                {
                    swal('', "Please Select Image", 'error')
                    return false
                }
            }

            function validate_image(elementId)
            {
                var fileUpload = document.getElementById(elementId);
                var isImageValid = true;
                //Check whether the file is valid Image.
                var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");

                //Check whether HTML5 is supported.
                if (typeof (fileUpload.files) != "undefined") {
                    //Initiate the FileReader object.
                    var reader = new FileReader();
                    //Read the contents of Image File.

                    reader.readAsDataURL(fileUpload.files[0]);
                    reader.onload = function (e) {
                        //Initiate the JavaScript Image object.
                        var image = new Image();

                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;

                        //Validate the File Height and Width.
                        image.onload = function () {

                            var height = this.height;
                            var width = this.width;

                            if (height == 100 && width == 100) {
                                return true;
                            } else {
                                swal("", "Height and Width must be 100px.", 'error');
                                $("#" + elementId).val('');


                            }
                            //alert("Uploaded image has valid Height and Width.");
                        };

                    }

                } else {
                    swal('', "This browser does not support HTML5.", 'error');
                    return false;
                }
            }

            function delete_image(filename)
            {
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this picture!",
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
                        var param = {}
                        $.get("<?php echo base_url('index.php/profile/delete_business_image') ?>" + "/" + filename, param)
                                .done(function (data) {
                                    data = jQuery.parseJSON(data);
                                    if (data['status'] == '1')
                                    {
                                        swal("", "Picture Removed Successfully", "success");
                                        location.reload();

                                    } else {
                                        swal("", "Picture remove failed", "error");
                                    }
                                });
                    } else {
                        swal("Cancelled", "Your picture is safe :)", "error");
                    }
                });
            }

//            $("#upload").bind("click", function() {
//                //Get reference of FileUpload.
//                var fileUpload = $("#fileUpload")[0];
//
//                //Check whether the file is valid Image.
//                var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
//                if (regex.test(fileUpload.value.toLowerCase())) {
//                    //Check whether HTML5 is supported.
//                    if (typeof (fileUpload.files) != "undefined") {
//                        //Initiate the FileReader object.
//                        var reader = new FileReader();
//                        //Read the contents of Image File.
//                        reader.readAsDataURL(fileUpload.files[0]);
//                        reader.onload = function(e) {
//                            //Initiate the JavaScript Image object.
//                            var image = new Image();
//                            //Set the Base64 string return from FileReader as source.
//                            image.src = e.target.result;
//                            image.onload = function() {
//                                //Determine the Height and Width.
//                                var height = this.height;
//                                var width = this.width;
//                                if (height > 100 || width > 100) {
//                                    alert("Height and Width must not exceed 100px.");
//                                    return false;
//                                }
//                                alert("Uploaded image has valid Height and Width.");
//                                return true;
//                            };
//                        }
//                    } else {
//                        alert("This browser does not support HTML5.");
//                        return false;
//                    }
//                } else {
//                    alert("Please select a valid Image file.");
//                    return false;
//                }
//            });
        </script>
    </body>
</html>