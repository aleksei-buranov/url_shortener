<?php
try {
  $pdo = new PDO('mysql:host=localhost;dbname=lesha', 'root','password');
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
  $h = "QqWwEeRrTtYyUuIiOoPpAaSsDdFfGgHhJjKkLlZzXxCcVvBbNnMm1234567890";
  $rand = substr(str_shuffle($h), 0, 10);
  $url = htmlentities($_POST['url']);


  //SUBMIT
  if ($url) {
    $stmt = $pdo->prepare('Select * from short_urls where long_url=:url');
    $stmt->bindParam(":url",$url);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_OBJ);
    if(!$res){
      $stmt = $pdo->prepare('Select * from short_urls where hash=:hash');
      $stmt->bindParam(":hash",$rand);
      $stmt->execute();
      $res = $stmt->fetch();
      if($res){
        echo "Такой хэш уже существует! Попробуйте отправить данные еще раз!";
        exit();
      }

      $stmt = $pdo->prepare("Insert into short_urls (long_url, hash) VALUES(:url,:hash)");
      $stmt->bindParam(":url",$url);
      $stmt->bindParam(":hash",$rand);
      $stmt->execute();
    }
    else {
      $rand = $res->hash;
    }
    echo "<strong><a href='$rand' target='_blank'>Short link</a></strong>";
  }

  //GET HASH
  $hash = $_GET['hash'];
  if(!empty($hash)){
  $stmt = $pdo->prepare('Select * from short_urls where hash=:hash');
  $stmt->bindParam(":hash",$hash);
  $stmt->execute();
  $res = $stmt->fetch(PDO::FETCH_OBJ);
  header("Location: $res->long_url");
}
?>
