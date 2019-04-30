<?if (!defined('_COOL_')) exit; // 개별 페이지 접근 불가?>
<?

$msgstr = array(

"db_err"		=> "DB Error"

,"board_null"		=> "존재하지 않는 게시글 입니다."
,"data_null"		=> "데이터가 없습니다."
,"deny1"			=> "로그인이 필요합니다."
,"deny2"			=> "접속 권한이 없습니다."
,"logout_confirm"	=> "로그아웃 하시겠습니까?"
,"logout_success"	=> "로그아웃 되었습니다."
,"param_null"		=> "모든 항목을 입력하세요."
,"adm_null"			=> "관리자 정보가 조회 되지 않습니다."
,"file_err"			=> "선택한 파일에 오류가 있습니다."
,"file_up_err"		=> "파일 업로드중 오류가 발생했습니다."
,"file_onlyimg"		=> "형식의 파일만 등록 가능합니다."
,"file_format_limit"=> "허용된 파일 확장자가 아닙니다."
,"file_format_limit2"=> "형식의 파일만 첨부가 가능합니다.\\n파일의 확장자를 확인해 주세요."
,"file_size_limit"	=> "MB 까지 첨부 가능합니다. 파일의 용량을 확인해 주세요."
,"file_del_null"	=> "삭제할 파일이 없습니다. 파일을 다시 확인해주세요."
,"save_err"			=> "데이터 저장중 오류가 발생했습니다."
,"save_success"		=> "등록 되었습니다."
,"edit_err"			=> "데이터 수정중 오류가 발생했습니다."
,"edit_success"		=> "수정 되었습니다."
,"del_err"			=> "데이터 삭제중 오류가 발생했습니다."
,"del_success"		=> "삭제 되었습니다."
,"save_confirm"		=> "등록 하시겠습니까?."
,"edit_confirm"		=> "수정 하시겠습니까?."
,"email_fail"		=> "이메일 전송에 실패 했습니다."
,"img_del_null"		=> "삭제할 이미지가 없습니다. 이미지를 다시 확인해주세요."

//로그인
,"login_id_null"	=> "아이디(E-mail)를 입력하세요."
,"login_pwd_null"	=> "비밀번호를 입력하세요."
,"login_success"	=> "로그인 완료."
,"acount_del"		=> "삭제된 관리자 계정입니다."
,"acount_deny"		=> "입력하신 아이디/비밀번호가 올바르지 않습니다."
,"acount_active_err" => "활동중인 계정이 아닙니다."
,"pwd_renew_success" => "임시 비밀번호가 담긴 메일이 발송되었습니다. \\n입력하신 이메일을 확인해 주세요."

//관리자 
,"email_deny"	=> "올바른 이메일 주소가 아닙니다."
,"id_null"		=> "아이디로 사용할 이메일을 입력하세요."
,"id_aready"	=> "이미 사용중인 아이디 입니다."
,"id_ok"		=> "사용 가능한 아이디입니다."
,"name_null"	=> "관리자 명을 입력하세요."
,"name_deny"	=> "관리자 명은 한글/영문 20자까지 입력 가능합니다."
,"pwd_null"		=> "사용할 비밀번호를 입력하세요."
,"pwd_null2"	=> "비밀번호를 다시한번 입력하세요."
,"pwd_deny"		=> "비밀번호는 영문/숫자/특수문자 2가지 이상 조합, 8자~20자 이내로 입력하세요."
,"pwd_match"	=> "입력한 비밀번호가 일치하지 않습니다."
,"pwd_renew_limit"	=> "슈퍼관리자는 비밀번호 찾기를 사용 할 수 없습니다."
,"level_null"	=> "분류를 선택하세요."
,"tel_null"		=> "전화번호를 선택하세요."
,"tel_null2"	=> "전화번호를 입력하세요."
,"tel_length"	=> "연락처는 12자까지 입력 가능합니다."
,"adm_reg_success"	=> "관리자 등록이 완료되었습니다."
,"adm_edit_success"	=> "수정이 완료 되었습니다."
,"adm_del_state"	=> "삭제 상태의 관리자는 수정이 불가능 합니다."
,"adm_del_aready"	=> "이미 삭제 상태입니다."
,"adm_del_success"	=> "삭제 완료 되었습니다."
,"memo_null"	=> "삭제 사유를 입력하세요."
,"memo_length"	=> "삭제 사유는 100자 까지 입력 가능합니다."


//메인배너
,"mb_file_null"	=> "등록할 이미지를 선택하세요."
,"mb_url_null"	=> "링크 URL을 입력하세요."
,"mb_reg_confirm"	=> "이미지를 등록하겠습니까?"
,"mb_file_err"		=> "선택한 파일에 오류가 있습니다."
,"mb_edit_confirm"	=> "수정 하겠습니까?"
,"mb_del_confirm"	=> "삭제 하겠습니까?"
,"mb_cnt_limit"		=> "메인 배너는 3개 까지 등록 가능합니다."
,"mb_cnt_limit2"	=> "메인 배너는 1개 이상 등록 해야합니다."

//공지사항
,"noti_state_null"	=> "노출 여부를 선택하세요."
,"noti_title_null"	=> "제목을 입력하세요."
,"noti_con_null"	=> "내용을 입력하세요."
,"noti_con_length"	=> "내용은 한글/영문/숫자/특수문자 5,000자 이내 입력 가능합니다."

//FAQ
,"faq_state_null"	=> "노출 여부를 선택하세요."
,"faq_title_null"	=> "제목을 입력하세요."
,"faq_con_null"		=> "내용을 입력하세요."
,"faq_con_length"	=> "내용은 한글/영문/숫자/특수문자 5,000자 이내 입력 가능합니다."
,"faq_cate_null"	=> "카테고리를 선택하세요."


//1:1문의
,"qna_name_null"	=> "문의자 명을 입력해주세요."
,"qna_email_null"	=> "이메일을 입력하세요."
,"qna_email_deny"	=> "올바른 이메일 주소가 아닙니다."
,"qna_title_null"	=> "문의 제목을 입력하세요."
,"qna_content_null"	=> "문의 내용을 입력하세요."
,"qna_content_length"	=> "문의 내용은 1,000자 까지 입력 가능합니다."
,"qna_agree_null"	=> "1:1문의를 위해 개인정보 취급방침에 동의해 주세요."
,"qna_reg_confirm"	=> "1:1문의를 등록 하시겠습니까?"
,"qna_success"		=> "1:1문의가 등록 등록 되었습니다."
,"qna_state_deny"	=> "답변 상태를 [답변 완료]로 변경해주세요."
,"qna_answer_null"	=> "답변을 입력하세요."
,"qna_answer_length"=> "답변은 한글/영문/숫자/특수문자 5,000자 이내 입력 가능합니다."
,"qna_answer_success"=> "답변이 등록되었습니다."
,"qna_answer_err"=> "답변 등록중 오류가 발생하였습니다."
,"qna_memo_null"	=> "답변 제외 사유를 입력하세요."
,"qna_memo_length"	=> "답변 제외 사유는 100자 까지 입력 가능합니다."

);



//전화번호
$tel_txt = "=선택=|010|011|016|017|018|019|070|02|031|032|033|041|042|043|044|051|052|053|054|055|061|062|063|064";
$tel_value = "|010|011|016|017|018|019|070|02|031|032|033|041|042|043|044|051|052|053|054|055|061|062|063|064";

?>