<?php

namespace Hyperreal\AcaciaBundle\Twig;

use Symfony\Component\Translation\TranslatorInterface;

class AcaciaExtension extends \Twig_Extension
{
    /** @var \Symfony\Component\Translation\TranslatorInterface */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getFilters()
    {
        return array(
            'babel' => new \Twig_Filter_Method($this, 'babelFilter')
        );
    }

    public function babelFilter($key, array $parameters = array(), $locale = null)
    {
        return $this->translator->trans($key, $parameters, 'HyperrealAcaciaBundle', $locale);
    }

    public function getName()
    {
        return 'acacia_extension';
    }
}
