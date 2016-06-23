<?php for ($i = 0; $i < count($orderlist); $i++) {
    ?>
    <li onclick="display_order_detail('<?php echo $orderlist[$i]['order_id']; ?>')">
        <a href="javascript:void(0)"  id="order_id_<?php echo $orderlist[$i]['order_id']; ?>"  class="item clearfix <?php
        if ($i == 0) {
            //echo 'active_detail_order';
        }
        ?>" >

            <?php if ($orderlist[$i]['status'] == "1") {
                ?>
                <img src="<?php echo base_url('assets/img/ic_error@3x.png'); ?>" alt="img" class="img">
            <?php } elseif ($orderlist[$i]['status'] == "2") {
                ?>
                <img src="<?php echo base_url('assets/img/ic_reload@3x.png'); ?>" alt="img" class="img">

            <?php } elseif ($orderlist[$i]['status'] == "3") {
                ?>
                <img src="<?php echo base_url('assets/img/ic_check_active@3x.png'); ?>" alt="img" class="img">
                <?php
            }
            ?>

            <span class="from">#<?php echo $orderlist[$i]['order_id']; ?></span>
            <span class="from" ><?php echo $orderlist[$i]['nickname']; ?></span>
            <span class="date"><?php echo $orderlist[$i]['no_items']; ?> items</span>
            <span class="time"><?php echo time_elapsed_string($orderlist[$i]['seconds']); ?></span>
        </a>
    </li>
<?php } ?>