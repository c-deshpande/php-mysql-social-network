<?php 
  session_start();

  if (!empty($_GET['username']) && !empty($_GET['password'])) {
    try {
      $dbh = new PDO("mysql:host=127.0.0.1:1111;dbname=","","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      $dbh->beginTransaction();
      $username = $_GET["username"];
      $password = md5($_GET["password"]);
      $stmt = $dbh->prepare('select * from users where username="'.$username.'" and password="'.$password.'"');
      $stmt->execute();
      $count = $stmt->rowCount();
      while ($row = $stmt->fetch()) {
        $fullName = $row["fullname"];
        $userEmail = $row["email"];
      }
      if ($count == 1) {
        $_SESSION['user'] = $username;
        $_SESSION['nameOfUser'] = $fullName;
        $_SESSION['email'] = $userEmail;
        header("location: network.php");
      } else {
        header("location: login.php");
      } 
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <style>
    .login-page {
      width: 360px;
      padding: 8% 0 0;
      margin: auto;
    }

    .form {
      position: relative;
      z-index: 1;
      background: #FFFFFF;
      max-width: 360px;
      margin: 0 auto 100px;
      padding: 45px;
      text-align: center;
      box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
    }

    .form input {
      font-family: 'Montserrat', sans-serif;
      outline: 0;
      background: #f2f2f2;
      width: 100%;
      border: 0;
      margin: 0 0 15px;
      padding: 15px;
      box-sizing: border-box;
      font-size: 14px;
    }

    button {
      font-family: 'Montserrat', sans-serif;
      text-transform: uppercase;
      outline: 0;
      width: 100%;
      border: 0;
      padding: 15px;
      background-color: #4b525b;
      font-size: 14px;
      cursor: pointer;
      color: white;
    }

    body {
      background-color: #1f2833;
      font-family: 'Montserrat', sans-serif;
    }
  </style>
</head>
<body>
  <div class="login-page">
    <div class="form">
      <h3 style="text-align: center;">A Social Network using PHP and MySQL</h3>
      <form class="login-form" action="">
        <input type="text" placeholder="username" name="username"/>
        <input type="password" placeholder="password" name="password"/>
        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</body>
</html>