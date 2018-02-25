<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Controller\Base\BaseFormController;
use App\Entity\ApplicationSlot;
use App\Entity\FrontendUser;
use App\Entity\ImportDirectory;
use App\Form\Model\ContactRequest\ContactRequestType;
use App\Model\ContactRequest;
use App\Service\EmailService;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/pool")
 *
 * @return Response
 */
class DirectoryController extends BaseFormController
{
    /**
     * @Route("/", name="directory_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        $buildings = $this->getDoctrine()->getRepository(ImportDirectory::class)->findAll();
        return $this->render('directory/index.html.twig', ["buildings" => $buildings, "category" => "all"]);
    }

    /**
     * @Route("/{filter}", name="directory_filter")
     *
     * @param $filter
     * @return Response
     */
    public function indexFilterAction($filter)
    {
        $buildings = $this->getDoctrine()->getRepository(ImportDirectory::class)->findBy(["category" => $filter]);
        return $this->render('directory/index.html.twig', ["buildings" => $buildings, "category" => $filter]);
    }
}
