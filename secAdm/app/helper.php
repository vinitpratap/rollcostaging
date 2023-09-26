<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!function_exists('saveQueryLog')) {

    function saveQueryLog($data) {

        DB::table('rollco_db_log')->insert(
                ['subject_id' => $data['subject_id'],
                    'user_id' => $data['user_id'],
                    'table_used' => $data['table_used'],
                    'description' => $data['description'],
                    'data_prev' => $data['data_prev'],
                    'data_now' => $data['data_now'],
                ]
        );
    }

}

if (!function_exists('assocToStringConversion')) {

    function assocToStringConversion($input) {
        if (is_array($input)) {
            $output = implode(', ',
                    array_map(
                            function ($v, $k) {
                        return sprintf("%s='%s'", $k, $v);
                    }, $input, array_keys($input)
            ));
            return $output;
        }
    }

}

if (!function_exists('debug')) {

    function debug($input) {
        echo "<pre>";
        print_r($input);
    }

}

if (!function_exists('getLocationId')) {

    function getLocationId($locnm) {

        return DB::table('rollco_ms_loc')->select('loc_id')
                        ->where('loc_nm', $locnm)
                        ->first();
    }

}

if (!function_exists('getLocationName')) {

    function getLocationName($locid) {

        return DB::table('rollco_ms_loc')->select('loc_nm')
                        ->where('loc_id', $locid)
                        ->first();
    }

}




if (!function_exists('getNotificationAdmin')) {

    function getNotificationAdmin() {

        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data['notidata'] = DB::table('rollco_ms_order')->select('order_id as id',
                                    'order_date as req_date',
                                    'user_id as cust_nm')
                            ->where('order_status', 0)
                            ->limit(15)
                            ->orderby('created_at', 'DESC')
                            ->get()->toArray();
            $data['noticount'] = DB::table('rollco_ms_order')->select('order_id as id',
                                    'order_date as req_date',
                                    'user_id as cust_nm')
                            ->where('order_status', 0)
                            ->get()->count();
        } else {
            $loc = getLocationName(Auth::guard('admin')->user()->loc);
            $data['notidata'] = DB::table('rollco_ms_order')->select('order_id as id',
                                    'order_date as req_date',
                                    'user_id as cust_nm')
                            ->limit(15)
                            ->where('order_status', 1)
                            ->orderby('created_at', 'DESC')
                            ->get()->toArray();
            $data['noticount'] = DB::table('rollco_ms_order')->select('order_id as id ',
                                    'order_date as req_date',
                                    'user_id as cust_nm')
                            ->where('order_status', 1)
                            ->get()->count();
        }
        return $data;
    }

}

if (!function_exists('get_time_difference_php')) {

    function get_time_difference_php($created_time) {
        date_default_timezone_set('Asia/Calcutta'); //Change as per your default time
        $str = strtotime($created_time);
        $today = strtotime(date('Y-m-d H:i:s'));

// It returns the time difference in Seconds...
        $time_differnce = $today - $str;

// To Calculate the time difference in Years...
        $years = 60 * 60 * 24 * 365;

// To Calculate the time difference in Months...
        $months = 60 * 60 * 24 * 30;

// To Calculate the time difference in Days...
        $days = 60 * 60 * 24;

// To Calculate the time difference in Hours...
        $hours = 60 * 60;

// To Calculate the time difference in Minutes...
        $minutes = 60;

        if (intval($time_differnce / $years) > 1) {
            return intval($time_differnce / $years) . " years ago";
        } else if (intval($time_differnce / $years) > 0) {
            return intval($time_differnce / $years) . " year ago";
        } else if (intval($time_differnce / $months) > 1) {
            return intval($time_differnce / $months) . " months ago";
        } else if (intval(($time_differnce / $months)) > 0) {
            return intval(($time_differnce / $months)) . " month ago";
        } else if (intval(($time_differnce / $days)) > 1) {
            return intval(($time_differnce / $days)) . " days ago";
        } else if (intval(($time_differnce / $days)) > 0) {
            return intval(($time_differnce / $days)) . " day ago";
        } else if (intval(($time_differnce / $hours)) > 1) {
            return intval(($time_differnce / $hours)) . " hours ago";
        } else if (intval(($time_differnce / $hours)) > 0) {
            return intval(($time_differnce / $hours)) . " hour ago";
        } else if (intval(($time_differnce / $minutes)) > 1) {
            return intval(($time_differnce / $minutes)) . " minutes ago";
        } else if (intval(($time_differnce / $minutes)) > 0) {
            return intval(($time_differnce / $minutes)) . " minute ago";
        } else if (intval(($time_differnce)) > 1) {
            return intval(($time_differnce)) . " seconds ago";
        } else {
            return "few seconds ago";
        }
    }

}


if (!function_exists('reduceWords')) {

    function reduceWords($str) {
        $out = strlen($str) > 77 ? substr($str, 0, 77) . "..." : $str;
        return $out;
    }

}

if (!function_exists('getPendingRequests')) {

    function getPendingRequest() {

        if (Auth::guard('admin')->user()->admin_role == 1) {
            $pendingData = DB::table('rollco_ms_order')->select('order_id',
                                    'order_date', 'cust_nm', 'req_code',
                                    'cust_mob')
                            ->where('order_status', 1)
                            ->orderby('created_at', 'DESC')
                            ->limit(6)
                            ->get()->toArray();
        } else {
            $loc = getLocationName(Auth::guard('admin')->user()->loc);
            $pendingData = DB::table('rollco_ms_order')->select('id',
                                    'req_date', 'cust_nm', 'req_code',
                                    'cust_mob')
                            ->where('cust_loc', $loc->loc_nm)
                            ->where('order_status', 1)
                            ->orderby('created_at', 'DESC')
                            ->limit(6)
                            ->get()->toArray();
        }
        return $pendingData;
    }

}

