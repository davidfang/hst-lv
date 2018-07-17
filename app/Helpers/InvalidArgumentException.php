<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2018/7/17
 * Time: 下午2:43
 */

namespace App\Helpers;

/**
 * InvalidArgumentException represents an exception caused by invalid arguments passed to a method.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0.14
 */
class InvalidArgumentException extends \BadMethodCallException
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'Invalid Argument';
    }
}