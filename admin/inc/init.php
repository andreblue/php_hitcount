<?
    require_once('config.php');
    $dsn = 'mysql:dbname='.$Config['Mysql']['Database'].';host='.$Config['Mysql']['Host'] ;
    try{
        $Database = new PDO($dsn, $Config['Mysql']['User'], $Config['Mysql']['Password']);
    }catch (PDOException $e){
         die("[Error][Grave]MYSQL Connect Error: ". $e->getMessage());
    }
    session_start();
    //Header Info
        require_once('header.base.php');
    $_SESSION['STATUS'] = true;
    if($_SESSION['STATUS'] === true){
    }else{
        require_once('login.base.php');
    }
    