
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


        




        <?php $this->load->view('v_script'); ?>


        <script>
            window.history.forward(-1);
            $("#reports_tab").addClass('active_tab');

        </script>








    </body>
</html>