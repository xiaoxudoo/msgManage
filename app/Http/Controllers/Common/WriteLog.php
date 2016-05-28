<?php
/**
 * Created by PhpStorm.
 * User: durx
 * Date: 2016/3/22
 * Time: 13:55
 */

namespace App\Http\Controllers\Common;


class WriteLog
{
  public static function writeLog($sg_code_file_name, $sg_line, $sg_content, $sg_level)
    {
        if($sg_code_file_name == NULL || $sg_line == NULL
            || $sg_content == NULL || $sg_level == NULL)
        {
            return -1;
        }

        $sg_fp = fopen("debug.log", "a");
        if($sg_fp === FALSE)
        {
            return -2;
        }

        $sg_date = date("Y-m-d H:i:s", time());

        $sg_ret = flock($sg_fp, LOCK_EX);
        if($sg_ret === TRUE)
        {
            fwrite($sg_fp, "[".$sg_date."][".$sg_code_file_name
                .":".$sg_line."][".$sg_level."]".$sg_content."\n");
            flock($sg_fp, LOCK_UN);
        }
        else
        {
            fclose($sg_fp);
            return -3;
        }

        fclose($sg_fp);
        return 0;
    }

}