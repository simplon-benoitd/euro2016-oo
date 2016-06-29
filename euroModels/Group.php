<?php

namespace euroModels;

/**
 * Class Group : structure de données décrivant un groupe : un id et une liste d'équipes
 */
class Group
{
    /**
     * @var string
     */
    public $id;

    public function getId():string
    {
        return $this->id;
    }

    public function setId($value)
    {
        if (is_string($value))
            $this->id = $value;
    }

    /**
     * @var array
     */
    public $teams;

    public function __construct($src)
    {
        $this->initData($src);
    }

    private function initData($src)
    {
        $this->setId($src->id);
        // teams
        $this->teams = [];
        foreach ($src->teams as $team) {
            $this->teams[] = $team;
        }
    }
}