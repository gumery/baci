<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

    /*
     * Shortcut for json_encode() with JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES
     * e.g. H("Hello, %s!", "world")
     *
     * @return string
     **/
    if (function_exists('J')) {
        die('J() was declared by other libraries, which may cause problems!');
    } else {
        function J($v, $opt = 0)
        {
            $opt |= JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

            return @json_encode($v, $opt);
        }
    }
