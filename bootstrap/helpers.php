<?php

/**
 * 路由name 转换成class  user.index user-index
 * @return mixed
 */
function route_class()
{
    return str_replace('.','-',Route::currentRouteName());
}