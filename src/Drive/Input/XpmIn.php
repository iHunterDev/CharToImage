<?php
namespace CharToImage\Drive\Input;

use CharToImage\Drive\InputBase;

class XpmIn implements InputBase
{
    public function read($path)
    {
        return imagecreatefromxpm($path);
    }
}