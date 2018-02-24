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
use App\Entity\Applicant;
use App\Entity\ApplicantJob;
use App\Entity\ApplicantLandlord;
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
    private const STATE_PREVIEW = "preview";
    private const STATE_CLOSED = "closed";
    private const STATE_APPLY = "apply";

    /**
     * @Route("/{applicationSlotGuid}", name="frontend_application_view")
     *
     * @param string $applicationSlotGuid
     * @return Response
     */
    public function indexAction($applicationSlotGuid)
    {
        return $this->redirectToState($this->getState($applicationSlotGuid), $applicationSlotGuid);
    }

    /**
     * @param $applicationSlotGuid
     * @return string
     */
    private function getState($applicationSlotGuid)
    {
        $applicationSlot = $this->getApplicationSlot($applicationSlotGuid);
        $now = new \DateTime();
        if ($applicationSlot->getStartAt() > $now) {
            return static::STATE_PREVIEW;
            //not started yet
        } else if ($applicationSlot->getEndAt() < $now) {
            return static::STATE_CLOSED;
        } else {
            return static::STATE_APPLY;
        }
    }

    /**
     * @param $state
     * @param $applicationSlotGuid
     * @return Response
     */
    private function redirectToState($state, $applicationSlotGuid)
    {
        switch ($state) {
            case static::STATE_PREVIEW:
                return $this->redirectToRoute("frontend_application_preview", ["applicationSlotGuid" => $applicationSlotGuid]);
            case static::STATE_CLOSED:
                return $this->redirectToRoute("frontend_application_apply", ["applicationSlotGuid" => $applicationSlotGuid]);
            case static::STATE_APPLY:
            default:
                return $this->redirectToRoute("frontend_application_apply", ["applicationSlotGuid" => $applicationSlotGuid]);
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
     * @Route("/{applicationSlotGuid}/closed", name="frontend_application_closed")
     *
     * @param $applicationSlotGuid
     * @return Response
     */
    public function closedAction($applicationSlotGuid)
    {
        $state = $this->getState($applicationSlotGuid);
        if ($state !== static::STATE_CLOSED) {
            return $this->redirectToState($state, $applicationSlotGuid);
        }
        return $this->render("frontend/application/closed.html.twig");
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
        $state = $this->getState($applicationSlotGuid);
        if ($state !== static::STATE_PREVIEW) {
            return $this->redirectToState($state, $applicationSlotGuid);
        }

        $applicationSlot = $this->getApplicationSlot($applicationSlotGuid);
        $preview = $this->getDoctrine()->getRepository(ApplicationPreview::class)
            ->findOneBy(['applicationSlot' => $applicationSlot->getId(), 'frontendUser' => $this->getUser()->getId()]);
        if ($preview != null) {
            return $this->redirectToRoute("frontend_application_remembered", ["applicationSlotGuid" => $applicationSlotGuid]);
        }

        $form = $this->createFormBuilder($preview)
            ->add(
                'form.send',
                SubmitType::class,
                ['label' => $translator->trans('preview.please_remember_action', [], 'frontend_application')]
            )
            ->getForm();

        $form = $this->handleForm(
            $form,
            $request,
            function () use ($applicationSlot) {
                $preview = new ApplicationPreview();
                $preview->setApplicationSlot($applicationSlot);
                $preview->setFrontendUser($this->getUser());
                $this->fastSave($preview);

                return $this->redirectToRoute('frontend_application_remembered', ['applicationSlotGuid' => $applicationSlot->getIdentifier()]);
            });

        if ($form instanceof Response) {
            return $form;
        }

        $arr['form'] = $form->createView();
        return $this->render("frontend/application/preview.html.twig", $arr);
    }

    /**
     * @Route("/{applicationSlotGuid}/remembered", name="frontend_application_remembered")
     *
     * @param Request $request
     * @param TranslatorInterface $translator
     * @param string $applicationSlotGuid
     * @return Response
     */
    public function rememberedAction(Request $request, TranslatorInterface $translator, $applicationSlotGuid)
    {
        $state = $this->getState($applicationSlotGuid);
        if ($state !== static::STATE_PREVIEW) {
            return $this->redirectToState($state, $applicationSlotGuid);
        }

        $applicationSlot = $this->getApplicationSlot($applicationSlotGuid);
        $preview = $this->getDoctrine()->getRepository(ApplicationPreview::class)
            ->findOneBy(['applicationSlot' => $applicationSlot->getId(), 'frontendUser' => $this->getUser()->getId()]);
        if ($preview == null) {
            return $this->redirectToRoute("frontend_application_preview", ["applicationSlotGuid" => $applicationSlotGuid]);
        }

        $form = $this->createFormBuilder($preview)
            ->add(
                'form.send',
                SubmitType::class,
                ['label' => $translator->trans('remembered.please_stop_remember_action', [], 'frontend_application')]
            )
            ->getForm();

        $form = $this->handleForm(
            $form,
            $request,
            function () use ($preview, $applicationSlotGuid) {
                $this->fastRemove($preview);
                return $this->redirectToRoute('frontend_application_preview', ['applicationSlotGuid' => $applicationSlotGuid]);
            });

        if ($form instanceof Response) {
            return $form;
        }

        $arr['form'] = $form->createView();
        return $this->render("frontend/application/remembered.html.twig", $arr);
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
            //no previous applications, so we need to create new anyways; skipping this step
            return $this->redirectToRoute("frontend_application_apply", ["applicationSlotGuid" => $applicationSlotGuid]);
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
                $cloneId = $form->getData()['clone'];
                if ($cloneId == -1) {
                    $application = $this->createNewApplication($applicationSlot);
                    $this->fastSave($application);
                } else {
                    $oldApplication = $this->getDoctrine()->getRepository(Application::class)
                        ->findOneBy(['id' => $cloneId, 'frontendUser' => $this->getUser()->getId()]);
                    if ($oldApplication == null) {
                        throw new AccessDeniedHttpException();
                    }
                    $application = $oldApplication->deepClone();
                    $this->fastSave($application);
                }
                return $this->redirectToRoute('frontend_application_apply', ['application' => $application]);
            });

        if ($form instanceof Response) {
            return $form;
        }

        $arr = [];
        $arr['form'] = $form->createView();
        $arr['welcome_header'] = $applicationSlot->getWelcomeHeader();
        $arr['welcome_text'] = $applicationSlot->getWelcomeText();

        return $this->render("frontend/application/new.html.twig", $arr);
    }


    /**
     * @Route("/{applicationSlotGuid}/apply", name="frontend_application_apply")
     *
     * @param Request $request
     * @param TranslatorInterface $translator
     * @param $applicationSlotGuid
     * @return Response
     */
    public function applyAction(Request $request, TranslatorInterface $translator, $applicationSlotGuid)
    {

        $application = $this->getDoctrine()->getRepository(Application::class)->findOneBy(["applicationSlot" => $applicationSlotGuid, "frontendUser" => $this->getUser()->getId()]);
        //todo: show form for applicants
        //todo: see https://symfony.com/doc/current/reference/forms/types/collection.html to implement client side functionality
        $form = $this->handleForm(
            $this->createForm(ApplicationType::class, $application)
                ->add("submit", SubmitType::class, array('label' => $translator->trans('new_application.submit', [], 'frontend_application'))),
            $request,
            function () use ($application) {
                $this->fastSave($application);
            }
        );
        $arr["form"] = $form->createView();
        $arr['welcome_header'] = $application->getApplicationSlot()->getWelcomeHeader();
        $arr['welcome_text'] = $application->getApplicationSlot()->getWelcomeText();
        return $this->render("frontend/application/index.html.twig", $arr);
    }
}
