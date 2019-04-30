<?if (!defined('_COOL_')) exit; // 개별 페이지 접근 불가?>
<?
//DB 스키마

/*관리자 맴버 테이블*/
CREATE TABLE TB_Admin
(

idx int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY
,a_id varchar(100) NOT NULL    COMMENT '관리자 ID (이메일)'
,a_name varchar(50) NOT NULL   COMMENT '관리자 이름'
,a_pwd varchar(1000) NOT NULL  COMMENT '패스워드 (암호화)'
,a_level varchar(10) NOT NULL default 'normal' COMMENT 'normal:일반관리자, super:슈퍼관리자'
,a_tel varchar(20)             COMMENT '전화번호 (000-0000-0000 형식)'
,a_reg_date datetime           COMMENT '등록일자'
,a_edit_date datetime          COMMENT '수정일자'
,a_state tinyint(4) default 1  COMMENT '0:삭제, 1:정상(기본값)'

,a_del_memo varchar(1000)      COMMENT '삭제 메모'
,a_del_date datetime           COMMENT '삭제일자'
,a_reg_id varchar(50) NOT NULL COMMENT '등록자 ID -> 삭제자 ID'
,a_ip varchar(20) NOT NULL     COMMENT '등록 IP -> 수정 IP Or  삭제자 IP'

);



/*메인배너 테이블*/
CREATE TABLE TB_MainBanner
(

idx int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY
,mb_link varchar(500)             COMMENT '링크 주소'
,mb_target varchar(10) default '_self'   COMMENT '링크 타겟 _self(기본값), _blank'
,mb_reg_date datetime             COMMENT '등록일자'
,mb_edit_date datetime            COMMENT '수정일자'
,mb_state tinyint(4) default 1    COMMENT '0:삭제, 1:정상(기본값)'
,a_id varchar(50) NOT NULL        COMMENT '등록자 ID -> 수정자 ID'
,mb_ip varchar(20) NOT NULL       COMMENT '등록 IP -> 수정자 IP'

);


/*메인배너 파일 테이블*/
CREATE TABLE TB_MainBanner_File
(
idx int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY
,mb_idx int(11) NOT NULL	       COMMENT 'TB_MainBanner idx'
,filename varchar(200) NOT NULL    COMMENT '파일명'
);



/*공지사항 테이블*/
CREATE TABLE TB_Notice
(

idx int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY
,n_title varchar(200) NOT NULL   COMMENT '제목'
,n_content TEXT(20000)           COMMENT '내용' 
,n_reg_date datetime             COMMENT '등록일자'
,n_edit_date datetime            COMMENT '수정일자'
,n_state tinyint(4) default 1    COMMENT '0:삭제, 1:정상(기본값), 2:비노출 '
,a_id varchar(50) NOT NULL       COMMENT '등록자 ID -> 수정자 ID'
,n_ip varchar(20) NOT NULL       COMMENT '등록 IP -> 수정자 IP Or 삭제자 IP'

);


/*FAQ 테이블*/
CREATE TABLE TB_FAQ
(

idx int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY
,f_cate varchar(50)              COMMENT '카테고리'
,f_title varchar(200) NOT NULL   COMMENT '제목'
,f_content TEXT(20000)           COMMENT '내용'
,f_reg_date datetime             COMMENT '등록일자'
,f_edit_date datetime            COMMENT '수정일자'
,f_state tinyint(4) default 1    COMMENT '0:삭제, 1:정상(기본값), 2:비노출 '
,a_id varchar(50) NOT NULL       COMMENT '등록자 ID -> 수정자 ID Or 삭제자 ID'
,f_ip varchar(20) NOT NULL       COMMENT '등록 IP -> 수정자 IP Or 삭제자 IP'

);



/*1:1문의 테이블*/
CREATE TABLE TB_QNA
(

idx int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY
,q_title varchar(200) NOT NULL      COMMENT '제목'
,q_content TEXT(20000)              COMMENT '내용'
,q_usr varchar(50) NOT NULL         COMMENT '문의자 이름'
,q_usr_email varchar(100) NOT NULL  COMMENT '문의자 이메일'
,q_date datetime                    COMMENT '문의일자'
,q_usrip varchar(20) NOT NULL       COMMENT '문의 IP'


,q_acontent TEXT(20000)             COMMENT '답변내용'
,q_reg_date datetime                COMMENT '답변일자'
,q_state tinyint(4) default 1       COMMENT '0:삭제, 1:문의중(기본값), 10:답변완료 '
,q_email_state tinyint(4) default 1 COMMENT '0:실패, 1:대기(기본값), 10:전송완료 '
,q_email_date datetime              COMMENT '이메일 전송 일자'
,q_del_memo varchar(1000)           COMMENT '삭제 메모'
,q_del_date datetime                COMMENT '삭제일자'
,a_id varchar(50) NOT NULL          COMMENT '등록자 ID -> 삭제자 ID'
,q_ip varchar(20) NOT NULL          COMMENT '등록 IP -> 삭제자 IP'

);



/*1:1문의 파일 테이블*/
CREATE TABLE TB_QNA_File
(
idx int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY
,q_idx int(11) NOT NULL	           COMMENT 'TB_QNA idx'
,filename varchar(200) NOT NULL    COMMENT '파일명'
);

?>