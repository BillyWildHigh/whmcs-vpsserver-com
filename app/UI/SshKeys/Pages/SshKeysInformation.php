<?php

namespace ModulesGarden\Servers\VpsServer\App\UI\SshKeys\Pages;

use ModulesGarden\Servers\VpsServer\App\UI\SshKeys\Others\SshKeysDescription;
use ModulesGarden\Servers\VpsServer\Core\Helper\Lang;
use ModulesGarden\Servers\VpsServer\Core\UI\Builder\BaseContainer;
use ModulesGarden\Servers\VpsServer\Core\UI\Interfaces\AdminArea;
use ModulesGarden\Servers\VpsServer\Core\UI\Interfaces\ClientArea;

class SshKeysInformation extends BaseContainer implements ClientArea, AdminArea
{

    protected $id    = 'cronInformation';
    protected $name  = 'cronInformation';
    protected $title = 'cronInformation';

    public function initContent()
    {
        $this->setTitle(Lang::getInstance()->T('sshKeys'));
    }
}
