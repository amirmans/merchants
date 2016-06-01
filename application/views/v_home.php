<?php
//$business_list[0]['id'] = "1";
//$business_list[0]['name'] = "Business 1";
//$business_list[0]['email'] = "tapin1@mailinator.com";
//$business_list[1]['id'] = "2";
//$business_list[1]['name'] = "Business 2";
//$business_list[1]['email'] = "tapin2@mailinator.com";
//$business_list[2]['id'] = "3";
//$business_list[2]['name'] = "Business 3";
//$business_list[2]['email'] = "tapin3@mailinator.com";
?>




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

        <div class="loading"><img src="<?php echo base_url('assets/img/loading.gif'); ?>" alt="loading-img"></div>
        
        
        <div class="content">

            <div class="col-md-12 col-lg-4">
                <br>
                <div class="panel panel-widget">
                    <div class="panel-title">
                        Business list
                    </div>
                    <div class="panel-body">

                        <ul class="mailbox-inbox">
                            <?php for ($i = 0; $i < count($business_list); $i++) {
                                ?>
                                <li>
                                    <a href="<?php echo base_url('index.php/login?businessID=' . encrypt_string($business_list[$i]['businessID'])); ?>" class="item clearfix">
                                        <span class="from"><?php echo $business_list[$i]['name']; ?></span>
                                        <span class="date"><?php echo $business_list[$i]['email']; ?></span>
                                    </a>
                                </li>
                            <?php } ?>




                        </ul>

                    </div>
                </div>
            </div>
            <?php $this->load->view('v_footer'); ?>

        </div>


        <?php $this->load->view('v_script'); ?>







    </body>
</html>