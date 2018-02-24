<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Enum;

use App\Enum\Base\BaseEnum;
use Symfony\Component\Form\FormBuilderInterface;

class FieldDisplayType extends BaseEnum
{
    const HIDE = 1;
    const OPTIONAL = 2;
    const REQUIRED = 3;
}