if (!function_exists('getTotalCustCount')) {

    function getTotalCustCount() {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data['count'] = DB::table('rollco_ms_users')->select('u_id')
                            ->get()->count();

            $data['prevmonth'] = DB::table('rollco_ms_users')->whereMonth(
                            'created_at', '=', Carbon::now()->subMonth()->month
                    )->get()->count();

            $data['currmonth'] = DB::table('rollco_ms_users')->whereMonth(
                            'created_at', '=', Carbon::now()->month
                    )->get()->count();

            $data['currweek'] = DB::table('rollco_ms_users')->
                            whereBetween('created_at',
                                    [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                            ->get()->count();
            $data['prevweek'] = DB::table('rollco_ms_users')->
                            whereBetween('created_at',
                                    [Carbon::today()->subWeek(), Carbon::now()->startOfWeek()])
                            ->get()->count();
        } else {
            $data['count'] = DB::table('rollco_ms_users')->select('u_id')
                            ->where('custloc', Auth::guard('admin')->user()->loc)
                            ->get()->count();

            $data['prevmonth'] = DB::table('rollco_ms_users')->whereMonth(
                                    'created_at', '=',
                                    Carbon::now()->subMonth()->month
                            )
                            ->where('custloc', Auth::guard('admin')->user()->loc)
                            ->get()->count();

            $data['currmonth'] = DB::table('rollco_ms_users')->whereMonth(
                            'created_at', '=', Carbon::now()->month
                    )->where('custloc', Auth::guard('admin')->user()->loc)->get()->count();

            $data['currweek'] = DB::table('rollco_ms_users')->
                            whereBetween('created_at',
                                    [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                            ->where('custloc', Auth::guard('admin')->user()->loc)->get()->count();
            $data['prevweek'] = DB::table('rollco_ms_users')->
                            whereBetween('created_at',
                                    [Carbon::today()->subWeek(), Carbon::now()->startOfWeek()])
                            ->where('custloc', Auth::guard('admin')->user()->loc)->get()->count();
        }
        $diffmonth = $data['currmonth'] - $data['prevmonth'];
        $data['prevmonth'] = $data['prevmonth'] != 0 ? $data['prevmonth'] : 1;
        if ($diffmonth != 0) {
            $data['perIncr'] = $diffmonth / $data['prevmonth'] * 100;
        } else {
            $data['perIncr'] = 0;
        }
        $diffweek = $data['currweek'] - $data['prevweek'];
        $data['prevweek'] = $data['prevweek'] != 0 ? $data['prevweek'] : 1;
        if ($diffmonth != 0) {
            $data['perDiffWeek'] = $diffweek / $data['prevweek'] * 100;
        } else {
            $data['perDiffWeek'] = 0;
        }
        return $data;
    }

}

if (!function_exists('getTotalReqCount')) {

    function getTotalReqCount() {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $data['open_req_count'] = DB::table('rollco_ms_order')->select('order_id')
                            ->whereIn('order_status', [0])
                            ->get()->count();
            $data['new_req_count'] = DB::table('rollco_ms_order')->select('order_id')
                            ->whereIn('order_status', [1])
                            ->get()->count();

            $data['prog_req_count'] = DB::table('rollco_ms_order')->select('order_id')
                            ->whereIn('order_status', [2, 3])
                            ->get()->count();
            $data['closed_req_count'] = DB::table('rollco_ms_order')->select('order_id')
                            ->whereIn('order_status', [4, 5])
                            ->get()->count();
            $data['canceled_req_count'] = DB::table('rollco_ms_order')->select('order_id')
                            ->whereIn('order_status', [6])
                            ->get()->count();

            $data['total_req_count'] = DB::table('rollco_ms_order')->select('order_id')
                            ->get()->count();

            $data['prevmonth'] = DB::table('rollco_ms_order')->whereMonth(
                            'created_at', '=', Carbon::now()->subMonth()->month
                    )->get()->count();

            $data['currmonth'] = DB::table('rollco_ms_order')->whereMonth(
                            'created_at', '=', Carbon::now()->month
                    )->get()->count();

            $data['newcurrweek'] = DB::table('rollco_ms_order')->select('order_id')->
                            whereBetween('created_at',
                                    [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                            ->whereIn('order_status', [1])
                            ->get()->count();
            $data['newprevweek'] = DB::table('rollco_ms_order')->select('order_id')->
                            whereBetween('created_at',
                                    [Carbon::today()->subWeek(), Carbon::now()->startOfWeek()])
                            ->whereIn('order_status', [1])
                            ->get()->count();

            $data['progcurrweek'] = DB::table('rollco_ms_order')->select('order_id')->
                            whereBetween('created_at',
                                    [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                            ->whereIn('order_status', [2, 3])
                            ->get()->count();
            $data['progprevweek'] = DB::table('rollco_ms_order')->select('order_id')->
                            whereBetween('created_at',
                                    [Carbon::today()->subWeek(), Carbon::now()->startOfWeek()])
                            ->whereIn('order_status', [2, 3])
                            ->get()->count();
        } else {
            $loc = getLocationName(Auth::guard('admin')->user()->loc);
            $data['open_req_count'] = DB::table('rollco_ms_order')->select('order_id')
                            ->whereIn('order_status', [0])
                            ->get()->count();
            $data['new_req_count'] = DB::table('rollco_ms_order')->select('order_id')
                            ->whereIn('order_status', [1])
                            ->get()->count();

            $data['prog_req_count'] = DB::table('rollco_ms_order')->select('order_id')
                            ->whereIn('order_status', [2, 3])
                            ->get()->count();
            $data['closed_req_count'] = DB::table('rollco_ms_order')->select('order_id')
                            ->whereIn('order_status', [4, 5])
                            ->get()->count();
            $data['canceled_req_count'] = DB::table('rollco_ms_order')->select('order_id')
                            ->whereIn('order_status', [6])
                            ->get()->count();

            $data['total_req_count'] = DB::table('rollco_ms_order')->select('order_id')
                            ->get()->count();

            $data['prevmonth'] = DB::table('rollco_ms_order')->whereMonth(
                            'created_at', '=', Carbon::now()->subMonth()->month
                    )->get()->count();

            $data['currmonth'] = DB::table('rollco_ms_order')->whereMonth(
                            'created_at', '=', Carbon::now()->month
                    )->get()->count();

            $data['newcurrweek'] = DB::table('rollco_ms_order')->select('order_id')->
                            whereBetween('created_at',
                                    [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                            ->whereIn('order_status', [1])
                            ->get()->count();
            $data['newprevweek'] = DB::table('rollco_ms_order')->select('order_id')->
                            whereBetween('created_at',
                                    [Carbon::today()->subWeek(), Carbon::now()->startOfWeek()])
                            ->whereIn('order_status', [1])
                            ->get()->count();

            $data['progcurrweek'] = DB::table('rollco_ms_order')->select('order_id')->
                            whereBetween('created_at',
                                    [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                            ->whereIn('order_status', [2, 3])
                            ->get()->count();
            $data['progprevweek'] = DB::table('rollco_ms_order')->select('order_id')->
                            whereBetween('created_at',
                                    [Carbon::today()->subWeek(), Carbon::now()->startOfWeek()])
                            ->whereIn('order_status', [2, 3])
                            ->get()->count();
        }
        $diffmonth = $data['currmonth'] - $data['prevmonth'];
        $data['prevmonth'] = $data['prevmonth'] != 0 ? $data['prevmonth'] : 1;
        if ($diffmonth != 0) {
            $data['perIncr'] = $diffmonth / $data['prevmonth'] * 100;
        } else {
            $data['perIncr'] = 0;
        }
        $newdiffweek = $data['newcurrweek'] - $data['newprevweek'];
        $data['newprevweek'] = $data['newprevweek'] != 0 ? $data['newprevweek'] : 1;
        if ($newdiffweek != 0) {
            $data['newperDiffWeek'] = $newdiffweek / $data['newprevweek'] * 100;
        } else {
            $data['newperDiffWeek'] = 0;
        }
        $progdiffweek = $data['progcurrweek'] - $data['progprevweek'];
        $data['progprevweek'] = $data['progprevweek'] != 0 ? $data['progprevweek'] : 1;
        if ($progdiffweek != 0) {
            $data['progperDiffWeek'] = $newdiffweek / $data['progprevweek'] * 100;
        } else {
            $data['progperDiffWeek'] = 0;
        }
        if (Auth::guard('admin')->user()->admin_role == 1) {
            $closedreq = DB::select('select year(created_at) as year,monthname(created_at) AS monthname, month(created_at) as month, count(order_id) as total_count from rollco_ms_order where order_status = 4 OR order_status = 5  group by year(created_at), month(created_at)');

            $openreq = DB::select('select year(created_at) as year,monthname(created_at) AS monthname, month(created_at) as month, count(order_id) as total_count from rollco_ms_order where order_status = 0  group by year(created_at), month(created_at)');
        } else {
            $loc = getLocationName(Auth::guard('admin')->user()->loc);
            $closedreq = DB::select('select year(created_at) as year,monthname(created_at) AS monthname, month(created_at) as month, count(order_id) as total_count from rollco_ms_order where order_status = 4 OR order_status = 5  group by year(created_at), month(created_at)');

            $openreq = DB::select('select year(created_at) as year,monthname(created_at) AS monthname, month(created_at) as month, count(order_id) as total_count from rollco_ms_order where order_status = 0  group by year(created_at), month(created_at)');
        }

        $closedreqArr = [];
        $openreqArr = [];
        foreach ($closedreq as $key => $value) {
//$closedreqArr[$value->year][$value->month] = $value->total_count;
            array_push($closedreqArr, $value->total_count);
        }

        foreach ($openreq as $key => $value) {
//$cancelreqArr[$value->year][$value->month] = $value->total_count;
            array_push($openreqArr, $value->total_count);
        }

        $data['closedReqArr'] = json_encode(array_reverse(array_pad($closedreqArr,
                                7, 0)));
        $data['openReqArr'] = json_encode(array_reverse(array_pad($openreqArr,
                                7, 0)));

        return $data;
    }

}


if (!function_exists('rand_pass')) {

    function rand_pass($length) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $length);
    }

}



if (!function_exists('get_sms')) {

//function for SMS
    function get_sms($url) {
        $url = str_replace("#", "%23", $url);
        $url = str_replace("<", "%26lt;", $url);
        $url = str_replace(">", "%26gt;", $url);
        $options = array(
            CURLOPT_RETURNTRANSFER => true, // return web page
            CURLOPT_HEADER => false, // don't return headers
            CURLOPT_FOLLOWLOCATION => true, // follow redirects
            CURLOPT_ENCODING => "", // handle all encodings
            CURLOPT_USERAGENT => "spider", // who am i
            CURLOPT_AUTOREFERER => true, // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
            CURLOPT_TIMEOUT => 120, // timeout on response
            CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);
        $header['errno'] = $err;
        $header['errmsg'] = $errmsg;
        $header['content'] = $content;
        return $header;
    }

}


// to get customer data according to request id

if (!function_exists('getCustDetailsFromRequest')) {

    function getCustDetailsFromRequest($req_id) {
        $reqData = DB::select("select req.cust_nm,req.cust_mob,req.req_code,req.req_dte_pref,req.req_timeslot_pref,req.req_ordr_amnt,serv.serv_nm,serv.serv_catnm FROM rollco_ms_order as req INNER JOIN rollco_cust_req_serv as serv ON req.id = serv.req_id where req.id = '" . $req_id . "'");
        return $reqData;
    }

}




if (!function_exists('validateImage')) {

    function validateImage($mime) {
        if ($mime == "jpeg" || $mime == "png" || $mime == "jpg" || $mime == "gif") {
            return true;
        } else {
            return false;
        }
    }

}



if (!function_exists('getCatName')) {

    function getCatName($catid) {

        $catData = DB::table('rollco_ms_cat')->select('cat_nm')
                ->where('cat_id', $catid)
                ->first();
        if (isset($catData->cat_nm))
            return $catData->cat_nm;
        else
            return false;
    }

}
if (!function_exists('getLocName')) {

    function getLocName($locid) {

        $catData = DB::table('rollco_ms_loc')->select('loc_nm')
                ->where('loc_id', $locid)
                ->first();
        if ($catData->loc_nm)
            return $catData->loc_nm;
        else
            return false;
    }

}


if (!function_exists('getMakeName')) {

    function getMakeName($mid) {

        if (!empty($mid)) {
            $catData = DB::table('rollco_ms_make')->select('make_nm')
                    ->where('make_id', $mid)
                    ->first();
            if ($catData && $catData->make_nm)
                return $catData->make_nm;
            else
                return false;
        } else {
            return false;
        }
    }

}
if (!function_exists('getModelName')) {

    function getModelName($mid) {
        if (!empty($mid)) {
            $catData = DB::table('rollco_ms_model')->select('model_nm')
                    ->where('model_id', $mid)
                    ->first();
            if ($catData && $catData->model_nm)
                return $catData->model_nm;
            else
                return false;
        } else {
            return false;
        }
    }

}
if (!function_exists('getProYear')) {

    function getProYear($yid) {
        if (!empty($yid)) {
            $catData = DB::table('rollco_ms_proyr')->select('proyr_from',
                            'proyr_to', 'current_flag')
                    ->where('proyr_id', $yid)
                    ->first();

            if ($catData && $catData->current_flag == 0) {
                if ($catData->proyr_from) {
                    if ($catData->proyr_to != 0) {
                        return $catData->proyr_from . "-" . $catData->proyr_to;
                    } else {
                        return $catData->proyr_from . "-on";
                    }
                } else
                    return false;
            } else {
                return 'On';
            }
        } else
            return false;
    }

}
if (!function_exists('getProCCM')) {

    function getProCCM($pid) {
        if (!empty($pid)) {
            $catData = DB::table('rollco_ms_proccm')->select('proccm_inf')
                    ->where('proccm_id', $pid)
                    ->first();
            if ($catData && $catData->proccm_inf)
                return $catData->proccm_inf;
            else
                return false;
        } else
            return false;
    }

}

if (!function_exists('getEngineCode')) {

    function getEngineCode($eid) {
        if (!empty($eid)) {
            $catData = DB::table('rollco_ms_engcode')->select('engcode_inf')
                    ->where('engcode_id', $eid)
                    ->first();

            if ($catData && $catData->engcode_inf)
                return $catData->engcode_inf;
            else
                return false;
        } else
            return false;
    }

}


if (!function_exists('getMsInfo')) {

    function getMsInfo($eid) {
        if (!empty($eid)) {
            $catData = DB::table('rollco_ms_mscode')->select('MsCode', 'V8Key')
                    ->where('part_no', $eid)
                    ->first();

            if ($catData)
                return $catData;
            else
                return false;
        } else
            return false;
    }

}

if (!function_exists('getProductName')) {

    function getProductName($pid) {

        $catData = DB::table('rollco_ms_product')->select('prod_nm')
                ->where('prod_id', $pid)
                ->first();
        if ($catData->prod_nm)
            return $catData->prod_nm;
        else
            return false;
    }

}
if (!function_exists('getSpareName')) {

    function getSpareName($pid) {

        $catData = DB::table('rollco_ms_spare')->select('spare_nm')
                ->where('spare_id', $pid)
                ->first();
        if ($catData->spare_nm)
            return $catData->spare_nm;
        else
            return false;
    }

}

if (!function_exists('csvToArray')) {

    function csvToArray($filename = '', $delimiter = ',') {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

}


if (!function_exists('getMakeByProduct')) {

    function getMakeByProduct($filename = '', $delimiter = ',') {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

}

if (!function_exists('getTotalProdCount')) {

    function getTotalProdCount($gr_id) {

        $catData = DB::table('rollco_ms_grproduct')->select('grp_id')
                        ->where('gr_id', $gr_id)
                        ->get()->count();
        return $catData;
    }

}

if (!function_exists('getservesCount')) {

    function getservesCount($spare_num) {

        $catData = DB::table('rollco_ms_spearservice')->select('sps_id')
                        ->where('spare_num', $spare_num)
                        ->get()->count();
        return $catData;
    }

}

if (!function_exists('getoemCount')) {

    function getoemCount($spare_num) {

        $catData = DB::table('rollco_ms_spearoem')->select('spm_id')
                        ->where('spare_num', $spare_num)
                        ->get()->count();
        return $catData;
    }

}

if (!function_exists('getapCount')) {

    function getapCount($part_no) {

        $catData = DB::table('rollco_ms_application')->select('ap_id')
                        ->where('part_no', $part_no)
                        ->get()->count();
        return $catData;
    }

}

if (!function_exists('getprName')) {

    function getprName($prod_id) {
        $catData = DB::table('rollco_ms_product')->select('prod_part_no')
                ->where('prod_id', $prod_id)
                ->first();
        if (isset($catData->prod_part_no))
            return $catData->prod_part_no;
        else
            return false;
    }

}

if (!function_exists('getUserName')) {

    function getUserName($uid) {
        $catData = DB::table('rollco_ms_users')->select('companyName')
                ->where('u_id', $uid)
                ->first();
        if (isset($catData->companyName))
            return $catData->companyName;
        else
            return false;
    }

}

if (!function_exists('getUserDetail')) {

    function getUserDetail($uid) {
        $catData = DB::table('rollco_ms_users')->select('companyName', 'com_emailAddress')
                ->where('u_id', $uid)
                ->first();
        if (isset($catData))
            return $catData;
        else
            return false;
    }

}

if (!function_exists('countOrderProduct')) {

    function countOrderProduct($oid) {
        $catData = DB::table('rollco_ms_order_details')
                ->where('order_id', $oid)
                ->count();
        return $catData;
        if (isset($catData))
            return $catData;
        else
            return false;
    }

}
if (!function_exists('getUserCurrency')) {

    function getUserCurrency($ugid) {
        $uData = DB::table('rollco_ms_group')->select('gr_currency')
                ->where('gr_id', $ugid)
                ->first();
        if (isset($catData->curr_name)) {
            
        } else {
            return false;
        }
        $catData = DB::table('rollco_ms_currency')->select('curr_name')
                ->where('curr_id', $uData->gr_currency)
                ->first();

        if (isset($catData->curr_name))
            return $catData->curr_name;
        else
            return false;
    }

}
if (!function_exists('getProductOEM')) {

    function getProductOEM($prod_part_no) {
        $uData = DB::table('rollco_ms_crossref')->select('crossref_oem')
                ->where('rc_num', $prod_part_no)
                ->first();

        if (isset($uData->crossref_oem))
            return $uData->crossref_oem;
        else
            return false;
    }

}
if (!function_exists('getSpareOEM')) {

    function getSpareOEM($spr_part_no) {
        $uData = DB::table('rollco_ms_spearoem')->select('oem_num')
                ->where('spare_num', $spr_part_no)
                ->first();

        if (isset($uData->oem_num))
            return $uData->oem_num;
        else
            return false;
    }

}
if (!function_exists('getMakeByProductID')) {

    function getMakeByProductID($pr_id) {
        $uData = DB::table('rollco_ms_product')->select('makeid')
                ->where('prod_id', $pr_id)
                ->first();
        if (isset($uData->makeid)) {
            $catData = DB::table('rollco_ms_make')->select('make_nm')
                    ->where('make_id', $uData->makeid)
                    ->first();
            if (isset($catData->make_nm))
                return $catData->make_nm;
            else
                return false;
        } else {
            return false;
        }
    }

}

if (!function_exists('getSpareDetail')) {

    function getSpareDetail($spr_id) {
        $uData = DB::table('rollco_ms_spare')->select('spare_oem', 'spare_make')
                ->where('spare_id', $spr_id)
                ->first();
        if ($uData) {
            return $uData;
        } else {
            return false;
        }
    }

}

if (!function_exists('getGroupName')) {

    function getGroupName($gid) {
        $uData = DB::table('rollco_ms_group')->select('gr_nm')
                ->where('gr_id', $gid)
                ->first();

        if (isset($uData->gr_nm))
            return $uData->gr_nm;
        else
            return false;
    }

}

if (!function_exists('getSalesCategoryName')) {

    function getSalesCategoryName($cid) {
        $uData = DB::table('rollco_ms_salescat')->select('scat_nm')
                ->where('sc_id', $cid)
                ->first();

        if (isset($uData->scat_nm))
            return $uData->scat_nm;
        else
            return false;
    }

}

if (!function_exists('getSalesCategoryValue')) {

    function getSalesCategoryValue($cid, $yr, $sid) {
        $uData = DB::table('rollco_ms_scat_sales_val')->select('ssv_scat_value', 'ssv_scat_qty', 'ssv_scat_faulty', 'ssv_scat_faulty_per')
                ->where('ssv_ss_id', $sid)
                ->where('ssv_scat_id', $cid)
                ->where('ssv_scat_year', $yr)
                ->first();

        if (isset($uData))
            return $uData;
        else
            return false;
    }

}



if (!function_exists('getActCodeUser')) {

    function getActCodeUser($cid) {
        $uData = DB::table('rollco_ms_users')->select('customerID')
                ->where('u_id', $cid)
                ->first();
        if (isset($uData->customerID)) {
            $rData = DB::table('rollco_ms_sales_appointment')->select('sa_id')
                    ->where('AcCode', $uData->customerID)
                    ->first();
            if (isset($rData->sa_id)) {
                return $rData->sa_id;
            } else {
                return false;
            }
        } else
            return false;
    }

}

if (!function_exists('getCustActid')) {

    function getCustActid($cid) {
        $uData = DB::table('rollco_ms_users')->select('customerID')
                ->where('u_id', $cid)
                ->first();

        if (isset($uData->customerID)) {
            return $uData->customerID;
        } else
            return false;
    }

}

if (!function_exists('getCurrName')) {

    function getCurrName($cid) {
        $uData = DB::table('rollco_ms_currency')->select('curr_name')
                ->where('curr_id', $cid)
                ->first();

        if (isset($uData->curr_name)) {
            return $uData->curr_name;
        } else
            return false;
    }

}
if (!function_exists('binaryToString')) {

    function binaryToString($binary) {
        $binaries = explode(' ', $binary);

        $string = null;
        foreach ($binaries as $binary) {
            $string .= pack('H*', dechex(bindec($binary)));
        }

        return $string;
    }

}

if (!function_exists('getProductPriceGroup')) {

    function getProductPriceGroup($cemail, $pname) {
        $uData = DB::table('rollco_ms_users')->select('g_id')
                ->where('com_emailAddress', $cemail)
                ->first();
//dd($uData);
        if (isset($uData->g_id)) {
            $gData = DB::table('rollco_ms_grproduct')->select('pr_price')
                    ->where('part_nm', $pname)
                    ->where('gr_id', $uData->g_id)
                    ->first();
            if (isset($gData->pr_price)) {
                return $gData->pr_price;
            } else
                return 0;
        } else
            return false;
    }

}

if (!function_exists('generatePIN')) {

    function generatePIN($digits = 4) {

        $i = 0; //counter

        $pin = ""; //our default pin is blank.

        while ($i < $digits) {

            //generate a random number between 0 and 9.

            $pin .= mt_rand(0, 9);

            $i++;
        }

        return $pin;
    }

}

if (!function_exists('getGroupCurrencySign')) {

    function getGroupCurrencySign($cid) {
        $uData = DB::table('rollco_ms_users')->select('g_id')
                ->where('u_id', $cid)
                ->first();
//dd($uData);
        if (isset($uData->g_id)) {
            return $uData->g_id;
        } else
            return false;
    }

}


if (!function_exists('getMCatName')) {

    function getMCatName($catid) {

        $catData = DB::table('rollco_ms_mcat')->select('mcat_nm')
                ->where('mcat_id', $catid)
                ->first();
        if (isset($catData->mcat_nm))
            return $catData->mcat_nm;
        else
            return false;
    }

}

if (!function_exists('CheckUserOrder')) {

    function CheckUserOrder($uid) {
        $uData = DB::table('rollco_ms_order')->select('order_id')
                ->where('user_id', $uid)
                ->count();
        if (isset($uData))
            return $uData;
        else
            return false;
    }

}

if (!function_exists('getUid')) {

    function getUid($customerid) {
        $uData = DB::table('rollco_ms_users')->select('u_id')
                ->where('customerID', $customerid)
                ->first();
        if (isset($uData->u_id))
            return $uData->u_id;
        else
            return false;
    }

}

if (!function_exists('getProductStatus')) {

    function getProductStatus($pname) {
        $uData = DB::table('rollco_ms_product')->select('prod_status')
                ->where('prod_part_no', $pname)
                ->where('prod_status', 1)
                ->first();
        if (isset($uData->prod_status)) {
            return true;
        } else {
            return false;
        }
    }

}

if (!function_exists('remove_accents')) {

    function remove_accents($string) {
        if (!preg_match('/[\x80-\xff]/', $string))
            return $string;

        $chars = array(
            // Decompositions for Latin-1 Supplement
            chr(195) . chr(128) => 'A', chr(195) . chr(129) => 'A',
            chr(195) . chr(130) => 'A', chr(195) . chr(131) => 'A',
            chr(195) . chr(132) => 'A', chr(195) . chr(133) => 'A',
            chr(195) . chr(135) => 'C', chr(195) . chr(136) => 'E',
            chr(195) . chr(137) => 'E', chr(195) . chr(138) => 'E',
            chr(195) . chr(139) => 'E', chr(195) . chr(140) => 'I',
            chr(195) . chr(141) => 'I', chr(195) . chr(142) => 'I',
            chr(195) . chr(143) => 'I', chr(195) . chr(145) => 'N',
            chr(195) . chr(146) => 'O', chr(195) . chr(147) => 'O',
            chr(195) . chr(148) => 'O', chr(195) . chr(149) => 'O',
            chr(195) . chr(150) => 'O', chr(195) . chr(153) => 'U',
            chr(195) . chr(154) => 'U', chr(195) . chr(155) => 'U',
            chr(195) . chr(156) => 'U', chr(195) . chr(157) => 'Y',
            chr(195) . chr(159) => 's', chr(195) . chr(160) => 'a',
            chr(195) . chr(161) => 'a', chr(195) . chr(162) => 'a',
            chr(195) . chr(163) => 'a', chr(195) . chr(164) => 'a',
            chr(195) . chr(165) => 'a', chr(195) . chr(167) => 'c',
            chr(195) . chr(168) => 'e', chr(195) . chr(169) => 'e',
            chr(195) . chr(170) => 'e', chr(195) . chr(171) => 'e',
            chr(195) . chr(172) => 'i', chr(195) . chr(173) => 'i',
            chr(195) . chr(174) => 'i', chr(195) . chr(175) => 'i',
            chr(195) . chr(177) => 'n', chr(195) . chr(178) => 'o',
            chr(195) . chr(179) => 'o', chr(195) . chr(180) => 'o',
            chr(195) . chr(181) => 'o', chr(195) . chr(182) => 'o',
            chr(195) . chr(182) => 'o', chr(195) . chr(185) => 'u',
            chr(195) . chr(186) => 'u', chr(195) . chr(187) => 'u',
            chr(195) . chr(188) => 'u', chr(195) . chr(189) => 'y',
            chr(195) . chr(191) => 'y',
            // Decompositions for Latin Extended-A
            chr(196) . chr(128) => 'A', chr(196) . chr(129) => 'a',
            chr(196) . chr(130) => 'A', chr(196) . chr(131) => 'a',
            chr(196) . chr(132) => 'A', chr(196) . chr(133) => 'a',
            chr(196) . chr(134) => 'C', chr(196) . chr(135) => 'c',
            chr(196) . chr(136) => 'C', chr(196) . chr(137) => 'c',
            chr(196) . chr(138) => 'C', chr(196) . chr(139) => 'c',
            chr(196) . chr(140) => 'C', chr(196) . chr(141) => 'c',
            chr(196) . chr(142) => 'D', chr(196) . chr(143) => 'd',
            chr(196) . chr(144) => 'D', chr(196) . chr(145) => 'd',
            chr(196) . chr(146) => 'E', chr(196) . chr(147) => 'e',
            chr(196) . chr(148) => 'E', chr(196) . chr(149) => 'e',
            chr(196) . chr(150) => 'E', chr(196) . chr(151) => 'e',
            chr(196) . chr(152) => 'E', chr(196) . chr(153) => 'e',
            chr(196) . chr(154) => 'E', chr(196) . chr(155) => 'e',
            chr(196) . chr(156) => 'G', chr(196) . chr(157) => 'g',
            chr(196) . chr(158) => 'G', chr(196) . chr(159) => 'g',
            chr(196) . chr(160) => 'G', chr(196) . chr(161) => 'g',
            chr(196) . chr(162) => 'G', chr(196) . chr(163) => 'g',
            chr(196) . chr(164) => 'H', chr(196) . chr(165) => 'h',
            chr(196) . chr(166) => 'H', chr(196) . chr(167) => 'h',
            chr(196) . chr(168) => 'I', chr(196) . chr(169) => 'i',
            chr(196) . chr(170) => 'I', chr(196) . chr(171) => 'i',
            chr(196) . chr(172) => 'I', chr(196) . chr(173) => 'i',
            chr(196) . chr(174) => 'I', chr(196) . chr(175) => 'i',
            chr(196) . chr(176) => 'I', chr(196) . chr(177) => 'i',
            chr(196) . chr(178) => 'IJ', chr(196) . chr(179) => 'ij',
            chr(196) . chr(180) => 'J', chr(196) . chr(181) => 'j',
            chr(196) . chr(182) => 'K', chr(196) . chr(183) => 'k',
            chr(196) . chr(184) => 'k', chr(196) . chr(185) => 'L',
            chr(196) . chr(186) => 'l', chr(196) . chr(187) => 'L',
            chr(196) . chr(188) => 'l', chr(196) . chr(189) => 'L',
            chr(196) . chr(190) => 'l', chr(196) . chr(191) => 'L',
            chr(197) . chr(128) => 'l', chr(197) . chr(129) => 'L',
            chr(197) . chr(130) => 'l', chr(197) . chr(131) => 'N',
            chr(197) . chr(132) => 'n', chr(197) . chr(133) => 'N',
            chr(197) . chr(134) => 'n', chr(197) . chr(135) => 'N',
            chr(197) . chr(136) => 'n', chr(197) . chr(137) => 'N',
            chr(197) . chr(138) => 'n', chr(197) . chr(139) => 'N',
            chr(197) . chr(140) => 'O', chr(197) . chr(141) => 'o',
            chr(197) . chr(142) => 'O', chr(197) . chr(143) => 'o',
            chr(197) . chr(144) => 'O', chr(197) . chr(145) => 'o',
            chr(197) . chr(146) => 'OE', chr(197) . chr(147) => 'oe',
            chr(197) . chr(148) => 'R', chr(197) . chr(149) => 'r',
            chr(197) . chr(150) => 'R', chr(197) . chr(151) => 'r',
            chr(197) . chr(152) => 'R', chr(197) . chr(153) => 'r',
            chr(197) . chr(154) => 'S', chr(197) . chr(155) => 's',
            chr(197) . chr(156) => 'S', chr(197) . chr(157) => 's',
            chr(197) . chr(158) => 'S', chr(197) . chr(159) => 's',
            chr(197) . chr(160) => 'S', chr(197) . chr(161) => 's',
            chr(197) . chr(162) => 'T', chr(197) . chr(163) => 't',
            chr(197) . chr(164) => 'T', chr(197) . chr(165) => 't',
            chr(197) . chr(166) => 'T', chr(197) . chr(167) => 't',
            chr(197) . chr(168) => 'U', chr(197) . chr(169) => 'u',
            chr(197) . chr(170) => 'U', chr(197) . chr(171) => 'u',
            chr(197) . chr(172) => 'U', chr(197) . chr(173) => 'u',
            chr(197) . chr(174) => 'U', chr(197) . chr(175) => 'u',
            chr(197) . chr(176) => 'U', chr(197) . chr(177) => 'u',
            chr(197) . chr(178) => 'U', chr(197) . chr(179) => 'u',
            chr(197) . chr(180) => 'W', chr(197) . chr(181) => 'w',
            chr(197) . chr(182) => 'Y', chr(197) . chr(183) => 'y',
            chr(197) . chr(184) => 'Y', chr(197) . chr(185) => 'Z',
            chr(197) . chr(186) => 'z', chr(197) . chr(187) => 'Z',
            chr(197) . chr(188) => 'z', chr(197) . chr(189) => 'Z',
            chr(197) . chr(190) => 'z', chr(197) . chr(191) => 's'
        );

        $string = strtr($string, $chars);

        return $string;
    }

}

if (!function_exists('getGroupPrice')) {

    function getGroupPrice($gid,$pname) {
        //DB::enableQueryLog();
        $uData = DB::table('rollco_ms_grproduct')->select('pr_price')
                ->where('gr_id', $gid)
                ->where('part_nm', $pname)
                ->first();
        //dd(DB::getQueryLog());
        if ($uData)
            return $uData->pr_price;
        else
            return '';
    }

}

if (!function_exists('updatestatus')) {
function updatestatus($u_id)
{
    //echo 'u_id::'.$u_id;
    if (isset($u_id) && $u_id > 0) {
        $uData = DB::table('rollco_ms_users')->select('com_emailAddress', 'companyName', 'user_status', 'cust_type', 'c_verified', 'na_authentication_key', 'na_agency_id')
                ->where('u_id', $u_id)
                ->first();
        $emailid = $uData->com_emailAddress;

        if (isset($emailid) && $emailid != '') {
            $na_authentication_key = $uData->na_authentication_key;
            $compname = $uData->companyName;
            $user_status = 0;
            if ($uData->user_status == 2 && $uData->c_verified == 1) {
                $user_status = 1;
            }
            if ($uData->na_authentication_key != '') {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://docs.rollingcomponents.com/api/updatestatus',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>'{
    "emailid":"' . $emailid . '",
    "authentication_key":"' . $na_authentication_key . '",
    "status":"' . $user_status . '"
}',
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                  ),
                ));
                $curl_response = curl_exec($curl);
                curl_close($curl);

            } else {

                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://docs.rollingcomponents.com/api/newagency',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                    "name":"' . $compname . '",
                    "clientid":"' . $u_id . '",
                    "emailid":"' . $emailid . '",
                    "status":"' . $user_status . '"
                  }',
                CURLOPT_HTTPHEADER => array(
                  'Content-Type: application/json'
                ),
                          ));
                $curl_response = curl_exec($curl);
//                curl_close($curl);

                $response_arr = json_decode($curl_response, true);

                // print_r($curl_response);
                // exit;


                if (isset($response_arr['agency id']) && $response_arr['agency id'] > 0) {
                    $na_authentication_key = $response_arr['authentication key'];
                    $na_agency_id = $response_arr['agency id'];
                    $na_status = $response_arr['status'];

                    if (isset($na_agency_id) && $na_agency_id > 0 && $na_authentication_key != '') {
                        /*------------------store new agency data in our database-----------------------*/
                        DB::table('rollco_ms_users')
                          ->where('u_id', $u_id)
                          ->update([
                              'na_authentication_key' => $na_authentication_key,'na_agency_id' => $na_agency_id
                          ]);
                        /*------------------store new agency data in our database end-------------------*/
    
                        /* comment on 250523
    
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://docs.rollingcomponents.com/public/api/newregister',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>'{
                              "name":"' . $compname . '",
                              "clientid":"' . $u_id . '",
                              "emailid":"' . $emailid . '",
                              "authentication_key":"' . $na_authentication_key . '",
                              "is_admin":"0",
                              "status":"' . $user_status . '"
                      }',
                        CURLOPT_HTTPHEADER => array(
                          'Content-Type: application/json'
                        ),
                              ));
    
                        $curl_response = curl_exec($curl);
                        curl_close($curl); */
                    }

    
                }



                
            }
        }
    }
}
}

if (!function_exists('deletestatus')) {
    function deletestatus($emailid, $na_authentication_key)
    {
        //echo 'u_id::'.$u_id;
            if (isset($emailid) && $emailid != '' && $na_authentication_key != '') {
                $user_status = 0;
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://docs.rollingcomponents.com/api/updatestatus',
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => '',
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'POST',
                      CURLOPT_POSTFIELDS =>'{
        "emailid":"' . $emailid . '",
        "authentication_key":"' . $na_authentication_key . '",
        "status":"' . $user_status . '"
    }',
                      CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                      ),
                    ));
                    $curl_response = curl_exec($curl);
                    curl_close($curl);
                }
    }
    }
?>
