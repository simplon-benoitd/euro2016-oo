<?php

namespace euroViews;

use utils\HTMLUtils;

define("PATH_APP", $_SERVER['PHP_SELF']);

/**
 * Class IndexView : gestion de l'affichage de la page d'accueil
 */
class IndexMobileView extends AbstractIndexView
{
    public function render():string
    {
        $view = HTMLUtils::tag('h1', $this->compet->name);

        foreach ($this->compet->groups as $group) {
            $view .= HTMLUtils::ahref(PATH_APP . '?selectedGroupId=' . $group->id, HTMLUtils::tag('h2', $group->id));
            $view .= $this->renderTeams($group);
        }

        return $view;
    }
}