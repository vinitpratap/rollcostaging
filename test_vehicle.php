<?php
phpinfo();
exit;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function get_post($url) {

    $url = str_replace("#", "%23", $url);

    $url = str_replace("<", "%26lt;", $url);

    $url = str_replace(">", "%26gt;", $url);

    $options = array(

        CURLOPT_RETURNTRANSFER => true, // return web page
       CURLOPT_SSL_VERIFYHOST => false, // don't return headers
        CURLOPT_SSL_VERIFYPEER => false, // don't return headers
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
	
	print_r($content);

    $err = curl_errno($ch);

    $errmsg = curl_error($ch);

    $header = curl_getinfo($ch);

    curl_close($ch);

    $header['errno'] = $err;

    $header['errmsg'] = $errmsg;

    $header['content'] = $content;

    return $header;

}

$car_no='YT14YDL';
$url="https://vrm.mamsoft.co.uk/vrmlookup/vrmlookup.asmx/Find?Username=RCCSWS&Password=fu9A8unE&Vrm=".$car_no;
                $mamData = get_post($url);
				//print_r($mamData);
	echo "<pre>";print_r($mamData);die; 
	exit;


			function testgetMAMdata($cno) {

       echo $data = 'Username=RCCSWS&Password=fu9A8unE&Vrm=' . $cno;

  echo     $url = "https://vrm.mamsoft.co.uk/vrmlookup/vrmlookup.asmx/Find";

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, 1);
 //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);	

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS,($data));

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    curl_setopt($ch, CURLOPT_HTTPHEADER,

            array('Content-Type: application/x-www-form-urlencoded'));

    $result = curl_exec($ch);
	print_r($result);
    $parser = simplexml_load_string($result);

print_r($parser);


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
          			$car_no='YT14YDL';

              //  $cat_id = trim($_POST['cat_id']);
				echo $car_no;
                $mamData = testgetMAMdata($car_no);
				//print_r($mamData);
	echo "<pre>";print_r($mamData);die; 
	exit;
?>