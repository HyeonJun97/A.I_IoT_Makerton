<?php 

    $conn = mysqli_connect('localhost','root','whdgk123','test');
    mysqli_query($conn,"set names utf8");
mysqli_set_charset($conn,"utf8");   


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        // 안드로이드 코드의 postParameters 변수에 적어준 이름을 가지고 값을 전달 받습니다.
        $u_mail = $_POST['u_mail'];
        $u_name=$_POST['u_name'];   //안드로이드에서 u_id값을 전달해줌
        $u_pw=$_POST['u_pw']; //안드로이드에서 u_pw값을 전달해줌
        $token=$_POST['token']; //안드로이드에서 token값을 전달해줌
        $response = array();
        $response["success"] = false;
        
        if(empty($u_name)){
            $errMSG = "사용하실 id를 입력하세요.";
        }
        else if(empty($u_pw)){
            $errMSG = "사용하실 pw를 입력하세요.";
        }
       else if(empty($u_mail)){
	        $errMSG = "사용하실 e-mail를 입력하세요.";
        }
       else{       
       //2     
        $sql2 = "insert into maker_login values('$u_mail','$u_pw','$u_name','$token') ";
        $result = mysqli_query($conn,$sql2);
        $response["success"] = true; 
       }
       

    }
    $statement = mysqli_prepare($con, "SELECT u_mail FROM maker_login WHERE u_mail = ?");
    mysqli_stmt_bind_param($statement, "s", $u_mail);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $u_mail);
    
    while(mysqli_stmt_fetch($statement)){
        $response["u_mail"]=$u_mail;
    }
    
    echo json_encode($response);
?>
