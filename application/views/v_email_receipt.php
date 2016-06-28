<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php

function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}
?>
<html xmlns="">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Tap In</title>


    </head>

    <body style="font-family: sans-serif;background-color: #E5E5E5" >
        <center>
            <table border="0" width="500"  bgcolor="white" style="display: table;border-collapse: separate;border-spacing: 2px;border-top:5px solid #E5E5E5;border-bottom:5px solid #E5E5E5" >

                <tr>
                    <td>

                        <table border="0" width="100%"  bgcolor="black" >
                            <tr>
                                <td height="10" style="text-align: center">
                                    <img src="<?php echo base_url('assets/email_templete/tap-in-logo-with-name~iphone@2x.png'); ?>" ></img>
                                </td>

                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="0" width="100%"   style="background-color: #4DBEC7">
                            <tr>
                                <td height="10">
                                    <h2 style="color: #fff;text-align: center"><?php echo $business_name; ?></h2>
                                </td>

                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table  border="0" width="100%" bgcolor="4DBEC7" style="padding: 10px">
                            <tr>
                                <td style="text-align: center">
                                    <span  style="color:#fff;font-size: 20px;">How was your experience?</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center" >
                                    <span style="color:#4DBEC7;"><a style="padding: 10px 10px 10px 10px;display: inline-block;white-space: nowrap;vertical-align: middle; -ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;" href="<?php echo base_url('index.php/rating/business_rating/?is_positive=1&orderId=' . encrypt_string($order_id)); ?>"><img src="<?php echo base_url('assets/email_templete/emoji_happy.png'); ?>" ></img></a></span>&nbsp;&nbsp;
                                    <span style="color:#4DBEC7"><a  style="padding: 10px 10px 10px 10px;display: inline-block;white-space: nowrap;vertical-align: middle; -ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;" href="<?php echo base_url('index.php/rating/business_rating/?is_positive=0&orderId=' . encrypt_string($order_id)); ?>"><img src="<?php echo base_url('assets/email_templete/emoji_unhappy.png'); ?>" ></img></a></span>
                                </td>
                            </tr>

                        </table>
                    </td>

                </tr>
