<?php

header('Content-Type:text/html; charset=utf-8');

$conn = mysqli_connect('localhost','root','whdgk123','test');
mysqli_query($conn,"set names utf8");
$token = $_POST['token'];
$sql="select * from image where tokenID='$token' order by date DESC";
$result = mysqli_query($conn,$sql);

$rowCnt = mysqli_num_rows($result);

for($i=0;$i<$rowCnt;$i++){
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    echo "$row[no]&$row[imgPath]&$row[date];";
}
//$row[no]&
mysqli_close($conn);
?>

