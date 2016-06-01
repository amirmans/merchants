<?php
//header( 'Content-type: text/xml' );
function getDBHandler()
{
    static $dbh = 0;
    if (!$dbh) {
        $dbh = mysqli_connect ("localhost", "artdoost_admin", "id0ntknow","artdoost_taptalk") or die ('I cannot connect to the database
        because: ');
//        mysql_select_db("artdoost_taptalk", $dbh);
    }
    return $dbh;
}

function getAllFieldsWithName($dbName, $fieldName, $criteria)
{
    $dbh = getDBHandler();
    $queryString =  "SELECT $fieldName FROM $dbName where $criteria";
    $result = mysqli_query($dbh, $queryString);
    
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    
    return $rows;
}
