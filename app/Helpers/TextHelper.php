<?php

namespace App\Helpers;

use Segment;

class TextHelper
{
    // public static function splitText($text)
    // {
    //     require_once (base_path('/vendor/notyes/thsplitlib/THSplitLib/segment.php'));
    //     $segment = new \Segment();   
    //     $text = str_replace(' ', '<>', $text);
    //     $text = str_replace('/', '+=', $text);
    //     $words = $segment->get_segment_array($text); 
        
    //     $out = implode("|",$words);
    //     $out = str_replace('<>', ' ', $out);
    //     $out = str_replace('+=', '/', $out);
    //     return $out;
    // }

    public static function splitText($text)
    {
        // require_once(base_path('/vendor/notyes/thsplitlib/THSplitLib/segment.php'));
        require_once(app_path('Helpers/THSplitLib/segment.php'));
        $segment = new \Segment();   
        $text = str_replace(' ', '<>', $text);
        $text = str_replace('/', '+=', $text);
        $words = $segment->get_segment_array($text);
        // dd($words);
        // ห่อแต่ละคำด้วย <nobr> เพื่อป้องกันการตัดคำ
        $wrappedWords = array_map(function($word) {
            return "<nobr>{$word}</nobr>";
        }, $words);
    
        // รวมคำคั่นด้วยเครื่องหมายที่ต้องการ เช่น |
        $out = implode("|", $wrappedWords);
       
        $out = str_replace('<>', ' ', $out);
        $out = str_replace('+=', '/', $out);
        // dd($out);
        return $out;
    }

    public static function FixBreak($text){
        $text = str_replace(' ', '!', $text);
        // require_once(base_path('/vendor/notyes/thsplitlib/THSplitLib/segment.php'));
        require_once(app_path('Helpers/THSplitLib/segment.php'));
        $segment = new \Segment(); 
        $words = $segment->get_segment_array($text);
        $out = implode(" ", $words);
        // dd($out);
        return $out;
    } 

    public static function callLonganTokenize($text)
    {
        // joerocknpc: 
        // programfamily: 
        // edutecht: 
        // fahsaith: 
        // ciwawin748@eoilup.com
        // eland60219@dotzi.net
        // panda346@driftz.net

        $apiKeys = explode('|', env('TEXT_API_KEYS')); // แปลงค่าใน .env เป็น array
        // dd($apiKeys);
        $randomKey = $apiKeys[array_rand($apiKeys)]; // สุ่ม key ออกจาก array
        $curl = curl_init();
        $text = str_replace(' ', '<>', $text);
        $url = "https://api.aiforthai.in.th/longan/tokenize?text=" . urlencode($text) . "&sep=%7C&wordseg=true&sentseg=true";
        // dd($apiKeys);
        // กำหนดค่า cURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "apikey: $randomKey" // ใช้ API Key ที่สุ่มมา
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #: " . $err;
        }
        // dd($response);
            // แปลง JSON เป็น PHP array
            $data = json_decode($response, true);
            
            // ตรวจสอบข้อมูลและแสดงผล
            if (isset($data['result']) && is_array($data['result'])) {
                $result = $data['result'][0]; // ดึงข้อความแรกจาก array
               
                $result = str_replace('|', ' ', $result);
                // dd($result);
                return $result;
                return response()->json(['message' => 'Success', 'data' => $result]);
            } else {
                return response()->json(['message' => 'No results found'], 404);
            }
        return $response;
    }
    
    public static function callLonganTokenizePost($text)
    {
        // joerocknpc: 
        // programfamily: 
        // edutecht: 
        // fahsaith: 
        // ciwawin748@eoilup.com
        // eland60219@dotzi.net
        // panda346@driftz.net


        $apiKeys = explode('|', env('TEXT_API_KEYS')); // แปลงค่าใน .env เป็น array
        $randomKey = $apiKeys[array_rand($apiKeys)]; // สุ่ม key ออกจาก array
        // dd($randomKey);
        $curl = curl_init();

        // แปลงช่องว่างเป็น "<>" (ถ้าจำเป็น)
        $text = str_replace(' ', '!', $text);

        // ตั้งค่า cURL สำหรับ POST
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.aiforthai.in.th/longan/tokenize',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'text' => $text, 
            ),
            CURLOPT_HTTPHEADER => array(
                "apikey: $randomKey"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #: " . $err;
        }

        // แปลง JSON เป็น PHP array
        $data = json_decode($response, true);

        // ตรวจสอบและประมวลผลข้อมูล
        if (isset($data['result']) && is_array($data['result'])) {
            $result = $data['result'][0]; // ดึงข้อความแรกจาก array
            // แปลงตัวคั่นกลับเป็นช่องว่าง
            $result = str_replace('|', ' ', $result);
            return $result;
        } else {
            // require_once(base_path('/vendor/notyes/thsplitlib/THSplitLib/segment.php'));
            require_once(app_path('Helpers/THSplitLib/segment.php'));
            $segment = new \Segment(); 
            $words = $segment->get_segment_array($text);
            $result = implode(" ", $words);
            return $result;
        }
    }

}
