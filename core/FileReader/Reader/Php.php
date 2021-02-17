<?php

namespace ModulesGarden\Servers\VpsServer\Core\FileReader\Reader;

use ModulesGarden\Servers\VpsServer\Core\ServiceLocator;

/**
 * Description of Json
 *
 * @author Rafał Ossowski <rafal.os@modulesgarden.com>
 */
class Php extends AbstractType
{

    protected function loadFile()
    {
        $return = '';
        try
        {
            if (file_exists($this->path . DS . $this->file))
            {
                $return = file_get_contents($this->path . DS . $this->file);
            }
        }
        catch (\Exception $e)
        {
            ServiceLocator::call('errorManager')->addError(self::class, $e->getMessage(), $e->getTrace());
        }

        $this->data = $return;
    }
}
