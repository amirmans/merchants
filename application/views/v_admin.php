<!--<div class="loading"><img src="--><?php //echo base_url('assets/img/loading.gif'); ?><!--" alt="loading-img"></div>-->
<div id="top" class="clearfix">

    <!-- Start App Logo -->
    <div class="applogo">
        <?php $reportPath = base_url('index.php/CorpDriverReport'); ?>
        <a href="<?php echo base_url(); ?>" class="logo">Tap-in</a>
    </div>
    <ul class="topmenu"  style="display: block">

        <li ><a id="reports_tab1" href="<?php echo base_url('index.php/CorpDriverReport'); ?>">Driver Report</a></li>
        <li ><a id="reports_tab2" href="<?php echo base_url('index.php/AdminOrderReport'); ?>">Order Reports</a></li>


    </ul>

    <!-- End Top Right -->

</div>



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

<!--         <div class="loading"><img src="<?php echo base_url('assets/img/loading.gif'); ?>" alt="loading-img"></div> -->


        <div >


            <?php $this->load->view('v_footer'); ?>

        </div>


        <!-- <?php $this->load->view('v_script'); ?> -->







    </body>
</html>