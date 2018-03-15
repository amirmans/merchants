<?php
/**
 * This file contains wrapper widget for date range picker
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */

namespace koolreport\inputs;

use \koolreport\core\Utility;

class DateRangePicker extends InputControl
{

    protected $format;
    protected $ranges;
    protected $locale;

    protected function resourceSettings()
    {
        return array(
            "folder"=>"bower_components",
            "js"=>array(
                "moment/moment.min.js",
                "daterangepicker/daterangepicker.js",
            ),
            "css"=>array(
                "daterangepicker/daterangepicker.css",
                "daterangepicker/extra.css",    
            )
        );
    }
    

    protected function onInit()
    {
        parent::onInit();
        if($this->value===null)
        {
            $this->value = array(date("Y-m-d 00:00:00"),date("Y-m-d 23:59:59"));
        }
        else
        {
            $start = new \DateTime($this->value[0]);
            $end = new \DateTime($this->value[1]);

            $this->value = array($start->format("Y-m-d H:i:s"),$end->format("Y-m-d H:i:s"));
        }



        $this->format = Utility::get($this->params,"format");
        $this->useLanguage();
        $this->locale = $this->languageMap;
        if($this->locale!==null)
        {
            if($this->format===null)
            {
                $this->format = Utility::get($this->locale,"format","MMM Do, YYYY");
                $this->locale["format"] = $this->format;
            }
            else
            {
                $this->locale["format"] = $this->format;
            }    
        }
        else
        {
            if($this->format===null)
            {
                $this->format = "MMM Do, YYYY";
            }
            $this->locale = array(
                'format'=>$this->format,
            );
        }

        $this->ranges = Utility::get($this->params,"ranges",array(
            "Today"=>DateRangePicker::today(),
            "Yesterday"=>DateRangePicker::yesterday(),
            "Last 7 days"=>DateRangePicker::last7days(),
            "Last 30 days"=>DateRangePicker::last30days(),
            "This month"=>DateRangePicker::thisMonth(),
            "Last month"=>DateRangePicker::lastMonth(),
        ));
    }

    protected function renderRanges()
    {
        $res = "";
        foreach($this->ranges as $name=>$value)
        {
            $res.= "'$name':[moment('".$value[0]."'),moment('".$value[1]."')],";
        }
        return "{{$res}}";
    }

    static function today()
    {
        $now = new \DateTime('now');
        return array($now->format('Y-m-d 00:00:00'),$now->format('Y-m-d 23:59:59'));
    }
    static function yesterday()
    {
        $now = new \DateTime('now');
        $now->sub(new \DateInterval('P1D'));
        return array($now->format('Y-m-d 00:00:00'),$now->format('Y-m-d 23:59:59'));
    }
    static function last7days()
    {
        $start = new \DateTime('now');
        $end = new \DateTime('now');
        $start->sub(new \DateInterval('P6D'));
        return array($start->format('Y-m-d 00:00:00'),$end->format('Y-m-d 23:59:59'));
    }
    static function last30days()
    {
        $start = new \DateTime('now');
        $end = new \DateTime('now');
        $start->sub(new \DateInterval('P30D'));
        return array($start->format('Y-m-d 00:00:00'),$end->format('Y-m-d 23:59:59'));
    }
    static function thisMonth()
    {
        $start = new \DateTime('now');
        $end = new \DateTime('now');
        $end->add(new \DateInterval('P30D'));
        $end = new \DateTime($end->format('Y-m-1'));
        $end->sub(new \DateInterval('P1D'));
        return array($start->format('Y-m-1 00:00:00'),$end->format('Y-m-d 23:59:59'));
    }
    static function lastMonth()
    {
        $start = new \DateTime('now');
        $end = new \DateTime('now');
        $end = new \DateTime($end->format('Y-m-1 23:59:59'));
        $end->sub(new \DateInterval('P1D'));
        $start = new \DateTime($end->format('Y-m-1'));
        return array($start->format('Y-m-1 00:00:00'),$end->format('Y-m-d 23:59:59'));
    }
}