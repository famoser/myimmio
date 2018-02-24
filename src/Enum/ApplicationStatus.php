<?php
/**
 * Created by PhpStorm.
 * User: Cedric
 * Date: 24/02/2018
 * Time: 21:39
 */

namespace App\Enum;


use App\Enum\Base\BaseEnum;

class ApplicationStatus extends BaseEnum
{
    const REJECTED = -1;
    const UNSET = 0;
    const CONFIRMED = 1;
}