<?php
if(!empty($_POST)){
  $filename = "mission_3-5.txt";
  //名前とコメント記入処理
  if(!empty($_POST['namae'])){
    if($_POST['password']=="world"){
      if($fp = fopen($filename, "a+")){
        //ここでfile読み込み、に数値を加算していく
        if(!feof($fp)){
          $i=1;
          while($texts=fgets($fp)){
            $i++;
          }
        }
        $namae = $_POST['namae'];
        $accept = $_POST['comment'];
        $data = $i."<>".$namae."<>".$accept."<> (".date("Y/m/d H:i:s").")\n";
        fwrite($fp,$data);//openして書き込む処理
        fclose($fp);//fileopenしたやつをclose
          if($accept=="完成"){
            echo "<br>おめでとう！";
          }
      }
    }elseif(empty($_POST['password'])){
      $pwempty1 = "パスワードを記入してください";
    }else{
      $pwdiff1 = "パスワードが違っています";
    }
    //こっから削除処理
  }elseif(!empty($_POST['sakujyo'])){
    if($_POST['password']=="world"){
      $sakujyo = $_POST['sakujyo'];
      if(fopen($filename, "r")){
        $fp = fopen($filename, "r");
        if(!feof($fp)){
          $i=1;
          while($texts=fgets($fp)){
            $divis = explode("<>",$texts);
            //print_r($divis);
            if($divis[0]==$sakujyo){
                $goodby = $divis[0].$divis[1].$divis[2].$divis[3];
            }else{
              $newdata[] = $i."<>".$divis[1]."<>".$divis[2]."<>".$divis[3];
              $i++;
            }
          }
          $emit = fopen($filename, "w");
            foreach ($newdata as $new) {
              //echo $new."<br>";
              fwrite($emit, $new);
            }
        }
      fclose($fp);
      }
    }elseif(empty($_POST['password'])){
      $pwempty2 = "パスワードを記入してください";
    }else{
      $pwdiff2 = "パスワードが違っています";
    }
    #編集値が送信されたら
  }elseif(!empty($_POST['hensyu'])){
    if($_POST['password']=="world"){
      $hensyu = $_POST['hensyu'];
      if(fopen($filename, "r")){
        $fp = fopen($filename, "r");
        if(!feof($fp)){
          $i=1;
          while($texts=fgets($fp)){
            $divis = explode("<>",$texts);
            //print_r($divis);
            if($divis[0]==$hensyu){
                $editer = $divis;
            }
          }
        }
      fclose($fp);
      }
    }elseif(empty($_POST['password'])){
      $pwempty3 = "パスワードを記入してください";
    }else{
      $pwdiff3 = "パスワードが違っています";
    }
  }elseif(!empty($_POST['edname'])){
    //編集後value送信値受け取り
    $ednum = $_POST['ednum'];
    $edname = $_POST['edname'];
    $edcom = $_POST['edcom'];
    $edtime = $_POST['edtime'];
    if(fopen($filename, "r")){
      $fp = fopen($filename, "r");
      if(!feof($fp)){
        $i=1;
        while($texts=fgets($fp)){
          $divis = explode("<>",$texts);
          //print_r($divis);
          if($divis[0]==$ednum){
              $change = $ednum."<>".$edname."<>".$edcom."<>".$edtime;
              $display = $ednum.$edname.$edcom.$edtime;
              //echo $change."aaa";
              $newdata[] = $change;
          }else{
            $newdata[] = $texts;
          }
        }
        $editop = fopen($filename, "w");//"a"の場合は改行{|n}が必要!
          foreach ($newdata as $new) {
            //echo $new."<br>";
            fwrite($editop, $new);
          }
      }
    fclose($fp);
    }
  }else{
    #デバック対策
    //exit;にしちゃうとそこで読み込みを終えるから、つまりhtml部分も表示しなくなる
    echo "<script>alert('空白を埋めてください')</script>";
  }
}
 ?>
<h1>discussion room 　パスワード(world)</h1>
<?php if(!empty($editer)): ?>
  <編集中>
  <form action="" method="post">
          <input type=hidden name="ednum" value="<?php echo $editer[0] ?>">
    　名前　<input type=text name="edname" value="<?php echo $editer[1] ?>">
    コメント<input type=text name="edcom" value="<?php echo $editer[2] ?>">
          <input type=hidden name="edtime" value="<?php echo $editer[3] ?>">
    <input type="submit">
  </form>
<?php else: ?>
  <hr>
  <form action="" method="post">
　　名前:　<input type=text name="namae">
　　コメント: <input type=text name="comment" value="コメント">
　　パスワード:　<input type=text name="password">
    <input type="submit">
    <?php if(!empty($pwdiff1)){echo "<font color='red'>パスワードが違っています</font>";} ?>
    <?php if(!empty($pwempty1)){echo "<font color='red'>パスワードを入れてください</font>";} ?>
  </form>
  <hr>
  <form action="" method="post"><!--formをくっつけると後(削除送信)が優先されてしまう--->
　　削除(番号を記入してください):　<input type=text name="sakujyo">
　　パスワード:　<input type=text name="password">
    <input type="submit" value="削除">
    <?php if(!empty($pwdiff2)){echo "<font color='red'>パスワードが違っています</font>";} ?>
    <?php if(!empty($pwempty2)){echo "<font color='red'>パスワードを入れてください</font>";} ?>
  </form>
  <hr>
  <form action="" method="post">
　　編集(番号を記入してください):　<input type=text name="hensyu">
　　パスワード:　<input type=text name="password">
    <input type="submit" value="編集">
    <?php if(!empty($pwdiff3)){echo "<font color='red'>パスワードが違っています</font>";} ?>
    <?php if(!empty($pwempty3)){echo "<font color='red'>パスワードを入れてください</font>";} ?>
  </form>
  <hr>
<?php endif; ?>

<?php if(!empty($accept)){echo "「".$accept."」と新しいファイルに記入しました";} ?>
<?php if(!empty($goodby)){echo $goodby."を削除しました";} ?>
<?php if(!empty($display)){echo "「".$display."」に変更しました";} ?>
<br><br>
----------------------以下コメント----------------------------------<br>
<?php

//最新ファイル（送信値を書き込んだファイル）をopenして読み込み
//$_POSTの上にあると前ページ変数を書き込む前だからread反映されない
touch('mission_3-5.txt');//ファイルがあるか確認→なければファイル作成
$filename = "mission_3-5.txt";
if(fopen($filename, "r")){
  $fp = fopen($filename, "r");
  if(!feof($fp)){
    while($texts=fgets($fp)){
      $divis = explode("<>",$texts);//分けたのを保存しないと
      //print_r($divis);
      foreach ($divis as $divi){
        echo $divi;
      }
      echo "<br>";
    }
  }
fclose($fp);
}
?>
