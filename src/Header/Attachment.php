<?php

namespace Spartan\Http\Header;

use Spartan\Http\Definition\HeaderInterface;

/**
 * Attachment Header
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Attachment implements HeaderInterface
{
    protected \SplFileInfo $file;

    /**
     * Attachment constructor.
     *
     * @param \SplFileInfo $file
     */
    public function __construct(\SplFileInfo $file)
    {
        $this->file = $file;
    }

    /**
     * @param string $name
     * @param string $contents Should not be base64_encoded
     *
     * @return Attachment
     */
    public static function fromContents(string $name, string $contents)
    {
        $filePath = sys_get_temp_dir() . '/' . microtime(true) . '/' . $name;
        @mkdir(dirname($filePath), 0777, true);
        file_put_contents($filePath, $contents);

        return new self(new \SplFileInfo($filePath));
    }

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return $this->file->getFilename();
    }

    /**
     * @inheritDoc
     */
    public function value()
    {
        return file_get_contents($this->file->getRealPath());
    }

    public function file(): \SplFileInfo
    {
        return $this->file;
    }

    public function mime(): string
    {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime     = finfo_file($fileInfo, $this->file->getPathname());
        finfo_close($fileInfo);

        return $mime;
    }

    public function __toString()
    {
        return (string)$this->value();
    }
}
