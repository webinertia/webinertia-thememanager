<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Command;

use DirectoryIterator;
use Laminas\Cli\Command\AbstractParamAwareCommand;
use Laminas\Cli\Input\ParamAwareInputInterface;
use Laminas\Filter\Exception;
use Laminas\Filter\File\Rename;
use SplFileInfo;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function in_array;
use function is_dir;
use function mkdir;

final class BuildTheme extends AbstractParamAwareCommand
{
    private const APP_DIR           = 'Application';
    private const LAYOUT_PATH       = __DIR__ . '/../../../../../module/Application/view/layout';
    private const THEME_NAME        = 'default';
    private const ERROR_PATH        = __DIR__ . '/../../../../../module/Application/view/error';
    private const MODULE_PATH       = __DIR__ . '/../../../../../module';
    private const VIEW_PATH_SEGMENT = '/view';
    // asset paths
    private const PUBLIC_PATH         = __DIR__ . '/../../../../../public';
    private const PUBLIC_PATH_SEGMENT = '/theme';
    private static $supportedAssets = ['css', 'img', 'js'];
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
        if ($this->migrateTheme($input, $output) === self::SUCCESS) {
            return $this->migrateAssets($input, $output);
        } else {
            return self::FAILURE;
        }
    }

    private function migrateTheme(InputInterface $input, OutputInterface $output): int
    {
        foreach (new DirectoryIterator(self::MODULE_PATH) as $moduleInfo) {
            if ($moduleInfo->isDot() || ! $moduleInfo->isDir()) {
                continue;
            }
            $module = $moduleInfo->getFilename();
            foreach (
                new DirectoryIterator($moduleInfo->getRealPath()
                . self::VIEW_PATH_SEGMENT) as $moduleSourceInfo
            ) {
                if (
                    $moduleSourceInfo->isDot()
                    || ! $moduleSourceInfo->isDir()
                    && $moduleSourceInfo->getFileName()
                    !== self::THEME_NAME
                ) {
                    continue;
                }
                $moduleSource = $moduleSourceInfo->getFileName();
                $target = $moduleInfo->getRealPath() . self::VIEW_PATH_SEGMENT . '/' . self::THEME_NAME;
                if (is_dir($target) || mkdir($target, 0600)) {
                    $output->writeln('<info>' . $target . ' has been created successfully. starting move...' . '</info>');
                    $filter = new Rename($target);
                    try {
                        $moduleMoved = $filter->filter($moduleSourceInfo->getRealPath());
                        $output->writeln('<info>' . $moduleMoved . ' has been moved successfully' . '</info>');
                        if ($module === self::APP_DIR) {
                            $layoutMoved = $filter->filter(self::LAYOUT_PATH);
                            $output->writeln('<info>' . $layoutMoved . ' has been moved successfully' . '</info>');
                            $errorMoved  = $filter->filter(self::ERROR_PATH);
                            $output->writeln('<info>' . $errorMoved . ' has been moved successfully' . '</info>');
                        }
                    } catch (Exception\RuntimeException $e) {
                        $output->writeln('<error>' . $e->getMessage() . '</error>');
                        return self::FAILURE;
                    }
                }
            }
            continue;
        }
        $output->writeln('<info>View files moved successfully for all modules...</info>');
        return self::SUCCESS;
    }

    private function migrateAssets(InputInterface $input, OutputInterface $output): int
    {
        $docRoot = new SplFileInfo(self::PUBLIC_PATH);
        $target = $docRoot->getRealPath() . self::PUBLIC_PATH_SEGMENT . '/' . self::THEME_NAME;
        if (is_dir($target) || mkdir($target, 0755, true)) {
            $themeInfo = new SplFileInfo($target);
            if ($themeInfo->isDir() && $themeInfo->isWritable()) {
                $output->writeln('<info>' . $themeInfo->getRealPath() . ' has been created and is writable. Starting asset move...' . '</info>');
                foreach (new DirectoryIterator($docRoot->getRealPath()) as $assetInfo) {
                    if ($assetInfo->isDot() || ! $assetInfo->isDir() && $assetInfo->getFilename() !== 'theme') {
                        continue;
                    }
                    $assetDir = $assetInfo->getFilename();
                    $filter = new Rename($target);
                    try {
                        if (in_array($assetDir, static::$supportedAssets)) {
                            $assetMoved = $filter->filter($assetInfo->getRealPath());
                            $output->writeln('<info>' . $assetMoved . ' has been moved successfully' . '</info>');
                        }
                    } catch (Exception\RuntimeException $e) {
                        $output->writeln('<error>' . $e->getMessage() . '</error>');
                        return self::FAILURE;
                    }
                }
            } else {
                $output->writeln('<error>' . $themeInfo->getRealPath() . ' is not writable. Please check your logs!' . '</error>');
                return self::FAILURE;
            }
        } else {
            $output->writeln('<error>' . $target . ' could not be created!' . '</error>');
            return self::FAILURE;
        }
        $output->writeln('<info>All supported assets moved successfully.</info>');
        return self::SUCCESS;
    }
}
