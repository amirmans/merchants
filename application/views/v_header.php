<div class="loading"><img src="<?php echo base_url('assets/img/loading.gif'); ?>" alt="loading-img"></div>
        <div id="top" class="clearfix">

            <!-- Start App Logo -->
            <div class="applogo">
                <a href="<?php echo base_url(); ?>" class="logo">Tap-in</a>
            </div>
          <ul class="topmenu"  style="display: block">
              &nbsp;&nbsp; <li ><a id="orderlist_tab" href="<?php echo base_url('index.php/site/orderlist'); ?>">ORDER LIST</a></li>
              <li ><a id="product_tab" href="<?php echo base_url('index.php/product'); ?>">PRODUTS</a></li>
              <li ><a id="option_tab" href="<?php echo base_url('index.php/option'); ?>">OPTIONS</a></li>


            </ul>

            <ul class="top-right">
                <li class="dropdown link">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle profilebox"><img src="<?php echo base_url('assets/img/admin.png'); ?>" alt="img"><b><?php echo  $this->session->userdata('name'); ?></b><span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-list dropdown-menu-right">
           
                        <li><a href="<?php echo base_url('index.php/profile'); ?>"><i class="fa falist fa-user"></i> Profile</a></li>
                        <li><a href="<?php echo base_url('index.php/login/logout'); ?>"><i class="fa falist fa-power-off"></i> Logout</a></li>
                    </ul>
                </li>

            </ul>
            <!-- End Top Right -->

        </div>