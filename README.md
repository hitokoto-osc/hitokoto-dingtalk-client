# hitokoto-dingtalk-client
> 获取一句 [hitokoto](https://github.com/hitokoto-osc) 并推送到钉钉群，给无聊的工作增加一点乐趣

**目前提供php版本客户端**
> *其他语言的版本正在积极开发中*

**开发计划**
- [x] php
- [ ] nodejs
- [ ] bash shell 
- [ ] golang 
- [ ] javascript

## 指南
> 各语言客户端的调用方法统一实现

**参数**
- `--api-url` 为 `hitokoto api` 或其镜像接口地址
- `--robot-url` 为钉钉群机器人链接

**调用示例**
```shell
$ ./dingtalk.php [--api-url https://v1.hitokoto.cn] --robot-url https://oapi.dingtalk.com/robot/xxxxx
```

## 其他

推荐使用使用定时任务调用