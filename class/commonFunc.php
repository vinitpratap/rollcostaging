<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getCatName($cid) {
    $sq = new ajquery;
    $catData = "SELECT cat_nm FROM rollco_ms_cat WHERE cat_id='" . $cid . "' LIMIT 1";
    $numsrow = $sq->numsrow($catData);
    if ($numsrow > 0) {
        $data = $sq->fearr($catData);
        return $data['cat_nm'];
    }
}

function getCurrSym($cid) {
    $sq = new ajquery;
    $catData = "SELECT curr_name FROM rollco_ms_currency WHERE curr_id='" . $cid . "' LIMIT 1";
    $numsrow = $sq->numsrow($catData);
    if ($numsrow > 0) {
        $data = $sq->fearr($catData);
        return $data['curr_name'];
    }
}

function getMakeid($mn) {
    $sq = new ajquery;
    $catData = "SELECT make_id FROM rollco_ms_make WHERE make_nm='" . $mn . "' LIMIT 1";
    $numsrow = $sq->numsrow($catData);
    if ($numsrow > 0) {
        $data = $sq->fearr($catData);
        return $data['make_id'];
    }
}

function getModelid($mn) {
    $sq = new ajquery;
    $catData = "SELECT model_id FROM rollco_ms_model WHERE model_nm='" . $mn . "' LIMIT 1";
    $numsrow = $sq->numsrow($catData);
    if ($numsrow > 0) {
        $data = $sq->fearr($catData);
        return $data['model_id'];
    }
}

function getYearid($yf) {
    $sq = new ajquery;
    $catData = "SELECT proyr_id FROM rollco_ms_proyr WHERE proyr_from='" . $yf . "' LIMIT 1";
    $numsrow = $sq->numsrow($catData);
    if ($numsrow > 0) {
        $data = $sq->fearr($catData);
        return $data['proyr_id'];
    }
}

function getMcatDetails($id) {
    $sq = new ajquery;
    $catData = "SELECT mcat_nm,mcat_image FROM rollco_ms_mcat WHERE mcat_id='" . $id . "' LIMIT 1";
    $numsrow = $sq->numsrow($catData);
    if ($numsrow > 0) {
        $data = $sq->fearr($catData);
        return $data;
    } else {
        return 0;
    }
}

function getCatDetails($id) {
    $sq = new ajquery;
    $catData = "SELECT cat_nm,cat_detail,cat_catlog,cat_image,cat_simage,cat_brochure,cat_bimg,cat_headinglines FROM rollco_ms_cat WHERE cat_id='" . $id . "' LIMIT 1";
    $numsrow = $sq->numsrow($catData);
    if ($numsrow > 0) {
        $data = $sq->fearr($catData);
        return $data;
    } else {
        return 0;
    }
}

function getUserName($id) {
    $sq = new ajquery;
    $catData = "SELECT firstName,lastName,com_city,com_state,com_zipCode,customerID,country FROM rollco_ms_users WHERE u_id='" . $id . "' LIMIT 1";
    $numsrow = $sq->numsrow($catData);
    if ($numsrow > 0) {
        $data = $sq->fearr($catData);
        return $data;
    } else {
        return 0;
    }
}

function getSheetid($id) {
    $sq = new ajquery;
    $catData = "SELECT ss_id FROM rollco_ms_sales_sheet WHERE user_id='" . $id . "' LIMIT 1";
    $numsrow = $sq->numsrow($catData);
    if ($numsrow > 0) {
        $data = $sq->fearr($catData);
        return $data['ss_id'];
    } else {
        return 0;
    }
}

function getSalesCatName($id) {
    $sq = new ajquery;
    $catData = "SELECT scat_nm FROM rollco_ms_salescat WHERE sc_id='" . $id . "' LIMIT 1";
    $numsrow = $sq->numsrow($catData);
    if ($numsrow > 0) {
        $data = $sq->fearr($catData);
        return $data['scat_nm'];
    } else {
        return 0;
    }
}

function getCustActid($id) {
    $sq = new ajquery;
    $catData = "SELECT customerID FROM rollco_ms_users WHERE u_id='" . $id . "' LIMIT 1";
    $numsrow = $sq->numsrow($catData);
    if ($numsrow > 0) {
        $data = $sq->fearr($catData);
        return $data['customerID'];
    } else {
        return 0;
    }
}

function getTempCustActid($id) {
    $sq = new ajquery;
    $catData = "SELECT customerID FROM rollco_ms_tmpusers WHERE u_id='" . $id . "' LIMIT 1";
    $numsrow = $sq->numsrow($catData);
    if ($numsrow > 0) {
        $data = $sq->fearr($catData);
        return $data['customerID'];
    } else {
        return 0;
    }
}

function getActCodeUser($cid,$tempid) {
    
    $sq = new ajquery;
    if($cid > 0){
        $custcode = getCustActid($cid);
    }else if($tempid > 0){
        $custcode = getTempCustActid($tempid);
    }
    
    if (isset($custcode) && $custcode != '') {
        $catData = "SELECT sa_id FROM rollco_ms_sales_appointment WHERE AcCode='" . $custcode . "' LIMIT 1";
        $numsrow = $sq->numsrow($catData);
        if ($numsrow > 0) {
            return 1;
        } else {
            return 0;
        }
    } else {
        return false;
    }
}


function getCCMName($yf,$cid,$mid,$modelid,$yrid) {
    $sq = new ajquery;
	$ccmArr = array();
    $catData = "SELECT proccm_inf FROM rollco_ms_proccm WHERE proccm_id='" . $yf . "' LIMIT 1";
    $numsrow = $sq->numsrow($catData);
    if ($numsrow > 0) {
        $data = $sq->fearr($catData);
		$ccmSql= "SELECT proccm_id FROM rollco_ms_proccm WHERE proccm_inf='".$data['proccm_inf']."' AND catid='".$cid."'
		AND makeid='".$mid."' AND modelid='".$modelid."' AND proyrid='".$yrid."'";
		$cnumsrow = $sq->numsrow($ccmSql);
		if($cnumsrow > 0){
			$cData = $sq->query($ccmSql);
			while($res = $sq->fetch($cData)){
				array_push($ccmArr,$res['proccm_id']);
			}
		}
    }
	return $ccmArr;
}

function getEngineCodeName($ecId,$cid,$mid,$modelid,$yrid) {
    $sq = new ajquery;
	$ccmArr = array();
    $catData = "SELECT engcode_inf FROM rollco_ms_engcode WHERE engcode_id='" . $ecId . "' LIMIT 1";
    $numsrow = $sq->numsrow($catData);
    if ($numsrow > 0) {
        $data = $sq->fearr($catData);
		$ecsql= "SELECT engcode_id FROM rollco_ms_engcode WHERE engcode_inf='".$data['engcode_inf']."' AND catid='".$cid."'
		AND makeid='".$mid."' AND modelid='".$modelid."' AND proyrid='".$yrid."' ";
		$cnumsrow = $sq->numsrow($ecsql);
		if($cnumsrow > 0){
			$cData = $sq->query($ecsql);
			while($res = $sq->fetch($cData)){
				array_push($ccmArr,$res['engcode_id']);
			}
		}
    }
	return $ccmArr;
}
