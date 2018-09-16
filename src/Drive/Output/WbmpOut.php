<?php
namespace CharToImage\Drive\Output;

use CharToImage\Drive\OutputBase;

class WbmpOut implements OutputBase
{
    public $type = 'wbmp';
    /**
     * [return 将图片返回到浏览器]
     * @param  [response] $im [图片资源]
     * @return [boolean] [输出是否成功]
     */
    public function return($im)
    {
        return imagewbmp($im);
    }

    /**
     * [write 写入到文件]
     * @param  [response] $im [图片资源]
     * @param  [string] $path [文件保存地址]
     * @return [mixed]       [成功则返回true|失败返回错误信息或false]
     */
    public function write($im, $path)
    {
        return imagewbmp($im, $path);
    }
}