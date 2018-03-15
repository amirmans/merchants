<?php
foreach($this->data as $item)
{
    $value = $item["value"];
    $text = $item["text"];
?>
    <div class="<?php echo $this->display=="horizontal"?"checkbox-inline":"checkbox"; ?>">
        <label>
            <input type="checkbox" aName="<?php echo $this->name; ?>" name="<?php echo $this->name."[]"; ?>" value="<?php echo $value ?>" <?php echo(in_array($value,$this->value))?"checked":""; ?>>
            <?php echo $text; ?>
        </label>
    </div>
<?php
}
?>
<script type="text/javascript">
var <?php echo $this->name; ?> = new CheckBoxList("<?php echo $this->name; ?>");
<?php
if($this->clientEvents)
{
    foreach($this->clientEvents as $eventName=>$function)
    {
    ?>
        <?php echo $this->name; ?>.on('<?php echo $eventName; ?>',<?php echo $function; ?>);
    <?php
    }    
}
?>
</script>