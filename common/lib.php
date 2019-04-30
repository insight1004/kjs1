<?if (!defined('_COOL_')) exit; // 개별 페이지 접근 불가?>
<?

//==============================================================================
// 공통 
//------------------------------------------------------------------------------

//문자 내 공백 제거
function trim_str($val){
	return preg_replace("/\s+/", "", $val);
}

//셀렉트 박스 구성
function option_str($data1,$data2,$option_name=''){

	$data1=explode("|",$data1); 
	$data2=explode("|",$data2); 
	for($i=0; $i < count($data1); $i++){$dataA[$i]=trim($data1[$i]);}
	for($i=0; $i < count($data2); $i++){$dataB[$i]=trim($data2[$i]);}
	for($i=0; $i < count($data2); $i++){
		$selected=($option_name==$dataB[$i])? "selected":"";
		$result .="<option value='$dataB[$i]' $selected>$dataA[$i]</option>\n\t\t\t";
	}

	return($result);
}


//콘솔로그
function Console_log($str){
    echo "<script>console.log( 'PHP_Console: " . $str . "' );</script>";
}


//로그인 + 접근 권한 체크 (Page)
function authChk($login=true, $alert=true, $level=''){
	global $msgstr;

	if ($login){
		if(!isset($_SESSION['ADM_ID'])) {
			echo "<script>";
			if($alert)echo " alert('".$msgstr['deny1']."'); ";
			echo " top.location.href='/adm/login.php' ";
			echo "</script>";
			exit;
		}
		
		$trimlevel = trim_str($level);
		if($level){
			
			$lvlflag = false;
			if(substr_count($level, ",") > 0){
				$levelcut =explode(',' , $level);
				$cnt = count($levelcut);
				for($i = 0 ; $i < $cnt ; $i++){
					if($_SESSION['ADM_LEVEL'] == $levelcut[$i]){
						$lvlflag = true;	
					}
				}
				
			}else{
				if($_SESSION['ADM_LEVEL'] == $level){
					$lvlflag = true;	
				}
			}

			if(!$lvlflag){
				echo "<script>alert('".$msgstr['deny2']."');</script>";
				exit;
			}

		}
	}

}


//로그인 + 접근 권한 체크 (Proc)
function authChkProc($login=true, $level=''){
	global $msgstr;

	if ($login){
		if(!isset($_SESSION['ADM_ID'])) {
			return 'logout';
			exit;
		}

		$trimlevel = trim_str($level);
		if($level){
			
			$lvlflag = false;
			if(substr_count($level, ",") > 0){
				$levelcut =explode(',' , $level);
				$cnt = count($levelcut);
				for($i = 0 ; $i < $cnt ; $i++){
					if($_SESSION['ADM_LEVEL'] == $levelcut[$i]){
						$lvlflag = true;	
					}
				}
				
			}else{
				if($_SESSION['ADM_LEVEL'] == $level){
					$lvlflag = true;	
				}
			}

			if(!$lvlflag){
				return 'deny';
				exit;
			}

		}
	}
}



