<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('FULL_PATH', dirname(__FILE__) . '/');
$stage = 'STAGING'; //STAGING
$snm = '';
$snmp = '';
$stitle = "Rollco";

$sitetitle = $stitle . " : Admin Control Panel";

$cssvers = '?v=5.08';
$jsvers = '?v=5.08';

$sitetitle = $stitle . " : Admin Control Panel";

if (($_SERVER['HTTP_HOST'] == 'localhost:90') || ($_SERVER['HTTP_HOST'] == 'localhost')) {
    $snm = 'rollco/web_v1/';
    $snmp = 'rollco/web_v1/';
    $siteurl = "http://" . $_SERVER['HTTP_HOST'] . "/" . $snm;
    $sitesurl = "http://" . $_SERVER['HTTP_HOST'] . "/" . $snm;

    $sitespsturl = "http://" . $_SERVER['HTTP_HOST'] . "/" . $snmp;

    $siteurlnew = "http://" . $_SERVER['HTTP_HOST'] . "/" . $snm;

    $siteurlnew1 = "http://" . $_SERVER['HTTP_HOST'] . "/" . $snm;

//error_reporting(0);

} else {
    $snm = '';
    $snmp = '';
    $siteurl = "http://www.rollingcomponents.com/" . $snm;

    $sitesurl = "http://www.rollingcomponents.com/" . $snm;

    $siteurlnew = "http://www.rollingcomponents.com/" . $snm;

    $siteurlnew1 = "http://www.rollingcomponents.com/" . $snm;

    //error_reporting(0);

}





require_once("sepconn.php");



class ajquery {



    function query($sql) {

        return GetMyConnection()->query($sql);

    }



    function fetch($sql) {

        return $sql->fetch_assoc();

    }



    function insertid() {

        return mysqli_insert_id(GetMyConnection());

    }
	 function error() {

        return mysqli_error(GetMyConnection());

    }



    function onumsrow($sql) {

//    print_r($sql);

        $numRows = $sql->num_rows;

        return $numRows;

    }



    function numsrow($sql) {



        $nums = GetMyConnection()->query($sql);

        $numRows = $nums->num_rows;

        return $numRows;

    }



    function fearr($sql) {

        $fetch = GetMyConnection()->query($sql);

        return $fetch->fetch_assoc();

    }



    function ferow($sql) {

        $fetch = GetMyConnection()->query($sql);

        return mysqli_fetch_row($fetch);

    }



    function remove($str) {

        return unlink($str);

    }



    function strreplace($str) {

        $contentbodypart = preg_replace("/[\r\n]/", "", trim($str));

        $contentbodypart = str_replace("\\'", "'", $contentbodypart);

        $contentbodypart = str_replace("'", "&#39;", $contentbodypart);

        $contentbodypart = stripslashes($contentbodypart);

        $contentbodypart = str_replace("<p>&nbsp;</p>", "", $contentbodypart);

        $contentbodypart = str_replace("(", "&#40;", $contentbodypart);

        $contentbodypart = str_replace(")", "&#41;", $contentbodypart);

        return $contentbodypart;

    }



    function quickreplace($str) {

        $contentbodypart = mysqli_escape_string(GetMyConnection(), $str);

        $contentbodypart = strip_tags($contentbodypart);

        return $contentbodypart;

    }



}



function recount($id, $tablename, $param_nm = '') {

    $grc = "select " . $id . " from " . $tablename;

    if ($param_nm != "") $grc .= " where " . $param_nm;

    $nums = mysqli_query($grc, GetMyConnection());

    $glbcnts = mysqli_num_rows($nums);

    return $glbcnts;

}



$sitadmurl = $siteurl . "secAdm/";



function RecursiveMkdir($path) {

    if (!file_exists($path)) {

        RecursiveMkdir(dirname($path));

        mkdir($path, 0777);

    }

}



define('ROOT_DIR', FULL_PATH);

