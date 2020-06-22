#!/usr/bin/env python3
# 入乡随俗，使用下划线命名
import json
import re
import sys
from urllib.request import Request
from urllib.request import urlopen


def get_argument(name , defaultValue = None) :
    """
    获取参数
    :param name:
    :param defaultValue:
    :return:
    """
    indexOf = sys.argv.index(name)
    if indexOf + 1 < len(sys.argv) :
        return sys.argv[ indexOf + 1 ]

    return defaultValue


def get_hitokoto(api_url) :
    """
    获取一言
    :param api_url:
    :return:
    """
    return json.loads(urlopen(api_url).read().decode())


def post_with_json(robot_url , data) :
    """
    推送到钉钉
    :param robot_url:
    :param data:
    :return:
    """
    data = bytes(data , 'utf8')
    pushed = urlopen(Request(
        robot_url , headers = { 'Content-Type' : 'application/json;charset=utf-8' } , data = data
    ))

    return json.loads(pushed.read().decode('utf-8'))


def make_data(source , creator , sentence) :
    """
    组合数据
    :param source:
    :param creator:
    :param sentence:
    :return:
    """
    return json.dumps({
        'msgtype' : 'markdown' ,
        'markdown' : {
            'title' : '一言' ,
            'text' : "**%s** \n > %s「%s」" % (sentence , creator , source) ,
        }
    })


if __name__ == '__main__' :
    api_url = get_argument('--api-url')
    pattern = re.compile(r'^https?://')

    if pattern.match(api_url) is None :
        print('--api-url must be url')
        exit(127)

    robot_url = get_argument('--robot-url')
    if robot_url is None :
        print('--robot-url is required')
        exit(126)

    if pattern.match(robot_url) is None :
        print('--robot-url must be url')
        exit(125)

    hitokoto = get_hitokoto(api_url)
    response = post_with_json(
        robot_url , make_data(hitokoto[ 'from' ] , hitokoto[ 'creator' ] , hitokoto[ 'hitokoto' ])
    )

    if response[ 'errcode' ] != 0 :
        print(response[ 'errmsg' ])
        exit(response[ 'errcode' ])

    print('success')
