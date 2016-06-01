
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
        </style>
    </head>
    <body>
        <?php $this->load->view('v_header'); ?>


        <div class="content">
            <div class="container-mailbox">

                <!-- Start Invoice -->
                <div class="invoice row" style="min-height: 870px">
                    <div class="invoicename">Business Profile</div>
                    <div class="logo">
                        <img src="../../tapin-server-staging/customer_files/icons/<?php echo $business_detail['icon']?>" alt="logo" width="150" ><br>
                        
                        <h1><?php echo $business_detail['name']; ?></h1 >

                        <h6><?php echo $business_detail['address']; ?><br></h6>
                    </div>

                    <div class="line row">
                        <div class="col-md-6 col-xs-6 padding-0 text-left">
                            <h4>Email</h4>
                            <h2><?php echo $business_detail['email']; ?></h2>
                        </div>
                        <div class="col-md-6 col-xs-6 padding-0 text-right">
                            <h4>Website</h4>
                            <h2><?php echo $business_detail['website']; ?></h2>
                        </div>
                    </div>

                    <div class="line row">
                        <div class="col-md-6 col-xs-6 padding-0 text-left">
                            <h4>Phone</h4>
                            <h2><?php echo $business_detail['phone']; ?></h2>
                        </div>
                        <div class="col-md-6 col-xs-6 padding-0 text-right">
                            <h4>Business Type</h4>
                            <h2><?php echo $business_detail['businessTypes']; ?></h2>
                        </div>
                    </div>
                    <div class="line row">
                        <div class="col-md-3 col-xs-3 padding-0 text-left">

                        </div>
                        <div class="col-md-6 col-xs-6 padding-0 text-center">
                            <h4>Stripe Secret Key</h4>
                            <h2 id="stripe_secret_key_text"><?php echo $business_detail['stripe_secret_key']; ?></h2>
                            <!--                            <a href="#" class=" btn btn-primary" data-toggle="modal" data-target="#stripeTokenModal">Edit</a>-->
                            <a href="javascript:void(0)" class="btn btn-primary" onclick="edit_stripe_secret_key()">Edit</a>
                        </div>
                        <div class="col-md-3 col-xs-3 padding-0 text-right">

                        </div>
                    </div>




                </div>
                <!-- End Invoice -->
            </div>
            <?php $this->load->view('v_footer'); ?>
        </div>

        <div class="modal fade" id="stripeTokenModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" id="form_stripe_secret_key" action="<?php echo base_url('index.php/profile/edit_stripe_secret_key'); ?>" method="post">
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

        <?php $this->load->view('v_script'); ?>


        <script>

            var options = {
                success: processEditStripeTokenResponse
            }
            window.history.forward(-1);

            $(document).ready(function() {
                // bind 'myForm' and provide a simple callback function 
                $('#form_stripe_secret_key').ajaxForm(options);

            });

            function processEditStripeTokenResponse(data) {

                var data = JSON.parse(data);
                if (data.status)
                {
                    $('#form_stripe_secret_key').trigger("reset");
                    $('#stripe_secret_key_text').text(data.stripe_secret_key);
                    $('#stripeTokenModal').modal('toggle');
                    swal('',"Stripe token updated successfully",'success')

                } else {
                    $('#stripeTokenModal').modal('toggle');
                    swal('',"Stripe token updated unsuccessfully",'error')
                    
                }
            }
            
            function edit_stripe_secret_key() {
                var stripe_secret_key_text = $('#stripe_secret_key_text').text();
                $('#stripe_secret_key').val(stripe_secret_key_text);
                $('#stripeTokenModal').modal('show');
            }
        </script>
    </body>
</html>