<?php
/**
 * Created by PhpStorm.
 * User: famoser
 * Date: 22/02/2018
 * Time: 11:35
 */

namespace App\Controller\Frontend;

use App\Controller\Base\BaseLoginController;
use App\Entity\FrontendUser;
use App\Form\Traits\User\LoginType;
use App\Form\Traits\User\RecoverType;
use App\Form\Traits\User\SetPasswordType;
use App\Service\Interfaces\EmailServiceInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/login")
 */
class LoginController extends BaseLoginController
{
    /**
     * @Route("/", name="frontend_login_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        $form = $this->createForm(LoginType::class);
        $form->add("form.login", SubmitType::class);
        $arr["form"] = $form->createView();
        return $this->render('frontend/login/index.html.twig', $arr);
    }

    /**
     * @Route("/recover", name="frontend_login_recover")
     *
     * @param Request $request
     * @param EmailServiceInterface $emailService
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function recoverAction(Request $request, EmailServiceInterface $emailService, TranslatorInterface $translator)
    {
        $form = $this->handleForm(
            $this->createForm(RecoverType::class)
                ->add("form.recover", SubmitType::class),
            $request,
            function ($form) use ($emailService, $translator) {
                /* @var FormInterface $form */

                //display success
                $this->displaySuccess($translator->trans("recover.success.email_sent", [], "frontend_login"));

                //check if user exists
                $exitingUser = $this->getDoctrine()->getRepository(FrontendUser::class)->findOneBy(["email" => $form->getData()["email"]]);
                if (null === $exitingUser) {
                    return $form;
                }

                //create new reset hash
                $exitingUser->setResetHash();
                $this->fastSave($exitingUser);

                //sent according email
                $emailService->sendActionEmail(
                    $exitingUser->getEmail(),
                    $translator->trans("recover.email.reset_password.subject", [], "frontend_login"),
                    $translator->trans("recover.email.reset_password.message", [], "frontend_login"),
                    $translator->trans("recover.email.reset_password.action_text", [], "frontend_login"),
                    $this->generateUrl("frontend_login_reset", ["resetHash" => $exitingUser->getResetHash()], UrlGeneratorInterface::ABSOLUTE_URL)
                );

                return $form;
            }
        );
        $arr["form"] = $form->createView();
        return $this->render('frontend/login/recover.html.twig', $arr);
    }

    /**
     * @Route("/reset/{resetHash}", name="frontend_login_reset")
     *
     * @param Request $request
     * @param $resetHash
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function resetAction(Request $request, $resetHash, TranslatorInterface $translator)
    {
        $user = $this->getDoctrine()->getRepository(FrontendUser::class)->findOneBy(["resetHash" => $resetHash]);
        if (null === $user) {
            $this->displayError($translator->trans("reset.error.invalid_hash", [], "frontend_login"));
            return $this->redirectToRoute("frontend_login_invalid", ["resetHash" => $resetHash]);
        }

        $form = $this->handleForm(
            $this->createForm(SetPasswordType::class, $user, ["data_class" => FrontendUser::class])
                ->add("form.set_password", SubmitType::class),
            $request,
            function ($form) use ($user, $translator, $request) {
                //check for valid password
                if ($user->getPlainPassword() != $user->getRepeatPlainPassword()) {
                    $this->displayError($translator->trans("reset.error.passwords_do_not_match", [], "frontend_login"));
                    return $form;
                }

                //display success
                $this->displaySuccess($translator->trans("reset.success.password_set", [], "frontend_login"));

                //set new password & save
                $user->setPassword();
                $user->setResetHash();
                $this->fastSave($user);

                //login user & redirect
                $this->loginUser($request, $user);
                return $this->redirectToRoute("frontend_dashboard_index");
            }
        );

        if ($form instanceof Response) {
            return $form;
        }

        $arr["form"] = $form->createView();
        return $this->render('frontend/login/reset.html.twig', $arr);
    }

    /**
     * @Route("/invalid/{resetHash}", name="frontend_login_invalid")
     *
     * @return Response
     */
    public function invalidAction()
    {
        return $this->render('frontend/login/invalid.html.twig');
    }

    /**
     * @Route("/login_check", name="frontend_login_check")
     */
    public function loginCheck()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    /**
     * @Route("/logout", name="frontend_login_logout")
     */
    public function logoutAction()
    {
        throw new \RuntimeException('You must configure the logout path to be handled by the firewall using form_login.logout in your security firewall configuration.');
    }
}