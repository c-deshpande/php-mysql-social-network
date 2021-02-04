<?php
  session_start();

  if (!isset($_SESSION['user']) && !isset($_SESSION['nameOfUser']) && !isset($_SESSION['email'])) {
    header('location: login.php');
  } else {
    try {
      $dbh = new PDO("mysql:host=127.0.0.1:1111;dbname=","","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      $stmt = $dbh->prepare('select * from users where users.username not in (select friend from friends where user="'.$_SESSION['user'].'") and not username="'.$_SESSION['user'].'"');
      $stmt->execute();
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }
  
    if (!empty($_GET['add'])) {
      try {
        $dbh->beginTransaction();
        $dbh->exec('delete from friends where user="'.$_SESSION["user"].'" and friend="'.$_GET["add"].'"');
        $dbh->exec('insert into friends values("'.$_SESSION["user"].'", "'.$_GET["add"].'")')
          or die(print_r($dbh->errorInfo(), true));
        $dbh->exec('insert into friends values("'.$_GET["add"].'", "'.$_SESSION["user"].'")')
          or die(print_r($dbh->errorInfo(), true));
        $dbh->commit();
      } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
      }
    }
  
    if (!empty($_GET['remove'])) {
      try {
        $dbh->beginTransaction();
        $dbh->exec('delete from friends where user="'.$_SESSION["user"].'" and friend="'.$_GET['remove'].'"');
        $dbh->exec('delete from friends where user="'.$_GET["remove"].'" and friend="'.$_SESSION['user'].'"');
        $dbh->commit();
      } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
      }
    }
  
    if (!empty($_GET['logout'])) {
      session_unset();
      session_destroy();
  
      header('location: login.php');
    }
  
    $getFriends = $dbh->prepare('select * from users, friends where users.username = friends.friend and friends.user = "'.$_SESSION["user"].'"');
    $getFriends->execute();
  
    $stmt = $dbh->prepare('select * from users where users.username not in (select friend from friends where user="'.$_SESSION['user'].'") and not username="'.$_SESSION['user'].'"');
    $stmt->execute();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Network</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <style>
    body {
      display: flex;
      flex-direction: column;
      margin: 0;
      background-color: #1f2833;
      font-family: 'Montserrat', sans-serif;
      min-height: 100vh;
    }
  
    main {
      display: flex;
      color: white;
      flex-grow: 1;
    }

    profile {
      flex-basis: 60%;
      background-color: #151c23;
      flex-grow: 1;
    }

    left {
      flex-basis: 20%;
      order: -1;
      background-color: #1f2833;
      position: relative;
      flex-grow: 1;
    }

    right {
      flex-basis: 20%;
      background-color: #1f2833;
      flex-grow: 1;
      min-height: 0;
      position: relative;
    }

    .dataitemcontainer {
      position: absolute; 
      padding:10px; 
      top: 0; 
      bottom: 0; 
      left: 0; 
      right: 0;
      overflow: auto;
    }

    button {
      font-family: 'Montserrat', sans-serif;
      text-transform: uppercase;
      background-color: #4b525b;
      padding: 5px;
      cursor: pointer;
      color: white;
      border: none;
    }

    @media all and (max-width: 640px) {
      main {
        flex-direction: column;
        flex-grow: 1;
      }
      
      nav {
        order: 0;
      }
      
      header, footer {
        flex-basis: 50px;
      }
    }

  </style>
</head>
<body>
    <main>
      <profile>
        <div style="padding: 10px; text-align: center;">
          <h1><?php print $_SESSION['nameOfUser']; ?></h1>
          <p>Username: <?php print $_SESSION['user']; ?></p>
          <p>Email: <?php print $_SESSION['email']; ?></p>
          <a href="network.php?logout=<?php print $_SESSION["user"]; ?>"><button>Logout</button></a>
        </div>
      </profile>
      <left>
        <div class="dataitemcontainer">
          <h2 style="text-align:center;">Friends</h3>
          <?php
            while ($friend = $getFriends->fetch()) { ?>
              <div>
                <p><span style="font-weight: bold;"><?php print $friend['fullname']; ?></span> (<?php print $friend['username']; ?>)</p>
                <p><?php print $friend['email']; ?></p>
                <a href="network.php?remove=<?php print $friend['username']; ?>"><button>Remove</button></a>
              </div>
              <br>
              <hr>
              <?php
            }
          ?>
        </div>
      </left>
      <right>
        <div class="dataitemcontainer">
          <h2 style="text-align:center;">Others</h3>
          <?php
            while ($row = $stmt->fetch()) { ?>
              <div>
                <p><span style="font-weight: bold;"><?php print $row['fullname']; ?></span> (<?php print $row['username']; ?>)</p>
                <p><?php print $row['email']; ?></p>
                <a href="network.php?add=<?php print $row['username']; ?>"><button>Add Friend</button></a>
              </div>
              <br>
              <hr>
              <?php
            }
          ?>
        </div>
      </right>
    </main>
</body>
</html>