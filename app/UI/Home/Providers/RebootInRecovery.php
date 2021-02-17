<?php

namespace ModulesGarden\Servers\VpsServer\App\UI\Home\Providers;

use Exception;
use ModulesGarden\Servers\VpsServer\App\Helpers\ServiceManager;
use ModulesGarden\Servers\VpsServer\Core\UI\Interfaces\AdminArea;
use ModulesGarden\Servers\VpsServer\Core\UI\Interfaces\ClientArea;
use ModulesGarden\Servers\VpsServer\Core\UI\ResponseTemplates\HtmlDataJsonResponse;
use ModulesGarden\Servers\VpsServer\Core\UI\Widget\Forms\DataProviders\BaseDataProvider;

/**
 * Description of Rebuild
 *
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class RebootInRecovery extends BaseDataProvider implements ClientArea, AdminArea
{

    public function read()
    {
        
    }

    public function create()
    {
        
    }

    public function delete()
    {
        
    }

    public function update()
    {
        try
        {
            $vmHelper = new ServiceManager($this->whmcsParams);
            $vmHelper->shutdown();
            return (new HtmlDataJsonResponse())
                            ->setStatusSuccess()
                            ->setMessageAndTranslate('rebootInRecoveryStarted')
                            ->addData('refreshState', 'serverinformationTable')
                            ->setCallBackFunction('refreshTable');
        }
        catch (Exception $ex)
        {
            return (new HtmlDataJsonResponse())->setStatusError()->setMessage($ex->getMessage());
        }
    }

}
