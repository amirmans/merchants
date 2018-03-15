<select id="<?php echo $this->name; ?>" <?php if($this->multiple) echo 'multiple="multiple"'; ?> name="<?php echo $this->name.($this->multiple?"[]":""); ?>"
<?php
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
    <option value="<?php echo $value; ?>" <?php echo (($this->multiple)?in_array($value,$this->value):($value==$this->value))?"selected":""; ?>><?php echo $text; ?></option>
<?php
}
?>
</select>
<script type="text/javascript">
    $('#<?php echo $this->name;?>').multiselect(<?php echo json_encode($this->options); ?>);
</script>