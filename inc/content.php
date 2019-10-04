<?php
function estimate_sumary($start, $end, $uid, $bankid, $state="", $type=0, $classid=0){
	global $conn;
	$where = "where jiid='$uid'";
	if($bankid != ""){
		$where .= " and bankid = '$bankid'";
	}
	if($start != ""){
		$where .= " and actime >".strtotime($start." 00:00:00");
	}
	if($end != ""){
		$where .= " and actime <".strtotime($end." 23:59:59");
	}
	if($type!=0){
		$where .= " and zhifu='$type' ";
	}
	if($classid!=0){
		$where .= " and acclassid='$classid' ";
	}
	if($state != ""){
		$where .= " and state = '$state' ";
	}
	$sql = "SELECT sum(acmoney) as total FROM ".TABLE."account ".$where;
	$query = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($query);
	if($row['total']){
		$money = $row['total'];
	}else{
		$money = "0.00";
	}
	echo $money;
}
function state_day($start,$end,$uid,$type=0,$classid=0){
	global $conn;
	if($start==""){$start=date("Y-m-d");}
	if($end==""){$end=date("Y-m-d");}	
	$where = "where jiid='$uid'";
	$where .= " and actime >".strtotime($start." 00:00:00")." and actime <".strtotime($end." 23:59:59");
	if($type!=0){
		$where .= " and zhifu='$type' ";
	}
	if($classid!=0){
		$where .= " and acclassid='$classid' ";
	}
	$sql = "SELECT sum(acmoney) as total FROM ".TABLE."account ".$where;
	$query = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($query);
	if($row['total']){
		$money = $row['total'];
	}else{
		$money = "0.00";
	}
	echo $money;
}
function total_count($classid=0,$year,$uid){
	global $conn;
	$where = "where FROM_UNIXTIME(actime,'%Y')='$year' and jiid='$uid'";
	if($classid!=0){
		$where .= " and acclassid='$classid' ";
	}
	$sql = "SELECT FROM_UNIXTIME(actime, '%m') AS month,sum(acmoney) AS total FROM ".TABLE."account ".$where." GROUP BY month";
	$query = mysqli_query($conn,$sql);
	$resArr = array();
	while($row = mysqli_fetch_array($query)){
      $resArr[] = $row;
    }
    return $resArr;
}
function user_first_year($uid){
	global $conn;
	global $this_year;
	$sql = "SELECT actime FROM ".TABLE."account where jiid='$uid' order by actime limit 1";
	$query = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($query);
	if($row['actime']){
		$user_first_year = date("Y",$row['actime']);
	}else{
		$user_first_year = $this_year;
	}
	return $user_first_year;
}
function show_type($classtype,$uid){
	global $conn;
	if($classtype<>""){
		$sql = "select * from ".TABLE."account_class where ufid='$uid' and classtype='$classtype' order by classtype asc,classid asc";
	}else{
		$sql = "select * from ".TABLE."account_class where ufid='$uid' order by classtype asc,classid asc";
	}	
	$query = mysqli_query($conn,$sql);
	$resArr = array();
    while($row = mysqli_fetch_array($query)){
      $resArr[] = $row;
    }
    return $resArr;
}
function itlu_page_search($uid,$pagesize=20,$page=1,$classid,$starttime="",$endtime="",$startmoney="",$endmoney="",$remark="",$bankid="", $state=""){
	global $conn;
	$nums = record_num_query($uid,$classid,$starttime,$endtime,$startmoney,$endmoney,$remark,$bankid);
	$pages=ceil($nums/$pagesize);
	if($pages<1){$pages=1;}
	if($page > $pages){ $page=$pages; }
	if($page < 1){ $page=1; }
	$kaishi=($page-1)*$pagesize;
	$sql = "SELECT a.*,b.classname FROM ".TABLE."account as a INNER JOIN ".TABLE."account_class as b ON b.classid=a.acclassid ";
	if($classid == "all"){
		
	}elseif($classid == "pay"){
		$sql .= " and zhifu = 2 ";
	}elseif($classid == "income"){
		$sql .= " and zhifu = 1 ";
	}else{
		$sql .= " and acclassid = '".$classid."' ";
	}
	if(!empty($bankid)){
		$sql .= " and bankid = '".$bankid."' ";
	}
	if(!empty($starttime)){
		$sql .= " and actime >= '".strtotime($starttime." 00:00:00")."' ";
	}
	if(!empty($endtime)){
		$sql .= " and actime <= '".strtotime($endtime." 23:59:59")."' ";
	}
	if(!empty($startmoney)){
		$sql .= " and acmoney >= '".$startmoney."' ";
	}
	if(!empty($endmoney)){
		$sql .= " and acmoney <= '".$endmoney."' ";
	}
	if(!empty($remark)){
		$sql .= " and acremark like '%".$remark."%' ";
	}
	if (!empty($state)){
		$sql .= " and state = '$state' ";
	}
	$sql .= "where a.jiid = '$uid' and ";
	$sql .= "a.acid in (select acid from ".TABLE."account where jiid = '$uid') order by a.actime desc limit $kaishi,$pagesize";
	$query = mysqli_query($conn,$sql);
    $resArr = array();
    while($row = mysqli_fetch_array($query)){
      $resArr[] = $row;
    }
    return $resArr;
}
function itlu_page_query($uid,$pagesize=20,$page=1){
	global $conn;
	$nums = record_num_query($uid,"all");
	$pages=ceil($nums/$pagesize);
	if($pages<1){$pages=1;}
	if($page > $pages){ $page=$pages; }
	if($page < 1){ $page=1; }
	$kaishi=($page-1)*$pagesize;	
	$sql = "SELECT a.*,b.classname FROM ".TABLE."account as a INNER JOIN ".TABLE."account_class as b ON b.classid=a.acclassid ";
	$sql .= "where a.jiid = '$uid' and ";
	$sql .= "a.acid in (select acid from ".TABLE."account where jiid = '$uid') order by a.actime desc limit $kaishi,$pagesize";
	$query = mysqli_query($conn,$sql);
    $resArr = array();
    while($row = mysqli_fetch_array($query)){
      $resArr[] = $row;
    }
    return $resArr;
}
function record_num_query($uid,$classid="",$starttime="",$endtime="",$startmoney="",$endmoney="",$remark="",$bankid=""){
	global $conn;
	$sql = "select count(acid) as total from ".TABLE."account where jiid = '$uid'";
	if($classid == "all"){
		
	}elseif($classid == "pay"){
		$sql .= " and zhifu = 2 ";
	}elseif($classid == "income"){
		$sql .= " and zhifu = 1 ";
	}else{
		$sql .= " and acclassid = '".$classid."' ";
	}
	if(!empty($bankid)){
		$sql .= " and bankid = '".$bankid."' ";
	}
	if(!empty($starttime)){
		$sql .= " and actime >= '".strtotime($starttime." 00:00:00")."' ";
	}
	if(!empty($endtime)){
		$sql .= " and actime <= '".strtotime($endtime." 23:59:59")."' ";
	}
	if(!empty($startmoney)){
		$sql .= " and acmoney >= '".$startmoney."' ";
	}
	if(!empty($endmoney)){
		$sql .= " and acmoney <= '".$endmoney."' ";
	}
	if(!empty($remark)){
		$sql .= " and acremark like '%".$remark."%' ";
	}
	$query = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($query);
	if($row['total']){
		$count_num = $row['total'];
	}else{
		$count_num = "0";
	}
	return $count_num;
}
function bankname($bankid,$uid,$defaultname="默认"){
	global $conn;
	$sql = "select bankname from ".TABLE."bank where userid = '$uid' and bankid='$bankid'";
	$query = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($query);
	if($row['bankname']){
		$bankname = $row['bankname'];
	}else{
		$bankname = $defaultname;
	}
	return $bankname;
}
function query_once($uid,$id){
	global $conn;
	$sql = "SELECT a.*,b.classname FROM ".TABLE."account as a INNER JOIN ".TABLE."account_class as b ON b.classid=a.acclassid ";
	$sql .= "where a.jiid = '$uid' and ";
	$sql .= "a.acid = '$id'";
	$query = mysqli_query($conn,$sql);
    $resArr = array();
    while($row = mysqli_fetch_array($query)){
      $resArr[] = $row;
    }
    return $resArr;
}
function db_list($dbname,$where,$orderby){
	global $conn;
	$sql = "SELECT * FROM ".TABLE.$dbname." ".$where." ".$orderby;
	$query = mysqli_query($conn,$sql);
    $resArr = array();
    while($row = mysqli_fetch_array($query)){
      $resArr[] = $row;
    }
    return $resArr;
}
function money_int_out($bankid,$money,$zhifu){
	global $conn;
	if($zhifu=="1"){
		$sql = "update ".TABLE."bank set balancemoney=balancemoney+".$money." where bankid=".$bankid;	
	}elseif($zhifu=="2"){
		$sql = "update ".TABLE."bank set balancemoney=balancemoney-".$money." where bankid=".$bankid;	
	}
	$res = mysqli_query($conn,$sql);
}
?>
