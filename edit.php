<?php  
 //1:DBへの接続
    $dsn='mysql:dbname=myfriends;host=localhost';
    $user='root';
    $password='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');
 //都道府県の選択
    $sql='SELECT*from `areas` WHERE 1';

    $stmt=$dbh->prepare($sql);
    $stmt->execute();

    //$recordデータ格納用の配列
    $areas = array();


    //3:取得したareaテーブルの情報を表示
    while (1) {
        //$
        $record=$stmt->fetch(PDO::FETCH_ASSOC);
        if ($record==false){
            break;
        }
        $areas[]=$record;
        //echo $record['area_name'];
        //echo '<br>';
    }


 //2:editボタンをおしたときにDBから取り出す
    if(!empty($_GET)&&($_GET['action']=='edit'))
    {
    $sql='SELECT*from `friends` where `friend_id`='.$_GET['id'];
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    //$recordデータ格納用の配列
    $friend=array();


//3:取得したareaテーブルの情報を表示
    $friend=$stmt->fetch(PDO::FETCH_ASSOC);


    }
//4 更新ボタンを押したときにupdate文を実行
    if(!empty($_POST))
    {
        //各更新データを代入
        $friend_name=$_POST['name'];
        $area_id=$_POST['area_id'];
        $gender=$_POST['gender'];
        $age=$_POST['age'];

        $sql="UPDATE `friends` SET `friend_name`='"."$friend_name"."',`area_id`='"."$area_id"."',`gender`='"."$gender"."',`age`='"."$age"."',`modified`='"."now()"."' WHERE `friend_id`=".$_GET['id'];
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        header('Location: index.php');//更新ボタンを押したときにupdate文を実行後、bbs.phpに戻る



    }
    //echo '<br>';
    //var_dump($friend);



    


 //3:DB登録

    $dbh=null;

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
        <legend>友達の編集</legend>
        <form method="post" action="" class="form-horizontal" role="form">
            <!-- 名前 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">名前</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control" placeholder="なまえ" value="<?php  echo $friend["friend_name"]; ?>">
              </div>
            </div>
            <!-- 出身 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">出身</label>
              <div class="col-sm-10">
                <select class="form-control" name="area_id" name="area_id">
                    <?php foreach ($areas as $area): 
                     if ($friend['area_id']==$area['area_id'])
                      { ?>
                          <option value="<?php echo $area['area_id']; ?>" selected><?php echo $area['area_name']; ?>  </option>
                      <?php } 

                     else
                      { ?> 
                          <option value="<?php echo $area['area_id']; ?>"><?php echo $area['area_name']; ?></option>
                      <?php } ?>
                    <?php endforeach; ?>
                </select>

              </div>
            </div>
            <!-- 性別 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">性別</label>
              <div class="col-sm-10">
                <select class="form-control" name="gender">

                  <option>性別を選択</option>
                  <!--if文でselectedをつけるのを選択する
                  if 男性
                  else 女性

                  -->

            <?php   
                  if($friend['gender']==1){ ?>
                  <option value="1" selected>男性</option>
                  <option value="2" >女性</option>                  
                  <?php } 

                  elseif($friend['gender']==2) { ?>
                  <option value="1">男性</option>
                  <option value="2" selected>女性</option>
            <?php } ?>

                </select>
              </div>
            </div>
            <!-- 年齢 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">年齢</label>
              <div class="col-sm-10">
                <input type="text" name="age" class="form-control" placeholder="齢" value="<?php echo $friend["age"];?>">
              </div>
            </div>

          <input type="submit" class="btn btn-default" value="更新">
        </form>
      </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
