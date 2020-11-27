<?php
/*
$sqltoken="select token from maker_img as img, maker_login as log where log.name = img.u_name";
    $tok = mysqli_query($con, $sqltoken);


    $title = "알림";
    $message = "사진이 도착했습니다 확인해보세요";
    //echo "아이디 :$userid \n";
    //echo "위도 : $latitude \n";
    //echo "경도 : $longtitude \n";
    
    //$imgPath =
    $arr = array();
    $arr['title'] = $title;
    $arr['message'] = $message;
    $arr['a']='0';
    $token123 = array();
    $token123[0]=$tok;
    $message_status = Android_Push($token123, $arr);
    //echo $message_status;
    // 푸시 전송 결과 반환.
    $obj = json_decode($message_status);

    // 푸시 전송시 성공 수량 반환.
    $cnt = $obj->{"success"};
    echo "요청이 완료되었습니다.";
    mysqli_close($conn);
*/

    include_once 'config.php';
	$conn = mysqli_connect("localhost", "root", "whdgk123", "test");

	$sql = "select token from maker_img as img, maker_login as log where log.name = img.u_name";
    echo "File upload sucess.";
	$result = mysqli_query($conn,$sql);
    $tokens = array();
    $tokens["token"] = $result;
	
	mysqli_close($conn);

    /*
	//관리자페이지 폼에서 입력한 내용들을 가져와 정리한다.
	$mTitle = $_POST['title'];
	if($mTitle == '') $mtitle="공지사항입니다.";
    $mMessage = $_POST['message']; 
	//알림할 내용들을 취합해서 $data에 모두 담는다. 프로젝트 의도에 따라 다른게 더 있을 수 있다.
	$inputData = array("title" => $mTitle, "body" => $mMessage);

    //마지막에 알림을 보내는 함수를 실행하고 그 결과를 화면에 출력해 준다.
    */
    $inputData = array("title" => "제목", "body" => "내용물");
	$result = send_notification($tokens, $inputData);
	echo $result;

	echo '
		<br><br>
		<button><a href="/fcm/">돌아가기</a></button>	';


    function send_notification ($tokens, $data)
	{
		$url = 'https://fcm.googleapis.com/fcm/send';
		//어떤 형태의 data/notification payload를 사용할것인지에 따라 폰에서 알림의 방식이 달라 질 수 있다.
		$msg = array(
			'title'	=> $data["title"],
			'body' 	=> $data["body"]
          );

		//data payload로 보내서 앱이 백그라운드이든 포그라운드이든 무조건 알림이 떠도록 하자.
		$fields = array(
				'registration_ids'		=> $tokens,
				'data'	=> $msg
			);

		//구글키는 config.php에 저장되어 있다.
		$headers = array(
			'Authorization:key =' $apiKey,
			'Content-Type: application/json'
			);

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
	}

/*
    function Android_Push($tok, $message) {

        $url = 'https://fcm.googleapis.com/fcm/send';
        $apiKey = "AAAAGVnzBjg:APA91bGs3eciWHlN_yIYD4Ae7OhpFYtVFdRkvaJcfP4-XlBtJPS7cnDvUeArtZltqChoIfuqIC8bCgUMGRqOcPv_-W_OmtjB5e2zDL7_CNoBY0qVIinOZVMx0JHSTwD6gJwmtOYSGZhS"
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
    }
*/
   




    ?>