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
use App\Entity\Building;
use App\Security\Voter\ApartmentVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/apartment")
 * @Security("has_role('ROLE_BACKEND_USER')")
 *
 * @return Response
 */
class ApartmentController extends BaseBackendController
{
    /**
     * @Route("/", name="backend_apartment_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        $arr["apartments"] = $this->getDoctrine()->getRepository(Apartment::class)->findAdministeredBy($this->getUser());;
        return $this->render('backend/apartment/index.html.twig', $arr);
    }

    /**
     * @Route("/{building}/new", name="backend_apartment_new")
     *
     * @param Request $request
     * @param Building $building
     * @return Response
     */
    public function newAction(Request $request, Building $building)
    {
        $apartment = new Apartment();
        $apartment->setBuilding($building);

        $form = $this->handleCreateForm(
            $request,
            $apartment
        );
        $arr["form"] = $form->createView();
        return $this->render('backend/apartment/new.html.twig', $arr);
    }

    /**
     * @Route("/{apartment}/edit", name="backend_apartment_edit")
     *
     * @param Request $request
     * @param Apartment $apartment
     * @return Response
     */
    public function editAction(Request $request, Apartment $apartment)
    {
        $this->denyAccessUnlessGranted(ApartmentVoter::EDIT, $apartment);

        $form = $this->handleUpdateForm(
            $request,
            $apartment
        );
        $arr["form"] = $form->createView();
        return $this->render('backend/apartment/edit.html.twig', $arr);
    }

    /**
     * @Route("/{apartment}/remove", name="backend_apartment_remove")
     *
     * @param Request $request
     * @param Apartment $apartment
     * @return Response
     */
    public function removeAction(Request $request, Apartment $apartment)
    {
        $this->denyAccessUnlessGranted(ApartmentVoter::REMOVE, $apartment);

        $form = $this->handleRemoveForm(
            $request,
            $apartment,
            function () {
                return $this->generateUrl("backend_dashboard_index");
            }
        );
        $arr["form"] = $form->createView();
        return $this->render('backend/apartment/remove.html.twig', $arr);
    }
}
