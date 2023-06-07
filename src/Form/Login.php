<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Form;

use Laminas\Filter;
use Laminas\InputFilter\InputFilterProviderInterface;
use Limatus\Form\Element\Password;
use Limatus\Form\Element\Text;
use Limatus\Form\Element\Submit;
use Limatus\Form\Form;
use Webinertia\ThemeManager\Validator\Password as PwdValidator;

final class Login extends Form implements InputFilterProviderInterface
{
    public function __construct(
        $name = 'login',
        $options = ['class' => 'row g-3 tm-login', 'mode' => self::GRID_MODE]
    ) {
        parent::__construct($name, $options);
    }

    public function init(): void
    {
        $this->add([
            'type' => Text::class,
            'name' => 'username',
            'attributes' => [
                'class'       => 'form-control',
                'placeholder' => 'Username'
            ],
            'options' => [
                'help'                 => 'This will be the value you entered during ThemeManager installation.',
                'bootstrap_attributes' => [
                    'class' => 'col-md-6'
                ],
                'help_attributes' => [
                    'class' => 'form-text text-muted',
                ],
            ],
        ]);
        $this->add([
            'name' => 'password',
            'type' => Password::class,
            'attributes' => [
                'class'            => 'form-control password',
                'placeholder'      => 'Password',
                'aria-describedby' => 'passwordHelp',
            ],
            'options' => [
                'help'                 => 'Must be at least 8 characters long,
                                           1 Uppercase,
                                           1 Lowercase,
                                           1 Special character. [\@_!#$%^&*()<>?|}{~:-]',
                'bootstrap_attributes' => [
                    'class' => 'col-md-6',
                ],
                'help_attributes'      => [
                    'class' => 'form-text text-muted',
                ],
            ],
        ]);
        $this->add([
            'name'       => 'save',
            'type'       => Submit::class,
            'attributes' => [
                'class' => 'btn btn-sm btn-secondary',
                'value' => 'Save',
            ],
        ]);
    }

    public function getInputFilterSpecification(): array
    {
        return [
            'password'    => [
                'required' => true,
                'filters'  => [
                    ['name' => Filter\StringTrim::class],
                ],
                'validators' => [
                    [
                        'name'    => PwdValidator::class,
                        'options' => [
                            'length'  => 4,
                            'upper'   => 2,
                            'lower'   => 1,
                            'special' => 1,
                        ],
                    ],
                ],
            ],
        ];
    }
}
