<?php

namespace ModulesGarden\Servers\VpsServer\App\UI\Firewalls\Others;

use ModulesGarden\Servers\VpsServer\Core\UI\Interfaces\AdminArea;
use ModulesGarden\Servers\VpsServer\Core\UI\Widget\Others\ModuleDescription;

class FirewallsDescription extends ModuleDescription implements AdminArea
{

    protected $name          = 'cronTaskDescription';
    protected $id            = 'cronTaskDescription';
    protected $title         = 'cronTaskDescription';

    public function initContent()
    {
        $this->setDescription('desc');
    }

    public static function getClass() {
        return FirewallsDescription::class;
    }

}
