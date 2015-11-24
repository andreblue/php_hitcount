<?php
    require_once('inc/config.php');
    $dsn = 'mysql:dbname='.$Config['Mysql']['Database'].';host='.$Config['Mysql']['Host'] ;
    try{
        $Database = new PDO($dsn, $Config['Mysql']['User'], $Config['Mysql']['Password']);
    }catch (PDOException $e){
         die("[Error][Grave]MYSQL Connect Error: ". $e->getMessage());
    }
    session_start();
    //Header Info
        require_once('header.base.php');
    if(isset($_SESSION['STATUS']) && !empty($_SESSION['STATUS']) && $_SESSION['STATUS'] === true){
        if(!isset($_GET['page']) or empty($_GET['page'])){
          require_once('inc/main.base.php');
        }elseif(!empty($_GET['page'])){
          $page = $_GET['page'];
          if($page == "history"){
            require_once('inc/history.base.php');
          }elseif($page == "pages"){
            require_once('inc/pages.base.php');
          }elseif($page == "logout"){
            require_once('inc/logout.base.php');
          }
        }

    }else{
        require_once('inc/login.base.php');
    }
