<?php

namespace App\WebPage\Types;

enum EnvType : string
{
    case LOCAL = 'local';
    case PROD = 'prod';
}
