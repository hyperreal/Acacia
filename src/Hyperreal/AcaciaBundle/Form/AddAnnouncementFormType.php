<?php

namespace Hyperreal\AcaciaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddAnnouncementFormType extends AbstractType
{
    private static $pickerOptions = array(
        'format' => 'yyyy-mm-dd',
        'weekStart' => 1,
        'minView' => 'month',
        'maxView' => 'month',
        'todayHighlight' => true,
        'language' => 'pl',
        'todayBtn' => true,
    );

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text');
        $builder->add('content', 'textarea');
        $builder->add('start_date', 'collot_datetime', array(
            'pickerOptions' => self::$pickerOptions
        ));
        $builder->add('end_date', 'collot_datetime', array(
            'pickerOptions' => self::$pickerOptions
        ));

        return $builder;
    }

    public function getName()
    {
        return 'acacia_user_add_announcement';
    }
}