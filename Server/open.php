<?php

    
    /*$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {
        $open=$_POST['open'];
        echo $open;
    }
    else{
        $open="1";
        echo $open;
        
    }*/
    $response=array();
    android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        // 안드로이드 코드의 postParameters 변수에 적어준 이름을 가지고 값을 전달 받습니다.
        $open = $_POST['open'];
        $response["success"] = true; 
        $response["open"]=$open;
        echo $open;
    }
    echo json_encode($response);
?>