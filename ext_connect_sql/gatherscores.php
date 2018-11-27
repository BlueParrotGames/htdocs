<?php
$serverip = "178.84.28.2:3350";
$username = "remote";
$password = "mf8k66DwgDa48GLx2Vdu5FqLN8vNmeHBuuKMBbcCw5VZYmQDr9ZNPcdmnZZNd2v894d2XGQ5RY5qZrZD8nNf4xNDqfmAEXae2np8rDKzBvHdpXrsesG8s3avRVbUs9W42deXmUtaujhVj9Sr64ttjZTH4M8BEJZwnYX4d4TYYMvAJUjTRMLT6WZz7JGGZcY5FpjvHD2fkENSNGEpKkrYNrXNDkXwTR6s2LM9YthTXQwYStSTRaWeXRCgNuVdVSrd";
$db = "grappleman";

$conn = new mysqli($serverip, $username, $password, $db);

if(mysqli_connect_errno())
{
  echo "Could not connect to database! Tell a programmer!";
  exit();
}

$query = "SELECT name, score FROM highscores ORDER BY score DESC LIMIT 10";

$cmd = mysqli_query($conn, $query);
$result = mysqli_fetch_all($cmd);

for ($i=0; $i < count($result); $i++)
{
  echo implode(" | ", $result[$i])."\n";
}
 ?>
