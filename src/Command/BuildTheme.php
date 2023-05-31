<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Command;

use DirectoryIterator;
use Laminas\Cli\Command\AbstractParamAwareCommand;
use Laminas\Cli\Input\ParamAwareInputInterface;
use Laminas\Cli\Input\StringParam;
use Laminas\Filter\Exception;
use Laminas\Filter\File\Rename;
use SplFileInfo;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use const DIRECTORY_SEPARATOR;

use function mkdir;

final class BuildTheme extends AbstractParamAwareCommand
{
    private const APP_DIR           = 'Application';
    private const LAYOUT_PATH       = __DIR__ . '/../../../../../module/Application/view/layout';
    private const THEME_NAME        = 'default';
    private const ERROR_PATH        = __DIR__ . '/../../../../../module/Application/view/error';
    private const MODULE_PATH       = __DIR__ . '/../../../../../module';
    private const VIEW_PATH_SEGMENT = '/view';
    public function __construct(
        /** @var array<string, mixed> $config */
        private array $config,
    ) {
        parent::__construct();
    }

    public function configure(): void
    {
        $this->setName('migrate-files');
        $this->setDescription('Migrate Files');
        $this->setHelp('This command restructures the applications view layer to what is required by ThemeManager');
    }

    /** @param ParamAwareInputInterface $input */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $result = $this->migrateTheme();
        return 0;
    }

    private function migrateTheme(): int
    {
        $pathStack = ['source' => '', 'target' => ''];
        foreach (new DirectoryIterator(self::MODULE_PATH) as $moduleInfo) {
            if ($moduleInfo->isDot() || ! $moduleInfo->isDir()) {
                continue;
            }
            $module = $moduleInfo->getFilename();
            foreach (new DirectoryIterator($moduleInfo->getRealPath() . self::VIEW_PATH_SEGMENT) as $moduleSourceInfo) {
                if ($moduleSourceInfo->isDot() || ! $moduleSourceInfo->isDir() && $moduleSourceInfo->getFileName() !== self::THEME_NAME) {
                    continue;
                }
                $moduleSource = $moduleSourceInfo->getFileName();
                $target = $moduleInfo->getRealPath() . self::VIEW_PATH_SEGMENT . '/' . self::THEME_NAME;
                if ($this->createTarget($target)) {
                    $filter = new Rename($target);
                    try {
                        $moduleMoved = $filter->filter($moduleSourceInfo->getRealPath());
                        if ($module === self::APP_DIR) {
                            $layoutMoved = $filter->filter(self::LAYOUT_PATH);
                            $errorMoved  = $filter->filter(self::ERROR_PATH);
                        }
                    } catch (Exception\RuntimeException $e) {
                        return self::FAILURE;
                    }
                }
            }
            continue;
        }
        return self::SUCCESS;
    }

    private function createTarget(string $path)
    {
        return mkdir($path, 0600);
    }
}
