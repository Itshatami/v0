<?php

namespace App\Library;

class SendSMS
{
   public static function sendVerification($phone_number, $vc)
   {

      try {
         $client = new \SoapClient("http://ippanel.com/class/sms/wsdlservice/server.php?wsdl");
         $user = "alirezahatami";
         $pass = "alireza57800";
         $fromNum = "+983000505";
         $toNum = array($phone_number);
         $pattern_code = "xwl8go0hhvnous5";
         $input_data = array("code" => $vc);
         echo $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
      } catch (\Throwable $th) {
         throw $th;
      }
   }
}
