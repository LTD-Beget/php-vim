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
     * @param string $filename
     * @param string $content
     * @return Vim
     */
    public function addFileContent(string $filename, string $content) : Vim
    {
        $this->originalContent[$filename] = $content;
        $this->tempFiles[$filename]       = $this->makeTemporaryFile($filename, $content);
        
        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isChanged(string $key) : bool
    {
        return $this->originalContent[$key] !== $this->getContent($key);
    }

    /**
     * @param string $key
     * @return string
     */
    public function getContent(string $key) : string
    {
        return file_get_contents($this->tempFiles[$key]);
    }

    /**
     * @param string $name
     * @param string $content
     * @return resource
     */
    private function makeTemporaryFile(string $name, string $content)
    {
        $filename = tempnam(sys_get_temp_dir(), $name.'_');
        file_put_contents($filename, $content);
        return $filename;
    }


    public function __destruct()
    {
        foreach ($this->getFilesPath() as $fileName) {
            if(is_file($fileName)) {
                unlink($fileName);
            }
        }
    }

    /**
     * @return array
     */
    private function getFilesPath() : array 
    {
        $paths =[];
        foreach ($this->tempFiles as $fileName) {
            $paths[] = $fileName;
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