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

use App\Controller\Base\BaseController;
use App\Controller\Base\BaseFormController;
use App\Entity\Building;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/building")
 * @Security("has_role('ROLE_BACKEND_USER')")
 *
 * @return Response
 */
class BuildingController extends BaseFormController
{
    /**
     * @Route("/new", name="backend_building_new")
     *
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $form = $this->handleCreateForm(
            $request,
            new Building()
        );
        $arr["form"] = $form->createView();
        return $this->render('backend/building/new.html.twig', $arr);
    }

    /**
     * @Route("/{building}/edit", name="backend_building_edit")
     *
     * @param Request $request
     * @param Building $building
     * @return Response
     */
    public function editAction(Request $request, Building $building)
    {
        $form = $this->handleUpdateForm(
            $request,
            $building
        );
        $arr["form"] = $form->createView();
        return $this->render('backend/building/edit.html.twig', $arr);
    }

    /**
     * @Route("/{building}/remove", name="backend_building_remove")
     *
     * @param Request $request
     * @param Building $building
     * @return Response
     */
    public function removeAction(Request $request, Building $building)
    {
        $form = $this->handleRemoveForm(
            $request,
            $building,
            function () {
                return $this->generateUrl("backend_dashboard_index");
            }
        );
        $arr["form"] = $form->createView();
        return $this->render('backend/building/remove.html.twig', $arr);
    }
}
