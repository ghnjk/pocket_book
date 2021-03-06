<?php include_once("header.php");?>
<?php 
$banklist = db_list("bank","where userid='$userid'","order by CONVERT( bankname USING gbk )  asc");
if (get("type") == "in"){
    $type_name = "收入";
    $type = 1;
}else{
    $type_name = "支出";
    $type = 2;
}
$sum_1 = 0.0;
$sum_2 = 0.0;
?>
<div class="table">
    <div class="table-header-group">  
        <ul class="table-row">  
            <li class="w12p">账户</li><li class="w12p">待结算总<?php echo $type_name; ?></li><li class="w12p">已结算总<?php echo $type_name; ?></li><li class="w22p">操作</li>
        </ul>  
    </div>
    <div class="table-row-group">
        <?php foreach($banklist as $item){ 
            $total_1 = total_account_sum($item["bankid"], 1, $type);
            $total_2 = total_account_sum($item["bankid"], 2, $type);
            $sum_1 += $total_1;
            $sum_2 += $total_2;
            ?>
            <ul class="table-row">
                <li><?php echo $item["bankname"] ?></li>
                <li><?php echo show_money( $total_1 ); ?></li>
                <li><?php echo show_money( $total_2 ); ?></li>
                <li>
                    <a href="add.php?bankid=<?php echo $item["bankid"] ?>">记账</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="detail.php?bankid=<?php echo $item["bankid"] ?>">明细</a>
                </li>
            </ul>
        <?php } ?>
    </div>
    <div class="table-header-group">  
        <ul class="table-row">  
            <li class="w12p">合计</li><li class="w12p"><?php echo show_money($sum_1); ?></li><li class="w12p"><?php echo show_money($sum_2); ?></li><li class="w22p"></li>
        </ul>  
    </div>
</div>
<?php include_once("footer.php");?>
