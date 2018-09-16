<?php
namespace CharToImage\Drive;

/**
 * 输出图像到浏览器
 * imagegif - gif 不写
 * imagejpeg - jpeg
 * imagepng - png
 * imagewbmp - wbmp
 * imagewebp - webp
 * imagexbm - xbm
 * imagebmp - bmp
 */
/**
 * 输出接口
 */
interface OutputBase
{
    /**
     * [return 将图片返回到浏览器]
     * @param  [response] $im [图片资源]
     * @return [boolean] [输出是否成功]
     */
    public function return($im);

    /**
     * [write 写入到文件]
     * @param  [response] $im [图片资源]
     * @param  [string] $path [文件保存地址]
     * @return [mixed]       [成功则返回true|失败返回错误信息或false]
     */
    public function write($im, $path);
    
}