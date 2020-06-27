package main

import (
    "bytes"
    "encoding/json"
    "fmt"
    "io"
    "io/ioutil"
    "net/http"
    "os"
    "regexp"
)

// 获取一言
func getHitokoto(url string) map[string]interface{} {
    response, error := http.Get(url)
    if error != nil {
        panic(error)
    }

    defer response.Body.Close()
    return json2Map(response.Body)
}

// 从命令行获取参数
func getArgument(name string, defaultValue string) string {
    args := os.Args[1:]
    length := len(args)
    for index, value := range args {
        if value == name {
            if index+1 <= length {
                return args[index+1]
            }
        }
    }

    return defaultValue
}

// 获取参数并设置默认值为空字符串
func getArgDefaultEmpty(name string) string {
    return getArgument(name, "")
}

// 将json数据从字节数组转换成map
func json2Map(jsonString io.Reader) map[string]interface{} {
    body, err := ioutil.ReadAll(jsonString)
    if err != nil {
        panic(err)
    }

    // 解析 json
    result := make(map[string]interface{})
    err = json.Unmarshal(body, &result)
    if err != nil {
        panic(err)
    }

    return result
}

// 发送json请求，向钉钉推数据
// 已知 url 和 json 都是合法的，忽略其它异常
func postWithJson(robotUrl string, data []byte) map[string]interface{} {
    request, _ := http.NewRequest("POST", robotUrl, bytes.NewBuffer(data))
    request.Header.Set("Content-Type", "application/json")

    client := &http.Client{}
    response, err := client.Do(request)
    if err != nil {
        panic(err)
    }

    defer response.Body.Close()

    return json2Map(response.Body)
}

// 构造推送向钉钉的数据
// 数据结构是清晰的，数据变量也是已知的，所以忽略错误
func makeData(source string, creator string, sentence string) []byte {
    jsonData, _ := json.Marshal(map[string]interface{}{
        "msgtype": "markdown",
        "markdown": map[string]string{
            "title": "一言",
            "text":  "**" + sentence + "** \n > " + creator + "「" + source + "」",
        },
    })

    return jsonData
}

func main() {
    // 构造正则，验证输入参数是否是合法的 url
    // 正则固定，忽略异常
    regs, _ := regexp.Compile("^https?://")

    apiUrl := getArgDefaultEmpty("--api-url")
    if !regs.MatchString(apiUrl) {
        fmt.Println("--api-url is required")
        os.Exit(127)
    }

    robotUrl := getArgDefaultEmpty("--robot-url")
    if !regs.MatchString(robotUrl) {
        fmt.Println("--robot-url must be url")
        os.Exit(125)
    }

    // 获取数据和推送到钉钉
    hitokoto := getHitokoto(apiUrl)
    response := postWithJson(robotUrl, makeData(
        hitokoto["from"].(string),
        hitokoto["creator"].(string),
        hitokoto["hitokoto"].(string),
    ))

    errCode := int(response["errcode"].(float64))
    if errCode != 0 {
        fmt.Println(response["errmsg"])
        os.Exit(errCode)
    }

    fmt.Println("success")
}
