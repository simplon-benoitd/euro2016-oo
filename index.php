<?php

define("PATH_DATA", "competition.json");
define("PATH_APP", $_SERVER['PHP_SELF']);


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

Interface View
{
    function render():string;
}

class ViewFactory
{

    public $forMobile;

    public function __construct(bool $mobile = false)
    {
        $this->forMobile = $mobile;
    }

    public function createIndexView(Competition $compet):View
    {
        return $this->forMobile ? new IndexMobileView($compet) : new IndexView($compet);
    }

    public function createGroupView(Competition $compet, string $groupId):View
    {
        return $this->forMobile ? new GroupMobileView($compet, $groupId) : new GroupView($compet, $groupId);
    }
}

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
            $view .= HTMLUtils::ahref(PATH_APP . '?selectedGroupId=' . $group->id, HTMLUtils::tag('h2', $group->id));
            $view .= $this->renderTeams($group);
        }

        return $view;
    }
}

abstract class AbstractGroupView implements View
{
    /**
     * @var Competition
     */
    protected $compet;
    protected $group;

    /**
     * GroupView constructor : initialisation des données
     * @param Competition $compet
     * @param string $groupId
     */
    public function __construct(Competition $compet, string $groupId)
    {
        $this->compet = $compet;

        $this->group = $compet->getGroupById($groupId);
    }

    /**
     * @param $teams
     * @return string
     * @internal param Group $group
     */
    protected function renderMatches($teams):string
    {
        $count = 0;
        $matches = array_map(function ($team) use ($teams, &$count) {
            $content = '';
            for ($i = $count; $i < 4; $i++) {
                $t = $teams[$i];
                if ($t != $team)
                    $content .= HTMLUtils::tag('p', HTMLUtils::img($team->flag) . $team->nom . '-' . $t->nom . HTMLUtils::img($t->flag));
            }
            $count++;
            return $content;
        }, $teams);

        return implode($matches);

    }
}

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


/**
 * Class GroupView : affichage de la page de détails d'un groupe ( liste  des matches )
 */
class GroupMobileView
{
    public function render():string
    {
        if ($this->group == null) {
            $view = HTMLUtils::ahref(PATH_APP, "Retour à la liste");
            $view .= HTMLUtils::tag("p", "Ce groupe n'existe pas");
        } else {
            $view = HTMLUtils::tag('h1', $this->compet->name);
            $view .= HTMLUtils::ahref(PATH_APP, "Retour à la liste");
            $view .= HTMLUtils::tag('h2', "Groupe " . $this->group->id);
            $view .= $this->renderMatches($this->group->teams);
        }

        return $view;
    }
}

/**
 * Class Competition : représentation des données d'une compétition : un nom et une liste de groupes
 */
class Competition
{
    public $name;

    public $groups;

    private $originalData;

    function __construct(stdClass $src)
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
     * @return Group
     */
    public function getGroupById($groupId)
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
            $selectedGroup = null;

        return $selectedGroup;
    }
}

/**
 * Class Group : structure de données décrivant un groupe : un id et une liste d'équipes
 */
class Group
{
    /**
     * @var string
     */
    public $id;
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
        $this->id = $src->id;
        // teams
        $this->teams = [];
        foreach ($src->teams as $team) {
            $this->teams[] = $team;
        }
    }
}

/**
 * Class Team : description d'une équipe , dans l'état seulement le nom
 */
class Team
{
    public $name;
}

/**
 * Class Utils : utilitaires HTML
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


$router = new Router();
$page = $router->get($_GET);

?>

<!doctype html>
<html lang="fr_FR">
<head>
    <meta charset="UTF-8">
    <title>UEFA</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php echo $page ?>
</body>
</html>
