<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Model;

use Laminas\Config\Factory;

final class User
{
    private const DATA = __DIR__ . '/../../../../../data/thememanager/user.config.php';

    public function __construct(
        protected string $userName,
        protected string $passwd,
        protected ?array $data
    ) {
        $this->data     = Factory::fromFile(self::DATA);
        $this->setUsername($this->data['username']);
        $this->setPasswd($this->data['passwd']);
    }

    public function getUsername(): null|string
    {
        return $this->userName;
    }

    public function setUsername(string $userName): void
    {
        $this->userName = $userName;
    }

    public function  getPasswd(): null|string
    {
        return $this->passwd;
    }

    public function setPasswd(string $passwd): void
    {
        $this->passwd = $passwd;
    }
}
