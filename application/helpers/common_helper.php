<?php


/**
 * 设置时区
 */
date_default_timezone_set('Asia/Shanghai');

/**
 * 日期时间戳
 */
if (!defined('TIMESTAMP')) {
    define('TIMESTAMP', time());
}

/**
 * 接口的统一输出方法
 * @param $success
 * @param array $data
 */
if (!function_exists('exitJson')) {

    function exitJson($success, $data = array())
    {
        if (empty($data)) {
            $data['msg'] = '成功';
        }

        $response = array(
            'success' => $success,
            'data' => $data,
        );

        echo json_encode((object)$response);
        exit;
    }
}

/**
 * p方法打印信息
 */
if (!function_exists('p')) {
    function p($obj = __LINE__, $flag = 0, $clear = FALSE)
    {
        if (isset($_SERVER['HTTP_HOST']) && strcasecmp($_SERVER['HTTP_HOST'], 'www.jxsvip.com') === 0) {
            return;
        }
        //0 print_r 2var_dump 4json 6text 8htmlspecialchars
        static $out_header = 0;
        if ($out_header == 0) {
            header("Content-Type: text/html; charset=utf-8");
        }
        $out_header++;

        ob_start();
        switch ($flag) {
            case 2:
            case 3:
                var_dump($obj);
                break;
                $obj = is_object($obj) ? _objectToArray($obj) : $obj;
            case 6:
            case 7:
                $dirname = 'ptestlog';
                if (!is_dir($dirname)) {
                    mkdir($dirname);
                }
                //date_default_timezone_set('Asia/Shanghai');
                $filename = $dirname . '/' . date('YmdHis') . '.txt';
                file_put_contents($filename, print_r($obj, TRUE));

            case 4:
            case 5:
                $obj = json_encode($obj);
            case 8:
            case 9:
                $obj = _array_htmlspecialchars($obj, ENT_QUOTES);
            default :
                print_r($obj);
                break;
        }
        $output = $clear ? ob_get_clean() : '<pre><div style="background:#fff;color:#000;border:1px dashed #f00;padding:20px;">' . ob_get_clean() . '</div></pre>';
        if ($flag % 2 == 1) {
            exit($output);
        } else {
            echo $output;
        }
    }
}

if (!function_exists('ll')) {
    /**
     * 载入类库文件 （参数参考:http://codeigniter.org.cn/user_guide/general/creating_libraries.html）
     *
     * @param string $library
     * @param $params
     * @param $object_name
     */
    function ll($library = '', $params = NULL, $object_name = NULL)
    {
        $CI = &get_instance();
        $CI->load->library($library, $params, $object_name);
    }
}

if (!defined('IMAGE_PREFIX')) {
    define('IMAGE_PREFIX', 'test/');
}