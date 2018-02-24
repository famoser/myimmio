<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Backend\ApplicationSlot;

use App\Controller\Backend\Base\BaseBackendController;
use App\Entity\Apartment;
use App\Entity\Application;
use App\Entity\ApplicationSlot;
use App\Entity\Building;
use App\Security\Voter\ApplicationSlotVoter;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/application")
 * @Security("has_role('ROLE_BACKEND_USER')")
 *
 * @return Response
 */
class ApplicationController extends BaseBackendController
{
    /**
     * @Route("/", name="backend_application_slot_application_index")
     *
     * @param ApplicationSlot $applicationSlot
     * @return Response
     */
    public function indexAction(ApplicationSlot $applicationSlot)
    {
        $arr["applications"] = $applicationSlot->getApplications();;
        return $this->render('backend/application_slot/application/index.html.twig', $arr);
    }

    /**
     * @Route("/{application}/view", name="backend_application_slot_application_view")
     *
     * @param Application $application
     * @return Response
     */
    public function viewAction(Application $application)
    {
        return $this->render('backend/application_slot/application/view.html.twig', ["application" => $application]);
    }
}
