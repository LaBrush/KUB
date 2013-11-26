<?php

namespace Kub\UserBundle\Form\Type;

use FOS\UserBundle\Form\DataTransformer\UserToUsernameTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\UsernameFormType as BaseType;

/**
 * Form type for representing a UserInterface instance by its username string.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class UsernameFormType extends BaseType
{
    /**
     * @see Symfony\Component\Form\AbstractType::getParent()
     */
    public function getParent()
    {
        throw new \Exception("Error Processing Request", 1);
        
        return 'genemu_jqueryselect2_choice';
    }

    /**
     * @see Symfony\Component\Form\FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'fos_user_username';
    }
}