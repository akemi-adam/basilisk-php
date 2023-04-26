<?php

use AkemiAdam\Basilisk\Enums\Constant;

foreach (Constant::HELPERS as $helper)
    require __DIR__ . "/$helper.php";