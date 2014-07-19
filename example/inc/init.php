<?
error_reporting(-1);
require_once("count.class.php");
require_once("config.php");
    //Create a instace of our class.
    if($count = new Count(
    $Config['Mysql']['Host'],
    $Config['Mysql']['Username'],
    $Config['Mysql']['Password'],
    $Config['Mysql']['Database'])){
    
    }else{
        die("Mysql Error");
    }
    
