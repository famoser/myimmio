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

use App\Controller\Frontend\Base\BaseFrontendController;
use App\Entity\Application;
use App\Entity\ApplicationSlot;
use App\Form\Application\ApplicationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/application")
 * @Security("has_role('ROLE_USER')")
 */
class ApplicationController extends BaseFrontendController
{
    /**
     * @Route("/{applicationSlotGuid}", name="frontend_application_view")
     *
     * @param string $applicationSlotGuid
     * @return Response
     */
    public function indexAction($applicationSlotGuid)
    {
        $applicationSlot = $this->getApplicationSlot($applicationSlotGuid);
        $application = $this->getDoctrine()->getRepository(Application::class)->findOneBy(["applicationSlot" => $applicationSlot->getId()]);

        $now = new \DateTime();
        if ($applicationSlot->getStartAt() > $now) {
            //not started yet
            return $this->redirectToRoute("frontend_application_preview", ["applicationSlotGuid" => $applicationSlotGuid]);
        } else if ($applicationSlot->getEndAt() < $now) {
            return $this->redirectToRoute("frontend_application_closed", ["applicationSlotGuid" => $applicationSlotGuid]);
        } else if ($application != null) {
            return $this->redirectToRoute("frontend_application_apply", ["application" => $application->getId()]);
        } else {
            return $this->redirectToRoute("frontend_application_new", ["applicationSlotGuid" => $applicationSlotGuid]);
        }
    }

    /**
     * @param $guid
     * @return ApplicationSlot|null|object
     */
    private function getApplicationSlot($guid)
    {
        $applicationSlot = $this->getDoctrine()->getRepository(ApplicationSlot::class)->findOneBy(["identifier" => $guid]);
        if ($applicationSlot == null) {
            throw new NotFoundHttpException();
        }
        return $applicationSlot;
    }

    /**
     * @Route("/{applicationSlotGuid}/preview", name="frontend_application_preview")
     *
     * @param Request $request
     * @param string $applicationSlotGuid
     * @return Response
     */
    public function previewAction(Request $request, $applicationSlotGuid)
    {
        //todo: show text with button
        //user needs to login to use this functionality
        return $this->render("frontend/application/index.html.twig");
    }


    /**
     * @Route("/{applicationSlotGuid}/closed", name="frontend_application_closed")
     *
     * @return Response
     */
    public function closedAction($applicationSlotGuid)
    {
        //todo: show sorry message
        return null;
    }


    /**
     * @Route("/{applicationSlotGuid}/new", name="frontend_application_new")
     *
     * @param $applicationSlotGuid
     * @return Response
     */
    public function newAction($applicationSlotGuid)
    {
        $applicationSlot = $this->getApplicationSlot($applicationSlotGuid);
        $application = $this->getDoctrine()->getRepository(Application::class)->findOneBy(["applicationSlot" => $applicationSlot->getId(), "frontendUser" => $this->getUser()->getId()]);

        $any = $this->getDoctrine()->getRepository(Application::class)->findBy(["frontendUser" => $this->getUser()->getId()]);
        if (count($any) === 0) {
            //no previous applications, trivially create new and redirect
            $application = new Application();
            $application->setApplicationSlot($applicationSlot);
            $application->setFrontendUser($this->getUser());

            $this->fastSave($application);
        }

        if ($application != null) {
            return $this->redirectToRoute("frontend_application_apply", ["application" => $application->getId()]);
        }

        //todo: show form to select previous applications, clone selected application and redirect to apply
        return $this->render("frontend/application/index.html.twig");
    }


    /**
     * @Route("/{application}/apply", name="frontend_application_apply")
     *
     * @param Application $application
     * @return Response
     */
    public function applyAction(Request $request, Application $application)
    {
        //todo: show form for applicants
        //todo: see https://symfony.com/doc/current/reference/forms/types/collection.html to implement client side functionality
        $form = $this->handleForm(
            $this->createForm(ApplicationType::class, $application)
                ->add("submit", SubmitType::class),
            $request,
            function () use ($application) {
                $this->fastSave($application);
            }
        );
        $arr["form"] = $form->createView();
        return $this->render("frontend/application/index.html.twig", $arr);
    }
}
