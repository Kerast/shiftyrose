<?php

namespace CT\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CTCoreBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
