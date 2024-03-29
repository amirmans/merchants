
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
            .invoice .logo img {
                margin-left: 260px;
            }
        </style>
    </head>
    <body>
        <?php $this->load->view('v_header'); ?>


        <div class="content">
            <div class="container-mailbox">

                <!-- Start Invoice -->
                <div class="invoice row" style="min-height: 870px">
                    <div class="invoicename">Business Profile</div>
                    <div class="edit_icon"> <a class="btn btn-primary pointer" onclick="edit_profile()">Edit</a><a href="<?php echo base_url('index.php/profile/add_business_images'); ?>" class="btn btn-primary pointer margin-l-10">Add Business Images</a></div>&nbsp;

                    <div class="logo">
                        <img id="icon_url" src="../../<?php echo staging_directory(); ?>/customer_files/icons/<?php echo $business_detail['icon'] ?>" alt="logo" width="150" ><br>

                        <h1><?php echo $business_detail['name']; ?></h1 >

                        <h6 id="address_text"><?php echo $business_detail['address']; ?><br></h6>
                    </div>

                    <div class="line row">
                        <div class="col-md-6 col-xs-6 padding-0 text-left">
                            <h4>Email</h4>
                            <h2 id="email_text"><?php echo $business_detail['email']; ?></h2>
                        </div>
                        <div class="col-md-6 col-xs-6 padding-0 text-right">
                            <h4>Website</h4>
                            <h2 id="website_text"><?php echo $business_detail['website']; ?></h2>
                        </div>
                    </div>
                    <div class="line row">
                        <div class="col-md-6 col-xs-6 padding-0 text-left">
                            <h4>Phone</h4>
                            <h2 id="phone_text"><?php echo $business_detail['phone']; ?></h2>
                        </div>
                        <div class="col-md-6 col-xs-6 padding-0 text-right">
                            <!--                            <h4>Business Type</h4>
                                                        <h2 id="business_type_text"><?php echo $business_detail['businessTypes']; ?></h2>-->
                        </div>
                    </div>
                    <div class="line row">
                        <div class="col-md-6 col-xs-6 padding-0 text-left">
                            <h4>Tagline</h4>
                            <h2 id="marketing_statement_text"><?php echo $business_detail['marketing_statement']; ?></h2>
                        </div>
                        <div class="col-md-6 col-xs-6 padding-0 text-right">
                            <h4>Wait Time</h4>
                            <h2 id="process_time_text"><?php echo $business_detail['process_time']; ?></h2>
                        </div>
                    </div>
                    <div class="line row">
                        <div class="col-md-6 col-xs-6 padding-0 text-left">
                            <h4>Short Name</h4>
                            <h2 id="short_name_text"><?php echo $business_detail['short_name']; ?></h2>
                        </div>
                        <div class="col-md-6 col-xs-6 padding-0 text-right">
                            <h4>Customer service’s SMS</h4>
                            <h2 id="sms_no_text"><?php echo $business_detail['sms_no']; ?></h2>
                        </div>
                    </div>

                    <div class="line row">
                        <div class="col-md-3 col-xs-3 padding-0 text-left">

                        </div>
                        <div class="col-md-6 col-xs-6 padding-0 text-center">
                            <h4>Stripe Secret Key</h4>
                            <h2 id="stripe_secret_key_text"><?php echo $business_detail['stripe_secret_key']; ?></h2>
                            <a href="#" class=" btn btn-primary" data-toggle="modal" data-target="#loginModal">Edit Stripe Secret Key</a>

                        </div>
                        <div class="col-md-3 col-xs-3 padding-0 text-right">

                        </div>
                    </div>
                    <div class="line row">
                        <div class="col-md-6 col-xs-6 padding-0 text-left">
                            <h4>Internal Info</h4>

                        </div>
                        <div class="col-md-6 col-xs-3 padding-0 text-right">
                            <a class="btn btn-primary pointer " onclick="edit_interinfo()">Edit Internal info</a>
                        </div>


                    </div>
                    <div class="line row">
                        <div class="col-md-6 col-xs-6 padding-0 text-left">
                            <h4>Internal Email</h4>
                            <?php
                            $email_array = explode(",", $internal['email']);
                            for ($hy = 0; $hy < count($email_array); $hy++) {
                                ?>
                                <h2 ><?php echo $email_array[$hy]; ?></h2>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 col-xs-6 padding-0 text-right">
                            <h4>Internal SMS NO</h4>
                            <?php
                            $sms_no_array = explode(",", $internal['sms_no']);
                            for ($hy = 0; $hy < count($sms_no_array); $hy++) {
                                ?>
                                <h2 ><?php echo $sms_no_array[$hy]; ?></h2>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="line row">
                        <div class="col-md-6 col-xs-6 padding-0 text-left">
                            <h4>Opening Hours</h4>

                        </div>
                        <div class="col-md-6 col-xs-3 padding-0 text-right">
                            <a class="btn btn-primary pointer " onclick="edit_opening_hours()">Edit Business Hours</a>
                        </div>

                    </div>
                    <table class="table text-center" >
                        <thead class="title">
                            <tr>
                                <td>WEEK DAY</td>
                                <td>FROM DATE</td>
                                <td>TO DATE</td>
                                <td>OPENING TIME</td>
                                <td class="">CLOSING TIME</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < count($business_detail['hours']); $i++) {
                                ?>
                                <tr>
                                    <td><?php
                                        if ($business_detail['hours'][$i]['weekday_id'] == 0) {
                                            echo 'Sunday';
                                        } elseif ($business_detail['hours'][$i]['weekday_id'] == 1) {
                                            echo 'Monday';
                                        } elseif ($business_detail['hours'][$i]['weekday_id'] == 2) {
                                            echo 'Tuesday';
                                        } elseif ($business_detail['hours'][$i]['weekday_id'] == 3) {
                                            echo 'Wednesday';
                                        } elseif ($business_detail['hours'][$i]['weekday_id'] == 4) {
                                            echo 'Thursday';
                                        } elseif ($business_detail['hours'][$i]['weekday_id'] == 5) {
                                            echo 'Friday';
                                        } elseif ($business_detail['hours'][$i]['weekday_id'] == 6) {
                                            echo 'Saturday';
                                        }
                                        ?></td>
                                    <td>
                                        <?php echo $business_detail['hours'][$i]['from_date'] ?>
                                    </td>
                                    <td>
                                        <?php echo $business_detail['hours'][$i]['to_date'] ?>
                                    </td>
                                    <td>
                                        <?php echo $business_detail['hours'][$i]['opening_time'] ?>
                                    </td>
                                    <td>
                                        <?php echo $business_detail['hours'][$i]['closing_time'] ?>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- End Invoice -->
            </div>
            <?php $this->load->view('v_footer'); ?>
        </div>

        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Login</h4>
                    </div>
                    <div class="modal-body" style="background: #F5F5F5;">
                        <div class="login-form" style="padding-top: 0px;">
                            <form class="form-horizontal" id="formlogin" action="<?php echo base_url('index.php/profile/do_authenticate'); ?>" method="post" >
                                <div class="form-area">
                                    <div class="group">
                                        <input type="text" class="form-control" placeholder="Username" name="username">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="group">
                                        <input type="password" class="form-control" placeholder="Password" name="password">
                                        <i class="fa fa-key"></i>
                                    </div>
                                </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <label id="category_error_text" class="pull-left color10"></label>
                        <button type="button" class="btn btn-white" data-dismiss="modal" >Close</button>
                        <button type="submit" class="btn btn-default" >Authenticate</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" id="form_edit_profile" action="<?php echo base_url('index.php/profile/edit_profile'); ?>" method="post" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Edit Profile</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address" class="col-sm-4 control-label form-label">Address</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="address" name="address" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-4 control-label form-label">Email</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="email" name="email" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="website" class="col-sm-4 control-label form-label">Website</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="website" name="website" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="col-sm-4 control-label form-label">Phone</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="phone" name="phone" >
                                        </div>
                                    </div>
                                    <!--                                    <div class="form-group">
                                                                            <label for="businessTypes" class="col-sm-4 control-label form-label">Business Type</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="businessTypes" name="businessTypes" required>
                                                                            </div>
                                                                        </div>-->
                                    <div class="form-group">
                                        <label for="marketing_statement" class="col-sm-4 control-label form-label">Tagline</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="marketing_statement" name="marketing_statement" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="process_time" class="col-sm-4 control-label form-label">Wait Time</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="process_time" name="process_time">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_name" class="col-sm-4 control-label form-label">Short Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="short_name" name="short_name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sms_no" class="col-sm-4 control-label form-label">Customer service’s SMS</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="sms_no" name="sms_no" >
                                        </div>
                                    </div>
                                    <!--                                    <div class="form-group">
                                                                            <label for="category_name" class="col-sm-4 control-label form-label">Stripe Secret Key</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="stripe_secret_key" name="stripe_secret_key" required>
                                                                            </div>
                                                                        </div>-->
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label form-label">Icon:</label>
                                        <div class="col-sm-8" id="imgArea">
                                            <img height="150" width="100" id="image" src="">
                                            <div id="imgChange"><span>Change Photo</span>
                                                <input type="file" accept="image/*" name="image_upload_file" id="image_upload_file">
                                            </div>
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
                            <button type="submit" class="btn btn-default" >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editStripeKeyModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" id="form_edit_stripekey" action="<?php echo base_url('index.php/profile/edit_stripe_key'); ?>" method="post" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Edit Stripe Secret Key</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">


                                    <div class="form-group">
                                        <label for="category_name" class="col-sm-4 control-label form-label">Stripe Secret Key</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="stripe_secret_key" name="stripe_secret_key" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
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
        <div class="modal fade" id="interinfoModal" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog ">
                <div class="modal-content">
                    <form class="form-horizontal" id="form_internal_info"  action="<?php echo base_url('index.php/profile/edit_internal_info'); ?>" method="post" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Edit Internal Info</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="internal_email" class="col-sm-4 control-label form-label">Internal email</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control user-success" id="internal_email" name="internal_email"  multiple pattern="^([\w+-.%]+@[\w-.]+\.[A-Za-z]{2,4},*[\W]*)+$"  value="<?php echo $internal['email']; ?>" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="internal_sms_no" class="col-sm-4 control-label form-label">Internal SMS no</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control user-success" id="internal_sms_no" name="internal_sms_no" value="<?php echo $internal['sms_no']; ?>"   pattern="^\+\d{10,11}(,\+\d{10,11})*$"  >
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-white" data-dismiss="modal" >Close</button>
                            <button type="submit" class="btn btn-default" onclick="return validate_before_save_internal()" >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="openingHoursModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form class="form-horizontal" id="form_opening_hours" action="<?php echo base_url('index.php/profile/edit_opening_hours'); ?>" method="post" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Edit Opening Hours</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table text-center" >
                                        <thead class="title">
                                            <tr>
                                                <td>WEEK DAY</td>
                                                <td>FROM DATE</td>
                                                <td>TO DATE</td>
                                                <td>OPENING TIME</td>
                                                <td class="">CLOSING TIME</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $enrtyids = '';
                                            for ($i = 0; $i < count($business_detail['hours']); $i++) {
                                                $enrtyids .= $business_detail['hours'][$i]['entry_id'];
                                                if ($i != count($business_detail['hours']) - 1) {
                                                    $enrtyids .= ',';
                                                }
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        if ($business_detail['hours'][$i]['weekday_id'] == 0) {
                                                            echo 'Sunday';
                                                        } elseif ($business_detail['hours'][$i]['weekday_id'] == 1) {
                                                            echo 'Monday';
                                                        } elseif ($business_detail['hours'][$i]['weekday_id'] == 2) {
                                                            echo 'Tuesday';
                                                        } elseif ($business_detail['hours'][$i]['weekday_id'] == 3) {
                                                            echo 'Wednesday';
                                                        } elseif ($business_detail['hours'][$i]['weekday_id'] == 4) {
                                                            echo 'Thursday';
                                                        } elseif ($business_detail['hours'][$i]['weekday_id'] == 5) {
                                                            echo 'Friday';
                                                        } elseif ($business_detail['hours'][$i]['weekday_id'] == 6) {
                                                            echo 'Saturday';
                                                        }
                                                        ?></td>
                                                    <td>
                                                        <div class="form-group" style="position:relative;">
                                                            <div class="col-sm-12">
                                                                <input type="text" name="fromdate_<?php echo $business_detail['hours'][$i]['entry_id']; ?>" id="fromdate_<?php echo $business_detail['hours'][$i]['entry_id']; ?>" class="form-control" value="<?php echo $business_detail['hours'][$i]['from_date'] ?>">
                                                            </div>

                                                        </div>

                                                    </td>
                                                    <td> 
                                                        <div class="form-group" style="position:relative;">
                                                            <div class="col-sm-12 " >
                                                                <input type="text" name="todate_<?php echo $business_detail['hours'][$i]['entry_id']; ?>" id="todate_<?php echo $business_detail['hours'][$i]['entry_id']; ?>" class="form-control" style="" value="<?php echo $business_detail['hours'][$i]['to_date'] ?>">
                                                            </div>

                                                        </div>

                                                    </td>
                                                    <td>
                                                        <div class="form-group" style="position:relative;">
                                                            <div class="col-sm-offset-2 col-sm-10 "  >
                                                                <input type="text" name="openingtime_<?php echo $business_detail['hours'][$i]['entry_id']; ?>" id="fromtime_<?php echo $business_detail['hours'][$i]['entry_id']; ?>" class="form-control" style="" value="<?php echo $business_detail['hours'][$i]['opening_time'] ?>">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="">
                                                        <div class="form-group"  style="position:relative;">
                                                            <div class="col-sm-offset-2 col-sm-10 ">
                                                                <input type="text" name="closingtime_<?php echo $business_detail['hours'][$i]['entry_id']; ?>" id="totime_<?php echo $business_detail['hours'][$i]['entry_id']; ?>" class="form-control" style="" value="<?php echo $business_detail['hours'][$i]['closing_time'] ?>">
                                                            </div>                                                          
                                                        </div>

                                                    </td>
                                                </tr>
                                            <?php }
                                            ?>
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="entryids" value="<?php echo $enrtyids; ?>">
                                </div>
                            </div>
                            <br>
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
            function validate_before_save_internal()
            {
                var validate = 1;
                var internal_email = $("#internal_email").val();
                var internal_sms_no = $("#internal_sms_no").val();
                var ec = internal_email.split(",");
                if (ec.length > 5) {
                    alert('You can add max 5 email');
                    return false;
                }

                var is = internal_sms_no.split(",");
                if (is.length > 5) {
                    alert('You can add max 5 mobile no');
                    return false;
                }


                return true;
            }
            var hours = $.parseJSON('<?php echo json_encode($business_detail['hours']); ?>')

            var options = {
                success: processEditProfileResponse
            }


            $(document).ready(function () {
                // bind 'myForm' and provide a simple callback function 
                $('#form_edit_profile').ajaxForm(options);


                $('#formlogin').ajaxForm({
                    success: processLoginResponse
                });

                $('#form_edit_stripekey').ajaxForm({
                    success: processEditStripeKeyResponse
                });
                $('#form_opening_hours').ajaxForm({
                    success: processEditOpeningHoursResponse
                });

                $('#form_internal_info').ajaxForm({
                    success: processinternalResponse
                });



            });


            function processEditProfileResponse(data) {

                var data = JSON.parse(data);
                if (data.status)
                {
                    $('#form_edit_profile').trigger("reset");
                    $('#stripe_secret_key_text').text(data.stripe_secret_key);
                    $('#address_text').text(data.address);
                    $('#email_text').text(data.email);
                    $('#website_text').text(data.website);
                    $('#phone_text').text(data.phone);
                    // $('#business_type_text').text(data.businessTypes);
                    $('#marketing_statement_text').text(data.marketing_statement);
                    $('#process_time_text').text(data.process_time);
                    $('#short_name_text').text(data.short_name);
                    $('#sms_no_text').text(data.sms_no);
                    $('#editProfileModal').modal('toggle');
                    swal('', "Profile updated successfully", 'success')
                    location.reload();

                } else {
                    $('#editProfileModal').modal('toggle');
                    swal('', "Profile updated unsuccessfully", 'error')
                }
            }

            function edit_profile() {

                var address = $('#address_text').text();
                $('#address').val(address);
                var email = $('#email_text').text();
                $('#email').val(email);
                var website = $('#website_text').text();
                $('#website').val(website);
                var phone = $('#phone_text').text();
                $('#phone').val(phone);
//                var business_type_text = $('#business_type_text').text();
//                $('#businessTypes').val(business_type_text);
                var marketing_statement_text = $('#marketing_statement_text').text();
                $('#marketing_statement').val(marketing_statement_text);
                var process_time_text = $('#process_time_text').text();
                $('#process_time').val(process_time_text);
                var short_name_text = $('#short_name_text').text();
                $('#short_name').val(short_name_text);
                var sms_no_text = $('#sms_no_text').text();
                $('#sms_no').val(sms_no_text);
                var stripe_secret_key_text = $('#stripe_secret_key_text').text();

                var icon_url = document.getElementById("icon_url").src;

                document.getElementById("image").src = icon_url;

                $('#stripe_secret_key').val(stripe_secret_key_text);
                $('#editProfileModal').modal('show');
            }
            document.getElementById("image_upload_file").onchange = function () {
                var reader = new FileReader();

                reader.onload = function (e) {
                    // get loaded data and render thumbnail.
                    document.getElementById("image").src = e.target.result;
                };

                // read the image file as a data URL.

                reader.readAsDataURL(this.files[0]);

            };
            function edit_opening_hours() {
                $('#openingHoursModal').modal('show');
            }

            function edit_interinfo()
            {
                $('#interinfoModal').modal('show');
            }

            function processEditOpeningHoursResponse(data) {

                var data = JSON.parse(data);
                if (data.status)
                {

                    $('#openingHoursModal').modal('toggle');
                    swal('', "Profile updated successfully", 'success')
                    location.reload();

                } else {
                    console.log(data);
                    $('#openingHoursModal').modal('toggle');
                    swal('', "Profile updated unsuccessfully", 'error')

                }
            }

            function processinternalResponse(data)
            {
                var data = JSON.parse(data);
                if (data.status)
                {
                    $('#interinfoModal').modal('toggle');
                    swal('', "Profile updated successfully", 'success')
                    location.reload();
                }
            }

            function processLoginResponse(data) {

                var data = JSON.parse(data);
                if (data.status)
                {
                    var loginbusinessId =<?php echo $this->session->userdata('businessID'); ?>;

                    if (loginbusinessId == data.user.businessID)
                    {
                        var stripe_secret_key_text = $('#stripe_secret_key_text').text();
                        $('#stripe_secret_key').val(stripe_secret_key_text);
                        $('#loginModal').modal('toggle');
                        $('#formlogin').trigger("reset");
                        $('#editStripeKeyModal').modal('show');
                    } else
                    {
                        swal('', "Invalid Login", 'error')
                    }


                } else {
                    swal('', "Login unsuccessfully", 'error')
                }
            }

            function processEditStripeKeyResponse(data) {

                var data = JSON.parse(data);
                if (data.status)
                {
                    $('#stripe_secret_key_text').text(data.stripe_secret_key);
                    $('#editStripeKeyModal').modal('hide');
                    swal('', data.msg, 'success')
                } else {
                    $('#openingHoursModal').modal('toggle');
                    swal('', "Stripe Token Updated Successfully", 'error')

                }
            }



            $(document).ready(function () {

                for (var i = 0; i < hours.length; i++)
                {
                    var from = "fromdate_" + hours[i].entry_id;
                    var to = "todate_" + hours[i].entry_id;
                    var openingtime = "openingtime_" + hours[i].entry_id;
                    var closingtime = "closingtime_" + hours[i].entry_id;

                    var option = {
                        singleDatePicker: true,
                        locale: {
                            format: 'YYYY-MM-DD'
                        }
                    }
                    if (i >= (hours.length - 2))
                    {
                        option.drops = "up"
                    }

                    $('input[name="' + from + '"]').daterangepicker(option);


                    $('input[name="' + to + '"]').daterangepicker(option);

                    $('input[name="' + openingtime + '"]').datetimepicker({format: 'HH:mm:ss', icons: {up: "fa fa-arrow-up", down: "fa fa-arrow-down"}});
                    $('input[name="' + closingtime + '"]').datetimepicker({format: 'HH:mm:ss', icons: {up: "fa fa-arrow-up", down: "fa fa-arrow-down"}});
                }
            });

        </script>

    </body>
</html>
