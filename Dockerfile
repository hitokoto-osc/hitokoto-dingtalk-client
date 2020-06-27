FROM centos:centos8.1.1911

ARG robot_url

COPY dingtalk.sh /

RUN chmod +x dingtalk.sh && \
	echo ${robot_url} > /tmp/robot_url

CMD echo "/dingtalk.sh --robot-url `cat /tmp/robot_url` > /dev/stdout" | bash
