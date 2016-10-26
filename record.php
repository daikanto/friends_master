<?php 
    //1:DBへの接続
    $dsn='mysql:dbname=myfriends;host=localhost';
    $user='root';
    $password='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');
//2:DBからareaテーブルの情報を表示
//DB名、テーブル名、カラム名はアクサングラーブで囲む：省略可
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
    //var_dump($areas);
    echo '<br>';
    echo '<br>';
    echo '<br>';
    //echo count($areas);



//post送信が行われたとき
    if(!empty($_POST)){
//htmlの変数をphp変数に代入する
    $friend_name=$_POST['name'];
    $area_id=$_POST['area_id'];
    $gender=$_POST['gender'];
    $age=$_POST['age'];
    //modifiedのカラムの登録が行われてしまう
    $sql = "INSERT INTO `friends`(`friend_id`, `friend_name`, `area_id`, `gender`, `age`, `created`) VALUES ('null','".$friend_name."','".$area_id."','".$gender."','".$age."',now())";
    //INSERT INTO `テーブル名`　SET `カラム名`＝値
    //$sql文実行
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    //echo $area_id;
    //echo count($area_id);



    header('Location: index.php');
    exit();//PHPの言語基盤break みたいなもの(文字を出力できる)

    }


// ３．データベースを切断する
    $dbh = null;

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>myfriends登録ページ</title>

  <!-- CSS -->
</head>
<body>
  <!-- ナビゲーションバー -->
    <!-- Bootstrapのcontainer -->
  <div class="container">
    <!-- Bootstrapのrow -->
    <div class="row">
     
<p style="font-size: 100px;">    

      <!-- 画面左側 -->
      <div class="col-md-4 content-margin-top">
        <!--入力フォーム-->
        <form action="record.php" method="post">
<!--1:name-->
          <div class="form-group">
            <div class="input-group">
             <input type="text" name="name" class="form-control" id="validate-text" placeholder="name" required>
            </div>
          </div>

<!--2:area_id -->
          <div class="form-group">
            <div class="input-group">
                <select name="area_id">
                    <?php foreach ($areas as $area): ?>
                  <option value="<?php echo $area['area_id']; ?>">
                    <?php echo $area['area_name']; ?>
                  </option>
                    <?php endforeach; ?>
                </select>
            </div>
          </div>

<!--gender-->
          <div class="form-group">
            <div class="input-group">
             <input type="radio" name="gender" value="1" /> 男
             <input type="radio" name="gender" value="2" /> 女 
            </div>
          </div>
<!-- age-->
          <div class="form-group">
            <div class="input-group">
             <input type="number" name="age" class="form-control" id="validate-text" placeholder="age" required>
            </div>
          </div>
 
<!-- つぶやくボタン -->
          <button type="submit">登録</button>
        </form>
      </div>
    </body>
  </html>


      
  
  