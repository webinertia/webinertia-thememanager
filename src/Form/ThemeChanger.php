<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Form;

use Laminas\Form\Element\Button;
use Limatus\Form\Element\Select;
use Limatus\Form\Element\Submit;
use Limatus\Form\Form;
use Limatus\Form\Fieldset;

final class ThemeChanger extends Form
{
    protected $attributes = [
        'class'  => 'row g-3 select-theme',
        'method' => 'POST',
    ];
    public function __construct(
        $name = 'theme-changer',
        $options = ['mode' => self::DEFAULT_MODE]
    ) {
        parent::__construct($name, $options);
    }

    public function init():  void
    {
        $options = $this->getOptions();
    }
}
