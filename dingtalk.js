#!/usr/bin/env node
const https = require('https')

function getArgument(name , defaultValue = null)
{
    const index = process.argv.indexOf(name)
    if (index === -1) {
        return defaultValue
    }
    return process.argv[index + 1]
}

function getHitokoto(apiUrl)
{
    return new Promise((resolve , reject) => {
        https.get(apiUrl , res => {
            res.on('data' , data => resolve(JSON.parse(data.toString())))
        }).on('error' , e => reject(e.message))
    })
}

function makeData(source , creator , sentence)
{
    return JSON.stringify({
        'msgtype': 'markdown' ,
        'markdown': {
            'title': '一言' ,
            'text': `**${sentence}** \n > ${creator}「${source}」` ,
        } ,
    })
}

async function postWithJson(url , data)
{
    const uriParams = url.split('/robot/')
    const options   = {
        path: `/robot/${uriParams[1]}` ,
        hostname: uriParams[0].replace('https://' , '') ,
        method: 'POST' ,
        headers: {
            'Content-Type': 'application/json;charset=utf-8' ,
        } ,
    }

    return new Promise((resolve , reject) => {
        const request = https.request(options , response => {
            response.on('data' , data => resolve(JSON.parse(data)))
        })

        request.on('error' , e => reject(e.message))
        request.write(data)
        request.end()
    })
}

(async () => {
    const robotUrl = getArgument('--robot-url')
    if (!/^https?:\/\//.test(robotUrl)) {
        return console.error('--robot-url must be url')
    }

    let apiUrl = getArgument('--api-url' , 'https://v1.hitokoto.cn/#')
    if (!/^https?:\/\//.test(apiUrl)) {
        return console.error('--api-url must be url')
    }

    // 获取一言
    const hitokoto = await getHitokoto(apiUrl ? apiUrl : null)

    // 推送到钉钉
    const response = await postWithJson(
        robotUrl ,
        makeData(hitokoto.from , hitokoto.creator , hitokoto.hitokoto) ,
    )

    if (response.errcode !== 0) {
        return console.error(response.errmsg)
    }

    console.log('success')
})()
