<?if (!defined('_COOL_')) exit; // 개별 페이지 접근 불가?>

<?
//DB 객체 생성
$con_db = db_connect();
?>

<!-- popup 2 modify -->
<div class="pop-window fade" id="modal-modify">
	<form method="post" action="" name="frmEdit" id="frmEdit">
	<input type="hidden" name="mb_idx" value="">
	<div class="mban_input">
		<!-- head -->
		<div class="input_head">
			<h4>메인 배너 수정</h4>
			<a href="javascript:;" data-dismiss="modal"><i class="mte i_close mte-2x"></i></a>
		</div>
		<!-- con -->
		<div class="input_con">
			<ul>
				<li><h5>현재 이미지</h5></li>
				<li><input type="text" placeholder="현재 이미지" name="now_img" id="now_img" disabled></li>
				<li><h5>변경할 이미지</h5></li>
				<li>
					<div class="attach">
						<input type="text" name="file_name" id="file1" placeholder="이미지 등록하기" readonly>
						<label for="file_img1">
							<span class="b_file">첨부</span>
						</label>
						<input type="file" name="new_mb_file[]" id="file_img1" onchange="document.getElementById('file1').value=this.value;">
						<a href="javascript:fileCancel('frmEdit');" class="b_red">삭제</a>
					</div>
				</li>
				<li><h5>링크 사용</h5></li>
				<li class="input_chk">
					<div class="radio radio-css radio-danger">
						<input type="radio" name="mb_target" id="radio_css_1" checked value="no" onclick="linkUse('frmEdit', 'no');">
						<label for="radio_css_1">링크없음</label>
					</div>
					<div class="radio radio-css radio-danger">
						<input type="radio" name="mb_target" id="radio_css_2" value="_self" onclick="linkUse('frmEdit', '_self');">
						<label for="radio_css_2">현재 창</label>
					</div>
					<div class="radio radio-css radio-danger">
						<input type="radio" name="mb_target" id="radio_css_3" value="_blank" onclick="linkUse('frmEdit', '_blank');">
						<label for="radio_css_3">새 창</label>
					</div>
				</li>

				</li>
				<li><h5>링크 URL</h5></li>
				<li><input type="text" placeholder="http://" name="mb_link" disabled value=""></li>
			</ul>
		</div>
		<!-- foot -->
		<div class="modal_foot">
			<a href="javascript:bnEdit();" class="b_blue">수정</a>
			<a href="javascript:;" data-dismiss="modal" class="b_sgrey">취소</a>
		</div>
	</div>
	</form>
</div>
<!-- END popup 2 modify //-->


<!-- popup 3 add -->
<div class="pop-window fade" id="modal-add">
	<form method="post" action="" name="frm" id="frm" enctype="multipart/form-data">
	<div class="mban_input">
		<!-- head -->
		<div class="input_head">
			<h4>메인 배너 등록</h4>
			<a href="javascript:;" data-dismiss="modal"><i class="mte i_close mte-2x"></i></a>
		</div>
		<!-- con -->
		<div class="input_con">
			<ul>
				<li><h5>등록할 이미지</h5></li>
				<li>
					<div class="attach">
						<input type="text" name="file_name" id="file2" placeholder="이미지 등록하기" readonly>
						<label for="file_img2">
							<span class="b_file">첨부</span>
						</label>
						<input type="file" name="mb_file[]" id="file_img2" onchange="document.getElementById('file2').value=this.value;">
						<a href="javascript:fileCancel('frm');" class="b_red">삭제</a>
					</div>
				</li>
				<li><h5>링크 사용</h5></li>
				<li class="input_chk">
					<div class="radio radio-css radio-danger">
						<input type="radio" name="mb_target" id="radio_css_4" checked value="no" onclick="linkUse('frm', 'no');">
						<label for="radio_css_4">링크없음</label>
					</div>
					<div class="radio radio-css radio-danger">
						<input type="radio" name="mb_target" id="radio_css_5" value="_self" onclick="linkUse('frm', '_self');">
						<label for="radio_css_5">현재 창</label>
					</div>
					<div class="radio radio-css radio-danger">
						<input type="radio" name="mb_target" id="radio_css_6" value="_blank" onclick="linkUse('frm', '_blank');">
						<label for="radio_css_6">새 창</label>
					</div>
				</li>
				<li><h5>링크 URL</h5></li>
				<li><input type="text" placeholder="http://" name="mb_link" disabled ></li>
			</ul>
		</div>
		<!-- foot -->
		<div class="modal_foot">
			<a href="javascript:bnReg();" class="b_blue">등록</a>
			<a href="javascript:;" data-dismiss="modal" class="b_sgrey">취소</a>
		</div>
	</div>
	</form>
</div>
<!-- END popup 3 add //-->



