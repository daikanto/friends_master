<?php  
 //1:DBへの接続
    $dsn='mysql:dbname=myfriends;host=localhost';
    $user='root';
    $password='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');
    //2:DBからareaテーブルの情報をarea_idを利用してレコードを取得
    //$_GET=array('area_id'=>20);
    $area_id=$_GET['area_id'];

    $sql='SELECT`area_name`from `areas` where `area_id`='.$area_id;

    $stmt=$dbh->prepare($sql);
    $stmt->execute();

 //1レコード分しか取得しないのでfetchも一回でいい
    $area=$stmt->fetch(PDO::FETCH_ASSOC);
   // var_dump($area);
   

    //friends テーブルから$area_idを使って友達を選択する
    $sql='SELECT `friend_id`,`friend_name`,`gender`from `friends` where `area_id`='.$area_id;


    $stmt=$dbh->prepare($sql);
    $stmt->execute();


    $friend= array();
    while (1) {
      $rec=$stmt->fetch(PDO::FETCH_ASSOC);
      if($rec==false){
        break;
      }
       $friend[]=$rec;//配列に代入することを忘れない

      // var_dump($friend); //<pre>タグはインデントのテキストが出力される

      }

      $sum_friend=0;
      $sum_boys=0;
      $sum_girls=0;



      //男女の人数をカウント、全体のカウント
      foreach ($friend as $count)
       {
          if ($count['gender']==1) {
            $sum_boys++;
          }
          elseif ($count['gender']==2) {
            $sum_girls++;
          }
          
       }
    $sum_friend=$sum_boys+$sum_girls;

    //echo $sum_friend;

    //削除ボタンを押したときのactionの値とidを取得
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
    



?>   

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>myFriends</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/form.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.html"><span class="strong-title"><i class="fa fa-facebook-square"></i> My friends</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4 content-margin-top">
      <legend><?php echo $area['area_name']; ?>の友達</legend>
      <div class="well">男性：<?php echo $sum_boys;?>名 女性：<?php echo $sum_girls;?>名</div>
        <table class="table table-striped table-hover table-condensed">
          <thead>
            <tr>
              <th><div class="text-center">名前</div></th>
              <th><div class="text-center"></div></th>
            </tr>
          </thead>
          <tbody>
           <?php foreach ($friend as $friend_list): ?>
            
            <!-- 友達の名前を表示 -->
            <tr>
              <td><div class="text-center"><?php echo $friend_list['friend_name']; ?></div></td>
              <td>
                <div class="text-center">
                  <a href="edit.php"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                  <!--href="javascript:void(0);ってなんぞや-->
                  <!--idを削除ボタンを押したときに値を送信 OK-->
                  <a href="show.php?id=<?php echo $friend_list['friend_id'];?>&action=delete" onclick="destroy();"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>  
            
          </tbody>
        </table>
        <input type="button" class="btn btn-default" value="新規作成" onClick="location.href='new.php'">
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
