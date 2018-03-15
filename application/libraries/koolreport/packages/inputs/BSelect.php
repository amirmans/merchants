<?php
/**
 * This file contains class to handle Bootrap MultiSelect
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */

namespace koolreport\inputs;
use \koolreport\core\Utility;

class BSelect extends InputControl
{
    use InputSelectData;
    protected $placeholder;
    protected $data;
    protected $dataBind;
    protected $options;
    protected $multiple=false;

    protected function resourceSettings()
    {
        return array(
            "folder"=>"bower_components",
            "js"=>array("bootstrap-multiselect/bootstrap-multiselect.js"),
            "css"=>array("bootstrap-multiselect/bootstrap-multiselect.css")
        );
    }


    protected function onInit()
    {
        parent::onInit();

        $this->multiple = Utility::get($this->params,"multiple",false);

        $this->defaultOption = Utility::get($this->params,"defaultOption",null);
        if($this->data==null)
        {
            $this->data = $this->getBindingData();
        }
        else 
        {
            $this->data = $this->parseDirectData($this->data);
        }
        
        if($this->defaultOption)
        {
            $this->data = array_merge($this->parseDirectData($this->defaultOption),$this->data);
        }

        if($this->multiple===true && $this->value===null)
        {
            $this->value = array();
        }
        $this->options = Utility::get($this->params,"options",array());

        $this->placeholder = Utility::get($this->params,"placeholder");
        if($this->placeholder!=null)
        {
            $this->attributes["placeholder"] = $this->placeholder;
        }
    }
}