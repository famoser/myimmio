<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Frontend;

use App\Controller\Base\BaseController;
use App\Controller\Frontend\Base\BaseFrontendController;
use App\Entity\Application;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard")
 * @Security("has_role('ROLE_FRONTEND_USER')")
 *
 * @return Response
 */
class DashboardController extends BaseFrontendController
{
    /**
     * @Route("/", name="frontend_dashboard_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        $arr["applications"] = $this->getDoctrine()->getRepository(Application::class)->findBy(['frontendUser' => $this->getUser()->getId()]);
        return $this->render('frontend/dashboard/index.html.twig', $arr);
    }
}
