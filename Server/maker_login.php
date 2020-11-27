<?php

    $con = mysqli_connect("localhost", "root", "whdgk123", "test");
    mysqli_query($con,'SET NAMES utf8');

    $u_mail = $_POST["u_mail"];
    $u_pw = $_POST["u_pw"];
   
    

    $statement = mysqli_prepare($con, "SELECT * FROM maker_login WHERE u_mail = ? AND u_pw = ?");
    mysqli_stmt_bind_param($statement, "ss", $u_mail, $u_pw);
    mysqli_stmt_execute($statement);


    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $u_mail, $u_pw, $u_name, $token);

      

    $response = array();
    $sql2 = "SELECT imgpath FROM `maker_img` WHERE (SELECT u_name FROM `maker_login` WHERE u_mail ='$u_mail' AND u_pw='$u_pw')=name ";
    $result = mysqli_query($con,$sql2);
    $row = mysqli_fetch_array($result);
    $imgpath=$row[0];
    $response['imgpath']=$imgpath;
    $response["success"] = false;	
    while(mysqli_stmt_fetch($statement)) {
        $response["success"] = true;
        $response["u_mail"] = $u_mail;
        $response["u_pw"] = $u_pw;
        $response["u_name"] = $u_name;
        
    }

   
    echo json_encode($response);
  //  $sql = "select imgpath from maker_img where name = $u_name";
  //  $result=array();
  ///  $result= mysql_fetch_array(mysqli_query($con,$sql)); 
  //  $response['imgpath'] = $result;
    

    ?>