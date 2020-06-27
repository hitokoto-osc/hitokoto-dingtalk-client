# php 版本
php: dingtalk.php
	chmod +x ./dingtalk.php
	./dingtalk.php --api-url $(api-url) --robot-url $(robot-url)

# linux shell 版本
linux-shell: dingtalk.sh
	chmod +x ./dingtalk.sh
	./dingtalk.sh --api-url $(api-url) --robot-url $(robot-url)

# nodejs 版本
nodejs: dingtalk.js
	chmod +x ./dingtalk.js
	./dingtalk.js --api-url $(api-url) --robot-url $(robot-url)

# python 版本
python: dingtalk.py
	chmod +x ./dingtalk.py
	./dingtalk.py --api-url $(api-url) --robot-url $(robot-url)

# golang 版本
golang: dingtalk.go
	go run ./dingtalk.go --api-url $(api-url) --robot-url $(robot-url)

# javascript 版本
javascript: dingtalk.html
	open dingtalk.html || xed-open dingtalk.html

# java 版本
java: Dingtalk.java
	mkdir /tmp/hitokoto && cd /tmp/hitokoto
	javac Dingtalk.java && java Dingtalk

# C 版本
c: dingtalk.c
	gcc -std=gnu99 ./dingtalk.c -o /tmp/hitokoto-dingtalk-client
	chmod +x /tmp/hitokoto-dingtalk-client
	/tmp/hitokoto-dingtalk-client

# 清理临时文件
clean:
	rm -rf /tmp/hitokoto /tmp/hitokoto-* || exit 0
