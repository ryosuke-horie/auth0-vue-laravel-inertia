# コンテナのベースとしてamazonlinux:2023を指定
FROM amazonlinux:2023

# nginxインストール
RUN dnf -y update
RUN dnf -y install nginx

# /etc/nginx/ssl ディレクトリが存在しない場合のみ作成
RUN if [ ! -d /etc/nginx/ssl ]; then mkdir -p /etc/nginx/ssl; fi

COPY ./ssl/server.crt /etc/nginx/ssl/server.crt
COPY ./ssl/server.key /etc/nginx/ssl/server.key
COPY ./ssl/server.password /etc/nginx/ssl/server.password

EXPOSE 5173

ENTRYPOINT ["/usr/sbin/nginx", "-g", "daemon off;"]