<!-- contents area -->
<div class="con_wrap">
	<!-- main banner -->
	<div class="mban_wrap">
		<h4 class="title">메인이미지</h4>

		<!-- main banner edit --> 
		<ul class="mban_select">

			<?
			$sql = " SELECT idx, mb_link, mb_target, mb_reg_date, mb_edit_date, mb_state ";
			$sql .= " FROM ".$db['main_bn_table'];
			$sql .= " WHERE mb_state=1 ";
			$sql .= " ORDER BY idx DESC ";
			
			$result = mysqli_query($con_db, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				$i = 0;
				while($row = $result->fetch_assoc()){

					//이미지 조회
					$getFile = mysqli_fetch_assoc(mysqli_query($con_db, "SELECT filename FROM ".$db['main_bn_file_table']." WHERE mb_idx=".$row['idx']));
					$filename = $getFile['filename'];
					$file[$i] = $getFile['filename'];

				?>
					
					<li <?if($i==0){?>class="active"<?}?>>
						<a href="javascript:bnEditSel(<?=$row['idx'];?>, '<?=$filename;?>', '<?=$row['mb_target'];?>', '<?=$row['mb_link'];?>');" class="btn_edit">Edit</a>
						<a href="#nav-pills-tab-<?=$i+1;?>" data-toggle="tab" >
							<span class="mban_thumb"><img src="../../files/mainbn/<?=$filename;?>" alt="main banner <?=$i+1;?>"></span>
						</a>
					</li>

				<?
				$i++;
				}
			}
			?>

			<?if($i<3){?>
			<li class="mban_add">
				<div>
					<a href="#modal-add" data-toggle="modal">
						<i class="mte i_image mte-4x"></i><p>이미지 등록</p>
					</a>
				</div>
			</li>
			<?}?>

			
		</ul>


		<div class="mban_view">
			
			<?for($i=0; $i<count($file); $i++){?>
				<div class="fade <?if($i==0){?>active in<?}?>" id="nav-pills-tab-<?=$i+1?>">
					<img src="../../files/mainbn/<?=$file[$i];?>" alt="main banner <?=$i+1?>">
				</div>
			<?}?>

		</div>
		<!-- END main banner edit -->

	</div>
	<!-- END main banner //-->

	<!-- 1:1 question -->
	<div class="table_wrap">
		<div class="tit_wrap">
			<h4>1:1 문의</h4>
			<a href="./?abkind=qna" class="b_more">더보기 +</a>
		</div>
		<table>
			<colgroup>
				<col width="8%"/>
				<col width="*"/>
				<col width="9%"/>
				<col width="9%"/>
				<col width="15%"/>
				<col width="15%"/>
			</colgroup>
			<tr>
				<th>No</th>
				<th>제목</th>
				<th>문의자</th>
				<th>상태</th>
				<th>문의 일시</th>
				<th>답변 일시</th>
			</tr>

			
			<?
			$page = 1;

			//SQL
			$columnStr = " idx, q_title, q_content, q_usr, q_usr_email, q_date, q_usrip, q_acontent, q_reg_date, q_state, q_email_state, q_email_date, q_del_memo, q_del_date, a_id, q_ip ";
			$tableStr = " FROM ".$db['qna_table'];
			$whereStr = " WHERE q_state in (0, 1, 10) ";
			$orderbyStr = " ORDER BY idx DESC ";
			

			$sql = " SELECT count(idx) AS cnt ";
			$sql .= $tableStr;
			$sql .= $whereStr;
			//echo $sql;

			$result = $con_db->query($sql);
			$row = $result->fetch_assoc();

			$allPost = $row['cnt']; //전체 게시글의 수
			
			if(!empty($allPost)) {

				$onePage = 10; // 한 페이지에 보여줄 게시글의 수.
				
				/*데이터 리스트 START*/
				$currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지
				$sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage; //limit sql 구문

				$sql = " SELECT " . $columnStr;
				$sql .= $tableStr; 
				$sql .= $whereStr;
				$sql .= $orderbyStr;
				$sql .=  $sqlLimit; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
				
				$result = mysqli_query($con_db, $sql);
				
				
				$i = 0;
				while($row = $result->fetch_assoc()){
				//NO (($allPost - $i)) - (($page-1)*$onePage)	
				?>		

				<tr>
					<td><?=(($allPost - $i)) - (($page-1)*$onePage)?></td>
					<td class="tal"><a href="./?abkind=qna&amkind=detail&idx=<?=$row["idx"];?>"><?=$row["q_title"];?></a></td>
					<td><?=$row["q_usr"];?></td>
					<td>
						<?
						switch ($row["q_state"]) {
							case '10':
								echo '답변완료';
								break;
							case '1':
								echo '답변대기';
								break;
							case '0':
								echo '<font color="#ff3300">삭제</font>';
								break;
						}
						?>
					</td>
					<td><?=substr($row["q_date"], 0, 16);?></td>
					<td><?=substr($row["q_reg_date"], 0, 16);?></td>
				</tr>

				<?$i++; }?>

			<?}else{?>

				<tr>
					<td colspan="6" style="text-align:center;">등록된 1:1문의가 없습니다</td>
				</tr>

			<?}?>


		</table>
	</div>
	<!-- END 1:1 question //-->
