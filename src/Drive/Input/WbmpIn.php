<?php
namespace CharToImage\Drive\Input;

use CharToImage\Drive\InputBase;

class WbmpIn implements InputBase
{
    public function read($path)
    {
        return imagecreatefromwbmp($path);
    }
}