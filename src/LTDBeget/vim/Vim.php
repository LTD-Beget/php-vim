<?php
/**
 * @author: Viskov Sergey
 * @date  : 4/28/16
 * @time  : 6:49 PM
 */

namespace LTDBeget\vim;

/**
 * Class Vim
 *
 * @package LTDBeget\vim
 */
final class Vim
{
    /**
     * @var Options
     */
    private $options;

    /**
     * @var string
     */
    private $editor;

    /**
     * @var array
     */
    private $tempFiles;

    /**
     * @var array
     */
    private $originalContent;

    /**
     * Vim constructor.
     *
     * @param Options|NULL $options
     */
    public function __construct(Options $options = NULL)
    {
        $editor = shell_exec('which vim');
        if(empty($editor)) {
            throw new \LogicException('Install vim');
        }
        $this->editor  =  trim($editor);
        $this->options = $options ?? new Options();
    }

    /**
     * Открывает Vim в консоли для редактирования
     */
    public function execute()
    {
        system($this->getCommand());
    }

    /**
     * @param string $key
     * @param string $content
     * @return Vim
     */
    public function addFileContent(string $key, string $content) : Vim
    {
        $this->originalContent[$key] = $content;
        $this->tempFiles[$key]       = $this->makeTemporaryFile($content);
        
        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isChanged(string $key) : bool
    {
        return $this->originalContent[$key] === $this->getContent($key);
    }

    /**
     * @param string $key
     * @return string
     */
    public function getContent(string $key) : string
    {
        return file_get_contents(stream_get_meta_data($this->tempFiles[$key])['uri']);
    }

    /**
     * @param $content
     * @return resource
     */
    private function makeTemporaryFile($content)
    {
        $tempFile = tmpfile();
        $filename = stream_get_meta_data($tempFile)['uri'];
        file_put_contents($filename, $content);
        return $tempFile;
    }

    /**
     * @return array
     */
    private function getFilesPath() : array 
    {
        $paths =[];
        foreach ($this->tempFiles as $fileResource) {
            $paths[] = stream_get_meta_data($fileResource)['uri'];
        }
        return $paths;
    }

    /**
     * @return string
     */
    private function getCommand() : string 
    {
        return 
            $this->editor .  ' ' .
            (string) $this->options . ' ' .
            implode(' ', array_map(function(string $path) {
                return escapeshellarg($path);
            }, $this->getFilesPath())) . ' ' .
            sprintf('> /proc/%s/fd/1', posix_getpid());
    }
}