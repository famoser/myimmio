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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/profile")
 * @Security("has_role('ROLE_USER')")
 */
class ProfileController extends BaseFrontendController
{
    /**
     * @Route("/", name="frontend_profile_index")
     *
     * @param Request $request
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, TranslatorInterface $translator)
    {
        $user = $this->getUser();
        $user->setAgbAccepted(true);
        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class)
            ->add('plainPassword', PasswordType::class, array('required' => false))
            ->add('repeatPlainPassword', PasswordType::class, array('required' => false))
            ->add('submit', SubmitType::class, array('label' => $translator->trans('profile.submit', [], 'frontend_profile')))->getForm();
        $form = $this->handleForm(
            $form,
            $request,
            function () use ($form, $user, $translator) {
                //check for matching passwords
                if ($user->getPlainPassword() !== $user->getRepeatPlainPassword()) {
                    $this->displayError($translator->trans("index.error.passwords_do_not_match", [], "frontend_register"));
                    return $form;
                }
                $user->setPassword();
                $user->setResetHash();
                $this->fastSave($user);
                return $this->redirectToRoute('frontend_profile_index');
            }
        );

        if ($form instanceof Response) {
            return $form;
        }

        $arr = array(
            'user' => $user,
            'changeForm' => $form->createView()
        );
        return $this->render('frontend/profile/index.html.twig', $arr);
    }
}
