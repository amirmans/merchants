<textarea id="<?php echo $this->name; ?>" name="<?php echo $this->name; ?>" <?php
    foreach($this->attributes as $name=>$value)
    {
        echo "$name='$value' ";
    }
?>><?php echo $this->value; ?></textarea>
<?php
if(count($this->clientEvents)>0)
{
?>
<script type="text/javascript">
<?php
    foreach($this->clientEvents as $name=>$function)
    {
    ?>
    $("#<?php echo $this->name ?>").on('<?php echo $name ?>',<?php echo $function; ?>);
    <?php
    }
?>
</script>
<?php    
}
?>