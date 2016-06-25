<?php

namespace utils;

/**
 * Class utils : utilitaires HTML
 */
class HTMLUtils
{
    static public function tag(string $tag, string $str):string
    {
        return "<" . $tag . ">" . $str . "</" . $tag . ">";
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
}
