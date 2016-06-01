

<html lang="en"><!-- Mirrored from egemem.com/theme/kode/v1.1/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 09 Apr 2015 09:26:17 GMT --><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login</title>
        <?php $this->load->view('v_head'); ?>
        <style type="text/css">
            .error1_msg{
                color: #E61818; text-align: center
            }
            .success1_msg{
                color:  #009900; text-align: center
            }

        </style></head>
    <body>

        <div class="login-form">
            <form method="post" action="<?php echo base_url('index.php/login/do_login'); ?>">
                <div class="top">
                    <h1>Tap-in</h1>
                    <h4>Business Login Area!!!</h4>
                </div>
                <div class="form-area">
                    <div class="group">
                        <input type="text" class="form-control" placeholder="Username" required id="username" name="username" value="<?php
                        if (isset($business['business_detail']['username'])) {
                            echo $business['business_detail']['username'];
                        }
                        ?>" >
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="group">
                        <input type="password" class="form-control" placeholder="Password" required  id="business_password" name="password" value="123456">
                        <i class="fa fa-key"></i>
                    </div>
                    <button type="submit" class="btn btn-default btn-block">LOGIN</button>
                </div>
                <p class="error1_msg"><?php echo $this->session->flashdata('error1'); ?></p>
                <p class="success1_msg"><?php echo $this->session->flashdata('success1'); ?></p>
            </form>

        </div>



        <script>
            window.history.forward(-1);
        </script>

    </body>
</html>