hitokoto-dingtalk-client
========

> 获取一句 [hitokoto](https://github.com/hitokoto-osc) 并推送到钉钉群，给无聊的工作增加一点乐趣

## 依赖管理
为了减少三方依赖，本仓库提供的客户端均采用语言标准库能力，不依赖任何第三方库

## 开发计划

> 对外提供各种语言的版本，对内提供一致的api，方便感兴趣的朋友们进行二开

- [x] [php](https://github.com/hitokoto-osc/hitokoto-dingtalk-client/blob/master/dingtalk.php)
- [x] [linux shell](https://github.com/hitokoto-osc/hitokoto-dingtalk-client/blob/master/dingtalk.sh)
- [x] [nodejs](https://github.com/hitokoto-osc/hitokoto-dingtalk-client/blob/master/dingtalk.js)
- [x] [python](https://github.com/hitokoto-osc/hitokoto-dingtalk-client/blob/master/dingtalk.py)
- [x] [golang](https://github.com/hitokoto-osc/hitokoto-dingtalk-client/blob/master/dingtalk.go)
- [ ] javascript
- [ ] c

## 参数
- `--api-url` 为 `hitokoto api` 或其镜像接口地址
- `--robot-url` 为[钉钉机器人](https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq)链接

## 调用示例

- php 

```shell
$ chmod +x ./dingtalk.php
$ ./dingtalk.php [--api-url https://v1.hitokoto.cn] --robot-url https://oapi.dingtalk.com/robot/xxxxx
```

- shell
> 目前仅支持定义 --robot-url

```shell
$ chmod +x ./dingtalk.sh
$ ./dingtalk.sh --robot-url https://oapi.dingtalk.com/robot/xxxxx
```

- nodejs

```shell
$ chmod +x ./dingtalk.js
$ ./dingtalk.js [--api-url https://v1.hitokoto.cn] --robot-url https://oapi.dingtalk.com/robot/xxxxx
```

- python3

```shell
$ chmod +x ./dingtalk.py
$ ./dingtalk.py [--api-url https://v1.hitokoto.cn] --robot-url https://oapi.dingtalk.com/robot/xxxxx
```

- golang

```shell
$ go run ./dingtalk.go [--api-url https://v1.hitokoto.cn] --robot-url https://oapi.dingtalk.com/robot/xxxxx
```

## 调用效果
![-w500](https://alextech-1252251443.cos.ap-guangzhou.myqcloud.com/2020/05-28-15906541899926.jpg)
