<div id="<?php echo $this->name; ?>" class="date-range-picker form-control">
    <input id="<?php echo $this->name; ?>_start" name="<?php echo $this->name; ?>[]" type="hidden" />
    <input id="<?php echo $this->name; ?>_end" name="<?php echo $this->name; ?>[]" type="hidden" />
    <div style="position:relative;">
        <i class="glyphicon glyphicon-calendar"></i>
        <span></span>
        <b class="caret"></b>
    </div>
</div>
<script type="text/javascript">
$(function(){
    var start = moment('<?php echo $this->value[0];?>','YYYY-MM-DD HH:mm:ss');
    var end = moment('<?php echo $this->value[1];?>','YYYY-MM-DD HH:mm:ss');

    $('#<?php echo $this->name; ?>').daterangepicker({
        startDate:start,
        endDate:end,
        locale:<?php echo json_encode($this->locale); ?>,
        ranges:<?php echo $this->renderRanges(); ?>,
    },cb);
<?php
if($this->clientEvents)
{
    foreach($this->clientEvents as $eventName=>$function)
    {
    ?>
    $('#<?php echo $this->name; ?>').on("<?php echo $eventName; ?>.daterangepicker",<?php echo $function; ?>);
    <?php
    }
}
?>
    function cb(start, end) {
        $('#<?php echo $this->name; ?>_start').val(start.format("YYYY-MM-DD HH:mm:ss"));
        $('#<?php echo $this->name; ?>_end').val(end.format("YYYY-MM-DD HH:mm:ss"));
        $('#<?php echo $this->name; ?> span').html(start.format('<?php echo $this->format; ?>') + ' - ' + end.format('<?php echo $this->format; ?>'));
    }
    cb(start,end);
});
</script>