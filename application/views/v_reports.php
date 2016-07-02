
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
                            <h3><?php echo $reports['today']; ?></h3>

                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-calendar-o"></i>Week</span>
                            <h3><?php echo $reports['week']; ?></h3>

                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title color-fix"><i class="fa fa-calendar-o"></i>Month</span>
                            <h3><?php echo $reports['month']; ?></h3>

                        </li>
                        <li class="col-xs-6 col-lg-3">
                            <span class="title"><i class="fa fa-shopping-cart"></i>Total Orders</span>
                            <h3><?php echo $reports['total']; ?></h3>
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
                                <div class="col-md-3  newtopstats3">
                                    <label id="datereport">0</label>
                                </div>
                                <div class="col-md-3">
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--                <div class="col-md-12">
                                <div class="topstats newtopstats">
                                    
                                    <div class="newtopstats1"><span>Select From Date - To Date : </span><input type="text" name="startdate" id="startdate" class="form-control" style="width: 50%;"></div>
                                    <div class="newtopstats2"><input type="button" name="search" id="search" value="Search" onclick="searchreport();"></div>
                                    <div class="newtopstats3"><h3 id="datereport">0</h3></div>
                                </div>
                            </div>-->




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
            $("#datereport").html(data.report);
        }
    </script>

</body>
</html>