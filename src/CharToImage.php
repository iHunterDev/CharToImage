<?php
namespace CharToImage;

use CharToImage\CharToImageException;
/**
 * 从文件或者URL创建一个图像
 * imagecreatefromgif - gif
 * imagecreatefromjpeg - jpeg
 * imagecreatefrompng - png
 * imagecreatefromstring - 从 string 中读取
 * imagecreatefromwbmp - wbmp
 * imagecreatefromwebp - webp
 * imagecreatefromxbm - xbm
 * imagecreatefromxpm - xpm
 *
 * 输出图像到浏览器
 * imagegif - gif
 * imagejpeg - jpeg
 * imagepng - png
 * imagewbmp - wbmp
 * imagewebp - webp
 * imagexbm - xbm
 * 
 *
 * 销毁图像
 * imagedestroy
 *
 * 读写像素
 * imagecolorat - 读索引
 * imagecolorsforindex - 读rgb
 * imagesetpixel - 写
 *
 * 字符转16进制
 * bin2hex
 *
 * 16进制转2进制
 * hex2bin
 *
 * 设置颜色
 * imagecolorallocate
 */

class CharToImage
{
    public $InObj;   // 输入对象
    public $OutputObj;  // 输出对象

    public $path; // 图片文件地址
    public $im; // 图片资源
    public $x; // 图片x轴长度
    public $y; // 图片y轴长度

    public $charMax;  // 最大保存字符数
    public $string; // 要被写入的字符串
    public $string_array; // 切割后数组
    public $strTotal; // 将要写入字符串的长度

    /**
     * [__construct 初始化]
     * @param [object] $InObj     [图片输入对象]
     * @param [object] $OutputObj [图片输出对象]
     * @param [string] $path      [图片地址]
     */
    public function __construct($InObj, $OutputObj, $path)
    {
        // 保存输入输出对象
        $this->InObj = $InObj;
        $this->OutputObj = $OutputObj;

        // 读取图片
        $this->read($path);

        // 获取坐标
        $this->getX();
        $this->getY();

        // 最大字符保存数
        $this->charMax = $this->x * $this->y - 1;
    }


    /**
     * [write 写入数据]
     * @param  [string]  $string [需要写入的字符串]
     * @param  mixed $path   [图片文件保存地址]
     * @return [mixed]          [图片url或者直接返回图片]
     */
    public function write($string, $path=false)
    {
        $this->string = $string;

        // 切割字符串
        $this->split();

        // 判断是否超出大小
        if ($this->charMax < $this->strTotal) throw new CharToImageException('文字超出图片最大存储访问,请更换图片.');

        $this_x = 1;
        $this_y = 1;

        foreach ($this->string_array as $key => $value) {
            $mark = false;
            // 计算 y 坐标
            if (($key + 1) > $this->x) $this_y = ceil(($key + 1) / $this->x);
            // echo ceil(($key + 1) / $this->x);
            // echo '<br>';

            // 计算 x 坐标
            $this_x = (($key + 1) % $this->x) == 0 ? 48 : (($key + 1) % $this->x);

            if ($value == 'end') {
                $mark = true;
            }
            $color = $this->setColor($value, $mark);

            // echo $this_x, ':', $this_y, ':', $this_x * $this_y, ':', $key+1, '<br>';


            imagesetpixel($this->im, $this_x, $this_y, $color);

        }
            if ($path) {

            } else {
                header("Content-Type: image/{$this->OutputObj->type}; charset=utf-8");
                header("Content-Disposition: attachment; filename=" . md5(time()) . '.' . $this->OutputObj->type);
                return $this->OutputObj->return($this->im);
            }
    }


