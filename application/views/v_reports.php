
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

        </style>

    </head>
    <body>
        <?php $this->load->view('v_header'); ?>
        <div class="content" >
            <!-- Start Page Header -->
            <div class="page-header">
                <h1 class="title">Reports</h1>
                <!-- End Page Header Right Div -->

            </div>
            <!-- End Page Header -->

            <div class="container-widget">
                <div class="col-md-12">
                    <h4>Orders</h4>
                    <ul class="topstats clearfix">
                        <li class="arrow"></li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-dot-circle-o"></i> Today </span>
                            <h3><?php echo $reports['today']['orders']; ?></h3>

                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-calendar-o"></i>Week</span>
                            <h3><?php echo $reports['week']['orders']; ?></h3>

                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title color-fix"><i class="fa fa-calendar-o"></i>Month</span>
                            <h3><?php echo $reports['month']['orders']; ?></h3>

                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-shopping-cart"></i>Total</span>
                            <h3><?php echo $reports['total']['orders']; ?></h3>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="container-widget">
                <div class="col-md-12">
                    <h4>Subtotal</h4>
                    <ul class="topstats clearfix">
                        <li class="arrow"></li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-dot-circle-o"></i> Today </span>
                            <h3><?php echo $reports['today']['subtotals']; ?></h3>
                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-calendar-o"></i>Week</span>
                            <h3><?php echo $reports['week']['subtotals']; ?></h3>
                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title color-fix"><i class="fa fa-calendar-o"></i>Month</span>
                            <h3><?php echo $reports['month']['subtotals']; ?></h3>
                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-shopping-cart"></i>Total</span>
                            <h3><?php echo $reports['total']['subtotals']; ?></h3>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="container-widget">
                <div class="col-md-12">
                    <h4>Tips</h4>
                    <ul class="topstats clearfix">
                        <li class="arrow"></li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-dot-circle-o"></i> Today </span>
                            <h3><?php echo $reports['today']['tips']; ?></h3>

                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-calendar-o"></i>Week</span>
                            <h3><?php echo $reports['week']['tips']; ?></h3>

                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title color-fix"><i class="fa fa-calendar-o"></i>Month</span>
                            <h3><?php echo $reports['month']['tips']; ?></h3>

                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-shopping-cart"></i>Total</span>
                            <h3><?php echo $reports['total']['tips']; ?></h3>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="container-widget">
                <div class="col-md-12">
                    <h4>Points</h4>
                    <ul class="topstats clearfix">
                        <li class="arrow"></li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-dot-circle-o"></i> Today </span>
                            <h3><?php echo $reports['today']['points']; ?></h3>

                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-calendar-o"></i>Week</span>
                            <h3><?php echo $reports['week']['points']; ?></h3>

                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title color-fix"><i class="fa fa-calendar-o"></i>Month</span>
                            <h3><?php echo $reports['month']['points']; ?></h3>

                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-shopping-cart"></i>Total</span>
                            <h3><?php echo $reports['total']['points']; ?></h3>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-md-3 newtopstats1">
                                    <span>Select From Date - To Date : </span>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="startdate" id="startdate" class="form-control" style="">
                                </div>
                                <div class="col-md-1">
                                    <input type="button" name="search" id="search" value="Search" onclick="searchreport();">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="min-height: 250px;">
                        <ul class="topstats clearfix">
                            <li class="col-xs-3">
                                <h3 id="orders">0</h3>
                                <span class="title"> Orders </span>
                            </li>
                            <li class="col-xs-3">
                                <h3 id="subtotals">0.00</h3>
                                <span class="title"> SubTotals </span>
                            </li>
                            <li class="col-xs-3">
                                <h3 id="tips">0.00</h3>
                                <span class="title"> Tips </span>
                            </li>
                            <li class="col-xs-3">
                                <h3 id="points">0.00</h3>
                                <span class="title"> Points </span>
                            </li>
                        </ul>
                    </div>

                </div>
               




            </div>
            <!-- Start Row -->

            <!-- End Row -->
            <form id="searchreport_form" class="form-horizontal"  method="post" action="<?php echo base_url('index.php/reports/searchreport'); ?>" >
                <input type="hidden" name="hiddendate" id="hiddendate"  value="">
            </form>
            <?php $this->load->view('v_footer'); ?>
        </div>




        <?php $this->load->view('v_script'); ?>


        <script>
            window.history.forward(-1);
            $("#reports_tab").addClass('active_tab');

        </script>
    <!--        <script type="text/javascript">
            $(function () {
                $('input[name="startdate"]').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true
                });
            });
        </script>-->
        <script type="text/javascript">
            $(function() {

                $('input[name="startdate"]').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear',
                        format: 'YYYY-MM-DD'
                    }
                });

                $('input[name="startdate"]').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                });

                $('input[name="startdate"]').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });

            });

            function searchreport() {
                var startdate = $("#startdate").val();
                if (startdate == "") {
                    swal('Error!', "Please select date")
                } else {
                    $("#hiddendate").val(startdate);
                    $('#searchreport_form').submit();

                }

            }
            $(document).ready(function() {
                $('#searchreport_form').ajaxForm({
                    success: searchreportResponse
                });
            });
            function searchreportResponse(data) {
                var data = JSON.parse(data);
                console.log(data)
                $("#orders").html(data.report.total_orders);
                $("#subtotals").html(data.report.total_subtotal);
                $("#tips").html(data.report.total_tip);
                $("#points").html(data.report.total_points);
            }
        </script>

    </body>
</html>