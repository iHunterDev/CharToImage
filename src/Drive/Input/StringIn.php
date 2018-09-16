<?php
namespace CharToImage\Drive\Input;

use CharToImage\Drive\InputBase;

class StringIn implements InputBase
{
    public function read($path)
    {
        return imagecreatefromstring($path);
    }
}