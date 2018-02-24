<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Frontend\Base;

use App\Controller\Base\BaseFormController;
use App\Entity\FrontendUser;
use Symfony\Component\HttpFoundation\Response;

class BaseFrontendController extends BaseFormController
{
    protected function render(string $view, array $parameters = array(), Response $response = null): Response
    {
        $parameters['is_frontend_user_logged_in'] = $this->getUser() instanceof FrontendUser;
        return parent::render($view, $parameters, $response);
    }


    /**
     * @return FrontendUser
     */
    protected function getUser()
    {
        return parent::getUser();
    }

}
