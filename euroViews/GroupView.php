<?php

namespace euroViews;

use utils\HTMLUtils;

define("PATH_APP", $_SERVER['PHP_SELF']);

/**
 * Class GroupView : affichage de la page de détails d'un groupe ( liste  des matches )
 */
class GroupView extends AbstractGroupView
{
    public function render():string
    {
        if ($this->group == null) {
            $view = HTMLUtils::ahref(PATH_APP, "Retour à la liste");
            $view .= HTMLUtils::tag("p", "Ce groupe n'existe pas");
        } else {
            $view = HTMLUtils::img('assets/euro.jpg'); // TODO permettre de choisir la taille de l'image
            $view .= HTMLUtils::tag('h1', $this->compet->name);
            $view .= HTMLUtils::ahref(PATH_APP, "Retour à la liste");
            $view .= HTMLUtils::tag('h2', "Groupe " . $this->group->id);
            $view .= $this->renderMatches($this->group->teams);
        }

        return $view;
    }
}

