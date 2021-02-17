<?php

namespace ModulesGarden\Servers\VpsServer\Core\UI\Widget\Buttons;

use \ModulesGarden\Servers\VpsServer\Core\UI\Builder\BaseContainer;
use \ModulesGarden\Servers\VpsServer\Core\UI\Interfaces\AjaxElementInterface;
use \ModulesGarden\Servers\VpsServer\Core\UI\Widget\Modals\ExampleModal;
use \ModulesGarden\Servers\VpsServer\Core\UI\ResponseTemplates;

/**
 * base button controller
 *
 * @author Sławomir Miśkowicz <slawomir@modulesgarden.com>
 */
class BaseModalButton extends BaseContainer implements AjaxElementInterface
{
    protected $id             = 'baseModalButton';
    protected $class          = ['lu-btn lu-btn-circle lu-btn-outline lu-btn-inverse lu-btn-success lu-btn-icon-only'];
    protected $icon           = 'fa fa-plus';
    protected $title          = 'baseModalButton';
    protected $htmlAttributes = [
        'href'        => 'javascript:;',
        'data-toggle' => 'lu-tooltip',
    ];
    protected $modal          = null;

    public function returnAjaxData()
    {
        return (new ResponseTemplates\HtmlDataJsonResponse($this->modal->getHtml()))->setCallBackFunction($this->callBackFunction);
    }

    public function initContent()
    {
        $this->initLoadModalAction(new ExampleModal());
    }

    public function setModal($modal)
    {
        $modal->setWhmcsParams($this->whmcsParams);
        $modal->setMainContainer($this->mainContainer);
        $this->modal = $modal;
        if ($modal instanceof \ModulesGarden\Servers\VpsServer\Core\UI\Interfaces\AjaxElementInterface)
        {
            $this->mainContainer->addAjaxElement($modal->initContent());
        }
    }

    protected function initLoadModalAction($modal)
    {
        $this->htmlAttributes['@click'] = 'loadModal($event, \'' . $this->id . '\', \'' . $this->getNamespace() . '\', \'' . $this->getIndex() . '\')';
        $this->setModal($modal);
    }

    public function switchToRemoveBtn()
    {
        $this->replaceClasses(['lu-btn lu-btn--danger lu-btn--link lu-btn--plain']);
        $this->setIcon('lu-btn--icon lu-zmdi lu-zmdi-delete');

        return $this;
    }
}
