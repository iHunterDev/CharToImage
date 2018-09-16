<?php
namespace CharToImage\Drive\Input;

use CharToImage\Drive\InputBase;

class XbmIn implements InputBase
{
    public function read($path)
    {
        return imagecreatefromxbm($path);
    }
}