    /**
     * [readText 读取保存在像素中的文本]
     * @return [string] [解码后的字符]
     */
    public function readText()
    {
        $num = 0;

        $this_x = 1;
        $this_y = 1;

        $encode_str = '';

        while(true) {
            // 计算 y 坐标
            if (($num + 1) > $this->x) $this_y = ceil(($num + 1) / $this->x);

            // 计算 x 坐标
            $this_x = (($num + 1) % $this->x) == 0 ? 48 : (($num + 1) % $this->x);

            $color_index = imagecolorat($this->im, $this_x, $this_y);

            $rgba = imagecolorsforindex($this->im, $color_index);

            $hex = $this->dec2hex($rgba);

            // 当读到纯黑色方块时, 结束读取
            if ($hex == '000000') {
                break;
            }

            $encode_str .= hex2bin($hex);

            // 防止死循环
            if (++$num > ($this->charMax - 1)) break;
        }

        return $encode_str;
    }




//+---------------------------------------------------------
//+---------------------------------------------------------
//| 辅助方法
//+---------------------------------------------------------
//+---------------------------------------------------------
    

    /**
     * [getX 获取图片x轴长度]
     * @return [int] [图片x轴长度]
     */
    protected function getX()
    {
        return $this->x = imagesx($this->im);
    }


    /**
     * [getY 获取图片y轴长度]
     * @return [int] [图片y轴长度]
     */
    protected function getY()
    {
        return $this->y = imagesy($this->im);
    }

    protected function read($path)
    {
        if (! file_exists($path)) throw new CharToImageException('图片不存在');
        if (! is_readable($path)) throw new CharToImageException('图片不可读');
        return $this->im = $this->InObj->read($path);
    }


    /**
     * [split 字符串切割]
     * @param  integer $length [块的大小]
     * @param  [string]  $string [要切割的字符串, 默认为$this->string]
     * @return [array]          [切割后的块数组]
     */
    protected function split($length=1, $string=null)
    {
        $mark = false;
        if (! $string) {
            $string = $this->string;
            $mark = true;
        }

        $start = 0;
        $strlen = mb_strlen($string);
        while ($strlen) {
            $array[] = mb_substr($string, $start, $length, "utf8");
            $string = mb_substr($string, $length, $strlen, "utf8");
            $strlen = mb_strlen($string);
        }

        // 加入结尾
        if ($mark) {
            array_push($array, 'end');
            $this->string_array = $array;

            // 统计字符总数
            $this->strTotal = count($array);
        }
        return $array;
    }


    /**
     * [setColor 设置颜色]
     * @param [string]  $char [需要写入的字符]
     * @param boolean $end  [是否是字符串结尾]
     * @return [response]          [资源对象]
     */
    protected function setColor($char, $end = false)
    {
        if ($end) return imagecolorallocate($this->im, 0, 0, 0);

        $hex = bin2hex($char);

        if (strlen($hex) != 6 && strlen($hex) != 4 && strlen($hex) != 2) throw new CharToImageException('暂不支持此字符');

        $rgb = $this->split(2, $hex);
        switch (count($rgb)) {            
            case 2:
                array_unshift($rgb, '00');
                break;
            
            case 1:
                array_unshift($rgb, '00', '00');
                break;
        }

        // 由于参数要求 int 类型, 所以将 16 进制转为 10 进制, 读取时记得转为 16 进制
        $color = imagecolorallocate($this->im, hexdec($rgb[0]), hexdec($rgb[1]), hexdec($rgb[2]));

        
        return $color;
    }


    /**
     * [dec2hex 10进制转16进制]
     * @param  [array] $rgba [rgba]
     * @return [string]       [返回16进制]
     */
    protected function dec2hex($rgba)
    {

        $dec_str = join('', $rgba);

        switch ($dec_str) {
            case '00130':
                return '0d0a';
                break;
            case '00320':
                return '20';
                break;
            case '000000':
                return '000000';
                break;
        }

        $arr = ['red', 'green', 'blue'];
        foreach ($arr as $key => $value) {
            if ($rgba[$value] < 16) {
                if ($rgba[$value] == 0) {
                    $rgba[$value] = null;
                } else {
                    $rgba[$value] = 20;
                }
            } else {
                $rgba[$value] = dechex($rgba[$value]);
            }

        }

        // 移除透明度
        array_pop($rgba);

        return join('', $rgba);
    }
}