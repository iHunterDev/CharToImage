<?php
namespace CharToImage\Drive\Input;

use CharToImage\Drive\InputBase;

class WebpIn implements InputBase
{
    public function read($path)
    {
        return imagecreatefromwebp($path);
    }
}