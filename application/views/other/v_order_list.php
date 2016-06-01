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
            <div class="container-mail">
                <div class="mailbox clearfix">
                    <div class="container-mailbox">

                        <div class="col-lg-3 col-md-4 padding-0">
                            <ul class="order-list">


                                <li class="order-menu">
                                    <div class="row">
                                        <div class="col-md-1"></div> 
                                        <div class="col-md-5"><span class=""><h5>ORDERS</h5></span></div> 
                                        <div class="col-md-6 text-right"><select class="selectpicker" style="margin: 10px 24px;">
                                                <option>All</option>
                                            </select>   </div> 
                                    </div>
                                </li> 
                                <li>
                                    <a href="#" class="item clearfix">
                                        <img src="<?php echo base_url('assets/img/ic_error@3x.png'); ?>" alt="img" class="img">
                                        <span class="from">#44447</span>
                                        <span class="from" >Bruce</span>
                                        <span class="date">9 items</span>
                                        <span class="time">1 min</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="item clearfix">
                                        <img src="<?php echo base_url('assets/img/ic_error@3x.png'); ?>" alt="img" class="img">
                                        <span class="from">#44446</span>
                                        <span class="from">Dawn</span>
                                        <span class="date">2 items</span>
                                        <span class="time">3 min</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="item clearfix">
                                        <img src="<?php echo base_url('assets/img/ic_reload@3x.png'); ?>" alt="img" class="img">
                                        <span class="from">#44445</span>
                                        <span class="from">Sajal</span>
                                        <span class="date">2 items</span>
                                        <span class="time">4 min</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="item clearfix">
                                        <img src="<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>" alt="img" class="img">
                                        <span class="from">#444444</span>
                                        <span class="from">Melinda C.</span>
                                        <span class="date">3 items</span>
                                        <span class="time">6 min</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="item clearfix">
                                        <img src="<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>" alt="img" class="img">
                                        <span class="from">#44443</span>
                                        <span class="from">Tim</span>
                                        <span class="date">5 items</span>
                                        <span class="time">10 min</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="item clearfix">
                                        <img src="<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>" alt="img" class="img">
                                        <span class="from">#44442</span>
                                        <span class="from">Zim E.</span>
                                        <span class="date">3 items</span>
                                        <span class="time">14 min</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="item clearfix">
                                        <img src="<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>" alt="img" class="img">
                                        <span class="from">#44441</span>
                                        <span class="from">Hernando.</span>
                                        <span class="date">2 item</span>
                                        <span class="time">18 min</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="item clearfix">
                                        <img src="<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>" alt="img" class="img">
                                        <span class="from">#44440</span>
                                        <span class="from">Boss.</span>
                                        <span class="date">2 item</span>
                                        <span class="time">22 min</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="item clearfix">
                                        <img src="<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>" alt="img" class="img">
                                        <span class="from">#44439</span>
                                        <span class="from">Sophia M.</span>
                                        <span class="date">21 item</span>
                                        <span class="time">39 min</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="item clearfix">
                                        <img src="<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>" alt="img" class="img">
                                        <span class="from">#44438</span>
                                        <span class="from"> Herm.</span>
                                        <span class="date">1 item</span>
                                        <span class="time">47 min</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <!-- End Mailbox Inbox -->

                        <!-- Start Chat -->
                        <div class="chat col-lg-9 col-md-8 padding-0">


                            <div class="invoice invoice-row">

                                <div class="line row">
                                    <div class="col-md-6 col-xs-6 padding-0 text-left">
                                        <h4><span class="badge"><i class="fa fa-check"></i> </span> Order Completed</h4>
                                        <h2>Jonathan Doe</h2>
                                    </div>
                                    <div class="col-md-6 col-xs-6 padding-0 text-right">
                                        <h4></h4>
                                        <h2><i class="fa-sort-desc"></i></h2>
                                    </div>
                                </div>

                                <table class="table">
                                    <thead class="title">
                                        <tr>
                                            <td>TASK DESCRIPTION</td>
                                            <td>HOURS</td>
                                            <td>RATE PER HOUR</td>
                                            <td class="text-right">TOTAL</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Ipad Application Design <p>Designed an app learning colors<br>for children</p></td>
                                            <td>20</td>
                                            <td>$ 90,00</td>
                                            <td class="text-right">$ 1.800,00</td>
                                        </tr>
                                        <tr>
                                            <td>Logo Design <p>Designed a logo for happy company</td>
                                            <td>10</td>
                                            <td>$ 50,00</td>
                                            <td class="text-right">$ 500,00</td>
                                        </tr>
                                        <tr>
                                            <td>iOS Application <p>Designed an iOs app for iPhone</td>
                                            <td>40</td>
                                            <td>$ 50,00</td>
                                            <td class="text-right">$ 2.000,00</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"></td>
                                            <td class="text-right">TOTAL<h4 class="total">$ 4.300,00</h4></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="bottomtext">
                                    <button class="btn btn-default"  data-toggle="modal" data-target="#payment_model" >Pay</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <?php $this->load->view('v_footer'); ?>

        </div>

        <div class="modal fade" id="payment_model" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Payment</h4>
                    </div>
                    <form>
                        <div class="modal-body">

                            <div class="form-group">

                                <div class="col-sm-12">

                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-credit-card"></i></div>
                                        <input type="text" class="form-control" id="exampleInputAmount" placeholder="Card number">
                                    </div>
                                </div>

                            </div>
                            <br>    
                            <div class="form-group">

                                <div class="col-sm-6">

                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control" id="exampleInputAmount" placeholder="MM/YY">
                                    </div>
                                </div>
                                  <div class="col-sm-6">

                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                        <input type="text" class="form-control" id="exampleInputAmount" placeholder="CSV">
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-default">Pay $200</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <?php $this->load->view('v_script'); ?>







    </body>
</html>