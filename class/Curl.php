<?php namespace Funch;

class Curl{
    public static function request($a, $return_raw = false){
        $url = $a['url'];
        $referer = isset($a['referer']) ? $a['referer'] : $url;
        $headers = isset($a['headers']) ? (is_array($a['headers']) ? $a['headers'] : explode("\r\n", $a['headers'])) : [];
        $post = isset($a['post']) ? $a['post'] : false;
        
        $headers[] = 'Host: ' . parse_url($url, PHP_URL_HOST);
        $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0';
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        $headers[] = 'Accept-Language: zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3';
        $headers[] = 'Referer: ' . $referer;
        $headers[] = 'Connection: close';
        
        $ch       = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, $return_raw);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        
        if ($post !== false) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        
        $response = curl_exec($ch);
        
        return $response;
    }
}