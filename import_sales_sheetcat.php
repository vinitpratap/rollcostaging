<?php
include("class/config.php");
$_SESSION['mstart'] = time();


ini_set('max_execution_time', 0);

if (isset($_FILES['file'])) {          //If Condition start here
    $handle = fopen($_FILES['file']['tmp_name'], "r");
    $mycount = 0;
    $count = 0;
    $mycnts = 0;
//$current_date=date('d-m-y');
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { //While loop start here
        if ($mycnts > 0) {
//echo "<pre>";print_r($data);die;
//Swith Case Variable start here
//code start for import Profile Change

            $AcCode = trim($data[0]);
            $CompanyName = trim($data[1]);

            $CaliperQty2018 = trim($data[2]);
            $CaliperValue2018 = trim($data[3]);

            $STEERINGPUMPQty2018 = trim($data[4]);
            $STEERINGPUMPValue2018 = trim($data[5]);


            $driveshaftQty2018 = trim($data[6]);
            $driveshaftValue2018 = trim($data[7]);

            $cvjointQty2018 = trim($data[8]);
            $cvjointValue2018 = trim($data[9]);

            $emsQty2018 = trim($data[10]);
            $emsValue2018 = trim($data[11]);

            $sparesQty2018 = trim($data[12]);
            $sparesValue2018 = trim($data[13]);

            $rotatingQty2018 = trim($data[14]);
            $rotatingValue2018 = trim($data[15]);




            $CaliperQty2019 = trim($data[16]);
            $CaliperValue2019 = trim($data[17]);

            $STEERINGPUMPQty2019 = trim($data[20]);
            $STEERINGPUMPValue2019 = trim($data[21]);


            $driveshaftQty2019 = trim($data[18]);
            $driveshaftValue2019 = trim($data[19]);

            $cvjointQty2019 = trim($data[22]);
            $cvjointValue2019 = trim($data[23]);

            $emsQty2019 = trim($data[24]);
            $emsValue2019 = trim($data[25]);

            $sparesQty2019 = trim($data[26]);
            $sparesValue2019 = trim($data[27]);

            $rotatingQty2019 = trim($data[28]);
            $rotatingValue2019 = trim($data[29]);


            $CaliperQty2020 = trim($data[30]);
            $CaliperValue2020 = trim($data[31]);

            $STEERINGPUMPQty2020 = trim($data[34]);
            $STEERINGPUMPValue2020 = trim($data[35]);


            $driveshaftQty2020 = trim($data[32]);
            $driveshaftValue2020 = trim($data[33]);

            $cvjointQty2020 = trim($data[36]);
            $cvjointValue2020 = trim($data[37]);

            $emsQty2020 = trim($data[38]);
            $emsValue2020 = trim($data[39]);

            $sparesQty2020 = trim($data[40]);
            $sparesValue2020 = trim($data[41]);

            $rotatingQty2020 = trim($data[42]);
            $rotatingValue2020 = trim($data[43]);


            $u_id = 0;

            $u_sql = "select ss_id from rollco_ms_sales_sheet where AcCode = '" . $AcCode . "'  LIMIT 1 ";
            $u_res = $sq->fearr($u_sql);
            if (isset($u_res['ss_id']) && $u_res['ss_id'] != '')
                $u_id = $u_res['ss_id'];

            if ($u_id != '') {
                if ($CaliperQty2018 != '' || $CaliperValue2018 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =6,ssv_scat_name='CALIPER',ssv_scat_year=2018,ssv_scat_value='" . $CaliperValue2018 . "',ssv_scat_qty='" . $CaliperQty2018 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }

                if ($CaliperQty2019 != '' || $CaliperValue2019 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =6,ssv_scat_name='CALIPER',ssv_scat_year=2019,ssv_scat_value='" . $CaliperValue2019 . "',ssv_scat_qty='" . $CaliperQty2019 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }

                if ($CaliperQty2020 != '' || $CaliperValue2020 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =6,ssv_scat_name='CALIPER',ssv_scat_year=2020,ssv_scat_value='" . $CaliperValue2020 . "',ssv_scat_qty='" . $CaliperQty2020 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }

                if ($STEERINGPUMPQty2018 != '' || $STEERINGPUMPValue2018 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =9,ssv_scat_name='STEERING PUMP',ssv_scat_year=2018,ssv_scat_value='" . $STEERINGPUMPValue2018 . "',ssv_scat_qty='" . $STEERINGPUMPQty2018 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }

                if ($STEERINGPUMPQty2019 != '' || $STEERINGPUMPValue2019 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =9,ssv_scat_name='STEERING PUMP',ssv_scat_year=2019,ssv_scat_value='" . $STEERINGPUMPValue2019 . "',ssv_scat_qty='" . $STEERINGPUMPQty2019 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }

                if ($STEERINGPUMPQty2020 != '' || $STEERINGPUMPValue2020 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =9,ssv_scat_name='STEERING PUMP',ssv_scat_year=2020,ssv_scat_value='" . $STEERINGPUMPValue2020 . "',ssv_scat_qty='" . $STEERINGPUMPQty2020 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }

                if ($driveshaftQty2018 != '' || $driveshaftValue2018 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =9,ssv_scat_name='Drive Shaft',ssv_scat_year=2018,ssv_scat_value='" . $driveshaftValue2018 . "',ssv_scat_qty='" . $driveshaftQty2018 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }

                if ($driveshaftQty2019 != '' || $driveshaftValue2019 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =9,ssv_scat_name='Drive Shaft',ssv_scat_year=2019,ssv_scat_value='" . $driveshaftValue2018 . "',ssv_scat_qty='" . $driveshaftQty2018 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }


                if ($driveshaftQty2020 != '' || $driveshaftValue2020 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =9,ssv_scat_name='Drive Shaft',ssv_scat_year=2020,ssv_scat_value='" . $driveshaftValue2020 . "',ssv_scat_qty='" . $driveshaftQty2020 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }

                if ($cvjointQty2018 != '' || $cvjointValue2018 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =8,ssv_scat_name='CV Joint',ssv_scat_year=2018,ssv_scat_value='" . $cvjointValue2018 . "',ssv_scat_qty='" . $cvjointQty2018 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }

                if ($cvjointQty2019 != '' || $cvjointValue2019 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =8,ssv_scat_name='CV Joint',ssv_scat_year=2019,ssv_scat_value='" . $cvjointValue2019 . "',ssv_scat_qty='" . $cvjointQty2018 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }

                if ($cvjointQty2020 != '' || $cvjointValue2020 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =8,ssv_scat_name='CV Joint',ssv_scat_year=2020,ssv_scat_value='" . $cvjointValue2019 . "',ssv_scat_qty='" . $cvjointQty2020 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }

                if ($emsQty2018 != '' || $emsValue2018 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =5,ssv_scat_name='EMS',ssv_scat_year=2018,ssv_scat_value='" . $emsValue2018 . "',ssv_scat_qty='" . $emsQty2018 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }

                if ($emsQty2019 != '' || $emsValue2019 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =5,ssv_scat_name='EMS',ssv_scat_year=2019,ssv_scat_value='" . $emsValue2019 . "',ssv_scat_qty='" . $emsQty2019 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }
                if ($emsQty2020 != '' || $emsValue2020 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =5,ssv_scat_name='EMS',ssv_scat_year=2020,ssv_scat_value='" . $emsValue2020 . "',ssv_scat_qty='" . $emsQty2020 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }




                if ($sparesQty2018 != '' || $sparesValue2018 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =4,ssv_scat_name='SPARES',ssv_scat_year=2018,ssv_scat_value='" . $sparesValue2018 . "',ssv_scat_qty='" . $sparesQty2018 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }

                if ($sparesQty2019 != '' || $sparesValue2019 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =4,ssv_scat_name='SPARES',ssv_scat_year=2019,ssv_scat_value='" . $sparesValue2019 . "',ssv_scat_qty='" . $sparesQty2019 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }

                if ($sparesQty2020 != '' || $sparesValue2020 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =4,ssv_scat_name='SPARES',ssv_scat_year=2020,ssv_scat_value='" . $sparesValue2020 . "',ssv_scat_qty='" . $sparesQty2020 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }



                if ($rotatingQty2018 != '' || $rotatingValue2018 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =7,ssv_scat_name='Rotating',ssv_scat_year=2018,ssv_scat_value='" . $rotatingValue2018 . "',ssv_scat_qty='" . $rotatingQty2018 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }
                if ($rotatingQty2019 != '' || $rotatingValue2019 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =7,ssv_scat_name='Rotating',ssv_scat_year=2019,ssv_scat_value='" . $rotatingValue2019 . "',ssv_scat_qty='" . $rotatingQty2019 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }
                if ($rotatingQty2020 != '' || $rotatingValue2020 != '') {
                    $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =7,ssv_scat_name='Rotating',ssv_scat_year=2020,ssv_scat_value='" . $rotatingValue2020 . "',ssv_scat_qty='" . $rotatingQty2020 . "',ssv_ss_id='" . $u_id . "'";
                    $sq->query($ins_sql);
                    $count++;
                }
            } else {
                $checkuser_sql = "SELECT u_id,com_emailAddress,com_zipCode,customerID FROM rollco_ms_users WHERE customerID='" . $AcCode . "' LIMIT 1";
                $u_res1 = $sq->fearr($checkuser_sql);
                if ($u_res1['u_id'] != '') {
                    $insertSql = "INSERT INTO rollco_ms_sales_sheet SET user_id='" . $u_res1['u_id'] . "',user_email='" . $u_res1['com_emailAddress'] . "',user_postcode='" . $u_res1['com_zipCode'] . "',AcCode='".$u_res1['customerID']."'";
                    $sq->query($insertSql);
                    $u_id = $sq->insertid();
                    
                    if ($CaliperQty2018 != '' || $CaliperValue2018 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =6,ssv_scat_name='CALIPER',ssv_scat_year=2018,ssv_scat_value='" . $CaliperValue2018 . "',ssv_scat_qty='" . $CaliperQty2018 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }

                    if ($CaliperQty2019 != '' || $CaliperValue2019 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =6,ssv_scat_name='CALIPER',ssv_scat_year=2019,ssv_scat_value='" . $CaliperValue2019 . "',ssv_scat_qty='" . $CaliperQty2019 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }

                    if ($CaliperQty2020 != '' || $CaliperValue2020 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =6,ssv_scat_name='CALIPER',ssv_scat_year=2020,ssv_scat_value='" . $CaliperValue2020 . "',ssv_scat_qty='" . $CaliperQty2020 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }

                    if ($STEERINGPUMPQty2018 != '' || $STEERINGPUMPValue2018 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =9,ssv_scat_name='STEERING PUMP',ssv_scat_year=2018,ssv_scat_value='" . $STEERINGPUMPValue2018 . "',ssv_scat_qty='" . $STEERINGPUMPQty2018 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }

                    if ($STEERINGPUMPQty2019 != '' || $STEERINGPUMPValue2019 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =9,ssv_scat_name='STEERING PUMP',ssv_scat_year=2019,ssv_scat_value='" . $STEERINGPUMPValue2019 . "',ssv_scat_qty='" . $STEERINGPUMPQty2019 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }

                    if ($STEERINGPUMPQty2020 != '' || $STEERINGPUMPValue2020 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =9,ssv_scat_name='STEERING PUMP',ssv_scat_year=2020,ssv_scat_value='" . $STEERINGPUMPValue2020 . "',ssv_scat_qty='" . $STEERINGPUMPQty2020 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }

                    if ($driveshaftQty2018 != '' || $driveshaftValue2018 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =9,ssv_scat_name='Drive Shaft',ssv_scat_year=2018,ssv_scat_value='" . $driveshaftValue2018 . "',ssv_scat_qty='" . $driveshaftQty2018 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }

                    if ($driveshaftQty2019 != '' || $driveshaftValue2019 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =9,ssv_scat_name='Drive Shaft',ssv_scat_year=2019,ssv_scat_value='" . $driveshaftValue2018 . "',ssv_scat_qty='" . $driveshaftQty2018 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }


                    if ($driveshaftQty2020 != '' || $driveshaftValue2020 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =9,ssv_scat_name='Drive Shaft',ssv_scat_year=2020,ssv_scat_value='" . $driveshaftValue2020 . "',ssv_scat_qty='" . $driveshaftQty2020 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }

                    if ($cvjointQty2018 != '' || $cvjointValue2018 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =8,ssv_scat_name='CV Joint',ssv_scat_year=2018,ssv_scat_value='" . $cvjointValue2018 . "',ssv_scat_qty='" . $cvjointQty2018 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }

                    if ($cvjointQty2019 != '' || $cvjointValue2019 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =8,ssv_scat_name='CV Joint',ssv_scat_year=2019,ssv_scat_value='" . $cvjointValue2019 . "',ssv_scat_qty='" . $cvjointQty2018 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }

                    if ($cvjointQty2020 != '' || $cvjointValue2020 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =8,ssv_scat_name='CV Joint',ssv_scat_year=2020,ssv_scat_value='" . $cvjointValue2019 . "',ssv_scat_qty='" . $cvjointQty2020 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }

                    if ($emsQty2018 != '' || $emsValue2018 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =5,ssv_scat_name='EMS',ssv_scat_year=2018,ssv_scat_value='" . $emsValue2018 . "',ssv_scat_qty='" . $emsQty2018 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }

                    if ($emsQty2019 != '' || $emsValue2019 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =5,ssv_scat_name='EMS',ssv_scat_year=2019,ssv_scat_value='" . $emsValue2019 . "',ssv_scat_qty='" . $emsQty2019 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }
                    if ($emsQty2020 != '' || $emsValue2020 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =5,ssv_scat_name='EMS',ssv_scat_year=2020,ssv_scat_value='" . $emsValue2020 . "',ssv_scat_qty='" . $emsQty2020 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }




                    if ($sparesQty2018 != '' || $sparesValue2018 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =4,ssv_scat_name='SPARES',ssv_scat_year=2018,ssv_scat_value='" . $sparesValue2018 . "',ssv_scat_qty='" . $sparesQty2018 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }

                    if ($sparesQty2019 != '' || $sparesValue2019 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =4,ssv_scat_name='SPARES',ssv_scat_year=2019,ssv_scat_value='" . $sparesValue2019 . "',ssv_scat_qty='" . $sparesQty2019 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }

                    if ($sparesQty2020 != '' || $sparesValue2020 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =4,ssv_scat_name='SPARES',ssv_scat_year=2020,ssv_scat_value='" . $sparesValue2020 . "',ssv_scat_qty='" . $sparesQty2020 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }



                    if ($rotatingQty2018 != '' || $rotatingValue2018 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =7,ssv_scat_name='Rotating',ssv_scat_year=2018,ssv_scat_value='" . $rotatingValue2018 . "',ssv_scat_qty='" . $rotatingQty2018 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }
                    if ($rotatingQty2019 != '' || $rotatingValue2019 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =7,ssv_scat_name='Rotating',ssv_scat_year=2019,ssv_scat_value='" . $rotatingValue2019 . "',ssv_scat_qty='" . $rotatingQty2019 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }
                    if ($rotatingQty2020 != '' || $rotatingValue2020 != '') {
                        $ins_sql = "INSERT INTO rollco_ms_scat_sales_val SET ssv_scat_id =7,ssv_scat_name='Rotating',ssv_scat_year=2020,ssv_scat_value='" . $rotatingValue2020 . "',ssv_scat_qty='" . $rotatingQty2020 . "',ssv_ss_id='" . $u_id . "'";
                        $sq->query($ins_sql);
                        $count++;
                    }
                }else{
                    $insertLog = "INSERT INTO rollco_ms_sales_year_log SET ac_code='".$AcCode."',company_name='".$CompanyName."',status='Skip'";
                    $sq->query($insertLog);
                }
            }
        }
        $mycnts++;
    }  //While loop end here
//exit;
    echo "<script>location.href='import_sales_sheetcat.php?mycnts=" . $count . "';</script>";
}   //If Condition end here
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $sitetitle; ?></title>
        <link href="stylesheet.css" rel="stylesheet" type="text/css">
        <SCRIPT language=JavaScript>
            function validate_import()
            {
                if (document.getElementById('file').value == "")
                {
                    alert("Please upload file");
                    document.getElementById('file').focus();
                    return false;
                }
            }
            function close_the_window() {
                self.close();
            }
        </script>
        <link rel="stylesheet" type="text/css" href="stylesheet.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
    </head>
    <body>
        <div id="wrapper" style="width: 700px"> 

            <div class="header"> 
                <div class="logo"><a><img src="images/logo.svg" alt="Rollco" /> </a></div> <h1>Rollco</h1> 

                <div class="nav"> 
                </div>
                <!--Header-End--></div>      

            <table width="100%" cellpadding="0" cellspacing="0" align="center">
                <tr> 
                    <td valign="top"><table width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td> 
                                <td> <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" >
                                        <tr> 
                                            <td> <table width="100%%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr> 
                                                        <td height="400" align="left" valign="top"><form action="import_sales_sheetcat.php" method="post" enctype="multipart/form-data" name="form1" class="text09" onSubmit="return validate_import();">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td colspan="2" class="txt5" style="padding-bottom: 20px">Import User Sales Year wise Sheet</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="txt11"><span>
<?php if (isset($_GET['mycnts'])) { ?>
                                                                                    Total <?php echo $_GET['mycnts']; ?> record(s) has been inserted successfully.
                                                                                    <br /><br /><br />
                                                                                    <a style="color: #000" href="import_sales_sheetcat.php">Back to Import User Sales Year wise Sheet</a>
                                                                                    <?php
                                                                                } else
                                                                                    echo "Please click on 'Browse' button to select and upload csv file.";
                                                                                ?>
                                                                            </span></td>
                                                                    </tr>
                                                                                <?php
                                                                                if (isset($_GET['mycnts'])) {
                                                                                    
                                                                                } else {
                                                                                    ?>                            
                                                                        <tr>
                                                                            <td colspan="2">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" style="height: 3px"></td>
                                                                        </tr>
                                                                        <tr class="text06">
                                                                            <td width="20%" class="txt5">&nbsp;<span class="txt11">Upload CSV: </span></td>
                                                                            <td width="80%"><input type="file" id="file" name="file"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2">&nbsp;</td>
                                                                        </tr>
                                                                        <tr class="text06">
                                                                            <td>&nbsp;</td>
                                                                            <td>
                                                                                <input name="Submit" type="submit" class="subbtn" value="Upload"></td>
                                                                        </tr>
<?php } ?>                          
                                                                </table>
                                                            </form></td>
                                                    </tr>
                                                </table></td>
                                        </tr>
                                    </table></td>
                            </tr>
                        </table></td>
                </tr>
            </table>
        </div>    
    </body>
</html>