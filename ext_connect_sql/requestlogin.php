<?php
$serverip = "178.84.28.2:3350";
$uid = "remote";
$pw = "mf8k66DwgDa48GLx2Vdu5FqLN8vNmeHBuuKMBbcCw5VZYmQDr9ZNPcdmnZZNd2v894d2XGQ5RY5qZrZD8nNf4xNDqfmAEXae2np8rDKzBvHdpXrsesG8s3avRVbUs9W42deXmUtaujhVj9Sr64ttjZTH4M8BEJZwnYX4d4TYYMvAJUjTRMLT6WZz7JGGZcY5FpjvHD2fkENSNGEpKkrYNrXNDkXwTR6s2LM9YthTXQwYStSTRaWeXRCgNuVdVSrd";
$db = "auth";

$conn = new mysqli($serverip, $uid, $pw, $db);

$GLOBALS['username'] = 'empty';
$GLOBALS['password'] = 'empty';
//$username = "empty";
//$password = "empty";

if(mysqli_connect_errno())
{
  echo "Could not connect to database! Tell a programmer!";
  exit();
}
else
{
  echo "Connected, let's go!";
}

$action = $_POST['method'];

switch ($action)
{
  case 'Init':
    Init();
    break;

  case 'CloseConnection':
    CloseConnection($conn);
    break;

  case 'Login':
    Login($conn);
    break;
}

function Login($conn)
{
  //$username = $_POST['username'];
  //$password = $_POST['password'];
  $GLOBALS['username'] = $_POST['username'];
  $GLOBALS['password'] = $_POST['password'];

  $username = $GLOBALS['username'];
  $password = $GLOBALS['password'];

  $query = "SELECT login_name, password, login_hash FROM account WHERE login_name='$username' and password='$password'";
  $cmd = mysqli_query ($conn, $query);
  $count = mysqli_num_rows($cmd);

  if($count == 1)
  {
      $val = mysqli_fetch_assoc($cmd);
      if(is_null($val["login_hash"]) || empty($val["login_hash"]))
      {
        echo "login hash is null";
        echo "User found";
        $encrypted = sha1("$username:$password:" . GetRandomWord());
        $updateQuery = "UPDATE account SET login_hash = '$encrypted' WHERE login_name = '$username'";
        $updateCMD = mysqli_query($conn, $updateQuery);
      }
      else
      {
        echo "login hash is not null \t" . $val["login_hash"];
      }
  }
  else
  {
    echo "User not found!";
  }
}

function CloseConnection($conn)
{
  $username = $GLOBALS['username'];
  $password = $GLOBALS['password'];

  echo $username . $password;

  $updateQuery = "UPDATE account SET login_hash = '' WHERE login_name = '$username'";
  $updateCMD = mysqli_query($conn, $updateQuery);

  mysqli_close($conn);
  echo "Connection closed!";
}

function Init()
{
  echo "potato";
}

function GetRandomWord()
{
$file = "../Core/nouns0.txt";
$file_arr = file($file);
$num_lines = count($file_arr);
$last_index = $num_lines -1;

$rand_index = rand(0, $last_index);
$rand_text = $file_arr[$rand_index];

return trim($rand_text);
}

?>
