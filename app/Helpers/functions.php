<?php
function get_image_url($path){
    if (URL::isValidUrl($path)) {
        return $path;
    }
    return Storage::disk(config('admin.upload.disk'))->url($path);
}

/**
 * 生成邀请码
 * @param $user_id
 * @return string
 */
function createInvitationCode($user_id) {

    static $source_string = 'Z1AQXSW23CDERFV4T5GBNHJMY6U7IKLO98P';

    $num = $user_id;

    $code = '';

    while ( $num > 0) {

        $mod = $num % 35;

        $num = ($num - $mod) / 35;

        $code = $source_string[$mod].$code;

    }

    if(empty($code[6]))

        $code = str_pad($code,7,'0',STR_PAD_LEFT);

    return $code;

}

/**
 * 解码邀请码
 * @param $code
 * @return float|int
 */
function decodeInvitationCode($code) {

    static $source_string = 'Z1AQXSW23CDERFV4T5GBNHJMY6U7IKLO98P';

    if (strrpos($code, '0') !== false)

        $code = substr($code, strrpos($code, '0')+1);

    $len = strlen($code);

    $code = strtoupper(strrev($code));

    $num = 0;

    for ($i=0; $i < $len; $i++) {

        $num += strpos($source_string, $code[$i]) * pow(35, $i);

    }

    return $num;

}

/**
 * 数组 转 对象
 *
 * @param array $arr 数组
 * @return object
 */
function array_to_object($arr) {
    if (gettype($arr) != 'array') {
        return;
    }
    foreach ($arr as $k => $v) {
        if (gettype($v) == 'array' || getType($v) == 'object') {
            $arr[$k] = (object)array_to_object($v);
        }
    }

    return (object)$arr;
}

/**
 * 对象 转 数组
 *
 * @param object $obj 对象
 * @return array
 */
function object_to_array($obj) {
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)object_to_array($v);
        }
    }

    return $obj;
}
