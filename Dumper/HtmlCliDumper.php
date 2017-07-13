<?php

namespace Fancyweb\HtmlCliDumperBundle\Dumper;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class HtmlCliDumper extends CliDumper
{
    /**
     * @var string
     */
    private $saveDirectoryPath;

    /**
     * @var string
     */
    private $viewBaseUrl;

    /**
     * @var bool
     */
    private $disableCliDump;

    /**
     * @var HtmlDumper
     */
    private $htmlDumper;

    /**
     * @var Filesystem
     */
    private $fs;

    /**
     * @param string $saveDirectoryPath
     * @param string $viewBaseUrl
     * @param bool $disableCliDump
     * @param callable|resource|string|null $output
     * @param string|null $charset
     * @param int $flags
     */
    public function __construct($saveDirectoryPath, $viewBaseUrl, $disableCliDump, $output = null, $charset = null, $flags = 0)
    {
        if (!is_string($saveDirectoryPath)) {
            throw new \DomainException();
        }

        if (!is_string($viewBaseUrl)) {
            throw new \DomainException();
        }

        parent::__construct($output, $charset, $flags);

        $this->saveDirectoryPath = rtrim($saveDirectoryPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->viewBaseUrl = sprintf('%s/', rtrim($viewBaseUrl, '/'));
        $this->disableCliDump = (bool) $disableCliDump;

        $this->htmlDumper = new HtmlDumper();
        $this->fs = new Filesystem();
    }

    /**
     * {@inheritDoc}
     */
    public function dump(Data $data, $output = null)
    {
        $result = !$this->disableCliDump ? parent::dump($data, $output) : null;

        $output = fopen('php://memory', 'r+b');
        $this->htmlDumper->dump($data, $output);
        $dumpFilename = sprintf('%s.html', uniqid('dump_'));
        $this->fs->dumpFile($this->saveDirectoryPath . $dumpFilename, stream_get_contents($output, -1, 0));
        fclose($output);

        $this->colors = false;
        $this->line = sprintf("\n=== HTML dump url ===\n>>> %s\n", $this->viewBaseUrl . $dumpFilename);
        parent::dumpLine(0);
        $this->colors = null;

        return $result;
    }
}
