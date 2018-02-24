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
use App\Entity\Applicant;
use App\Entity\Application;
use App\Entity\ApplicationLabel;
use App\Entity\ApplicationSlot;
use App\Entity\Building;
use App\Enum\ApplicationStatus;
use App\Repository\ApplicationLabelRepository;
use App\Security\Voter\ApplicationSlotVoter;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $arr["labels"] = $this->getDoctrine()->getRepository(ApplicationLabel::class)->findAll();
        $arr["applications"] = $applicationSlot->getApplications();
        $arr["apartment"] = $applicationSlot->getApartment();
        foreach($arr["applications"] as $application) {
            $application->score = rand(0,100);
            $applicant = $application->getApplicants()[0];
            if($applicant instanceof Applicant) {
                $application->name = $applicant->getFullName();
            } else {
                $application->name = '';
            }
            switch ($application->getStatus()) {
                case ApplicationStatus::CONFIRMED:
                    $application->accepted = true;
                    $application->rejected = false;
                    break;
                case ApplicationStatus::REJECTED:
                    $application->accepted = false;
                    $application->rejected = true;
                    break;
                default:
                    $application->accepted = false;
                    $application->rejected = false;
            }
        }
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

    /**
     * @Route("/{application}/toggleLabel/{label}")
     *
     * @param ObjectManager $manager
     * @param Application $application
     * @param ApplicationLabel $label
     * @return JsonResponse
     */
    public function toggleLabelAtApplicationAction(ObjectManager $manager, Application $application, ApplicationLabel $label)
    {
        if($application->getLabels()->contains($label)) {
            $application->getLabels()->removeElement($label);
        } else {
            $application->getLabels()->add($label);
        }
        $manager->persist($application);
        $manager->flush();
        return new JsonResponse([
            'success' => true
        ]);
    }
}
