<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Tap In</title>
    </head>
    <body style="font-family: sans-serif">
        <center>
            <table border="0" width="500"  >
                <tr>
                    <td>
                        <table border="0" width="500" style="background-color: #4DBEC7">
                            <tr>
                                <td colspan="3">
                                    <h3 style="margin-left: 60px;color: #fff"> THANKS FOR YOUR ORDER!</h3>
                                    <p style="margin-left: 60px;color: #fff">We'll send you alert when your order is ready.</p>
                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>

                <?php for ($i = 0; $i < count($order_detail); $i++) {
                    ?>
                    <tr>
                        <td>
                            <table>
                                <tr style="vertical-align: top">
                                    <td>
                                        <table border="0" width="70" style="text-align: center" >
                                            <tr style="">
                                                <td style="margin-top: 0">
                                                    <h2> <?php echo $order_detail[$i]['quantity']; ?></h2>
                                                    <hr style="    border-width: 1.98px;border-color: #AAAAAA;"/>
                                                </td>
                                            </tr>
                                            <tr style="">
                                                <td >
                                                    <img src="<?php echo base_url('assets/email_templete/ic_heart_unlike @3x.png'); ?>" width="30" height="30"></img>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table border="0" width="430">
                                            <tr style="">

                                                <td rowspan="2" style="padding: 7px"> 
                                                    <p style="font-weight: bold"><?php echo $order_detail[$i]['name']; ?></p>
                                                    <p style="color: #808080"><?php echo $order_detail[$i]['short_description']; ?></p>
                                                </td>
                                                <td rowspan="2">
                                                    <h1 style="text-align: right;margin-right: 10px">$<?php echo $order_detail[$i]['price']; ?></h1>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>


                        </td>   
                    </tr>
                <?php } ?>

                <tr >
                    <td style="">
                        <table cellpadding='0' cellspacing='0'  border="0" width="500" style="padding: 20px;border-collapse: initial;">
                            <tr  bgcolor="#EBEBEB" style="">
                                <td bgcolor="#EBEBEB">
                                    <p style="padding-left: 15px"><span style="color:#ABABAB">ORDER #</span><?php echo $order_id; ?></p>
                                    <p style="padding-left: 15px;color: #4DBEC7">ORDER IN PROCESS</p>
                                    <p style="padding-left: 15px"><span style="color:#ABABAB">AVERAGE WAITING TIME 20 MINS</span></p>
                                </td> 
                                <td><span style="color: #ABABAB;font-weight: bold">$<?php echo $total; ?></span></td>
                            </tr>

                            <tr bgcolor="#fff" >
                                <td bgcolor="">
                                    <p style="padding-left: 15px"></p>

                                </td> 
                                <td></td>
                            </tr>
                            <tr bgcolor="#EBEBEB" >
                                <td bgcolor="#EBEBEB">
                                    <p style="padding-left: 15px"><span style="color:#4DBEC7">PAID</span> Visa XXXX XXXX XXXX <?php echo substr($cc_no, -4) . " " . $exp_month . "/" . $exp_year; ?></p>

                                </td> 
                                <td></td>
                            </tr>
                        </table>
                    </td>

                </tr>
                <tr>
                    <td>
                        <table  border="0" width="500" >
                            <tr>
                                <td style="padding: 5px"><span style="color:#4DBEC7"><img src="<?php echo base_url('assets/email_templete/ic_rewards@3x.png'); ?>" width="30" height="30"></img></span></td>
                                <td style="padding: 5px"><span style="color:#4DBEC7">Earn 19 Reward Points</span></td>
                            </tr>
                            <tr>
                                <td style="padding: 5px"><span style="color:#4DBEC7"><img src="<?php echo base_url('assets/email_templete/ic_rewards@3x.png'); ?>" width="30" height="30"></img></span></td>
                                <td style="padding: 5px"><span style="color:#4DBEC7">You Redeem 192 Reward Points</span></td>
                            </tr>
                            <tr>
                                <td style="padding: 5px"><span style="color:#4DBEC7"><img src="<?php echo base_url('assets/email_templete/ic_heart_like@3x.png'); ?>" width="30" height="30"></img></span></td>
                                <td style="padding: 5px"><span style="color:#4DBEC7">Save Your Fevorite Items For Next Time!</span></td>
                            </tr>
                        </table>
                    </td>

                </tr>
            </table>


        </center>
    </body>
</html>
