<?php

namespace euroViews;

use euroModels\Competition;
use euroModels\Group;
use utils\HTMLUtils;

abstract class AbstractIndexView implements View
{
    /**
     * @var Competition
     */
    protected $compet;

    /**
     * IndexView constructor : initialisation des données de la compétitions
     * @param Competition $compet
     */
    public function __construct(Competition $compet)
    {
        $this->compet = $compet;
    }

    /**
     * affichage de la liste des équipes
     * @param $group Group
     * @return string
     */
    protected function renderTeams($group):string
    {
        $view = '';
        foreach ($group->teams as $teamInfo) {
            $view .= HTMLUtils::tag('p', HTMLUtils::img($teamInfo->flag) . $teamInfo->nom);
        }
        return $view;
    }
}