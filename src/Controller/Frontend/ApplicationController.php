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
use App\Entity\ApplicationPreview;
use App\Entity\ApplicationSlot;
use App\Form\Application\ApplicationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

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
     * @param $guid
     * @return ApplicationPreview|null
     */
    private function getPreview($guid)
    {
        $applicationSlot = $this->getApplicationSlot($guid);
        $applicationPreview = $this->getDoctrine()->getRepository(ApplicationPreview::class)
            ->findOneBy(['applicationSlot' => $applicationSlot->getId(), 'frontendUser' => $this->getUser()->getId()]);
        return $applicationPreview;
    }

    /**
     * @param $applicationSlot
     * @return Application
     */
    private function createNewApplication($applicationSlot){
        $application = new Application();
        $application->setApplicationSlot($applicationSlot);
        $application->setFrontendUser($this->getUser());
        return $application;
    }

    /**
     * @Route("/{applicationSlotGuid}/preview", name="frontend_application_preview")
     *
     * @param Request $request
     * @param TranslatorInterface $translator
     * @param string $applicationSlotGuid
     * @return Response
     */
    public function previewAction(Request $request, TranslatorInterface $translator, $applicationSlotGuid)
    {
        $preview = $this->getPreview($applicationSlotGuid);

        if ($preview != null) {
            return $this->render("frontend/application/preview_success.html.twig");
        }

        $applicationSlot = $this->getApplicationSlot($applicationSlotGuid);

        $preview = new ApplicationPreview();
        $preview->setApplicationSlot($applicationSlot);
        $preview->setFrontendUser($this->getUser());

        $form = $this->createFormBuilder($preview)
            ->add('form.send', SubmitType::class, array('label' => $translator->trans('preview.submit', [], 'frontend_application')))
            ->getForm();

        $form = $this->handleForm($form, $request,
            function () use ($preview, $translator, $applicationSlotGuid) {
                $this->fastSave($preview);
                $this->displaySuccess($translator->trans('preview.submit_success', [], 'frontend_application'));
                return $this->redirectToRoute('frontend_application_preview', ['applicationSlotGuid' => $applicationSlotGuid]);
            });

        //todo: user needs to login to use this functionality

        $arr = [];
        $arr['form'] = $form->createView();

        return $this->render("frontend/application/preview.html.twig", $arr);
    }


    /**
     * @Route("/{applicationSlotGuid}/closed", name="frontend_application_closed")
     *
     * @param $applicationSlotGuid
     * @return Response
     */
    public function closedAction($applicationSlotGuid)
    {
        return $this->render("frontend/application/closed.html.twig");
    }


    /**
     * @Route("/{applicationSlotGuid}/new", name="frontend_application_new")
     *
     * @param Request $request
     * @param TranslatorInterface $translator
     * @param $applicationSlotGuid
     * @return Response
     */
    public function newAction(Request $request, TranslatorInterface $translator, $applicationSlotGuid)
    {
        $applicationSlot = $this->getApplicationSlot($applicationSlotGuid);
        $application = $this->getDoctrine()->getRepository(Application::class)->findOneBy(["applicationSlot" => $applicationSlot->getId(), "frontendUser" => $this->getUser()->getId()]);

        $any = $this->getDoctrine()->getRepository(Application::class)->findBy(["frontendUser" => $this->getUser()->getId()]);
        if (count($any) === 0) {
            //no previous applications, trivially create new and redirect
            $application = $this->createNewApplication($applicationSlot);
            $this->fastSave($application);
        }

        if ($application != null) {
            return $this->redirectToRoute("frontend_application_apply", ["application" => $application->getId()]);
        }

        $choices = [];
        foreach ($any as $app) {
            $choices[$app->getApplicationSlot()->getDescription()] = $app->getId();
        }
        $choices[$translator->trans('new_application.start_new_application', [], 'frontend_application')] = -1;

        $form = $this->createFormBuilder()
            ->add('clone', ChoiceType::class, array(
                'choices' => $choices
            ))
            ->add('send', SubmitType::class, array(
                'label' => $translator->trans('new_application.start_application', [], 'frontend_application')
            ))
            ->getForm();

        $form = $this->handleForm($form, $request,
            function () use ($form, $applicationSlot) {
                $cloneId = $form->get('clone');
                if ($cloneId == -1){
                    $application = $this->createNewApplication($applicationSlot);
                    $this->fastSave($application);
                } else {
                    $oldApplication = $this->getDoctrine()->getRepository(Application::class)
                        ->findOneBy(['id' => $cloneId, 'frontendUser' => $this->getUser()->getId()]);
                    if ($oldApplication == null){
                        throw new AccessDeniedHttpException();
                    }
                    $application = $oldApplication->deepClone();
                    $this->fastSave($application);
                }
                return $this->redirectToRoute('frontend_application_apply', ['application' => $application]);
            });

        $arr = [];
        $arr['form'] = $form->createView();

        return $this->render("frontend/application/new.html.twig", $arr);
    }


    /**
     * @Route("/{application}/apply", name="frontend_application_apply")
     *
     * @param Request $request
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
