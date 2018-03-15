<select id="<?php echo $this->name; ?>" multiple name="<?php echo $this->name; ?>[]" <?php
foreach($this->attributes as $name=>$value)
{
    echo "$name='$value'";
}
?> >
<?php
foreach($this->data as $item)
{
    $value = $item["value"];
    $text = $item["text"];
?>
    <option value="<?php echo $value; ?>" <?php echo in_array($value,$this->value)?"selected":""; ?>><?php echo $text; ?></option>
<?php
}
?>
</select>
<script type="text/javascript">
    $('#<?php echo $this->name; ?>').select2(<?php echo json_encode($this->options);?>);
    <?php
    if($this->clientEvents)
    {
        foreach($this->clientEvents as $name=>$function)
        {
        ?>
        $('#<?php echo $this->name; ?>').on('<?php echo $name ?>',<?php echo $function; ?>);
        <?php
        }
    }
    ?>    
</script>