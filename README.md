# hitokoto-dingtalk-client
> 获取一句 [hitokoto](https://github.com/hitokoto-osc) 并推送到钉钉群，给无聊的工作增加一点乐趣

## 开发计划
- [x] php
- [x] linux shell
- [x] nodejs
- [ ] python
- [ ] golang
- [ ] javascript

## 参数
- `--api-url` 为 `hitokoto api` 或其镜像接口地址
- `--robot-url` 为[钉钉机器人](https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq)链接

## 调用示例

*php*
```shell
$ chmod +x ./dingtalk.php
$ ./dingtalk.php [--api-url https://v1.hitokoto.cn] --robot-url https://oapi.dingtalk.com/robot/xxxxx
```

*shell*
> 目前仅支持定义 --robot-url

```shell
$ chmod +x ./dingtalk.sh
$ ./dingtalk.sh --robot-url https://oapi.dingtalk.com/robot/xxxxx
```

*nodejs*

```shell
$ chmod +x ./dingtalk.js
$ ./dingtalk.js [--api-url https://v1.hitokoto.cn] --robot-url https://oapi.dingtalk.com/robot/xxxxx
```

## 调用效果
![-w500](https://alextech-1252251443.cos.ap-guangzhou.myqcloud.com/2020/05-28-15906541899926.jpg)
