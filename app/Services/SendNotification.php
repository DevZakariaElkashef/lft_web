<?php

namespace App\Services;


class SendNotification
{

    private static $URL = "https://fcm.googleapis.com/fcm/send";


    const NOTIFICATION_KEY = 'AAAA0DW6Bm0:APA91bHKFFV4Kg75aM5EvLqTr9JEl4H-GrNaMDml_vexzXhXHtNIlwc12cjRq0GOUw4t96MIZNcm8KD0YSAYvJun-HXVSrTW0AusF1YYT2oTWzZkmX0srWTE7FbVz-4tNzT8P5jgkf7o';

    public static function send($token, $title,$text)
    {
        $data = [
            "to" =>$token,
            "data" =>[
                    "title" => $title,
                    'body' => $text,
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK"
                ],
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . self::NOTIFICATION_KEY,
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $result=curl_exec($ch);
        return true;
    }
}
