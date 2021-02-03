<?php 



if(empty($_COOKIE['Target']) || empty($_POST['num'])) {
  // 在游戏开始时生成随机数
      $target = random_int(1,1000);
      // 不能存于文件中，因为有多个用户访问，会覆盖掉原来的数据
      // file_put_contents('number.txt',$target);
      // 因为 Cookie 是每个用户自己独立保存，每个用户存的是自己要猜的数
      setcookie('Target',$target);
}else {
  $count = empty($_COOKIE['count']) ? 0 : (int)$_COOKIE['count'];
  if($count < 10) {
    // 用户来试一试
    //   // 对比用户提交的数字和用户 Cookie 存放的被猜的数字
    //   // $_POST['num'] --> 用户试一试的数字
    //   // $_COOKIE['Target'] --> 被猜的数字
        $result = (int)$_POST['num'] - (int)$_COOKIE['Target'];
        if($result == 0){
          $message = '√';
          // 游戏重新开始 ，删除 Cookie 即可
          setcookie('Target');
          setcookie('count');
        }else if($result < 0) {
          $message = '<';
        }else {
          $message = '>';
        }
    setcookie('count',$count + 1);
  }else {
    $message = '超过限制次数,Game Over';
    setcookie('Target');
    setcookie('count');
  }
}
    



    // var_dump($target);
  // if($_SERVER['REQUEST_METHOD'] === 'GET') {
    
  //   $guess = $_GET['num'];
  //   var_dump($guess);
  // }
  // if($guess = $target){
  //   echo '√';
  // }else if($guess < $target) {
  //   echo '<';
  // }else {
  //   echo '>';
  // }

// ---------------------------------------------判断请求方式，辨别是第几次请求----------------------------------
// if($_SERVER['REQUEST_METHOD'] === 'GET') {
//   // 在游戏开始时生成随机数
//       $target = random_int(1,1000);
//       // 不能存于文件中，因为有多个用户访问，会覆盖掉原来的数据
//       // file_put_contents('number.txt',$target);
//       // 因为 Cookie 是每个用户自己独立保存，每个用户存的是自己要猜的数
//       setcookie('Target',$target);
// }else {
//   // 用户来试一试
//   // 对比用户提交的数字和用户 Cookie 存放的被猜的数字
//   // $_POST['num'] --> 用户试一试的数字
//   // $_COOKIE['Target'] --> 被猜的数字
//   $result = (int)$_POST['num'] - (int)$_COOKIE['Target'];
//   if($result ==  0) {
//     echo '猜对了';
//   }else if ($result < 0) {
//     echo '猜小了';
//   }else {
//     echo '猜大了';
//   }
// }



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>猜数字</title>
  <style>
    body {
      padding: 100px 0;
      background-color: #2b3b49;
      color: #fff;
      text-align: center;
      font-size: 2.5em;
    }
    input {
      padding: 5px 20px;
      height: 50px;
      background-color: #3b4b59;
      border: 1px solid #c0c0c0;
      box-sizing: border-box;
      color: #fff;
      font-size: 20px;
    }
    button {
      padding: 5px 20px;
      height: 50px;
      font-size: 16px;
    }
  </style>
</head>
<body>
  <h1>猜数字游戏</h1>
  <p>Hi，我已经准备了一个0~1000的数字，你需要在仅有的10机会之内猜对它。</p>
  <?php if (isset($message)): ?>
    <p style="background: #f00;"><?php echo $message; ?></p>
  <?php endif ?>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="number" min="0" max="1000" name="num" placeholder="随便猜">
    <button type="submit">试一试</button>
  </form>
</body>
</html>
