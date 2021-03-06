<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Enum\Base;

use ReflectionClass;

abstract class BaseEnum
{
    /**
     * returns an array fit to be used by the ChoiceType.
     *
     * @return array
     */
    public static function getChoicesForBuilder()
    {
        $elem = new static();

        return $elem->getChoicesForBuilderInternal();
    }

    /**
     * makes from camelCase => camel_case.
     *
     * @param $camelCase
     *
     * @return string
     */
    private static function camelCaseToTranslation($camelCase)
    {
        return mb_strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $camelCase));
    }

    /**
     * generates an array to be used in form fields.
     *
     * @return array
     */
    protected function getChoicesForBuilderInternal()
    {
        try {
            $res = [];
            $reflection = new ReflectionClass(get_class($this));
            $choices = $reflection->getConstants();

            foreach ($choices as $name => $value) {
                $res[strtolower($name)] = $value;
            }
            return ['choices' => $res, 'choice_translation_domain' => "enum_" . $this->camelCaseToTranslation($reflection->getShortName())];
        } catch (\ReflectionException $e) {
        }

        return [];
    }

    /**
     * returns a translation string for the passed enum value.
     *
     * @param $enumValue
     *
     * @return bool|string
     */
    protected function getTranslationForValueInternal($enumValue)
    {
        try {
            $reflection = new ReflectionClass(get_class($this));
            $choices = $reflection->getConstants();

            foreach ($choices as $name => $value) {
                if ($value === $enumValue) {
                    return strtolower($name);
                }
            }
        } catch (\ReflectionException $e) {
        }

        return "";
    }

    /**
     * returns a translation string for the passed enum value.
     *
     * @param $enumValue
     *
     * @return string
     */
    public static function getTranslationForValue($enumValue)
    {
        $elem = new static();

        return $elem->getTranslationForValueInternal($enumValue);
    }
}
