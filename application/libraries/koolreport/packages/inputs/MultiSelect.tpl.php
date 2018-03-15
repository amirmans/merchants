<select multiple name="<?php echo $this->name; ?>[]" <?php
foreach($this->attributes as $name=>$value)
{
    echo "$name='$value'";
}
?> >
<?php
foreach($this->data as $item)
{
    $value=$item["value"];
    $text=$item["text"];
?>
    <option value="<?php echo $value; ?>" <?php echo in_array($value,$this->value)?"selected":""; ?>><?php echo $text; ?></option>
<?php
}
?>
</select>
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