<?php

namespace euroModels;


/**
 * Class Competition : représentation des données d'une compétition : un nom et une liste de groupes
 */
class Competition
{
    public $name;

    public $groups;

    private $originalData;

    function __construct(\stdClass $src)
    {
        $this->initData($src);
        $this->originalData = $src;
    }

    function __toString():string
    {
        return "Objet Competition[" . $this->name . " ( nombre groupes : " . count($this->groups) . " ')" . "]";
    }


    /**
     * initialisation des données à partir d'un objet stdClass
     * @param $src
     */
    private function initData($src)
    {
        $this->name = $src->name;

        // création des groupes
        $this->groups = [];
        foreach ($src->groups as $group) {
            $this->groups[] = new Group($group);
        }
    }

    /**
     * renvoie le groupe
     * @param $groupId
     * @return Group|null
     * @throws \Exception
     */
    public function getGroupById($groupId):Group
    {
        $selectedGroups = array_filter(
            $this->groups,
            function ($group) use ($groupId) {
                //echo $groupId." / " .$group->id.B;
                return $group->id == $groupId;
            });
        
        if (count($selectedGroups) > 0)
            $selectedGroup = $selectedGroups[array_keys($selectedGroups)[0]];

        else if (count($selectedGroups) == 0)
            throw new \Exception("Erreur : l'id n'existe pas");
        //$selectedGroup = null;

        return $selectedGroup;
    }
}
