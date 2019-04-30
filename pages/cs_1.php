<?if (!defined('_COOL_')) exit; // 개별 페이지 접근 불가?>
<?
$page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);
?>

<!-- Main Slider banner -->
<div class="sub_top cs cs1"></div>
<!-- END Main Slider banner -->

<!-- contents -->
<div class="sub_con">
	<div class="app_tit">
		<h1>공지사항</h1>
		<p>CoolWallet S 와 관련된 공지사항을 알려드립니다.</p>
	</div>
	
	<!-- list -->
	<div class="list_wrap" id="accordion">
		<!-- list cols group -->
		
		<?
		//DB 객체 생성
		$con_db = db_connect();

		//SQL
		$columnStr = " idx, n_title, n_content, n_reg_date, n_edit_date, n_state, a_id, n_ip ";
		$tableStr = " FROM ".$db['notice_table'];
		$whereStr = " WHERE n_state in (1) ";
		$orderbyStr = " ORDER BY idx DESC ";
		

		$sql = " SELECT count(idx) AS cnt ";
		$sql .= $tableStr;
		$sql .= $whereStr;

		$result = $con_db->query($sql);
		$row = $result->fetch_assoc();

		$allPost = $row['cnt']; //전체 게시글의 수
		//$paging = "";
		
		?>
		
		<?
		if(!empty($allPost)) {

			$onePage = 20; // 한 페이지에 보여줄 게시글의 수.
			$pageGrp = 10; // 페이지 그룹 수.
			$pageGrp_m = 5; // 페이지 그룹 수. (모바일)
			
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
			while($row = $result->fetch_assoc()){
			//NO (($allPost - $i)) - (($page-1)*$onePage)	
			?>	
				<div class="panel cols_wrap">
					<!-- list title -->
					<div class="cols_tit">
						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#cols_<?=$row["idx"];?>">
							<i class="mte mte-3x"></i>
							<?=$row["n_title"];?>
						</a>
					</div>
					<!-- END list title //-->
					<!-- contents view -->
					<div id="cols_<?=$row["idx"];?>" class="view_wrap collapse">
						<div class="view_con">
							<h3><?=$row["n_title"];?></h3>

							<p><?=htmlspecialchars_decode($row["n_content"]);?></p>
							
							<p class="date"><?=substr($row["n_reg_date"], 0, 16);?></p>
						</div>
					</div>
					<!-- END contents view //-->
				</div>
				<!-- END list cols group //-->
			<?}?>
		<?}else{?>
			<div class="panel cols_wrap" >
				<div class="cols_tit">
					<a class="collapsed" >
						등록된 공지사항이 없습니다
					</a>
				</div>
			</div>

		<?}?>


	</div>
	<!-- END list //-->

	<!-- page -->
	<?$param = "bkind=".$bkind."&mkind=".$mkind."&skind=".$skind;?>
	<?=paging($page, $onePage, $pageGrp, $allPost, $param);?>
	<?=paging_m($page, $onePage, $pageGrp_m, $allPost, $param);?>
	<!-- END page -->

</div>
<!-- END contents //-->
