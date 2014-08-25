<?php

namespace Mr\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MrUserBundle extends Bundle {
    public function getParent() {
        return 'FOSUserBundle';
    }
}