define('DOC_IMAGES', ROOT_DIR . 'images/');



if (isset($_SERVER['DOCUMENT_ROOT'])) {

   $cpath = $_SERVER['DOCUMENT_ROOT'] . '' . $snm . '/';

    if ($_SERVER['HTTP_HOST'] == 'localhost')

            $cpath = $_SERVER['DOCUMENT_ROOT'] . '' . $snm . '/';

} else {

    $cpath = ROOT_DIR;

}



function getlastdayofmonth($month, $year) {

    for ($day = 28; $day < 32; $day++) {

        if (!checkdate($month, $day, $year)) return $day - 1;

    }

    $vars = $day - 1;

}



function is_odd($number) {

    return $number & 1; // 0 = even, 1 = odd

}



$sq = new ajquery;



function sentence_case($string) {

    $sentences = preg_split('/([.?!]+)/', $string, -1,

            PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    $new_string = '';

    foreach ($sentences as $key => $sentence) {

        $new_string .= ($key & 1) == 0 ?

                ucfirst(strtolower(trim($sentence))) :

                $sentence . ' ';

    }

    return trim($new_string);

}



//For showing only number in any string mady by Ajit kumar singh on 01feb2010

function allownums($str) {

    return $result = preg_replace("/[^0-9]/", "", $str);

}



//end here..

//Upload images script



function upload($file_id, $folder = "", $types = "") {

    if (!$_FILES[$file_id]['name']) return array('', 'No file specified');

    $file_title = $_FILES[$file_id]['name'];

    //Get file extension

    //$ext_arr = split("\.",basename($file_title));

    //$ext = strtolower($ext_arr[count($ext_arr)-1]); //Get the last extension

    $ext = pathinfo($file_title, PATHINFO_EXTENSION);

    //Not really uniqe - but for all practical reasons, it is

    $uniqer = substr(md5(uniqid(rand(), 1)), 0, 6);

    $file_name = "rc" . $uniqer . '_' . $file_title; //Get Unique Name

    $all_types = explode(",", strtolower($types));

    if ($types) {

        if (in_array($ext, $all_types)) ;

        else {

            $result = "'" . $_FILES[$file_id]['name'] . "' is not a valid file."; //Show error if any.

            return array('', $result);

        }

    }

    //Where the file must be uploaded to

    if ($folder) $folder .= '/'; //Add a '/' at the end of the folder

    $uploadfile = $folder . $file_name;

    $result = '';

    //Move the file from the stored location to the new location

    if (!move_uploaded_file($_FILES[$file_id]['tmp_name'], $uploadfile)) {

        $result = "Cannot upload the file '" . $_FILES[$file_id]['name'] . "'"; //Show error if any.

        if (!file_exists($folder)) {

            $result .= " : Folder don't exist.";

        } elseif (!is_writable($folder)) {

            $result .= " : Folder not writable.";

        } elseif (!is_writable($uploadfile)) {

            $result .= " : File not writable.";

        }

        $file_name = '';

    } else {

        if (!$_FILES[$file_id]['size']) { //Check if the file is made

            @unlink($uploadfile); //Delete the Empty file

            $file_name = '';

            $result = "Empty file found - please use a valid file."; //Show the error message

        } else {

            chmod($uploadfile, 0777); //Make it universally writable.

        }

    }

    return array($file_name, $result);

}



//Upload images ends here.....

//Code for validate emails

function validate_email($emails) {

    $clean = array();

    $val = 0;

    $email_pattern = '/^[^@\s<&>]+@([-a-z0-9]+\.)+[a-z]{2,}$/i';

    if (preg_match($email_pattern, $emails)) {

        $clean['email'] = $emails;

        $val = 1;

    }

    return $val;

}



///ends here...

//Code for validate numeric value

function validate_nums($varnums) {

    $clean = array();

    $val = 0;

    if ($varnums == strval(intval($varnums))) {

        $clean['num'] = $varnums;

        $val = 1;

    }

    return $val;

}



///ends here...

//Limit the workd

function word_limiter($str, $limit = 100, $end_char = '&#8230;') {



    if (trim($str) == '') return $str;



    preg_match('/\s*(?:\S*\s*){' . (int) $limit . '}/', $str, $matches);

    if (strlen($matches[0]) == strlen($str)) $end_char = '';

    return rtrim($matches[0]) . $end_char;

}



function quote_smart($value) {

    if (get_magic_quotes_gpc()) {

        $value = stripslashes($value);

    }

    if (is_numeric($value)) {

        $value = preg_replace("/[^0-9]/", "", $value);

    } else {

        // $value =mysqli_real_escape_string(GetMyConnection(),$value);

        // $value =preg_replace("/[^0-9A-Za-z-_ ]/","",$value);

        $value = str_replace("drop", "", $value);

        $value = str_replace("delete", "", $value);

        $value = str_replace("select", "", $value);

        $value = str_replace("insert", "", $value);

        $value = str_replace("update", "", $value);

        $value = str_replace("version", "", $value);

        $value = str_replace("concat", "", $value);

        $value = str_replace("user", "", $value);

        $value = str_replace("script", "", $value);

        $value = str_replace("database", "", $value);

        $value = str_replace(";", "", $value);

        $value = substr($value, 0, 25);

    }

    return $value;

}



function fileexists($flnm) {

    $ext = substr($flnm, strrpos($flnm, '.') + 1);

    return $ext;

}



$timezone = 5.5; //(GMT -5:00) EST (U.S. & Canada)

$getsystime = gmdate("G:i", time() + 3600 * ($timezone + date("I")));

$getsyssec = gmdate("s", time() + 3600 * ($timezone + date("I")));

$getsysdate = gmdate("Y-m-d", time() + 3600 * ($timezone + date("I")));

$getsysday = gmdate("l", time() + 3600 * ($timezone + date("I")));

$getdatetime = $getsysdate . " " . $getsystime . ":" . $getsyssec;



function repqrystrng($str) {

    $pnt = str_replace("select", "", $str);

    $pnt = str_replace("insert", "", $pnt);

    $pnt = str_replace("update", "", $pnt);

    $pnt = str_replace("drop", "", $pnt);

    $pnt = str_replace("union", "", $pnt);

    $pnt = str_replace(".php", "", $pnt);

    $pnt = str_replace(".asp", "", $pnt);

    $pnt = str_replace(".jsp", "", $pnt);

    $pnt = str_replace("http", "", $pnt);

    $pnt = str_replace("1=1", "", $pnt);

    $pnt = str_replace("--", "", $pnt);

    $pnt = str_replace("'", "", $pnt);

    $pnt = str_replace(" or ", "", $pnt);

    $pnt = str_replace(" 0 ", "", $pnt);

    $pnt = str_replace(" 1 ", "", $pnt);

    $pnt = str_replace(" and ", "", $pnt);

    return $pnt;

}



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



function get_post($url) {

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



//

//$URL_SITE = $config['SITE_URL'];

//$con=GetMyConnection();

$countmsg = 0;

date_default_timezone_set('Asia/Calcutta');

$timezone = 5.5; //(GMT -5:00) EST (U.S. & Canada)

$getsystime = gmdate("G:i", time() + 3600 * ($timezone + date("I")));

$getsyssec = gmdate("s", time() + 3600 * ($timezone + date("I")));

$getsysdate = gmdate("Y-m-d", time() + 3600 * ($timezone + date("I")));

$getsysday = gmdate("l", time() + 3600 * ($timezone + date("I")));

$getdatetime = $getsysdate . " " . $getsystime . ":" . $getsyssec;



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



function check_input($input_value) {

    $search = array("'<script[^>]*?>.*?</script>'si", // Strip out javascript

        "'<[/!]*?[^<>]*?>'si");          // Strip out HTML tags



    $replace = array("",

        "");



    $text = preg_replace($search, $replace, $input_value);

    if ($text != $input_value) {

        return false;

        exit;

    } else return true;

}



function my_simple_crypt($string, $action = 'e') {

    // you may change these values to your own

    $secret_key = 'secret_key';

    $secret_iv = 'secret_iv';



    $output = false;

    $encrypt_method = "AES-256-CBC";

    $key = hash('sha256', $secret_key);

    $iv = substr(hash('sha256', $secret_iv), 0, 16);



    if ($action == 'e') {

        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key,

                        0, $iv));

    } else if ($action == 'd') {

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key,

                0, $iv);

    }



    return $output;

}



