<?php

namespace euroViews;

use utils\HTMLUtils;

define("PATH_APP", $_SERVER['PHP_SELF']);

/**
 * Class IndexView : gestion de l'affichage de la page d'accueil
 */
class IndexView extends AbstractIndexView
{

    public function render():string
    {
        $view = HTMLUtils::img('assets/euro.jpg'); // TODO permettre de choisir la taille de l'image
        $view .= HTMLUtils::tag('h1', $this->compet->name);

        foreach ($this->compet->groups as $group) {
            $view .= HTMLUtils::ahref(PATH_APP . '?selectedGroupId=' . $group->getId(), HTMLUtils::tag('h2', $group->getId()));
            $view .= $this->renderTeams($group);
        }

        return $view;
    }
}