<?php include_once("header.php");?>
<?php 
$banklist = db_list("bank","where userid='$userid'","order by bankid asc");
?>
<div class="table">
    <div class="table-header-group">  
        <ul class="table-row">  
            <li class="w12p">账户</li><li class="w12p">待结算总收入</li><li class="w12p">已结算总收入</li><li class="w12p">未结算总支出</li><li class="w12p">已结算总支出</li><li class="w22p">操作</li>
        </ul>  
    </div>
    <div class="table-row-group">
        <?php foreach($banklist as $item){ ?>
            <ul class="table-row">
                <li><?php echo $item["bankname"] ?></li>
                <li><?php echo show_money( total_account_sum($item["bankid"], 1, 1) ); ?></li>
                <li><?php echo show_money( total_account_sum($item["bankid"], 2, 1) ); ?></li>
                <li><?php echo show_money( total_account_sum($item["bankid"], 1, 2) ); ?></li>
                <li><?php echo show_money( total_account_sum($item["bankid"], 2, 2) ); ?></li>
                <li>
                    <a href="add.php?bankid=<?php echo $item["bankid"] ?>">记账</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="detail.php?bankid=<?php echo $item["bankid"] ?>">明细</a>
                </li>
            </ul>
        <?php } ?>
    </div>
</div>
<?php include_once("footer.php");?>
