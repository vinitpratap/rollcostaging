<?php session_start();?>

<?php if(isset($_SESSION['countPro']) && $_SESSION['countPro'] != 0){ ?>
<p id="compProd1" class=" <?php if(!isset($_SESSION['cpr1']) && $_SESSION['cpr1'] == ''){echo "displayNone";}?>" data-prod_part ="<?php if(isset($_SESSION['cpr1']) && $_SESSION['cpr1'] != ''){echo $_SESSION['cpr1'];}?>" ><span class="compProd1"><?php if(isset($_SESSION['cpr1']) && $_SESSION['cpr1'] != ''){echo $_SESSION['cpr1'];}?> </span><span class="close cprod1" > X </span> 
</p>
<p id="compProd2 " class="<?php if(!isset($_SESSION['cpr2']) && $_SESSION['cpr2'] == ''){echo "displayNone";}?>" data-prod_part ="<?php if(isset($_SESSION['cpr2']) && $_SESSION['cpr2'] != ''){echo $_SESSION['cpr2'];}?>"><span class="compProd2"><?php if(isset($_SESSION['cpr2']) && $_SESSION['cpr2'] != ''){echo $_SESSION['cpr2'];}?> </span><span class="close cprod2"> X </span> 
</p>
<p id="compProd3 " class="<?php if(!isset($_SESSION['cpr3']) && $_SESSION['cpr3'] == ''){echo "displayNone";}?>" data-prod_part ="<?php if(isset($_SESSION['cpr3']) && $_SESSION['cpr3'] != ''){echo $_SESSION['cpr3'];}?>"><span class="compProd3"><?php if(isset($_SESSION['cpr3']) && $_SESSION['cpr3'] != ''){echo $_SESSION['cpr3'];}?> </span><span class="close cprod3"> X </span>
</p>
<div class="compare-btn "><a href="compare.php" class="goToCompare <?php if(isset($_SESSION['countPro']) && $_SESSION['countPro'] != 0){if($_SESSION['countPro'] < 2){echo "displayNone";} }?>" > COMPARE</a></div>

<?php } ?>
