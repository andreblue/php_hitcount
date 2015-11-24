<?php
  if(isset($_POST['submit']) && !empty($_POST['submit']) && $_POST['submit'] == "Log In"){
    if(isset($_POST['username']) && !empty($_POST['username']) && $_POST['username'] === $Config['Access']['Username']){
      if(isset($_POST['password']) && !empty($_POST['password']) && md5($_POST['password']) === $Config['Access']['Password']){
        $_SESSION["STATUS"] = true;
        ?>
        <head>
           <!-- HTML meta refresh URL redirection -->
           <meta http-equiv="refresh"
           content="0; url=index.php">
        </head>
        <div class="content">
          <h2>Logging you in, and redirecting you back to the main page.</h2>
        </div>

        <?php
      }
    }else{
      ?>
      <h2 style="color: red;">Invaild Username or Password. Please try again.</h2>
      <form action="" method="POST">
          <input type="text" name="username" placeholder="Username">
          <input type="password" name="password" placeholder="Password">
          <input type="submit" name="submit" value="Log In">
      </form>

      <?php
    }

  }else{

 ?>



<form action="" method="POST">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" name="submit" value="Log In">
</form>
<?php
}
  #print_r($_POST);
 ?>
