<?php

namespace utils;

class XMLParser implements Parser{
    
    public static function format($data):\stdClass
    {
        $xml = simplexml_load_string($data);
        $json = json_encode($xml);
        return json_decode($json);
    }
}