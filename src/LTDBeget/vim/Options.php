<?php
/**
 * @author: Viskov Sergey
 * @date  : 4/28/16
 * @time  : 6:54 PM
 */

namespace LTDBeget\vim;

/**
 * Class Options
 *
 * @package LTDBeget\vim
 */
final class Options
{
    /**
     * @var bool
     */
    private $diffMode = false;

    /**
     * @var bool
     */
    private $easyMode = false;

    /**
     * @var bool
     */
    private $readonlyMode = false;

    /**
     * @var string
     */
    private $encoding;


    /**
     * @var string
     */
    private $termEncoding;


    /**
     * @return string
     */
    public function getTermEncoding()
    {
        return $this->termEncoding;
    }


    /**
     * @param string $termEncoding
     *
     * @return Options
     */
    public function setTermEncoding(string $termEncoding)
    {
        $this->termEncoding = $termEncoding;

        return $this;
    }

    /**
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }


    /**
     * set encoding=<your encoding>
     * @param string $encoding
     *
     * @return Options
     */
    public function setEncoding(string $encoding) : Options
    {
        $this->encoding = $encoding;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDiffMode()
    {
        return $this->diffMode;
    }

    /**
     * @param bool $diffMode
     * @return Options
     */
    public function setDiffMode(bool $diffMode) : Options
    {
        $this->diffMode = $diffMode;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEasyMode()
    {
        return $this->easyMode;
    }

    /**
     * @param bool $easyMode
     * @return Options
     */
    public function setEasyMode(bool $easyMode) : Options
    {
        $this->easyMode = $easyMode;

        return $this;
    }

    /**
     * @return bool
     */
    public function isReadonlyMode()
    {
        return $this->readonlyMode;
    }

    /**
     * @param bool $readonlyMode
     * @return Options
     */
    public function setReadonlyMode(bool $readonlyMode) : Options
    {
        $this->readonlyMode = $readonlyMode;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        $options = [];

        if($this->isDiffMode()) {
            $options[] = '-d';
        }

        if($this->isEasyMode()) {
            $options[] = '-y';
        }

        if($this->isReadonlyMode()) {
            $options[] = '-R';
        }

        if($this->encoding) {
            $options[] = "-c 'set encoding=".escapeshellarg($this->encoding)."'";
        }

        if($this->termEncoding) {
            $options[] = "-c 'set termencoding=".escapeshellarg($this->termEncoding)."'";
        }

        return implode(' ', $options);
    }
}