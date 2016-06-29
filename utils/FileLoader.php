<?php

namespace utils;

class FileLoader{
    
    public $file;
    public $data;
    
    public function __construct($file)
    {
        $this->file = $file;
        $this->data = file_get_contents($this->file);
    }
    
    public  function getFileType(){

        if (preg_match("/json/i", $this->file)) {
            return JsonParser::format($this->data);
        }
        else if(preg_match("/xml/i", $this->file)){
            return XMLParser::format($this->data);
        }
        else{
            throw new \Exception("Erreur : Ce type de fichier n'est pas pris en charge");
        }
    }

}