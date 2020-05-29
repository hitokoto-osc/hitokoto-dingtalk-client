#!/usr/bin/php
<?php

/**
 * 获取和检查URL
 */
function getArg ($arg) {
    $argv = $GLOBALS['_SERVER']['argv'];
    if (in_array($arg , $argv)) {
        $apiUrlIndex = array_search($arg ,$argv) + 1;
        if (isset($argv[$apiUrlIndex])) {
            return $argv[$apiUrlIndex];
        }
    }
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
 * @return array
 * @copyright ©Alex (System.out.println.org and use TLS). All rights reserved.
 */
function makeData($source , $creator , $sentence)
{
    return [
        'msgtype'  => 'markdown' ,
        'markdown' => [
            'title' => '一言' ,
            'text'  => <<<TEXT
**{$sentence}**

> {$creator}「{$source}」
TEXT
            ,
        ] ,
    ];
}

/**
 * 请求钉钉
 *
 * @param       $uri
 * @param       $data
 * @return mixed
 * @copyright ©Alex (System.out.println.org and use TLS). All rights reserved.
 */
function postWithJson($uri , $data)
{
    $ch = curl_init();
    curl_setopt($ch , CURLOPT_URL , $uri);
    curl_setopt($ch , CURLOPT_POST , 1);
    curl_setopt($ch , CURLOPT_CONNECTTIMEOUT , 5);
    curl_setopt($ch , CURLOPT_HTTPHEADER , ['Content-Type: application/json;charset=utf-8']);
    curl_setopt($ch , CURLOPT_POSTFIELDS , json_encode($data));
    curl_setopt($ch , CURLOPT_RETURNTRANSFER , true);
    $data = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($data);
}

// 钉钉群机器人 URL
$robotUrl = getArg('--robot-url');
if ($robotUrl === null) {
    exit('--robot-url is required');
}

// 一言API地址
$apiUrl = getArg('--api-url') ?? 'https://v1.hitokoto.cn/#';

// 请求
$hitokoto = getHitokoto($apiUrl);
// 构造 markdown 和发送到钉钉
$result   = postWithJson(
    $robotUrl , 
    makeData($hitokoto->from , $hitokoto->creator , $hitokoto->hitokoto)
);

// 判断响应
if ($result->errcode !== 0) {
    exit($result->errmsg . PHP_EOL);
}

exit('success');
