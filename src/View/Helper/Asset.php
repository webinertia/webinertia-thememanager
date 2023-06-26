<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\View\Helper;

use Laminas\View\Exception;
use Laminas\View\Helper\Asset as LaminasAsset;

use function array_key_exists;
use function sprintf;

/**
 * View helper plugin to fetch asset from resource map.
 *
 */
class Asset extends LaminasAsset
{
    /** @var \Laminas\View\Renderer\PhpRenderer $view */
    protected $view;
    /**
     * @param non-empty-string $asset
     * @return non-empty-string
     * @throws Exception\InvalidArgumentException
     */
    public function __invoke($asset)
    {
        if (! array_key_exists($asset, $this->resourceMap)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'The asset with the name "%s" has not been defined.',
                $asset
            ));
        }
        $basePath = $this->view->plugin('basePath');

        return $basePath($this->resourceMap[$asset]);
    }
}
