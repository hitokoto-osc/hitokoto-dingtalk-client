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
- [ ] java
- [ ] c

## 命令行参数
- `--api-url` 为 `hitokoto api` 或其镜像接口地址
- `--robot-url` 为[钉钉机器人](https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq)链接

## 抽象编程 API

> 此处提供伪代码，实际命名规则与参数类型根据目标语言的约定而改变

|  api  | 参数 |  功能  |
|  ---- | ---- | ----  |
| get-argument(name , default) | 名称，默认值 | 获取命令行参数 |
| get-hitokoto(api-url) | 一言API地址或其镜像 | 获取一言 |
| post-with-json(robot-url , data) | 机器人API地址 |  推送到钉钉服务器 |
| make-data(source , creator , sentence) | 从哪里来，谁创建的，说了什么 | 构造发送给钉钉的数据 |

## 编译运行

所有版本均提供 `Makefile` 和命令行与两种运行方法。二者的区别为 `Makefile` 为编译型语言提供标准编译支持，命令行则需要自行编译

### Makefile

使用 `php`、`linux-shell`、`nodejs`、`python`、`golang` 中的任何一个，替换命令中的 *LANGUAGE* 或 *$language* 即可

```shell
$ language=LANGUAGE
$ make clean $language \
    api-url https://v1.hitokoto.cn \
    robot-url=https://oapi.dingtalk.com/robot/xxxxx
```

### 命令行
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


### *shell*
> shell 版本仅支持 centos，所以本仓库特别提供了基于 docker 的运行方法

- Makefile
```shell
$ make linux-shell-with-docker
```

- 命令行
```shell
$ docker build -t hitokoto/client:v1 . --build-arg robot_url=https://oapi.dingtalk.com/robot/xxxxx
$ docker run --rm hitokoto/client:v1
```

## 推送效果
![-w500](https://alextech-1252251443.cos.ap-guangzhou.myqcloud.com/2020/05-28-15906541899926.jpg)
