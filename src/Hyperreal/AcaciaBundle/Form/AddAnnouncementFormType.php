<?php

namespace Hyperreal\AcaciaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddAnnouncementFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text');
        $builder->add('content', 'textarea');
        $builder->add('start_date', 'date');
        $builder->add('end_date', 'date');

        return $builder;
    }

    public function getName()
    {
        return 'hyperreal_acacia_user_add_announcement';
    }
}