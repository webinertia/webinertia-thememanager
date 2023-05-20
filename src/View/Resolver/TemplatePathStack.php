<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\View\Resolver;

use Webinertia\ThemeManager\Model\Theme;
use Laminas\View\Resolver\TemplatePathStack as Stack;

use function str_contains;

class TemplatePathStack extends Stack
{
    public function addPaths(array $paths)
    {
        $theme = new Theme();
        $activeTheme = $theme->getActiveTheme();
        foreach ($paths as $path) {
            if (! str_contains($path, 'laminas-developer-tools')) {
                $this->addPath($path . '/' . Theme::DEFAULT_THEME);
                if ($activeTheme !== Theme::DEFAULT_THEME) {
                    $this->addPath($path . '/' . $activeTheme);
                }
            } else {
                $this->addPath($path);
            }
        }
        return $this;
    }
}
