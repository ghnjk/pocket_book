<?php include_once("header.php");?>
<?php 
$banklist = db_list("bank","where userid='$userid'","order by bankid asc");
?>
<div class="table">
    <div class="table-header-group">  
        <ul class="table-row">  
            <li class="w12p">�˻�</li><li class="w22p">���</li><li class="w22p">����</li>
        </ul>  
    </div>
    <div class="table-row-group">
        <?php foreach($banklist as $item){ ?>
            <ul class="table-row">
                <li><?php echo $item["bankname"] ?></li>
                <li><?php echo $item["balancemoney"] ?></li>
                <li><a href="add.php?bankname=<?php echo $item["bankname"] ?>">����</a></li>
            </ul>
        <?php } ?>
    </div>
</div>
<?php include_once("footer.php");?>
