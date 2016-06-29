<?php

namespace utils;

/**
 * Class utils : utilitaires HTML
 */
class HTMLUtils
{
    static $HTMLtags;


    /**
     * renvoie une string representant des balises HTML
     * @param $tag
     * @param $str
     * @return string
     * @throws \Exception
     */
    static public function tag(string $tag, string $str):string
    {
        if(HTMLUtils::checkHTMLTag($tag) === true){
            return "<" . $tag . ">" . $str . "</" . $tag . ">";
        }
        else{

            throw new \Exception("Erreur : cette balise n'existe pas");
        }
        
    }

    /**
     * renvoie un lien html basé sur une url et un texte affiché
     * @param string $url
     * @param string $str
     * @return string
     */
    static public function ahref(string $url, string $str):string
    {
        return '<a href="' . $url . '">' . $str . "</a>";
    }

    /**
     * renvoie une image basée sur une url
     * @param string $url
     * @return string
     */
    static public function img(string $url):string
    {
        return '<img class="flags" src="' . $url . '"></img>';
    }

    /**
     * Verifie qu'un tag HTML existe et revoie true ou false.
     * @param string $tag
     * @return bool
     */
    static public function checkHTMLTag(string $tag):bool
    {
        if(self::$HTMLtags === null ){
            self::$HTMLtags = json_decode(file_get_contents("HTMLTags.json"),true);
        }

        if(array_search ( $tag , self::$HTMLtags)!= false){
            return true;
        }
        else{
            return false;
        }

    }
}

