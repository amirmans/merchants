
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
            #product_table tr td:nth-child(1){
                width:18%;
            }
            #product_table tr td:nth-child(2){
                width:10%;
            }
        </style>

    </head>
    <body>
        <?php $this->load->view('v_header'); ?>
        <div class="content">
            <!-- Start Page Header -->
            <div class="page-header">
                <h1 class="title">Reports</h1>
                <!-- End Page Header Right Div -->

            </div>
            <!-- End Page Header -->

            <div class="container-widget">
                <div class="col-md-12">
                    <ul class="topstats clearfix">
                        <li class="arrow"></li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-dot-circle-o"></i> Today </span>
                            <h3><?php echo $reports['today'];?></h3>
                            
                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-calendar-o"></i>Week</span>
                            <h3><?php echo $reports['week'];?></h3>
                            
                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title color-fix"><i class="fa fa-calendar-o"></i>Month</span>
                            <h3><?php echo $reports['month'];?></h3>
                            
                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-shopping-cart"></i>Total Orders</span>
                            <h3 ><?php echo $reports['total'];?></h3>
                            
                        </li>
                        
                    </ul>
                </div>
            </div>

            <?php $this->load->view('v_footer'); ?>
        </div>




        <?php $this->load->view('v_script'); ?>


        <script>
            window.history.forward(-1);
            $("#reports_tab").addClass('active_tab');

        </script>








    </body>
</html>