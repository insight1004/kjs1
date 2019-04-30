<?if (!defined('_COOL_')) exit; // 개별 페이지 접근 불가?>
<?
$page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);

$f_start = (isset($_REQUEST['f_start']) ? $_REQUEST['f_start'] : '');
$f_end = (isset($_REQUEST['f_end']) ? $_REQUEST['f_end'] : '');
$f_kind = (isset($_REQUEST['f_kind']) ? $_REQUEST['f_kind'] : '');
$f_txt = (isset($_REQUEST['f_txt']) ? $_REQUEST['f_txt'] : '');


if($f_txt=='')$f_kind='';
if($f_kind=='')$f_txt='';

//날짜 기본 셋팅
if($f_start == "") $f_start =  date('Y/m/d', strtotime(date('Y/m/d')."-30 days"));
if($f_end == "") $f_end = date('Y/m/d');
?>


<!-- datepicker js -->
<script src="../../js/form-plugins.min.js"></script>
<!-- END datepicker js -->

<script>
	$(document).ready(function() {
		FormPlugins.init();
	});

	function search(){
		var f = document.frmSearch;

		if (f.f_start.value != "" && f.f_end.value != "" && f.f_start.value > f.f_end.value){
			alert('날짜 범위가 올바르지 않습니다');
			f.f_end.focus();
			return false;
		}else{
			f.method = "get";
			f.action='./';
			f.submit();
		}
		
	}
</script>

