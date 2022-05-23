<?php

namespace app\helpers\ios;

use app\helpers\PushMessage;


class PushNotification
{
    protected $certPath = '';
    protected $keyPath  = '';
    protected $apnsHostName = "https://api.push.apple.com";
    protected $apnsTopic = "ru.IceDigital.CheckPassMRR";
    protected $debug = false;

    static protected $instance;

    static public function getInstance($pemPath = '', $debug = true) {
        if (self::$instance === null) {
            self::$instance = new PushNotification($pemPath, $debug);
        }
        return self::$instance;
    }

    protected function __construct($pemPath = '', $debug = true)
    {
        if (is_array($pemPath) && count($pemPath) > 1) {
           $this->certPath = (string) $pemPath[0];
           $this->keyPath  = (string) $pemPath[1];
        }  else {
           $pemPath = (string)$pemPath;
           $this->certPath = preg_replace('/\.pem$/', '.crt', $pemPath);
           $this->keyPath = preg_replace('/\.pem$/', '.key', $pemPath);
        }

        $this->debug = $debug;
    }

    public function send($deviceToken, PushMessage $message) {
        $deviceTokens = is_array($deviceToken) ? $deviceToken : [$deviceToken];
        $results = [];

        foreach ($deviceTokens as $token) {
	    $cmd = implode(' ', [
               '/usr/bin/nghttp', '-v', 
               '-H', escapeshellarg(sprintf('apns-topic: %s', $this->apnsTopic)),
               '-H', escapeshellarg('apns-push-type: alert'),
               '--data=-',
               '--cert='.escapeshellarg($this->certPath),
               '--key='.escapeshellarg($this->keyPath),
                sprintf('%s/3/device/%s', $this->apnsHostName, $token)
            ]);

            $rc  = 1;
            $out = '';
            $err = '';
            $nghttp = proc_open(
                $cmd, 
                [['pipe', 'r'], ['pipe', 'w'], [ 'pipe', 'w']], 
                $pipes
            );
            if (is_resource($nghttp)) {
                fwrite($pipes[0], json_encode([
                    'aps' => [
                       'alert' => [
                           'title' => $message->getTitle(),
                           'body' => $message->getMessage(),
                       ],
                       'sound' => 'default'
                    ]
                ]));
                fclose($pipes[0]);
                $out = stream_get_contents($pipes[1]);
                $err = stream_get_contents($pipes[2]);
                $rc = proc_close($nghttp);
            }

            $results[$token] = [ $rc == 0, "$cmd\n\nSTDOUT:\n$out\n\nSTDERR:$err\n" ];
        }
        return $results;
    }

    public function close() {}
}


