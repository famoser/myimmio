<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Backend;

use App\Controller\Backend\Base\BaseBackendController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard")
 * @Security("has_role('ROLE_BACKEND_USER')")
 *
 * @return Response
 */
class DashboardController extends BaseBackendController
{
    /**
     * @Route("/", name="backend_dashboard_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        $arr["buildings"] = $this->getUser()->getBuildings();
        return $this->render('backend/dashboard/index.html.twig', $arr);
    }
}
