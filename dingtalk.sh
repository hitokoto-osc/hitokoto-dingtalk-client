#!/bin/bash

PATH="/bin:/sbin/:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/root/bin"
JSON_BODY=""
HITOKOTO_API="https://v1.hitokoto.cn/#"
DINGTALK_API=""

# 生成数据
function makeJsonBody() {
    JSON_BODY="{
\"msgtype\": \"markdown\",
\"markdown\": {
\"title\": \"一言\",
\"text\": \"${1}

> ${2}「${3}」\"
}}"
}

# 请求API，获取一言
getHitokoto() {
    curl --request GET -sL --output '/tmp/hitokoto-api-response' --url "$1"
}

# 请求钉钉
postWithJson() {
    curl -s -X POST -H "Content-Type: application/json;charset=utf-8" \
        -d "$JSON_BODY" \
        --url "$1"
}

# 获取参数
getArgs() {
    # 获取参数
    if [[ $1 == '--robot-url' ]]; then
        DINGTALK_API=$2
    fi

    [[ $DINGTALK_API == '' ]] && echo '--robot-url is required' && exit 2
}

if [[ ! -f /etc/redhat-release ]]; then
    echo 'CentOS only'
    exit
fi

getArgs $1 $2
getHitokoto "https://v1.hitokoto.cn/#"

if [[ -f /tmp/hitokoto-api-response ]]; then
    # 获取api结果，解析json
    from=$(grep -Po '(?<=from":").+?from' /tmp/hitokoto-api-response | sed 's/","from//')
    creator=$(grep -Po '(?<=creator":").+?creator_uid' /tmp/hitokoto-api-response | sed 's/","creator_uid//')
    sentence=$(grep -Po '(?<=hitokoto":").+?type' /tmp/hitokoto-api-response | sed 's/","type//')

    # 构造钉钉使用的body体
    makeJsonBody "$sentence" "$creator" "$from"

    # 推送到钉钉
    pushed=$(postWithJson "$DINGTALK_API")
    if [[ $(echo "$pushed" | grep '"errcode":0') == '' ]]; then
        echo $pushed
    else
        echo 'success !'
    fi
else
    echo "hitokoto api 请求失败"
    exit 2
fi
