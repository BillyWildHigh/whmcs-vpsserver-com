<?php

use WHMCS\View\Menu\Item as MenuItem;
use \ModulesGarden\Servers\VpsServer\Core\Http\Request;
use \ModulesGarden\Servers\VpsServer\Core\Http\View\MainMenu;
use ModulesGarden\Servers\VpsServer\App\Helpers\CustomFields;
use \ModulesGarden\Servers\VpsServer\Core\DependencyInjection;
use \ModulesGarden\Servers\VpsServer\Core\Helper\ClientAreaSidebar;

$hookManager->register(
        function (MenuItem $primarySidebar)
{
   $sidebarHaleper = new ClientAreaSidebar();
   if(!$sidebarHaleper->isProperProductType()){
        return;
   }
   if(isset($_REQUEST['id'])){
        $serverId = CustomFields::get($_REQUEST['id'], 'serverID');
        if(empty($serverId))
        {
            //return;
        }
   }
   $request = Request::build();

   if ($request->get('action', false) === 'cancel')
   {
       $overview = $primarySidebar->getChild('Service Details Overview');
       if (is_object($overview))
       {
           $information = $overview->getChild('Information');
           if (is_object($information))
           {
               $uri = $information->getUri();
               $pos = stripos($uri, '#');
               if ($pos > 0)
               {
                   $uri = substr($uri, 0, $pos);
                   $information->setUri($uri);
               }
           }
       }
   }

   if ($request->get('action', false) !== 'productdetails')
   {
       if($request->get('action', false) == 'cancel')
       {
           if(is_object($primarySidebar)){
               $action = $primarySidebar->getChild('Service Details Actions');
               if(is_object($action)) {
                   if (is_object($action->getChild('Change Password'))) {
                       $pageController = new \ModulesGarden\Servers\VpsServer\App\Helpers\PageController();
                       if (!$pageController->clientAreaResetPassword()) {
                           $primarySidebar->getChild('Service Details Actions')->removeChild('Change Password');
                       }
                   }
               }
           }
       }
       return;
   }


   $menuItems      = DependencyInjection::create(MainMenu::class)->getMenu();


   foreach ($menuItems as $name => $item)
   {
       if (is_null($primarySidebar->getChild($name)))
       {
           $sidebarHaleper->addSubmenuItem($primarySidebar, $name, $item);
       }

       if (!is_null($primarySidebar->getChild($name)) && count($item['children']) > 0)
       {
           if (count($item['children']) > 0)
           {
               try
               {
                   $pageController   = new \ModulesGarden\Servers\VpsServer\App\Helpers\PageController();
                   $pageController->getVM();
                   $item['children'] = $pageController->checkPages($item['children']);
               }
               catch (\Exception $ex)
               {
                   continue;
               }
           }
           $sidebarHaleper->addChildren($primarySidebar->getChild($name), $item['children']);
       }
   }
   if(is_object($primarySidebar)){
       $action = $primarySidebar->getChild('Service Details Actions');

       if(is_object($action)) {
           if (is_object($action->getChild('Change Password'))) {
               $pageController = new \ModulesGarden\Servers\VpsServer\App\Helpers\PageController();
               if (!$pageController->clientAreaResetPassword()) {
                   $primarySidebar->getChild('Service Details Actions')->removeChild('Change Password');
           }
       }
       }
   }
   if ($request->get('a', false) == 'management')
   {

       $action = $primarySidebar->getChild('Service Details Actions');
       if (!is_object($action))
       {
           return;
       }
       $changePassword = $action->getChild('Change Password');
       if (is_object($changePassword))
       {
               $currentLink = $changePassword->getUri();
               if (strpos($currentLink, '#') === 0) {
                   $link = 'clientarea.php?action=productdetails&id=' . (int)$_GET['id'] . $currentLink;
                   $changePassword->setUri('#" onclick = " window.location = \'clientarea.php?action=productdetails&id=' . $link . '\' " ');
               }
               if (strpos($currentLink, '#tabChangepw') > 0) {
                   $changePassword->setUri('#" onclick = " window.location = \'' . $currentLink . '\' " ');
               }

       }

       $overview = $primarySidebar->getChild('Service Details Overview');
       if (is_object($overview))
       {
           $info = $overview->getChild('Information');
           if (is_object($info))
           {
               $currentLink = $info->getUri();
               if (strpos($currentLink, '#') === 0)
               {
                   $link = 'clientarea.php?action=productdetails&id=' . (int) $_GET['id'];
                   $info->setUri('#" onclick = " window.location = \'clientarea.php?action=productdetails&id=' . $link . '\' " ');
               }
               if (strpos($currentLink, '#tabOverview') > 0)
               {
                   $info->setUri('#" onclick = " event.preventDefault(); window.location = \'' . str_replace('#tabOverview', '', $currentLink) . '\'"');
               }
           }
       }
   }
}, 943
);
