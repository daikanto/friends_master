<?php  
 //1:DBへの接続
    $dsn='mysql:dbname=myfriends;host=localhost';
    $user='root';
    $password='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');
    //2:DBからareaテーブルの情報をarea_idを利用してレコードを取得
    //$_GET=array('area_id'=>20);
    if(!empty($_GET)&&($_GET['action']=='delete'))
    {
    //SQL文でDELETEを実行
    $sql = "DELETE FROM `friends` where `friend_id`=".$_GET['id'];//delete文
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    //index.phpに画面遷移を行う
   header('Location: index.php');//削除後、bbs.phpに戻る

    

    }

    echo '<br>';
    echo '<br>';
    


   $dbh=null;

?>   

