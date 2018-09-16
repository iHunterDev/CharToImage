<?php
namespace CharToImage\Drive\Input;

use CharToImage\Drive\InputBase;

class JpegIn implements InputBase
{
    public function read($path)
    {
        return imagecreatefromjpeg($path);
    }
}