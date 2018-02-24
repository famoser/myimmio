<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Backend\Base;

use App\Controller\Base\BaseFormController;
use App\Entity\BackendUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class BaseBackendController extends BaseFormController
{

    protected function render(string $view, array $parameters = array(), Response $response = null): Response
    {
        $parameters['is_backend_user_logged_in'] = $this->getUser() instanceof BackendUser;
        return parent::render($view, $parameters, $response);
    }

    /**
     * @return BackendUser
     */
    protected function getUser()
    {
        return parent::getUser();
    }

}
