<?php
require APPPATH."/libraries/koolreport/autoload.php";

class BaseReport extends \koolreport\KoolReport
{
    function settings()
    {
        return array(
            "assets"=>array(
                "path"=>"../../assets",
                "url"=>base_url()."assets",
            ),
            "dataSources"=>array(
                "Corp"=>array(
                    "connectionString"=>"mysql:host=localhost;dbname=artdoost_local_tapin",
                    "username"=>"artdoost_dbadmin",
                    "password"=>"id0ntknow",
                    "charset"=>"utf8"
                )
            )
        );
    }
}