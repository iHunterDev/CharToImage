<?php
namespace CharToImage\Drive\Input;

use CharToImage\Drive\InputBase;

class PngIn implements InputBase
{
    public function read($path)
    {
        return imagecreatefrompng($path);
    }
}