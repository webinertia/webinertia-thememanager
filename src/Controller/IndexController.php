<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Controller;

use Laminas\Form\FormElementManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ModelInterface;
use Laminas\View\Model\ViewModel;
use Webinertia\ThemeManager\Form\Login;

final class IndexController extends AbstractActionController implements AdminControllerInterface
{
    /** @var \Laminas\Http\PhpEnvironment\Request $request */
    protected $request;

    public function __construct(
        protected FormElementManager $formManager
    ) {
    }

    public function loginAction(): ModelInterface
    {
        $view = new ViewModel();
        $form = $this->formManager->get(Login::class);
        $form->setAttribute('action', $this->url()->fromRoute('tm.login'));

        if ($this->request->isPost()) {
            $post = $this->request->getPost()->toArray();
            $form->setData($post);
            if ($form->isValid()) {

            } else {

            }
        }

        $view->setVariable('form', $form);
        return $view;
    }

    public function changeThemeAction(): ModelInterface
    {
        return new JsonModel(['selected' => 'test']);
    }
}
