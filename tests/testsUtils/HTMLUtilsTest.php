<?php
/**
 * Created by PhpStorm.
 * User: sev
 * Date: 25/06/16
 * Time: 19:05
 */

namespace tests\testsUtils;


use utils\HTMLUtils;

class HTMLUtilsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * test de la fonction tag avec une string h1 en parametre
     */
    public function test_TagIsString(){
        
        $tag = 'h1';
        $str = '';
        
        $this->assertEquals("<h1></h1>", HTMLUtils::tag($tag,$str));
    }

    /**
     * test de la fonction tag en passant en parametre un chiffre
     *  @expectedException \Exception
     */
    public function test_TagIsNotAString(){
        
        $str = '';
        $exeption = new \Exception("Erreur : cette balise n'existe pas");
        
        $this->assertEquals($exeption,HTMLUtils::tag(4,$str));
    }

    /**
     * test de la fonction tag en passant une string en parametre mais qui ne correspond pas a une balise HTML existante
     *  @expectedException \Exception
     */
    public function test_TagDoesNotExist(){

        $tag = 'Umbrella';
        $str = '';
        $exeption = new \Exception("Erreur : cette balise n'existe pas");

        $this->assertEquals($exeption, HTMLUtils::tag($tag,$str));
    }

    /**
     * test de la fonction checktag avec un parametre qui correspond a un tag et l'autre non. 
     */
    public function test_checkTag(){

        $this->assertEquals(true, HTMLUtils::checkHTMLTag("h1"));
        $this->assertEquals(false, HTMLUtils::checkHTMLTag("coucou"));

    }
}
