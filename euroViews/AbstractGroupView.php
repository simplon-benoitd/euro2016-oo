<?php

namespace euroViews;

use euroModels\Competition;
use utils\HTMLUtils;

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

        try {
            $this->group = $compet->getGroupById($groupId);
        } catch (Exception $error) {
            echo 'Error !!!' . $error->getMessage();
        }
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