// debug 



function debug($str) {

    echo "<pre>";

    print_r($str);

}



// test input function 

function test_input($data) {

    $data = trim($data);

    $data = stripslashes($data);

    $data = htmlspecialchars($data);

    return $data;

}



function splitIdAndText($value) {

    $val = explode('_', $value);

    return array("id" => $val[0], "text" => $val[1]);

}



function getMAMdata($cno) {

    $data = 'Username=RCCSWS&Password=fu9A8unE&Vrm=' . $cno;

    $url = "https://vrm.mamsoft.co.uk/vrmlookup/vrmlookup.asmx/Find";

    $ch = curl_init($url);



    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS,($data));

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    curl_setopt($ch, CURLOPT_HTTPHEADER,

            array('Content-Type: application/x-www-form-urlencoded'));

    $result = curl_exec($ch);

    $parser = simplexml_load_string($result);



//    SimpleXMLElement Object ( [Vrm] => TN07GYT [Vin] => SHSRE67707U017714 [EngineNo] => N22A26517718 [EngineSize] => 2204 [EngineModel] => N22A2 [Fuel] => DIESEL [Make] => HONDA [Model] => CR-V I-CTDI EX (MK3 (RE67)) [Colour] => GREY [Transmission] => MANUAL [TransmissionCode] => M [BodyPlan] => ATV/SUV (5 DOORS) [BodyPlanCode] => SimpleXMLElement Object ( ) [Gears] => 6 [YearOfManufacture] => 2007 [DateRegistered] => 20070510 [Scrapped] => 0 [Exported] => 0 [Imported] => 0 [DtpMakeCode] => D5 [DtpModelCode] => 200 [MamMake] => Honda [MamModel] => CR-V [MamSModel] => SimpleXMLElement Object ( ) [MvrisMakeCode] => SimpleXMLElement Object ( ) [MvrisModelCode] => SimpleXMLElement Object ( ) [RelatedMVRIS] => SimpleXMLElement Object ( ) [Power] => 138.1~103 [Valves] => 16 [Indval] => 5966 [MamEngSize] => 2.2 [Co2Em] => 173,E4 [IntroDate] => 20060601 [MSCode] => 12103040000006 [Weight] => 0 [WheelPlan] => C [DriveType] => 4X4 [CWC] => 93342 [MMIv8] => SimpleXMLElement Object ( [MMIv8Key] => 110045 ) ) 

    if (count($parser) > 0) {

        $vrm = (string) $parser->Vrm;

        $make = (string) $parser->Make;

        $model = (string) $parser->Model;

        $year = (string) $parser->YearOfManufacture;

        $esize = (string) $parser->EngineSize;

        $mscode = (string) $parser->MSCode;

        $MMIv8Key = (string) $parser->MMIv8->MMIv8Key[0];

        //debug($parser->MMIv8->MMIv8Key[0]);die;

        return array('vrm'=>$vrm,'make'=>$make,'model'=>$model,'year'=>$year,'esize'=>$esize,'mscode'=>$mscode,'MMIv8Key'=>$MMIv8Key);

    }else{

        return 0;

    }



}

function checkIssetNotEmpty($var){

   if(isset($var) && $var !=''){

       return true;

   }else{

       return false;

   }

}

?>