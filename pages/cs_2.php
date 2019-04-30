<?if (!defined('_COOL_')) exit; // 개별 페이지 접근 불가?>
<?
$page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);
?>

<!-- Main Slider banner -->
<div class="sub_top cs cs2"></div>
<!-- END Main Slider banner -->

<!-- contents -->
<div class="sub_con">
	<div class="app_tit">
		<h1>FAQ</h1>
		<p>고객님께서 자주 문의하신 질문과 답변입니다.</p>
	</div>
	
	<!-- tab menu -->
	<div class="tab_wrap">
		<ul>
			<li <?if($mkind=='') echo "class='on'";?>><a href="sub.php?bkind=<?=$bkind?>">전체</a></li>
			<li <?if($mkind=='일반문의') echo "class='on'";?>><a href="sub.php?bkind=<?=$bkind?>&mkind=일반문의">일반문의</a></li>
			<li <?if($mkind=='사용문의') echo "class='on'";?>><a href="sub.php?bkind=<?=$bkind?>&mkind=사용문의">사용문의</a></li>
			<li <?if($mkind=='고장문의') echo "class='on'";?>><a href="sub.php?bkind=<?=$bkind?>&mkind=고장문의">고장문의</a></li>
		</ul>
	</div>
	<!-- END tab menu //-->
	
	<!-- list -->
	<div class="list_wrap" id="accordion">

		<?
		//DB 객체 생성
		$con_db = db_connect();

		//SQL
		$columnStr = " idx, f_cate, f_title, f_content, f_reg_date, f_edit_date, f_state, a_id, f_ip ";
		$tableStr = " FROM ".$db['faq_table'];
		$whereStr = " WHERE f_state in (1) ";
		$orderbyStr = " ORDER BY idx DESC ";
		
		//카테고리
		if($mkind != "") $whereStr .= " AND f_cate like '%".$mkind."%' "; 

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
							<?=$row["f_title"];?>
						</a>
					</div>
					<!-- END list title //-->
					<!-- contents view -->
					<div id="cols_<?=$row["idx"];?>" class="view_wrap collapse">
						<div class="view_con">
							<h3><?=$row["f_title"];?></h3>

							<p><?=htmlspecialchars_decode($row["f_content"]);?></p>
							
							<p class="date"><?=substr($row["f_reg_date"], 0, 16);?></p>
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
						등록된 FAQ가 없습니다
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
