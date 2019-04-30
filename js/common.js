
/**************************************************************************************
 * 공통으로 사용되는 스크립트
 **************************************************************************************/;


//숫자만 입력
function fn_onlyNumber(obj) {
	$(obj).keyup(function(){
		 $(this).val($(this).val().replace(/[^0-9]/g,""));
	}); 
}


//한글 입력제한
function fn_hanLimit(obj){
	$(obj).keyup(function(){
		$(this).val( $(this).val().replace( /[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/g, "" ) );
	}); 
}



//이메일 체크 		
function fn_emailChk(val){
	
	if( val.length > 0 ){
		
	   var regExp = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

       if(!regExp.test(val)){
         return false;
       }else{
		return true;
	   }
    }else{
		return false;
	}
}


//비밀번호 체크 (영문/숫자/특수문자 2가지 이상 조합, 8자~20자)
function fn_pwdChk(str){

 var pw = str;
 var num = pw.search(/[0-9]/g);
 var eng = pw.search(/[a-z]/ig);
 var spe = pw.search(/[`~!@@#$%^&*|₩₩₩'₩";:₩/?]/gi);

 if( (num < 0 && eng < 0) || (eng < 0 && spe < 0) || (spe < 0 && num < 0) ){
	return false;
 }else{
	return true;
 }

}



//공백 제거
function fn_trim(str){
	return str.replace(/ /gi, "");    // 모든 공백을 제거
}


//특수문자 체크
function fn_strCheck(str){
   //정규식 구문
    var RegExp = /[\{\}\[\]\/?.,;:|\)*~`!^\-_+┼<>@\#$%&\'\"\\\(\=]/gi;     
    if(str.match(RegExp)){ //정규표현식과 같은 부분이 있으면 true 
        return true;
    }
    return false;
}