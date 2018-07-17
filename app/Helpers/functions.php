<?php
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

function decodeInvitationCode($code) {

    static $source_string = 'Z1AQXSW23CDERFV4T5GBNHJMY6U7IKLO98P';

    if (strrpos($code, '0') !== false)

        $code = substr($code, strrpos($code, '0')+1);

    $len = strlen($code);

    $code = strrev($code);

    $num = 0;

    for ($i=0; $i < $len; $i++) {

        $num += strpos($source_string, $code[$i]) * pow(35, $i);

    }

    return $num;

}
