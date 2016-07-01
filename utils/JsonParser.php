<?php

namespace utils;

class JsonParser implements Parser{

    
    public static function format($data):\stdClass
    {
        return json_decode($data);
    }
}