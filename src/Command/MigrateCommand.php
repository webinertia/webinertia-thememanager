<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Command;

use Laminas\Cli\Command\AbstractParamAwareCommand;
use Laminas\Cli\Input\ParamAwareInputInterface;
use Laminas\Cli\Input\StringParam;
use Laminas\Filter\File\Rename;
use SplFileInfo;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use const DIRECTORY_SEPARATOR;

class MigrateCommand extends AbstractParamAwareCommand
{
    private const TARGET_PATH = __DIR__ . '/../../../../../module/Application/view/default';
    private const THEME_NAME  = 'default';
    private const SOURCE_PATH = __DIR__ . '/../../../../../module/Application/view';
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
        return 0;
    }
}
