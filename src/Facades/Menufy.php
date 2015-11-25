<?php

namespace Phpuzem\Menufy\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Description of MenufyFacade
 *
 * @author phpuzem
 */
class Menufy extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'menufy';
    }
}
