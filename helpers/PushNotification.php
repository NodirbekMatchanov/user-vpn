<?php

namespace app\helpers;

class PushNotification
{
    //const FCM_API_KEY = 'AAAA3CkxQB0:APA91bHC3SlyhqnojrKeIs8oYlD-pFOj0A_LXk9R4SqcD4F1bbbWVjs33nJnN_7J0UbhTQTIoA7MBBT_A_rblOb3_qWRSFhTI653f2ovvLrb3WMg-HzbONdV2SqDnvoGe6orBloElXjBATtzGZhGVG6Gq3iovIeV7Q';
    //const FCM_API_KEY = 'cOtuhmwmPzc:APA91bGK8azTAe8KGGJ15OEfHhAZbTnIbIjGHNnmLFBM8TWrJuiSC7ZOOo2IhhLFQdY9B9CyxeA-xX9-I8T9astr27lJKJ6D_srOtU1jzWtKaeYqKmEHm_Kneuga8mMz8ICqmB1l61Uh';
    const FCM_API_KEY = 'AAAA3CkxQB0:APA91bHFvb0bUDIGQagqvxOr6h0k3ymlypbCnOC6Bl9Pmq-RoVzZZczXk-nb590IBR2J4vT2eajuayqoGCmQI88KlTQthmX_Nb2N7sjnPAuA5oz352gdiAYrmhKY6pSmZQqtk5lv0uDy';
    //const FCM_API_KEY = 'AIzaSyC5yEFizFzSKr1-VGfQBAMEdGJwrYDtFJc';
    const MAX_TOKEN_PER_REQUEST = 1000;

    private static $fcmApiBaseURL = 'https://fcm.googleapis.com';

    /**
     * @param $deviceToken
     * @param PushMessage $message
     * @return array<fcmToken=>array<boolean,response>>
     */
    public static function send($deviceToken, PushMessage $message)
    {
        $tokens = is_array($deviceToken) && count($deviceToken) ? array_chunk($deviceToken, self::MAX_TOKEN_PER_REQUEST, false) : [$deviceToken];

        $messageData = [
            'title' => $message->getTitle(),
            'body' => $message->getMessage()
        ];
        $maxLength = 3000; // The total size of the payload data that is included in a message can't exceed 4096 bytes.
        if (strlen($messageData['body']) > $maxLength) {
            $messageData['body'] = substr($messageData['body'], 0, $maxLength);
        }

        $results = [];
        foreach ($tokens as $tokenPart) {
            $fields = [
                'registration_ids' => $tokenPart,
                //'data' => $messageData,
                'notification' => $messageData
            ];
            $_result = self::makeRequest($fields);
            if (is_array($tokenPart)) {
                foreach ($tokenPart as $tp) {
                    $results[$tp] = $_result;
                }
            } else {
                $results[$tokenPart] = $_result;
            }
        }
        return $results;
    }

    /**
     * @param array $postFields
     * @return array
     */
    private static function makeRequest(Array $postFields = array())
    {
        $headers = [
            'Authorization: key=' . self::FCM_API_KEY,
            'Content-Type: application/json'
        ];
        $output = [];

        $ch = curl_init(self::$fcmApiBaseURL . '/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postFields));
        curl_setopt(
            $ch, 
            CURLOPT_HEADERFUNCTION, 
            function($curl, $h) use (&$output) {
                $l = strlen($h);
                $h = explode(':', $h, 2);
                if (count($h) < 2) {
                    return $l;
                }
                $output[strtolower(trim($h[0]))][] = trim($h[1]);
                return $l;
            }
        );

        $result = curl_exec($ch);
        if (isset($_GET['debug'])) {
            var_dump($result);
            exit;
        }

        if (curl_errno($ch)) {
            return [false, $result, $output];
        }

        curl_close($ch);

        $response = json_decode($result);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [false, $result, $output];
        }

        return [$response && $response->success == 1, $response, $output];
    }
}
