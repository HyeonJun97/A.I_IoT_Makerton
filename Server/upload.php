<?php
    header("Content-Type:text/html; charset=UTF-8");
    header("Content-Type: image/png; charset=UTF-8");
    header("Content-Type: application/octet-stream; charset=UTF-8");
    //언어를 utf-8로 설정부분

    //여기 밑에 $file부터 $result까지는 신경안써도돼 선언만하고 안써가지고 여기서 에러는 안났을꺼야
    $file = $_FILES['files'];
   // $tok = $_POST['token'];

    $file_name = $_FILES['files']['name'];
    $tmp_file = $_FILES['files']['tmp_name'];
    
   
    $srcName = $file['files']['name'];
    $tmpName = $file['tmp_name'];//php파일을 받으면 임시저장소에 넣는다. 그곳이 tmp

    //임시 저장소 이미지를 원하는 폴더로 이동
    $dstName ='uploads/'.$file_name;
    $result = move_uploaded_file($tmp_file,$dstName);
    //바로 밑에 if절은 변수에다가 저장따로안하고 바로 $_FILES로 불러와서 위에 변수를 안썼어
    if($_FILES['files']['error']>0)echo "Error raised";//애뮬에서 뜬 에러
    else{
        #echo "FIle type : ".$_FILES['files']['type']." \n";
        $fileaddr = "uploads/" . $_FILES['files']['name'];//파일이 저장되는 경로
        if(is_uploaded_file($_FILES['files']['tmp_name']))
        {
            if(!move_uploaded_file($_FILES['files']['tmp_name'],$fileaddr))//사진을 지정된 경로로 보내는 함수 성공하면 1반환 실패하면 0반환 나는 여기서 에러가뜸 조건에 !가 붙어있으니까 0을 반환했다는건데 왜 서버에 이미지가 보내졌는지는 모르겠어
            echo "Error raised from file moving process\n";
        }
        else echo "File upload sucess.";
    }
    /*if($result){
        echo "upload success\n";
    }else{
        echo "upload fail\n";
        echo $result;
    }*/
    
    $username = $_POST['username'];
    
    //echo "$dstName\n";
    //$now = date('Y-m-d H:i:s');

    $con = mysqli_connect('localhost','root','whdgk123','test');

    mysqli_query($con,"set names utf8");

    
    //$sql1 = "select count(*) from maker_img where name = '$username'";
    $sql1 = "select * from maker_img where name = '$username'";
    $result1 = mysqli_query($con,$sql1);
    
    
   
    if(mysqli_num_rows($result1) == 0){   
    $sql3="insert into maker_img(imgpath, name) values('$dstName','$username')";
    $result3 = mysqli_query($con,$sql3);
    echo $result3;
    if($result3) echo "insert success \n";
    else echo "insert fail \n";   
    }
    else{
        $sql2 = "update maker_img set imgpath = '$dstName' where name = '$username'";
        $result2 = mysqli_query($con,$sql2);
        if($result2) echo "update success \n";
        else echo "update fail \n"; 
    } 


  //aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa

//토큰 알아내기 
    $sql4="select token from maker_login, maker_img where maker_login.u_name = maker_img.name";
    $result4 = mysqli_query($con,$sql4);
    $token = array();
    if(mysqli_num_rows($result4) > 0 ){
        while ($row = mysqli_fetch_assoc($result4)) {
            $token[] = $row['token'];
        }
    }

    $tokens=array();
    $tokens[0]="ffRDp9vDQJCQmRkkAamdZ3:APA91bHA3NBMe86KI72KxFKssIGbfcxGk3G1RyG1RVWnXE-4cVBLZ51JdxsXNyf7wnsfX7T7VbYpy-DHOxNtVuPZB3MWyu99EBN1591Gq_arNJ668ZJFg-6t_rnM_GtW1bVBl-bhPLAj";
    echo $tokens[0];
    $title = "알림";
    $message = $username." 본인이 맞습니까?";
    $notification =array();
    $notification['title']=$title;
    $notification['body']=$message;
    $url = 'https://fcm.googleapis.com/fcm/send';
    $apiKey = "AAAAGVnzBjg:APA91bGs3eciWHlN_yIYD4Ae7OhpFYtVFdRkvaJcfP4-XlBtJPS7cnDvUeArtZltqChoIfuqIC8bCgUMGRqOcPv_-W_OmtjB5e2zDL7_CNoBY0qVIinOZVMx0JHSTwD6gJwmtOYSGZhS";
    $fields = array('registration_ids'=>$tokens,'notification'=>$notification);
    $headers=array('Authorization:key='.$apiKey,'Content-Type: application/json');
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($fields));
    $result = curl_exec($ch);
    if($result==FALSE){
        $this->output->set_status_header(500);
    }
    curl_close($ch);
    echo $result;
    /*
    echo $token[0];
    $title = "알림";
    $message = "도어락 열림 요청이 왔습니다.";
    



    $arr = array();
    $arr['title'] = $title;
    $arr['message'] = $message;
    
    $token123 = array();
    $token123[0]=$token[0];
    $message_status = Android_Push($token123, $arr);
    //echo $message_status;
    // 푸시 전송 결과 반환.
    $obj = json_decode($message_status);

    // 푸시 전송시 성공 수량 반환.
    $cnt = $obj->{"success"};
    echo "요청이 완료되었습니다.";
    mysqli_close($con);

    function Android_Push($tok, $message) {

        $url = 'https://fcm.googleapis.com/fcm/send';
        $apiKey = "AAAAGVnzBjg:APA91bGs3eciWHlN_yIYD4Ae7OhpFYtVFdRkvaJcfP4-XlBtJPS7cnDvUeArtZltqChoIfuqIC8bCgUMGRqOcPv_-W_OmtjB5e2zDL7_CNoBY0qVIinOZVMx0JHSTwD6gJwmtOYSGZhS";
    
        $fields = array('registration_ids' => $tok,'data' => $message);
        $headers = array('Authorization:key='.$apiKey,'Content-Type: application/json');
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    
    
        return $result;
    }*/
?>