</div>
<!-- END contents area //-->



<script type="text/javascript">


//배너등록
function bnReg(){
	var f = document.frm;


	var fileinput = $('#frm input[name="mb_file[]"]');
    var filecnt = 0;

    for (var i = 0; i < fileinput.length; i++) {
        if (fileinput[i].value) {
           filecnt++;
        }
    } 

	
	if(filecnt < 1){
		alert("<?=$msgstr['mb_file_null']?>");
		return false;

	}else if((f.mb_target.value=="_self" || f.mb_target.value=="_blank") && f.mb_link.value==""){
		alert("<?=$msgstr['mb_url_null']?>");
		f.mb_link.focus();
		return false;

	}else{

		if(confirm("<?=$msgstr['mb_reg_confirm']?>")){
			
			var ajax_url = "/proc/mainbn_reg_ok.php";	
			var formData = new FormData($("#frm")[0]);
			var params = "";
			var msg = "";

			$.ajax({
			   type:"post",
			   mimeType: 'multipart/form-data',
			   url:ajax_url,
			   //data:params,
			   data:formData,
			   dataType:"JSON", // JSON 리턴
			   beforeSend:function(){
					$("#frm input[name='file_name']").val('');
					$("#file_img2").val("");
					$('#modal-add').modal('hide');
			   },
			   success : function(data) {
					// success
					// TODO
					alert(data.rtnmsg);
					if (data.state){
						top.location.reload();
					}
			   },
			   complete : function(data) {
					 // 통신이 실패했어도 완료가 되었을 때
					 // TODO
			   },
			   error : function(xhr, status, error) {
					 //alert("통신 에러");
			   },
			   cache: false,
			   contentType: false,
			   processData: false,
			   timeout:100000 //응답제한시간 ms
			});

		}

	}
	
}


//배너선택 (수정)
function bnEditSel(idx, filename, target, linkurl){
	//값 셋팅
	$("#frmEdit input[name=mb_idx]").val(idx);
	$("#frmEdit input[name=now_img]").val(filename);
	$("#frmEdit input[name=mb_link]").val(linkurl);

	if (target=="no"){
		$("#radio_css_1").prop("checked", true)
		$("#frmEdit input[name=mb_link]").attr("disabled", true);
	}else if (target=="_self"){
		$("#radio_css_2").prop("checked", true)
		$("#frmEdit input[name=mb_link]").attr("disabled", false);
	}else if (target=="_blank"){
		$("#radio_css_3").prop("checked", true)
		$("#frmEdit input[name=mb_link]").attr("disabled", false);
	}

	$('#modal-modify').modal();
	
}


//배너수정
function bnEdit(){
	var f = document.frmEdit;


	if((f.mb_target.value=="_self" || f.mb_target.value=="_blank") && f.mb_link.value==""){
		alert("<?=$msgstr['mb_url_null']?>");
		f.mb_link.focus();
		return false;

	}else{

		if(confirm("<?=$msgstr['mb_edit_confirm']?>")){
			
			var ajax_url = "/proc/mainbn_edit_ok.php";	
			var formData = new FormData($("#frmEdit")[0]);
			var params = "";
			var msg = "";

			$.ajax({
			   type:"post",
			   mimeType: 'multipart/form-data',
			   url:ajax_url,
			   //data:params,
			   data:formData,
			   dataType:"JSON", // JSON 리턴
			   beforeSend:function(){
					$("#frmEdit input[name='file_name']").val('');
					$("#file_img1").val("");
					$('#modal-add').modal('hide');
			   },
			   success : function(data) {
					// success
					// TODO
					alert(data.rtnmsg);
					if (data.state){
						top.location.reload();
					}
			   },
			   complete : function(data) {
					 // 통신이 실패했어도 완료가 되었을 때
					 // TODO
			   },
			   error : function(xhr, status, error) {
					 //alert("통신 에러");
			   },
			   cache: false,
			   contentType: false,
			   processData: false,
			   timeout:100000 //응답제한시간 ms
			});

		}

	}
	
	
	
}



//링크사용
function linkUse(frm, kind){
	if(kind=="no"){
		$("#"+frm+" input[name=mb_link]").attr("disabled", true); //설정
	}else if(kind=="_self" || kind=="_blank"){
		$("#"+frm+" input[name=mb_link]").attr("disabled", false); //해제
	}
}


//파일 선택 취소
function fileCancel(frm){

	if(frm=='frm'){

		if($("#file_img2").val()==''){
			alert("<?=$msgstr['img_del_null']?>");
		}else{
			$("#"+frm+" input[name=file_name]").val('');
			$("#file_img2").val("");
		}


	}else if(frm=='frmEdit'){

		if($("#file_img1").val()==''){
			alert("<?=$msgstr['img_del_null']?>");
		}else{
			$("#"+frm+" input[name=file_name]").val('');
			$("#file_img1").val("");
		}

	}

}
</script>