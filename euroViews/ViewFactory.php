<?php

namespace euroViews;

use euroModels\Competition;

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