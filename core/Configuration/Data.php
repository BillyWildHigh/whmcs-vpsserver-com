<?php

namespace ModulesGarden\Servers\VpsServer\Core\Configuration;

use ModulesGarden\Servers\VpsServer\Core\FileReader\Reader;
use ModulesGarden\Servers\VpsServer\Core\ModuleConstants;

/**
 * Description of Data
 *
 * @author Rafał Ossowski <rafal.os@modulesgarden.com>
 */
class Data
{
    protected static $data = [];

    public function __construct()
    {
        $this->load();
    }

    public function __get($name)
    {
        $this->load();
        if (array_key_exists(lcfirst($name), self::$data))
        {
            return self::$data[lcfirst($name)];
        }
        return null;
    }

    public function getAll()
    {
        return self::$data;
    }

    private function load()
    {
        if (count(self::$data) == 0)
        {
            $this->loadConfig();
        }
    }

    private function loadConfig()
    {
        $dataDev  = $this->read(ModuleConstants::getDevConfigDir() . DS . 'configuration.yml');
        $dataCore = $this->read(ModuleConstants::getCoreConfigDir() . DS . 'configuration.yml');

        $data = $this->parseConfigData($dataDev, $dataCore);
        
        $this->loadPackageConfig($data);

        self::$data = $data ? : [];
    }

    private function loadPackageConfig(&$data)
    {
        if (file_exists(ModuleConstants::getModuleRootDir() . DS . 'moduleVersion.php'))
        {
            include ModuleConstants::getModuleRootDir() . DS . 'moduleVersion.php';
            if ($moduleVersion)
            {
                $data['version'] = $moduleVersion;
            }
        }

        if ($data['description'] && strpos($data['description'], ':WIKI_URL:'))
        {
            $data['description'] = str_replace(':WIKI_URL:', ($moduleWikiUrl ? : 'https://www.docs.modulesgarden.com/'), $data['description']);
        }
    }

    private function parseConfigData($dataDev, $dataCore)
    {
        if (!$dataDev && $dataCore)
        {
            return $dataCore;
        }

        if (!$dataDev && $dataCore)
        {
            return $dataCore;
        }

        foreach ($dataCore as $coreKey => $core)
        {
            $isFind = false;
            foreach ($dataDev as $devKey => $dev)
            {
                if ($devKey === $coreKey)
                {
                    $isFind = true;
                    break;
                }
            }
            if (!$isFind)
            {
                $dataDev[$coreKey] = $core;
            }
        }

        return $dataDev;
    }

    private function read($name)
    {
        return Reader::read($name)->get(); 
    }
}
