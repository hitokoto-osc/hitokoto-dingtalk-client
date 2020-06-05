#!/usr/bin/env php
<?php

/**
 * 获取和检查URL
 *
 * @param      $arg
 * @param null $default
 * @return mixed
 */
function getArgument($arg , $default = null)
{
    $argv = $GLOBALS['_SERVER']['argv'];
    if (in_array($arg , $argv)) {
        return $argv[array_search($arg , $argv) + 1] ?? $default;
    }
    
    return $default;
}

/**
 * 请求API，获取一言
 *
 * @param $apiUrl
 * @return mixed
 * @copyright ©Alex (System.out.println.org and use TLS). All rights reserved.
 */
function getHitokoto($apiUrl)
{
    return json_decode(file_get_contents($apiUrl));
}

/**
 * 生成数据
 *
 * @param $source
 * @param $creator
 * @param $sentence
 * @return string
 * @copyright ©Alex (System.out.println.org and use TLS). All rights reserved.
 */
function makeData($source , $creator , $sentence)
{
    return json_encode([
        'msgtype'  => 'markdown' ,
        'markdown' => [
            'title' => '一言' ,
            'text'  => "**{$sentence}**
            
> {$creator}「{$source}」" ,
        ] ,
    ]);
}

/**
 * 请求钉钉
 *
 * @param       $uri
 * @param       $data
 * @return mixed
 * @copyright ©Alex (System.out.println.org and use TLS). All rights reserved.
 */
function postToDingtalk($uri , $data)
{
    $ch = curl_init();
    curl_setopt($ch , CURLOPT_URL , $uri);
    curl_setopt($ch , CURLOPT_POST , 1);
    curl_setopt($ch , CURLOPT_CONNECTTIMEOUT , 5);
    curl_setopt($ch , CURLOPT_HTTPHEADER , ['Content-Type: application/json;charset=utf-8']);
    curl_setopt($ch , CURLOPT_POSTFIELDS , $data);
    curl_setopt($ch , CURLOPT_RETURNTRANSFER , true);
    $data = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($data);
}

// 钉钉机器人 URL
$robotUrl = getArgument('--robot-url');
if (! preg_match('/^https?:\/\//' , $robotUrl)) {
    exit('--robot-url must be url');
}

// 一言API地址
$apiUrl = getArgument('--api-url' , 'https://v1.hitokoto.cn/#');
if (! preg_match('/^https?:\/\//' , $apiUrl)) {
    exit('--api-url must be url');
}

// 请求
$hitokoto = getHitokoto($apiUrl);
// 构造 markdown 和发送到钉钉
$result = postToDingtalk(
    $robotUrl ,
    makeData($hitokoto->from , $hitokoto->creator , $hitokoto->hitokoto)
);

// 判断响应
if ($result->errcode !== 0) {
    exit($result->errmsg . PHP_EOL);
}

exit('success');
