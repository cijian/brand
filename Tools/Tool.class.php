<?php
/**
 * Created by PhpStorm.
 * User: cijian
 * Date: 2018/8/27
 * Time: 下午6:16
 */

/**
 * @param $path
 */
namespace Tools;

class Tool{
    /**
     * @param string $csv_file
     * @param int $length 必须大于 CVS 文件内最长的一行。在 PHP 5 中该参数是可选的。如果忽略（在 PHP 5.0.4 以后的版本中设为 0）该参数的话，那么长度就没有限制，不过可能会影响执行效率
     * @param int $start
     * @param int $line
     * @return array|bool
     */
    function read_csv_lines($csv_file = '',$length = 0,$start = 0,$line = 0)
    {
        //set auto_detect_line_endings to deal with Mac line ending
//        ini_set('auto_detect_line_endings',TRUE);


        if (!$handle = fopen($csv_file, 'r')) {
            return false;
        }

        $i = 0;
        //设置区间 指针偏移行数
        if($start != 0){
            while (false !== ($lines = fgets($handle))) {
                if(++$i < $start) {
                    continue;
                }
                break;
            }
        }


//        $i = $i===0??0;
        $i = 0;
        $data = array();

        while (($csv = fgetcsv($handle, $length)) !== FALSE && ($line == 0 || $i++<$line)) {
            $num = count($csv);
            if($num == 2){
                $data[$csv[0]] = $csv[1];
            }else{
                unset($csv[0]);
                $data[$csv[0]] = array_values($csv);
            }

        }

        fclose($handle);
//        ini_set('auto_detect_line_endings',FALSE);

        return $data;
    }


    function getFirstString($str){

//        $first = mb_substr($str,0,1);  //第一个字母是英文就不用了
        $first = substr($str,0,1);
        return strtoupper($first);

    }
}


