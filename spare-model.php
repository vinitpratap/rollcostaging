
<?php
include 'class/config.php';
if (isset($_POST['sid']) && $_POST['sid'] > 0) {

    $spareSql = "SELECT spare_img,spare_part_no FROM rollco_ms_spare WHERE spare_id='" . $_POST['sid'] . "'";

    $numsrow = $sq->numsrow($spareSql);
    if ($numsrow > 0) {
        $sdata = $sq->fearr($spareSql);
        ?>
        <!-- Modal body -->
        <div class="modal-body">
            <div class="w-100 d-block mb-4"> <img id="ContentPlaceHolder1_ImageSpair" src="../upload/spare/<?php echo $sdata['spare_img']; ?>" align="absmiddle" class="img-fluid" style="max-width: 50% !important;"></div>
            <div class="table-responsive d-inline-flex">
                <table class="table table-striped table-bordered nb-4 w-50">
                    <thead class="thead-light">
                        <tr>
                            <th>Servicing_Numbers</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $spareSql = "SELECT ss.srvs_num FROM rollco_ms_spare AS s INNER JOIN rollco_ms_spearservice as ss ON ss.spare_num = s.spare_part_no INNER JOIN rollco_ms_product as p ON p.prod_part_no = ss.srvs_num WHERE s.spare_id='" . $_POST['sid'] . "'";
                        $numsrow2 = $sq->numsrow($spareSql);
                        if ($numsrow2 > 0) {
                            $spData = $sq->query($spareSql);
                            while ($rs1 = $sq->fetch($spData)) {
                                ?>
                                <tr>
                                    <td><?php echo $rs1['srvs_num']; ?></td>
                                </tr>

                            <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <table class="table table-striped table-bordered nb-4 w-50">
                    <thead class="thead-light">
                        <tr>
                            <th>Component_OEM_Numbers</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $spareSql1 = "SELECT so.oem_num FROM rollco_ms_spare AS s INNER JOIN rollco_ms_spearoem as so ON so.spare_num = s.spare_part_no WHERE s.spare_id='".$_POST['sid']."' ";
                        $numsrow3 = $sq->numsrow($spareSql1);
                        if ($numsrow3 > 0) {
                            $spData1 = $sq->query($spareSql1);
                            while ($soem = $sq->fetch($spData1)) {
                                ?>
                                <tr>
                                    <td><?php echo $soem['oem_num'];?></td>
                                </tr>
                            <?php
                            }
                        }
                        ?>
                    </tbody>
                </table> 
            </div>


        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        <?php
    }
}
?>
