<?php

namespace Hyperreal\AcaciaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddAnnouncementFormType extends AbstractType
{
    /**
     * Locale used when there is no $locale file where $locale could be %locale% or %kernel.default_locale%
     * i.e. in case of misconfiguration
     */
    const DEFAULT_LOCALE = 'en';

    private static $pickerOptions = array(
        'format' => 'yyyy-mm-dd',
        'autoclose' => true,
        'weekStart' => 1,
        'minView' => 'month',
        'maxView' => 'month',
        'todayHighlight' => true,
        'todayBtn' => true,
    );

    public function __construct($locale)
    {
        if (isset(self::$pickerOptions['language'])) {
            return;
        }

        $localeFile = $this->extractDatetimePickerBundlePrefix() . $locale . '.js';
        if (file_exists($localeFile)) {
            self::$pickerOptions['language'] = $locale;
        } else {
            self::$pickerOptions['language'] = self::DEFAULT_LOCALE;
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array(
            'label' => 'forms.announcement-management.new.title',
            'translation_domain' => 'HyperrealAcaciaBundle',
        ));
        $builder->add('start_date', 'collot_datetime', array(
            'label' => 'forms.announcement-management.new.start-date',
            'translation_domain' => 'HyperrealAcaciaBundle',
            'pickerOptions' => self::$pickerOptions
        ));
        $builder->add('end_date', 'collot_datetime', array(
            'label' => 'forms.announcement-management.new.end-date',
            'translation_domain' => 'HyperrealAcaciaBundle',
            'pickerOptions' => self::$pickerOptions
        ));
        $builder->add('content', 'textarea', array(
            'label' => 'forms.announcement-management.new.content',
            'translation_domain' => 'HyperrealAcaciaBundle',
        ));

        return $builder;
    }

    public function getName()
    {
        return 'acacia_user_add_announcement';
    }

    private function extractDatetimePickerBundlePrefix()
    {
        $dateTimePickerBundleClass = new \ReflectionClass('SC\DatetimepickerBundle\SCDatetimepickerBundle');
        $bundleDirPrefix = pathinfo($dateTimePickerBundleClass->getFileName(), PATHINFO_DIRNAME)
            . '/Resources/public/js/locales/bootstrap-datetimepicker.';
        return $bundleDirPrefix;
    }
}