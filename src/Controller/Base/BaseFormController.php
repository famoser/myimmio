<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Base;

use App\Entity\Base\BaseEntity;
use App\Form\Fallback\RemoveThing;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

class BaseFormController extends BaseDoctrineController
{
    /**
     * inject the translator service
     *
     * @return array
     */
    public static function getSubscribedServices()
    {
        return parent::getSubscribedServices() + ['translator' => TranslatorInterface::class];
    }

    /**
     * @return TranslatorInterface
     */
    private function getTranslator()
    {
        return $this->get("translator");
    }

    /**
     * @param FormInterface $form
     * @param Request $request
     * @param callable $onValidCallable with $form ass an argument
     *
     * @return FormInterface
     */
    protected function handleForm(FormInterface $form, Request $request, $onValidCallable)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                return $onValidCallable($form);
            }

            $this->displayError(
                $this->getTranslator()->trans('error.form_validation_failed', [], 'common_form')
            );
        }

        return $form;
    }

    /**
     * creates a "create" form
     *
     * @param Request $request
     * @param BaseEntity $defaultEntity
     * @param string|null $successLink
     * @return FormInterface
     */
    protected function handleCreateForm(Request $request, BaseEntity $defaultEntity, string $successLink = null)
    {
        $translator = $this->getTranslator();

        //create form utils
        $formType = $this->classToFormType(get_class($defaultEntity));
        $createMyForm = function ($entity) use ($formType, $translator) {
            return $this->createForm($formType, $entity)
                ->add("submit", SubmitType::class,
                    [
                        "label" => $translator->trans("submit.create", [], "common_form"),
                        "translation_domain" => false
                    ]
                );
        };

        //clone entity so we can generate a new empty form
        $clonedEntity = clone($defaultEntity);
        $myOnSuccessCallable = function () use ($defaultEntity, $clonedEntity, $createMyForm, $translator, $successLink) {
            $this->fastSave($defaultEntity);
            $this->displaySuccess($translator->trans('successful.create', [], 'common_form'), $successLink);
            return $createMyForm($clonedEntity);
        };

        return $this->handleForm(
            $createMyForm($defaultEntity),
            $request,
            $myOnSuccessCallable
        );
    }

    /**
     * creates a "update" form
     *
     * @param Request $request
     * @param BaseEntity $entity
     * @return FormInterface
     */
    protected function handleUpdateForm(Request $request, BaseEntity $entity)
    {
        $translator = $this->getTranslator();
        $formType = $this->classToFormType(get_class($entity));

        $myOnSuccessCallable = function ($form) use ($entity, $translator) {
            $this->fastSave($entity);
            $this->displaySuccess($translator->trans('successful.update', [], 'common_form'));
            return $form;
        };

        return $this->handleForm(
            $this->createForm($formType, $entity)
                ->add("submit", SubmitType::class,
                    [
                        "label" => $translator->trans("submit.update", [], "common_form"),
                        "translation_domain" => false
                    ]
                ),
            $request,
            $myOnSuccessCallable
        );
    }

    /**
     * creates a "create" form
     *
     * @param Request $request
     * @param BaseEntity $entity
     * @param callable $afterRemoveCallable called after successful remove
     * @param callable $beforeRemoveCallable called after successful submit, before entity is removed. return true to continue removal
     * @return FormInterface
     */
    protected function handleRemoveForm(Request $request, BaseEntity $entity, $afterRemoveCallable, $beforeRemoveCallable = null)
    {
        $translator = $this->getTranslator();

        $myOnSuccessCallable = function ($form) use ($entity, $translator, $afterRemoveCallable, $beforeRemoveCallable) {
            $manager = $this->getDoctrine()->getManager();

            if (is_callable($beforeRemoveCallable)) {
                if (!$beforeRemoveCallable($entity, $manager)) {
                    $this->displayError($translator->trans('error.delete_failed', [], 'common_form'));
                    return $form;
                }
            }

            $manager->remove($entity);
            $manager->flush();

            $this->displaySuccess($translator->trans('successful.delete', [], 'common_form'));
            return $afterRemoveCallable();
        };

        $formType = $this->classToFormType(get_class($entity), "Delete");
        if (!class_exists($formType)) {
            $formType = RemoveThing::class;
        }

        $myForm = $this->handleForm(
            $this->createForm($formType, $entity)
                ->add(
                    "submit",
                    SubmitType::class,
                    [
                        "label" => $translator->trans("submit.delete", [], "common_form"),
                        "translation_domain" => false
                    ]
                ),
            $request,
            $myOnSuccessCallable
        );
        return $myForm;
    }

    /**
     * produces App\Form\MyClassName\MyClassNameType from Famoser\Class\MyClassName
     * if $isRemoveType is true then the remove form is returned.
     *
     * @param string $classWithNamespace
     *
     * @param string $prepend is prepended to class name
     * @return string
     */
    private function classToFormType($classWithNamespace, $prepend = '')
    {
        $className = mb_substr($classWithNamespace, mb_strrpos($classWithNamespace, '\\') + 1);

        return 'App\\Form\\' . $className . '\\' . $prepend . $className . 'Type';
    }
}
