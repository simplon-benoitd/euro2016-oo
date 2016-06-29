<?php

namespace euroControllers;

use euroViews\ViewFactory;
use euroViews\View;
use euroModels\Competition;

/**
 * Class CompetitionController
 * charge les données d'une compétition et expose un accès aux différentes vues nécessaires pour l'affichage de la compétition et de ses matches
 */
class CompetitionController
{
    public $competition;

    public $viewFactory;

    /**
     * CompetitionController constructor.
     * @param $path
     * @param ViewFactory $viewFactory
     */
    function __construct($path, ViewFactory $viewFactory)
    {
        $data = file_get_contents($path);
        $this->competition = new Competition(json_decode($data));
        $this->viewFactory = $viewFactory;
    }

    /**
     * renvoi l'affichage de la page d'accueil ( liste des groupes )
     * @return string
     */
    public function renderIndexView():string
    {
        $view = $this->viewFactory->createIndexView($this->competition);
        return $view->render();
        //$view = new IndexView($this->competition);
        //return $this->render($view);
        //return $view->render();
    }

    /**
     * renvoie l'affichage des détails d'un groupe
     * @param string $groupId
     * @return string
     */
    public function renderGroupView(string $groupId):string
    {
        $view = $this->viewFactory->createGroupView($this->competition, $groupId);
        //$view = new GroupView($this->competition, $groupId);
        return $this->render($view);
        //return $view->render();
    }

    public function render(View $view):string
    {
        return $view->render();
    }
}