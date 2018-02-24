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
use App\Entity\Apartment;
use App\Entity\ApplicationSlot;
use App\Entity\Building;
use App\Security\Voter\ApplicationSlotVoter;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/application_slot")
 * @Security("has_role('ROLE_BACKEND_USER')")
 *
 * @return Response
 */
class ApplicationSlotController extends BaseBackendController
{
    /**
     * @Route("/", name="backend_application_slot_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        $arr["application_slots"] = $this->getDoctrine()->getRepository(ApplicationSlot::class)->findAdministeredBy($this->getUser());;
        return $this->render('backend/application_slot/index.html.twig', $arr);
    }

    /**
     * @Route("/{apartment}/new", name="backend_application_slot_new")
     *
     * @param Request $request
     * @param Apartment $apartment
     * @return Response
     */
    public function newAction(Request $request, Apartment $apartment)
    {
        $applicationSlot = new ApplicationSlot();
        $applicationSlot->setApartment($apartment);
        $applicationSlot->setIdentifier(Uuid::uuid4());

        $form = $this->handleCreateForm(
            $request,
            $applicationSlot
        );
        $arr["form"] = $form->createView();
        return $this->render('backend/application_slot/new.html.twig', $arr);
    }

    /**
     * @Route("/{applicationSlot}/edit", name="backend_application_slot_edit")
     *
     * @param Request $request
     * @param ApplicationSlot $applicationSlot
     * @return Response
     */
    public function editAction(Request $request, ApplicationSlot $applicationSlot)
    {
        $this->denyAccessUnlessGranted(ApplicationSlotVoter::EDIT, $applicationSlot);

        $form = $this->handleUpdateForm(
            $request,
            $applicationSlot
        );
        $arr["form"] = $form->createView();
        return $this->render('backend/application_slot/edit.html.twig', $arr);
    }

    /**
     * @Route("/{applicationSlot}/remove", name="backend_application_slot_remove")
     *
     * @param Request $request
     * @param ApplicationSlot $applicationSlot
     * @return Response
     */
    public function removeAction(Request $request, ApplicationSlot $applicationSlot)
    {
        $this->denyAccessUnlessGranted(ApplicationSlotVoter::REMOVE, $applicationSlot);

        $form = $this->handleRemoveForm(
            $request,
            $applicationSlot,
            function () {
                return $this->generateUrl("backend_dashboard_index");
            }
        );
        $arr["form"] = $form->createView();
        return $this->render('backend/application_slot/remove.html.twig', $arr);
    }
}
