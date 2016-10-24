	<?php 
	//1:DBへの接続
	    $dsn='mysql:dbname=myfriends;host=localhost';
	    $user='root';
	    $password='';
	    $dbh = new PDO($dsn, $user, $password);
	    $dbh->query('SET NAMES utf8');
	 //関数を使ったsql文の実行

	    $sql="SELECT COUNT(`friend_id`) FROM `friends` WHERE `area_id`=1";
	    $stmt=$dbh->prepare($sql);
	    $stmt->execute();

	    
        $record=$stmt->fetch(PDO::FETCH_ASSOC);
        $count[]=$record;
	    var_dump($count);
		




 	?>