<!--                <tr style="background-color: #4DBEC7">
                    <td style="text-align: center">
                        <div style="text-align: center;border-bottom-color:#546476;border-bottom-style:solid;border-left-color:transparent;border-left-style:solid;border-right-color:transparent;border-right-style:solid;border-width:0 8px 8px;min-height:0;vertical-align:bottom;width:0;"></div>
                    </td>
                </tr>-->
                <tr>
                    <td>
                        <table border="0" width="100%" style="background-color: #4DBEC7;text-align: center">
                            <tr>
                                <td>
                                    <h3 style="color: #fff;"> Thanks for your order <?php echo $order_id; ?>!</h3>
                                    <p style="color: #fff;">We'll send you an alert, when your order is ready.</p>
                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>

                <?php for ($i = 0; $i < count($order_detail); $i++) {
                    ?>
                    <tr>
                        <td>
                            <table >
                                <tr style="vertical-align: top">
                                    <td>
                                        <table border="0" width="70" style="text-align: center" >
                                            <tr style="">
                                                <td style="padding: 0;line-height: 0;">
                                                    <h2> <?php echo $order_detail[$i]['quantity']; ?></h2>
                                                    <hr style="border-width: 1.98px;border-color: #AAAAAA;"/>
                                                </td>
                                            </tr>
                                            <tr style="">
                                                <td>
                                                    <a href="<?php echo base_url('index.php/rating/product_rating/?&orderId=' . encrypt_string($order_id) . '&productId=' . encrypt_string($order_detail[$i]['product_id'])); ?>"><img src="<?php echo base_url('assets/email_templete/ic_heart_unlike@3x.png'); ?>" width="30" height="30"></img></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table border="0" width="430">
                                            <tr style="">

                                                <td rowspan="2"> 
                                                    <p style="font-weight: bold"><?php echo $order_detail[$i]['name']; ?></p>
                                                    <p style="color: #808080"><?php echo limit_text($order_detail[$i]['short_description'], 12); ?></p>
                                                    <?php if (count($order_detail[$i]['option_ids']) > 0) {
                                                        ?>
                                                        <ul style="list-style: none;color: #808080; padding-left:15px">

                                                            
                                                            <?php foreach ($order_detail[$i]['option_ids'] as $option) {
                                                                ?>
                                                                <li>+ <?php echo $option['name']; ?></li>
                                                            <?php }
                                                            ?>
                                                        </ul>
                                                        <?php }
                                                    ?>


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

                <tr>
                    <td>
                        <table border="0"   width="100%"  style="" >
                            <tr>
                                <td colspan="2" height="1" style="border-collapse:collapse;border-top-color:#e0e1e2;border-top-style:dashed;border-top-width:2px;font-size:0;line-height:0;padding:0"></td>
                            </tr>
                            <tr style="line-height: 0;">
                                <td>

                                    <p style="font-weight: bold;font-size: 21px;margin-left: 10px">Subtotal</p>
                                </td>
                                <td >

                                    <h1 style="text-align: right;margin-right: 10px">$<?php
                                        if ($subtotal == null || $subtotal == '') {
                                            echo '0.00';
                                        } else {
                                            echo $subtotal;
                                        }
                                        ?></h1>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" height="1" style="border-collapse:collapse;border-top-color:#e0e1e2;border-top-style:dashed;border-top-width:2px;font-size:0;line-height:0;padding:0"></td>
                            </tr>

                            <tr style="line-height: 0">
                                <td>
                                    <p style="font-weight: bold;font-size: 21px;margin-left: 10px">Tax</p>
                                </td>
                                <td>
                                    <h1 style="text-align: right;margin-right: 10px">$<?php echo $tax_amount; ?></h1>
                                </td>
                            </tr>
                            <tr style="line-height: 0">
                                <td>
                                    <p style="font-weight: bold;font-size: 21px;margin-left: 10px">Tip</p>
                                </td>
                                <td>
                                    <h1 style="text-align: right;margin-right: 10px">$<?php echo $tip_amount; ?></h1>
                                </td>
                            </tr>
                            <tr style="line-height: 0">
                                <td >
                                    <p style="font-weight: bold;font-size: 21px;margin-left: 10px">Points</p>

                                </td>
                                <td >

                                    <h1 style="text-align: right;margin-right: 10px">$
                                        <?php
                                        if ($points_dollar_amount == null || $points_dollar_amount == '') {
                                            echo '0.00';
                                        } else {
                                            echo $points_dollar_amount;
                                        }
                                        ?></h1>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" height="1" style="border-collapse:collapse;border-top-color:#e0e1e2;border-top-style:dashed;border-top-width:2px;font-size:0;line-height:0;padding:0"></td>
                            </tr>
                        </table>
                    </td>

                </tr>
                <tr>
                    <td style="">
                        <table cellpadding='0' cellspacing='0'  border="0" width="500" style="padding: 20px;border-collapse: initial;">
                            <tr  bgcolor="#EBEBEB" style="">
                                <td bgcolor="#EBEBEB">
                                    <p style="padding-left: 15px"><span style="color:#ABABAB">ORDER #</span><?php echo $order_id; ?></p>
                                    <p style="padding-left: 15px;color: #4DBEC7">ORDER IN PROCESS</p>
                                    <p style="padding-left: 15px"><span style="color:#ABABAB">AVERAGE WAITING TIME 20 MINS</span></p>
                                </td> 
                                <td><span style="color: #ABABAB;font-weight: bold;font-size: 30px">$<?php echo $total; ?></span></td>
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
                        <table  border="0" width="100%" >
                            <tr>
                                <td style="padding: 5px"><span style="color:#4DBEC7"><img src="<?php echo base_url('assets/email_templete/ic_rewards@3x.png'); ?>" width="30" height="30"></img></span></td>
                                <?php
                                $earnPoints = round($total);
                                ?>
                                <td style="padding: 5px"><span style="color:#4DBEC7">Earn <?php echo $earnPoints; ?> Reward Points</span></td>
                            </tr>
                            <tr>
                                <td style="padding: 5px"><span style="color:#4DBEC7"><img src="<?php echo base_url('assets/email_templete/ic_rewards@3x.png'); ?>" width="30" height="30"></img></span></td>
                                <td style="padding: 5px"><span style="color:#4DBEC7">You Redeem <?php echo $redeem_points; ?> Reward Points</span></td>
                            </tr>
                            <tr>
                                <td style="padding: 5px"><span style="color:#4DBEC7"><img src="<?php echo base_url('assets/email_templete/ic_heart_like@3x.png'); ?>" width="30" height="30"></img></span></td>
                                <td style="padding: 5px"><span style="color:#4DBEC7">Save Your Fevorite Items For Next Time!</span></td>
                            </tr>
                        </table>
                    </td>

                </tr>
<!--                <tr>
                    <td>
                        <table  border="0" width="510" bgcolor="4DBEC7">

                            <tr>

                                <td style="padding: 5px;text-align: right">
                                    <span  style="color:#fff;font-weight: bold;font-size: 20px;">Provide Your feedback</span>
                                </td>
                                <td style="padding: 5px;text-align: left" >
                                    <span style="color:#4DBEC7;"><a style="padding: 10px 10px 10px 10px;border-radius: 999px;display: inline-block;white-space: nowrap;vertical-align: middle; -ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;border: 2px solid transparent;;border-color: #fff" href="<?php echo base_url('index.php/rating/business_rating/?is_positive=1&orderId=' . encrypt_string($order_id)); ?>"><img src="<?php echo base_url('assets/email_templete/ic_thumb_like.png'); ?>" width="30" height="30"></img></a></span>&nbsp;&nbsp;
                                    <span style="color:#4DBEC7"><a  style="padding: 10px 10px 10px 10px;border-radius: 999px;display: inline-block;white-space: nowrap;vertical-align: middle; -ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;border: 2px solid transparent;;border-color: #fff" href="<?php echo base_url('index.php/rating/business_rating/?is_positive=0&orderId=' . encrypt_string($order_id)); ?>"><img src="<?php echo base_url('assets/email_templete/ic_thumb_unlike.png'); ?>" width="30" height="30"></img></a></span>
                                </td>


                            </tr>

                        </table>
                    </td>

                </tr>-->
            </table>


        </center>
    </body>
</html>