//페이징
function paging($page, $onePage, $pageGrp, $allPost, $param='')
{	
	$allPage = ceil($allPost / $onePage); //전체 페이지의 수
	$currentSection = ceil($page / $pageGrp); //현재 섹션
	$allSection = ceil($allPage / $pageGrp); //전체 섹션의 수

	$firstPage = ($currentSection * $pageGrp) - ($pageGrp - 1); //현재 섹션의 처음 페이지

	if($currentSection == $allSection) {
		$lastPage = $allPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
	} else {
		$lastPage = $currentSection * $pageGrp; //현재 섹션의 마지막 페이지
	}

	$prevPage = (($currentSection - 1) * $pageGrp); //이전 페이지, 11~20일 때 이전을 누르면 10 페이지로 이동.
	$nextPage = (($currentSection + 1) * $pageGrp) - ($pageGrp - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.

	
	if($lastPage){

		$paging = '<div class="page">'; // 페이징을 HTML 저장할 변수

		//첫 페이지가 아니라면 처음 버튼을 생성
		if($page != 1) { 
			//$paging .= '<a href="'.$_SERVER[SCRIPT_NAME].'?page=1&'.$param.'" title="처음"><i class="mte i_navigate_before vam"></i></a>';
		}
		//첫 섹션이 아니라면 이전 버튼을 생성
		/*
		if($currentSection != 1) { 
			$paging .= '<a href="'.$_SERVER[SCRIPT_NAME].'?page='.$prevPage.'&'.$param.'" title="이전"><i class="mte i_navigate_before vam"></i></a>';
		}else{
			$paging .= '<a href="'.$_SERVER[SCRIPT_NAME].'?page='.($page-1).'&'.$param.'" title="이전"><i class="mte i_navigate_before vam"></i></a>';
		}
		*/
		
		if($page > 1){
			$paging .= '<a href="'.$_SERVER[SCRIPT_NAME].'?page='.($page-1).'&'.$param.'" title="이전"><i class="mte i_navigate_before vam"></i></a>';
		}else{
			$paging .= '<a href="javascript:alert(\'이전 페이지가 없습니다.\');" title="이전"><i class="mte i_navigate_before vam"></i></a>';
		}
		

		
		$paging .= "&nbsp;";
		
		for($i = $firstPage; $i <= $lastPage; $i++) {
			if($i == $page) {
				$paging .= '<a href="#" class="on">'.$i.'</a>';
			} else {
				$paging .= '<a href="'.$_SERVER[SCRIPT_NAME].'?page='.$i.'&'.$param.'">'.$i.'</a>';
			}
			$paging .= "&nbsp;";
		}

		//$paging .= "&nbsp;";

		//마지막 섹션이 아니라면 다음 버튼을 생성
		/*
		if($currentSection != $allSection) { 
			$paging .= '<a href="'.$_SERVER[SCRIPT_NAME].'?page='.$nextPage.'&'.$param.'" title="다음"><i class="mte i_navigate_next vam"></i></a>';
		}else{
			$paging .= '<a href="#" class="none" title="다음"><i class="mte i_navigate_next vam"></i></a>';
		}
		*/
		
		if($page < $allPage) { 
			$paging .= '<a href="'.$_SERVER[SCRIPT_NAME].'?page='.($page+1).'&'.$param.'" title="다음"><i class="mte i_navigate_next vam"></i></a>';
		}else{
			$paging .= '<a href="javascript:alert(\'다음 페이지가 없습니다.\');" title="다음"><i class="mte i_navigate_next vam"></i></a>';
		}

		//마지막 페이지가 아니라면 끝 버튼을 생성
		if($page != $allPage) { 
			//$paging .= '<a href="'.$_SERVER[SCRIPT_NAME].'?page='.$allPage.'&'.$param.'" title="마지막"><i class="mte i_navigate_next vam"></i></a>';
		}
		$paging .= '</div>';

	}
 
    return $paging;
}




//페이징(모바일)
function paging_m($page, $onePage, $pageGrp_m, $allPost, $param='')
{	
	$allPage = ceil($allPost / $onePage); //전체 페이지의 수
	$currentSection = ceil($page / $pageGrp); //현재 섹션
	$allSection = ceil($allPage / $pageGrp); //전체 섹션의 수

	$firstPage = ($currentSection * $pageGrp) - ($pageGrp - 1); //현재 섹션의 처음 페이지

	if($currentSection == $allSection) {
		$lastPage = $allPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
	} else {
		$lastPage = $currentSection * $pageGrp; //현재 섹션의 마지막 페이지
	}

	$prevPage = (($currentSection - 1) * $pageGrp); //이전 페이지, 11~20일 때 이전을 누르면 10 페이지로 이동.
	$nextPage = (($currentSection + 1) * $pageGrp) - ($pageGrp - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.

	
	if($lastPage){

		$paging = '<div class="page respon_show">'; // 페이징을 HTML 저장할 변수

		//첫 페이지가 아니라면 처음 버튼을 생성
		if($page != 1) { 
			//$paging .= '<a href="'.$_SERVER[SCRIPT_NAME].'?page=1&'.$param.'" title="처음"><i class="mte i_navigate_before vam"></i></a>';
		}

		//첫 섹션이 아니라면 이전 버튼을 생성
		/*
		if($currentSection != 1) { 
			$paging .= '<a href="'.$_SERVER[SCRIPT_NAME].'?page='.$prevPage.'&'.$param.'" title="이전"><i class="mte i_navigate_before vam"></i></a>';
		}else{
			$paging .= '<a href="#" class="none" title="이전"><i class="mte i_navigate_before vam"></i></a>';
		}
		*/

		if($page > 1){
			$paging .= '<a href="'.$_SERVER[SCRIPT_NAME].'?page='.($page-1).'&'.$param.'" title="이전"><i class="mte i_navigate_before vam"></i></a>';
		}else{
			$paging .= '<a href="javascript:alert(\'이전 페이지가 없습니다.\');" title="이전"><i class="mte i_navigate_before vam"></i></a>';
		}

		
		$paging .= "&nbsp;";
		
		for($i = $firstPage; $i <= $lastPage; $i++) {
			if($i == $page) {
				$paging .= '<a href="#" class="on">'.$i.'</a>';
			} else {
				$paging .= '<a href="'.$_SERVER[SCRIPT_NAME].'?page='.$i.'&'.$param.'">'.$i.'</a>';
			}
			$paging .= "&nbsp;";
		}

		//$paging .= "&nbsp;";

		//마지막 섹션이 아니라면 다음 버튼을 생성
		/*
		if($currentSection != $allSection) { 
			$paging .= '<a href="'.$_SERVER[SCRIPT_NAME].'?page='.$nextPage.'&'.$param.'" title="다음"><i class="mte i_navigate_next vam"></i></a>';
		}else{
			$paging .= '<a href="#" class="none" title="다음"><i class="mte i_navigate_next vam"></i></a>';
		}
		*/

		if($page < $allPage) { 
			$paging .= '<a href="'.$_SERVER[SCRIPT_NAME].'?page='.($page+1).'&'.$param.'" title="다음"><i class="mte i_navigate_next vam"></i></a>';
		}else{
			$paging .= '<a href="javascript:alert(\'다음 페이지가 없습니다.\');" title="다음"><i class="mte i_navigate_next vam"></i></a>';
		}

		//마지막 페이지가 아니라면 끝 버튼을 생성
		if($page != $allPage) { 
			//$paging .= '<a href="'.$_SERVER[SCRIPT_NAME].'?page='.$allPage.'&'.$param.'" title="마지막"><i class="mte i_navigate_next vam"></i></a>';
		}
		$paging .= '</div>';

	}
 
    return $paging;
}



//오늘날짜
function nowDate(){
	return date('Y-m-d');
}



//오늘날짜 시간
function nowDateTime(){
	return date('Y-m-d H:i:s');
}


//오늘날짜 시간 (숫자만)
function nowDateTimeTight(){
	return date('YmdHis');
}


//모바일 접속 체크
function isMobile(){

	//Check Mobile
	$mAgent = array("iPhone","iPod","Android","Blackberry", "Opera Mini", "Windows ce", "Nokia", "sony", "Mobile");
	$chkMobile = false;
	for($i=0; $i<sizeof($mAgent); $i++){
		if(stripos( $_SERVER['HTTP_USER_AGENT'], $mAgent[$i] )){
			$chkMobile = true;
			break;
		}
	}
	return $chkMobile;
}


//랜덤 문자열
function GenerateString($length, $kind=''){
	
	if($kind==1){
		$characters = "0123456789";
	}else if($kind==2){
		$characters = "abcdefghijklmnopqrstuvwxyz";  
	}else if($kind==3){
		$characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	}else if($kind==4){
		$characters = "_!@#$%^&*()[]";
	}else{
		$characters  = "0123456789";  
		$characters .= "abcdefghijklmnopqrstuvwxyz";  
		$characters .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";  
		$characters .= "_!@#$%^&*()[]";
	}

    $string_generated = "";  
      
    $nmr_loops = $length;  
    while ($nmr_loops--)  
    {  
        $string_generated .= $characters[mt_rand(0, strlen($characters))];  
    }  
      
    return $string_generated;  
}  



//1:1 문의 등록 알림 이메일
function qna_regmail($question){
	
	global $qna_email;

	$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
	$qna_url = $protocol.$_SERVER["HTTP_HOST"].'/sub.php?bkind=cs3';


	$html='<table align="center" border="0" cellspacing="0" cellpadding="0" style="width:700px;font-family:나눔고딕, NanumGothic, 돋움, Dotum, Sans-serif">';
    $html.='<tr>';
    $html.='    <td>';
    $html.='        <table align="center" width="100%" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #ed999a">';
    $html.='            <tr>';
    $html.='                <td style="padding-top:30px; padding-bottom:30px"><a href="http://www.hansolsecure.com/" target="_blank"><img src="'.$protocol.$_SERVER["HTTP_HOST"].'/images/ci_hansol.png" alt="한솔시큐어"></a></td>';
    $html.='                <td align="right"><a href="http://coolwallet.co.kr/" target="_blank"><img src="'.$protocol.$_SERVER["HTTP_HOST"].'/images/mail_bi.png" alt="쿨월렛"></a></td>';
    $html.='            </tr>';
    $html.='        </table>';
    $html.='    </td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='    <td align="center">';
    $html.='        <table align="center" width="100%" cellspacing="0" cellpadding="0">';
    $html.='            <tr>';
    $html.='                <td align="center" style="letter-spacing:-1px; height:150px">';
    $html.='                    <h1 style="color:#444;margin:0;letter-spacing:-2px">1:1문의가 등록되었습니다.</h1>';
    $html.='                </td>';
    $html.='            </tr>';
    $html.='            <tr>';
    $html.='                <td align="center" style="border-top:1px solid #444;border-bottom:1px solid #444; width:100%">';
    $html.='                    <table align="center" width="100%" cellspacing="0" cellpadding="0">';
    $html.='                        <tr>';
    $html.='                            <td bgcolor="#f9f9f9" style="width:100%; padding:10px 20px; border-bottom:1px dotted #c8c8c8">';
    $html.='                                <p style="color:#444"><b>고객님께서 문의하신 내용은 다음과 같습니다.</b></p>';
    $html.='                            </td>';
    $html.='                        </tr>';
    $html.='                        <tr>';
    $html.='                            <td style="width:100%; padding:10px 20px">';
    $html.='                                <p style="font-size:13px; color:#999; padding:10px 0;line-height:20px">';
    $html.=                                    $question;
    $html.='                                </p>';
    $html.='                            </td>';
    $html.='                        </tr>';
    $html.='                    </table>';
    $html.='                </td>';
    $html.='            </tr>';
    $html.='            <tr>';
    $html.='                <td style="padding:30px"></td>';
    $html.='            </tr>';
    $html.='        </table>';
    $html.='    </td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='    <td align="center" style="border-top:1px solid #ed999a; padding-top:20px">';
    $html.='        <p style="color:#666;font-size:12px;line-height:20px;letter-spacing:-1px">';
    $html.='            본 메일은 발신 전용이며, 회신이 되지 않습니다.<br>';
    $html.='            추가 문의사항은 <a href="'.$qna_url.'" target="_blank" style="color:#1a93d9; text-decoration:none">1:1문의</a> 또는 한솔시큐어 고객센터(02-2082-0756)를 통해 문의하여 주시기 바랍니다.<br>';
    $html.='            Copyright &copy; Hansol secure Corp. All rights reserved.';
    $html.='        </p>';
    $html.='    </td>';
    $html.='</tr>';
	$html.='</table>';



	//수신자 주소 만들기
	$mailadrr = "";
	for($i=0; $i < count($qna_email); $i++){
		if($i > 0)$mailadrr .= ",";
		$mailadrr .= $qna_email[$i];
	}

	$mailTo = $mailadrr; //수신주소
    //$nameTo  = $to_name; //수신자 이름

	$mailFrom = FROM_EMAIL; //발신주소
	$nameFrom  = FROM_NAME; //발신자 이름
    
    $cc = ""; //참조
    $bcc = ""; //숨은참조

	$subject = "1:1문의가 등록되었습니다.";
    $content = $html;    

    $charset = "UTF-8";

    $nameFrom   = "=?$charset?B?".base64_encode($nameFrom)."?=";
    //$nameTo   = "=?$charset?B?".base64_encode($nameTo)."?=";
    $subject = "=?$charset?B?".base64_encode($subject)."?=";

    $header  = "Content-Type: text/html; charset=utf-8\r\n";
    $header .= "MIME-Version: 1.0\r\n";

    $header .= "Return-Path: <". $mailFrom .">\r\n";
    $header .= "From: ". $nameFrom ." <". $mailFrom .">\r\n";
    $header .= "Reply-To: <". $mailFrom .">\r\n";
    if ($cc)  $header .= "Cc: ". $cc ."\r\n";
    if ($bcc) $header .= "Bcc: ". $bcc ."\r\n";

    $result = mail($mailTo, $subject, $content, $header);

    if($result) {
		return true;
	} else {
		return false;
	}

}




//1:1 문의 이메일 보내기
function qna_sendmail($to_mail, $to_name, $from_mail, $from_name, $question, $answer){
	

	$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
	$qna_url = $protocol.$_SERVER["HTTP_HOST"].'/sub.php?bkind=cs3';


	$html='<table align="center" border="0" cellspacing="0" cellpadding="0" style="width:700px;font-family:나눔고딕, NanumGothic, 돋움, Dotum, Sans-serif">';
    $html.='<tr>';
    $html.='    <td>';
    $html.='        <table align="center" width="100%" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #ed999a">';
    $html.='            <tr>';
    $html.='                <td style="padding-top:30px; padding-bottom:30px"><a href="http://www.hansolsecure.com/" target="_blank"><img src="'.$protocol.$_SERVER["HTTP_HOST"].'/images/ci_hansol.png" alt="한솔시큐어"></a></td>';
    $html.='                <td align="right"><a href="http://coolwallet.co.kr/" target="_blank"><img src="'.$protocol.$_SERVER["HTTP_HOST"].'/images/mail_bi.png" alt="쿨월렛"></a></td>';
    $html.='            </tr>';
    $html.='        </table>';
    $html.='    </td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='    <td align="center">';
    $html.='        <table align="center" width="100%" cellspacing="0" cellpadding="0">';
    $html.='            <tr>';
    $html.='                <td align="center" style="letter-spacing:-1px; height:150px">';
    $html.='                    <p style="color:#666; margin:0">안전한 암호화폐 거래를 보장하는 COOLWALLET S 고객센터입니다.</p>';
    $html.='                    <h1 style="color:#444;margin:0;letter-spacing:-2px">고객님께서 문의하신 질문에 답변 드립니다.</h1>';
    $html.='                </td>';
    $html.='            </tr>';
    $html.='            <tr>';
    $html.='                <td align="center" style="border-top:1px solid #444;border-bottom:1px solid #444; width:100%">';
    $html.='                    <table align="center" width="100%" cellspacing="0" cellpadding="0">';
    $html.='                        <tr>';
    $html.='                            <td bgcolor="#f9f9f9" style="width:100%; padding:10px 20px; border-bottom:1px dotted #c8c8c8">';
    $html.='                                <p style="color:#444"><b>고객님께서 문의하신 내용은 다음과 같습니다.</b></p>';
    $html.='                            </td>';
    $html.='                        </tr>';
    $html.='                        <tr>';
    $html.='                            <td style="width:100%; padding:10px 20px">';
    $html.='                                <p style="font-size:13px; color:#999; padding:10px 0;line-height:20px">';
    $html.=                                    $question;
    $html.='                                </p>';
    $html.='                            </td>';
    $html.='                        </tr>';
    $html.='                    </table>';
    $html.='                </td>';
    $html.='            </tr>';
    $html.='            <tr>';
    $html.='                <td style="padding:30px"></td>';
    $html.='            </tr>';
    $html.='            <tr>';
    $html.='                <td align="center" style="border-top:1px solid #444;border-bottom:1px solid #444">';
    $html.='                    <table align="center" width="100%" cellspacing="0" cellpadding="0">';
    $html.='                        <tr>';
    $html.='                            <td bgcolor="#f9f9f9" style="width:100%; padding:10px 20px; border-bottom:1px dotted #c8c8c8">';
    $html.='                                <p style="color:#444"><b>고객님께서 문의하신 질문에 대한 답변 드립니다.</b></p>';
    $html.='                            </td>';
    $html.='                        </tr>';
    $html.='                        <tr>';
    $html.='                            <td style="width:100%; padding:10px 20px">';
    $html.='                                <p style="font-size:13px;color:#444;font-weight:bold;padding:10px 0;line-height:20px">';
	$html.=										$answer;
    $html.='                                </p>';
    $html.='                            </td>';
    $html.='                        </tr>';
    $html.='                    </table>';
    $html.='                </td>';
    $html.='            </tr>';
    $html.='            <tr>';
    $html.='                <td style="padding:30px"></td>';
    $html.='            </tr>';
    $html.='        </table>';
    $html.='    </td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='    <td align="center" style="border-top:1px solid #ed999a; padding-top:20px">';
    $html.='        <p style="color:#666;font-size:12px;line-height:20px;letter-spacing:-1px">';
    $html.='            본 메일은 발신 전용이며, 회신이 되지 않습니다.<br>';
    $html.='            추가 문의사항은 <a href="'.$qna_url.'" target="_blank" style="color:#1a93d9; text-decoration:none">1:1문의</a> 또는 한솔시큐어 고객센터(02-2082-0756)를 통해 문의하여 주시기 바랍니다.<br>';
    $html.='            Copyright &copy; Hansol secure Corp. All rights reserved.';
    $html.='        </p>';
    $html.='    </td>';
    $html.='</tr>';
	$html.='</table>';




	$mailTo = $to_mail; //수신주소
    $nameTo  = $to_name; //수신자 이름

	$mailFrom = $from_mail; //발신주소
	$nameFrom  = $from_name; //발신자 이름
    
    $cc = ""; //참조
    $bcc = ""; //숨은참조

	$subject = ($to_name=='') ? "고객님께서 문의하신 질문에 답변 드립니다." : $to_name."님께서 문의하신 질문에 답변 드립니다.";
    $content = $html;    

    $charset = "UTF-8";

    $nameFrom   = "=?$charset?B?".base64_encode($nameFrom)."?=";
    //$nameTo   = "=?$charset?B?".base64_encode($nameTo)."?=";
    $subject = "=?$charset?B?".base64_encode($subject)."?=";

    $header  = "Content-Type: text/html; charset=utf-8\r\n";
    $header .= "MIME-Version: 1.0\r\n";

    $header .= "Return-Path: <". $mailFrom .">\r\n";
    $header .= "From: ". $nameFrom ." <". $mailFrom .">\r\n";
    $header .= "Reply-To: <". $mailFrom .">\r\n";
    if ($cc)  $header .= "Cc: ". $cc ."\r\n";
    if ($bcc) $header .= "Bcc: ". $bcc ."\r\n";

    $result = mail($mailTo, $subject, $content, $header);

    if($result) {
		return true;
	} else {
		return false;
	}


}



//패스워드 찾기 이메일 보내기
function pwd_sendmail($to_mail, $from_mail, $from_name, $pwdrenew){
	

	$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
	$adm_url = $protocol.$_SERVER["HTTP_HOST"].'/adm/';
	$qna_url = $protocol.$_SERVER["HTTP_HOST"].'/sub.php?bkind=cs3';


	$html='<table align="center" border="0" cellspacing="0" cellpadding="0" style="width:700px;font-family:나눔고딕, NanumGothic, 돋움, Dotum, Sans-serif">';
    $html.='<tr>';
    $html.='    <td>';
    $html.='        <table align="center" width="100%" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #ed999a">';
    $html.='            <tr>';
    $html.='                <td style="padding-top:30px; padding-bottom:30px"><a href="http://www.hansolsecure.com/" target="_blank"><img src="'.$protocol.$_SERVER["HTTP_HOST"].'/images/ci_hansol.png" alt="한솔시큐어"></a></td>';
    $html.='                <td align="right"><a href="http://coolwallet.co.kr/" target="_blank"><img src="'.$protocol.$_SERVER["HTTP_HOST"].'/images/mail_bi.png" alt="쿨월렛"></a></td>';
    $html.='            </tr>';
    $html.='        </table>';
    $html.='    </td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='    <td align="center">';
    $html.='        <table align="center" width="100%" cellspacing="0" cellpadding="0" style="margin:50px 0px">';
    $html.='            <tr>';
    $html.='                <td align="center" style="letter-spacing:-1px;padding-top:50px; padding-bottom:50px">';
    $html.='                    <p style="color:#666; margin:0px">안전한 암호화폐 거래를 보장하는 COOLWALLET S 고객센터입니다.</p>';
    $html.='                    <h1 style="color:#444; margin:0px;letter-spacing:-2px">임시 비밀번호를 안내해드립니다.</h1>';
    $html.='                </td>';
    $html.='            </tr>';
    $html.='            <tr>';
    $html.='                <td align="center" style="border-top:1px solid #444;border-bottom:1px solid #444;background-color:#f9f9f9; padding:30px 10px">';
    $html.='                    <p style="color:#666;margin:0">임시 비밀번호</p>';
    $html.='                    <h1 style="color:#f4514a;margin:0px">'.$pwdrenew.'</h1>';
    $html.='                </td>';
    $html.='            </tr>';
    $html.='            <tr>';
    $html.='                <td align="center" style="padding:10px">';
    $html.='                    <p style="font-size:13px;color:#444;letter-spacing:-1px">임시 비밀번호를 통해 로그인 하신 후 새로운 비밀번호로 변경해주시기 바랍니다.</p>';
    $html.='                </td>';
    $html.='            </tr>';
    $html.='            <tr>';
    $html.='                <td align="center" style="padding:50px">';
    $html.='                    <a href="'.$adm_url.'"><img src="'.$protocol.$_SERVER["HTTP_HOST"].'/images/mail_btn.gif" alt="Coolwallet 관리자 바로가기"></a>';
    $html.='                </td>';
    $html.='            </tr>';
    $html.='        </table>';
    $html.='    </td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='    <td align="center" style="border-top:1px solid #ed999a; padding-top:20px">';
    $html.='        <p style="color:#666;font-size:12px;line-height:20px;letter-spacing:-1px">';
    $html.='            본 메일은 발신 전용이며, 회신이 되지 않습니다.<br>';
    $html.='            추가 문의사항은 <a href="'.$qna_url.'" target="_blank" style="color:#1a93d9; text-decoration:none">1:1문의</a> 또는 한솔시큐어 고객센터(02-2082-0756)를 통해 문의하여 주시기 바랍니다.<br>';
    $html.='            Copyright &copy; Hansol secure Corp. All rights reserved.';
    $html.='        </p>';
    $html.='    </td>';
    $html.='</tr>';
	$html.='</table>';

	

	$mailTo = $to_mail; //수신주소
    //$nameTo  = $to_name; //수신자 이름

	$mailFrom = $from_mail; //발신주소
	$nameFrom  = $from_name; //발신자 이름
    
    $cc = ""; //참조
    $bcc = ""; //숨은참조

	$subject = "임시 비밀번호를 안내해드립니다.";
    $content = $html;    

    $charset = "UTF-8";

    $nameFrom   = "=?$charset?B?".base64_encode($nameFrom)."?=";
    //$nameTo   = "=?$charset?B?".base64_encode($nameTo)."?=";
    $subject = "=?$charset?B?".base64_encode($subject)."?=";

    $header  = "Content-Type: text/html; charset=utf-8\r\n";
    $header .= "MIME-Version: 1.0\r\n";

    $header .= "Return-Path: <". $mailFrom .">\r\n";
    $header .= "From: ". $nameFrom ." <". $mailFrom .">\r\n";
    $header .= "Reply-To: <". $mailFrom .">\r\n";
    if ($cc)  $header .= "Cc: ". $cc ."\r\n";
    if ($bcc) $header .= "Bcc: ". $bcc ."\r\n";

    $result = mail($mailTo, $subject, $content, $header);

    if($result) {
		return true;
	} else {
		return false;
	}


}



//==============================================================================
// DB 
//------------------------------------------------------------------------------

// DB 연결
function sql_connect($host, $user, $pass, $db=MYSQL_DB)
{

    if(function_exists('mysqli_connect') && MYSQLI_USE) {
        $link = mysqli_connect($host, $user, $pass, $db);

        // 연결 오류 발생 시 스크립트 종료
        if (mysqli_connect_errno()) {
            die('Connect Error: '.mysqli_connect_error());
        }
    } else {
        $link = mysql_connect($host, $user, $pass);
    }

    return $link;
}


// DB 선택
function sql_select_db($db, $connect)
{

    if(function_exists('mysqli_select_db') && MYSQLI_USE)
        return mysqli_select_db($connect, $db);
    else
        return mysql_select_db($db, $connect);
}


//DB 객체 생성
function db_connect(){
	$con_db = sql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die('MySQL Connect Error!!!');
	return $con_db; 
}


// multi-dimensional array에 사용자지정 함수적용
function array_map_deep($fn, $array)
{
    if(is_array($array)) {
        foreach($array as $key => $value) {
            if(is_array($value)) {
                $array[$key] = array_map_deep($fn, $value);
            } else {
                $array[$key] = call_user_func($fn, $value);
            }
        }
    } else {
        $array = call_user_func($fn, $array);
    }

    return $array;
}


// SQL Injection 대응 문자열 필터링
function sql_escape_string($str)
{
    $str = call_user_func('addslashes', $str);
    return $str;
}



//==============================================================================
// SQL Injection 등으로 부터 보호를 위해 sql_escape_string() 적용
//------------------------------------------------------------------------------
// magic_quotes_gpc 에 의한 backslashes 제거
if (get_magic_quotes_gpc()) {
    $_POST    = array_map_deep('stripslashes',  $_POST);
    $_GET     = array_map_deep('stripslashes',  $_GET);
    $_COOKIE  = array_map_deep('stripslashes',  $_COOKIE);
    $_REQUEST = array_map_deep('stripslashes',  $_REQUEST);
}

// sql_escape_string 적용
$_POST    = array_map_deep(ESCAPE_FUNCTION,  $_POST);
$_GET     = array_map_deep(ESCAPE_FUNCTION,  $_GET);
$_COOKIE  = array_map_deep(ESCAPE_FUNCTION,  $_COOKIE);
$_REQUEST = array_map_deep(ESCAPE_FUNCTION,  $_REQUEST);
//==============================================================================
?>