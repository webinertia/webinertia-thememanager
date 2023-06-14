<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Form;

use Laminas\Filter;
use Laminas\InputFilter\InputFilterProviderInterface;
use Limatus\Form\Element\Password;
use Limatus\Form\Element\Text;
use Limatus\Form\Element\Submit;
use Limatus\Form\Form;
use Webinertia\Validator\Password as PwdValidator;

final class Login extends Form implements InputFilterProviderInterface
{
    protected $attributes = ['method' => 'POST'];

    public function __construct(
        $name = 'login',
        $options = [
            'mode' => self::GRID_MODE,
            'boostrap_attributes' => [
                'class' => 'row g-3 mx-auto tm-login'
            ],
        ]
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
                    'class' => 'col-md-8'
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
                                           2 Uppercase,
                                           2 Lowercase,
                                           2 Special characters. [].+=\@_!#$%^&*()<>?|}{~:-',
                'bootstrap_attributes' => [
                    'class' => 'col-md-8',
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
                'validators' => [
                    [
                        'name'    => PwdValidator::class,
                        'options' => [
                            'length'  => 8,
                            'upper'   => 2,
                            'lower'   => 2,
                            'special' => 2,
                        ],
                    ],
                ],
                'filters'  => [
                    ['name' => Filter\StringTrim::class],
                ],
            ],
        ];
    }
}
