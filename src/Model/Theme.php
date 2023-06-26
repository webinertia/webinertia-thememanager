<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Model;

use Laminas\Config\Factory;
use Webinertia\ThemeManager\Session\Container;

use function dirname;

use const PHP_SAPI;

class Theme
{
    public const BASE_PATH_SEGMENT = 'theme/';
    public const CONFIG_PATH   = __DIR__ . '/../../../../../data/thememanager/';
    public const DEFAULT_THEME = 'default';
    /** @var string $activeTheme */
    protected $activeTheme;
    /** @var array<non-empty-string, non-empty-string> $resourceMap */
    protected $resourceMap;
    /** @var string $fallBack */
    protected $fallBack;
    /** @var string $configFilename */
    protected $configFilename = 'theme.config.php';
    /** @var string $directory */
    protected $directory;
    /** @var array<int, string> $paths */
    protected $paths = [];
    /** @var string $resourceId */
    protected $resourceId = 'themes';
    /** @var array<string, array> $config */
    protected $config = [];
    /** @var array<string, array> $defaultConfig */
    private static $defaultConfig = [
            'default' => [
                'id' => 1,
                'active' => true,
                'name' => 'default',
                'resource_map' => [
                    'css/style.css'     => 'theme/default/css/style.css',
                    'css/bootstrap.css' => 'theme/default/css/bootstrap.css',
                    'css/bootstrap.min.css' => 'theme/default/css/bootstrap.min.css',
                    'js/bootstrap.js'   => 'theme/default/js/bootstrap.js',
                    'img/favicon.ico'   => 'theme/default/img/favicon.ico',
                ],
            ]
    ];
    /** @var Container $sessionContainer */
    private $sessionContainer;

    public function __construct(Container $container)
    {
        $this->sessionContainer = $container;
        $this->directory  = dirname(__DIR__, 4) . '/theme/';
        if (PHP_SAPI !== 'cli') {
            $this->config     = Factory::fromFile(self::CONFIG_PATH . $this->configFilename);
            $this->processConfig($this->config);
        } else {
            $this->processConfig(self::$defaultConfig);
        }

    }

    protected function processConfig(array $config): void
    {
        foreach ($config as $theme) {
            if ($theme['active']) {
                $this->setActiveTheme($theme['name']);
                if (isset($theme['resource_map'])) {
                    $this->setResourceMap($theme['resource_map']);
                }
            }
            if (! empty($theme['fallback'])) {
                $this->setFallBack($theme['fallback']);
            }
        }
    }

    public function getThemePaths(): array
    {
        if ($this->activeTheme === self::DEFAULT_THEME) {
            $this->paths = [$this->directory . self::DEFAULT_THEME];
        } elseif ($this->activeTheme !== self::DEFAULT_THEME && $this->fallBack === self::DEFAULT_THEME) {
            $this->paths = [
                $this->directory . self::DEFAULT_THEME,
                $this->directory . $this->activeTheme,
            ];
        } elseif ($this->activeTheme !== self::DEFAULT_THEME && $this->fallBack !== self::DEFAULT_THEME) {
            $this->paths = [
                $this->directory . $this->fallBack,
                $this->directory . $this->activeTheme,
            ];
        }
        return $this->paths;
    }

    /** @param string $activeTheme */
    public function setActiveTheme($activeTheme): void
    {
        $this->activeTheme = $activeTheme;
    }

    public function getActiveTheme(): string
    {
        if (isset($this->sessionContainer->theme)) {
            return $this->sessionContainer->theme;
        }
        return $this->activeTheme;
    }

    /** @param string $fallBack */
    public function setFallBack($fallBack)
    {
        $this->fallBack = $fallBack;
    }

    public function getFallBack(): string
    {
        return $this->fallBack;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function getResourceMap(): array
    {
        return $this->resourceMap;
    }

    public function setResourceMap(array $resouceMap): void
    {
        $this->resourceMap = $resouceMap;
    }

    public function getOwnerId(): mixed
    {
        return 0;
    }
}
