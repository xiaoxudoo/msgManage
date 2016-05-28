<?php
namespace App\Http\Controllers\Common;
use Mockery\CountValidator\Exception;

/**
 * Created by PhpStorm.
 * User: durx
 * Date: 2016/3/11
 * Time: 14:26
 */
class ToolUtil
{
    //代码有问题，注释掉。
//    public function getFiles($dir,$fileArr)
//    {
//        if(!is_dir($dir) || $fileArr == null){
//            return null;
//        }
//        $handle = opendir($dir);
//        while(($file = readdir($handle)) != false){
//            if($file == "." || $file=="..")
//            {
//                continue;
//            }
//            $file = $dir.DIRECTORY_SEPARATOR.$file;
//            if(is_file($file))
//            {
//               array_push($fileArr,$file);
//                echo "输出文件数组中的内容";
//                var_dump($fileArr);
//            }elseif(is_dir($file))
//            {
//                $this->getFiles($file,$fileArr);
//            }
//        }
//        closedir($dir);
//    }

public function  getFiles($dir)
{
    if(!(is_dir($dir)))
    {
        return;
    }
    if($dh=opendir($dir))
    {
        $fileArr = array();
        while(($file=readdir($dh))!==false)
        {
              echo $dir.$file;
        }
    }


}
    /**
     * 根据输入的文件名字，构造文件的目录，这里只对\resources\files目录下的文件适用
     * @param $fileName
     * @return null|string
     */
    public function getFilePath($fileName)
    {
        if($fileName == null || empty($fileName))
        {
            return null;
        }
        $currentPath = getcwd();
        $filePath = dirname($currentPath)."/public/files/".$fileName;
        return $filePath;
    }

    public function trimall($str)//删除空格
    {
        $source=array(' ','　','\t','\n','\r');
        $result=array('','','','','');
        if(empty($result)){
            return "";
        }
        return str_replace($source,$result,$str);
    }

    /**
     * 功能，封装了一下，兼容windows与linux的文件的换行符
     * @param $splitTag
     * @param $content
     * @return array
     * Created by durx.
     */
    public static function  explode($splitTag,$content){
        if($splitTag == "\r\n"){
            $os = php_uname();
            if(strstr($os,"Windows")){
                $lineArr = explode("\r\n",$content);
            }else{//默认是linux操作系统
                $lineArr = explode("\n",$content);
            }
        }else{
            $lineArr = explode($splitTag,$content);
        }
        return $lineArr;
    }
    public static function   arr_split_zh($tempaddtext){
        if(empty($tempaddtext)){
            return;
        }
        try{
            $tempaddtext = iconv("UTF-8", "GBK//IGNORE", $tempaddtext);
        }catch (Exception $e){
            WriteLog::writeLog(__FILE__,__LINE__,"输入的参数中含有非法字符","ERROR");
            return;
        }

        $cind = 0;
        $arr_cont=array();

        for($i=0;$i<strlen($tempaddtext);$i++)
        {
            if(strlen(substr($tempaddtext,$cind,1)) > 0){
                if(ord(substr($tempaddtext,$cind,1)) < 0xA1 ){ //如果为英文则取1个字节
                    array_push($arr_cont,substr($tempaddtext,$cind,1));
                    $cind++;
                }else{
                    array_push($arr_cont,substr($tempaddtext,$cind,2));
                    $cind+=2;
                }
            }
        }
        foreach ($arr_cont as &$row)
        {
//            $row=iconv("gb2312","UTF-8",$row);
            try{
                $row=iconv("GBK","UTF-8",$row);
            }catch (Exception $e){
                WriteLog::writeLog(__FILE__,__LINE__,"输入的参数中含有非法字符","ERROR");
                return;
            }
        }
        return $arr_cont;
    }
    public static function  getPrefix($text){
        if(empty($text)){
            return;
        }
        $prefixArr = array();
       $charArr = self::arr_split_zh($text);
        $count = count($charArr);
        for($i = 0; $i < $count; $i++){
            $prefix = "";
            for($j = 0; $j <= $i; $j++){
                $prefix = $prefix.$charArr[$j];
            }
            $prefixArr[] = $prefix;
        }
        return $prefixArr;
    }
}