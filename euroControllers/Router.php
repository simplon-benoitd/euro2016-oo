<?php

namespace euroControllers;

use euroViews\ViewFactory;

//define("PATH_DATA", "competition.json");
define("PATH_DATA", "competition.xml");


/**
 * charger de choisir la vue à renvoyer en fonction des infos passées dans $params
 * Class Router
 */
class Router
{
    /**
     * renvoie une vue en fonction des paramètres transmis, si aucun paramètre renvoie la page d'accueil
     * @param array $params tableau des paramètres de la requête ( au plus simple $_GET, $_POST )
     * @param bool $forMobile
     * @return string
     */
    public function get(array $params, bool $forMobile = false)
    {

        $controller = new CompetitionController(PATH_DATA, new ViewFactory($forMobile));

        if (isset($params["selectedGroupId"])) {
            $groupId = $params["selectedGroupId"];
            return $controller->renderGroupView($groupId);
        }

        return $controller->renderIndexView();
    }
}