<!-- contents area -->
<div class="con_wrap">
	<!-- search -->

	<form method="post" action="" name="frmSearch" id="frmSearch">
	<input type="hidden" name="abkind" value="<?=$abkind?>">
	<input type="hidden" name="amkind" value="<?=$amkind?>">
	<input type="hidden" name="askind" value="<?=$askind?>">

	<div class="search_wrap">
		<div class="panel">
			<ul>
				<li><h5>등록일</h5></li>
				<li>
					<div class="daterange">
						<label for="datepicker-default"><i class="mte i_date_range mte-1x vat"></i></label>
						<input type="text" class="" name="f_start" id="datepicker-default" placeholder="날짜선택" value="<?=$f_start?>" autocomplete="off"/>
					</div>
					~
					<div class="daterange">
						<label for="datepicker-autoClose"><i class="mte i_date_range mte-1x vat"></i></label>
						<input type="text" class="" name="f_end" id="datepicker-autoClose" placeholder="날짜선택" value="<?=$f_end?>" autocomplete="off"/>
					</div>
				</li>
				<li><h5>검색종류</h5></li>
				<li class="search_input">
					<div>
						<select name="f_kind" id="" class="">
							<!-- <option value="">=검색종류=</option> -->
							<option value="a_id" <?if($f_kind=='a_id')echo 'selected'?>>아이디</option>
							<option value="a_name" <?if($f_kind=='a_name')echo 'selected'?>>관리자 명</option>
						</select>
					</div>
					<div>
						<input type="text" name="f_txt" placeholder="검색" value="<?=$f_txt;?>">
						<a href="javascript:search();"><i class="mte i_search"></i></a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	</form>

	<?		

	//DB 객체 생성
	$con_db = db_connect();

	//SQL
	$columnStr = " a_id, a_name, a_level, a_tel, a_reg_date, a_state, a_ip ";
	$tableStr = " FROM ".$db['admin_table'];
	$whereStr = " WHERE a_state in (0, 1) ";
	$orderbyStr = " ORDER BY idx DESC ";
	

	//날짜 조건 (시작일)
	if($f_start!=''){
		$start_date = strtotime($f_start);
		$whereStr .= " AND a_reg_date >= '".date('Y-m-d', $start_date)." 00:00:00' "; 
	}


	//날짜 조건 (종료일)
	if($f_end!=''){
		$end_date = strtotime($f_end." +1 days");
		$whereStr .= " AND a_reg_date < '".date('Y-m-d', $end_date)." 00:00:00' "; 
	}
	

	//검색 단어
	if($f_kind!='' && $f_txt!='') $whereStr .= " AND ".$f_kind." like '%".$f_txt."%' "; 


	$sql = " SELECT count(idx) AS cnt ";
	$sql .= $tableStr;
	$sql .= $whereStr;
	//echo $sql;

	$result = $con_db->query($sql);
	$row = $result->fetch_assoc();

	$allPost = $row['cnt']; //전체 게시글의 수
	//$paging = "";
	
	?>
	
	<!-- list table -->
	<div class="table_wrap mt40">
		<div class="tit_wrap">
			<h4>관리자 목록</h4>
			<a href="" class="b_num">총 <?=$allPost;?>개</a>
		</div>
		<table>
			<colgroup>
				<col width="8%"/>
				<col width="*"/>
				<col width="10%"/>
				<col width="13%"/>
				<col width="15%"/>
				<col width="10%"/>
				<col width="15%"/>
			</colgroup>
			<tr>
				<th>No</th>
				<th>아이디</th>
				<th>관리자 명</th>
				<th>분류</th>
				<th>휴대전화</th>
				<th>상태</th>
				<th>등록일</th>
			</tr>
			

			<?
			if(!empty($allPost)) {

				$onePage = 20; // 한 페이지에 보여줄 게시글의 수.
				$pageGrp = 10; // 페이지 그룹 수.
				
				/*데이터 리스트 START*/
				$currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지
				$sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage; //limit sql 구문

				$sql = " SELECT " . $columnStr;
				$sql .= $tableStr; 
				$sql .= $whereStr;
				$sql .= $orderbyStr;
				$sql .=  $sqlLimit; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
				
				$result = mysqli_query($con_db, $sql);
				
			?>
				<?
				$i = 0;
				while($row = $result->fetch_assoc()){
				//NO (($allPost - $i)) - (($page-1)*$onePage)	
				?>		
				<tr <?if($row["a_state"]==0){?>style="background:#f6f6f6;"<?}?>>
					<td><?=(($allPost - $i)) - (($page-1)*$onePage)?></td>
					<td><a href="./?abkind=<?=$abkind?>&amkind=info&id=<?=$row["a_id"];?>&f_start=<?=$f_start;?>&f_end=<?=$f_end;?>&f_kind=<?=$f_kind;?>&f_txt=<?=$f_txt;?>&page=<?=$page;?>"><?=$row["a_id"];?></a></td>
					<td><?=$row["a_name"];?></td>
					<td>
						<?
						switch ($row["a_level"]) {
							case 'normal':
								echo '일반관리자';
								break;
							case 'super':
								echo '슈퍼관리자';
								break;
						}
						?>
					</td>
					<td><?=$row["a_tel"];?></td>
					<td>
						<?
						switch ($row["a_state"]) {
							case '0':
								echo '<font color="#ff3300">삭제</font>';
								break;
							case '1':
								echo '활동중';
								break;
						}
						?>
					</td>
					<td><?=substr($row["a_reg_date"], 0, 10);?></td>
				</tr>
				<?$i++; }?>

			<?}else{?>

				<tr>
					<td colspan="7" style="text-align:center;">등록된 관리자가 없습니다</td>
				</tr>

			<?}?>

		</table>
		<div class="foot_btn">
			<a href="./?abkind=adm&amkind=reg" class="b_add b_blue">관리자 등록</a>
		</div>
		

		<!-- page -->
		<?$param = "abkind=".$abkind."&amkind=".$amkind."&askind=".$askind."&f_start=".$f_start."&f_end=".$f_end."&f_kind=".$f_kind."&f_txt=".$f_txt;?>
		<?=paging($page, $onePage, $pageGrp, $allPost, $param);?>
		<!-- END page -->
		
	</div>
	<!-- END list table //-->
	
	<?$con_db=null;?>

</div>
<!-- END contents area //-->