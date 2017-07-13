<?php
/**
 *	description:ZMAX验证码 主文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2014-12-08
 */

/**
 * @description validatecode  class file
 *
 * @copyright 
 */
  
class CValidateCode 
{
	/**
	 * @description random seed
	 * @type string
	 */
	private $_charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';   
	
	/**
	 * @description captchar
	 * @type string
	 */
    private $_code;         
	
	/**
	 * @description the length of captchar
	 * @type int
	 */
    private $_codelen = 4;   
	
	/**
	 * @description the width(height) of captchar
	 * @type int
	 */
    private $_width = 130;                   
    private $_height = 50;                 
	
	/**
	 * @description the handle of image
	 * @type object
	 */
    private $_img; 
    private $_font;                             
    private $_fontsize = 20;                
    private $_fontcolor; 
	
	/**
	 * @description the path of this file
	 * @type string00
	 */
	private $_path;

   
    public function __construct($path_root) 
	{
		$this->_path = $path_root;
        $this->_font = $path_root.'/elephant.ttf';
    }

	/**
	 *	@description create code form rand number
	 *  @param none
	 *  @return none
	 */
    private function _createCode() 
	{
        $_len = strlen($this->_charset)-1;
        for ($i=0;$i<$this->_codelen;$i++) {
            $this->_code .= $this->_charset[mt_rand(0,$_len)];
        }
    }

	
    private function _createBg() 
	{
        $this->_img = imagecreatetruecolor($this->_width, $this->_height);
        $color = imagecolorallocate($this->_img, mt_rand(157,255), mt_rand(157,255), mt_rand(157,255));
        imagefilledrectangle($this->_img,0,$this->_height,$this->_width,0,$color);
    }

    
    private function _createFont() 
	{    
        $_x = $this->_width / $this->_codelen;
        for ($i=0;$i<$this->_codelen;$i++) {
            $this->_fontcolor = imagecolorallocate($this->_img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
            imagettftext($this->_img,$this->_fontsize,mt_rand(-30,30),$_x*$i+mt_rand(1,5),$this->_height / 1.4,$this->_fontcolor,$this->_font,$this->_code[$i]);
        }
    }


    private function _createLine() 
	{
        for ($i=0;$i<6;$i++) {
            $color = imagecolorallocate($this->_img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
            imageline($this->_img,mt_rand(0,$this->_width),mt_rand(0,$this->_height),mt_rand(0,$this->_width),mt_rand(0,$this->_height),$color);
        }
        for ($i=0;$i<100;$i++) {
            $color = imagecolorallocate($this->_img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
            imagestring($this->_img,mt_rand(1,5),mt_rand(0,$this->_width),mt_rand(0,$this->_height),'*',$color);
        }
    }

    
    private function _outPut($strFileName, $strPath="") 
	{
		
		$path = $strPath;
		if($path=="")
		{
			$path = $this->_path;
		}
		$filePath = $path .'/'.$strFileName;
        header('Content-type:image/png');
        imagepng($this->_img,$filePath);
		//在这里已经释放了图片资源
        imagedestroy($this->_img);
		
    }
	
	/**
	 *	@description get the captcha image
	 *  @param string $strFileName the name of the image 
	 *  @param string $strPath the path of the image  .default is the root path
	 *  @return none
	 */
    
    public function createImage($strFileName, $strPath="") {
        $this->_createBg();
        $this->_createCode();
        $this->_createLine();
        $this->_createFont();
        $this->_outPut($strFileName ,$strPath);
		unset($this->_font);
    }

    /**
	 *	@description get the image code
	 *  @param none
	 *  @return string the code on the image
	 */
    public function getCode() {
        return strtolower($this->_code);
    }
	
}