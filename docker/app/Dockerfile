# コンテナのベースとしてamazonlinux:2023を指定
FROM amazonlinux:2023

RUN dnf -y update

RUN dnf -y install unzip \
    wget

# php、モジュール関連インストール
RUN dnf -y install php less php-intl \
    php-cli php-json php-common php-devel php-pear php-fpm \
    php-gd php-mbstring php-pdo php-xml php-pgsql \
    ImageMagick gcc ImageMagick-devel libzip libzip-devel && \
    pecl channel-update pecl.php.net && \
    pecl install imagick zip


# OpenAPI用のJavaのインストール
RUN cd /usr/local/ && \
    wget https://download.java.net/openjdk/jdk17/ri/openjdk-17+35_linux-x64_bin.tar.gz && \
    tar zxvf openjdk-17+35_linux-x64_bin.tar.gz && \
    rm openjdk-17+35_linux-x64_bin.tar.gz && \
    alternatives --install /usr/bin/java java /usr/local/jdk-17/bin/java 1 && \
    alternatives --install /usr/bin/javac javac /usr/local/jdk-17/bin/javac 1

# unix socket
RUN mkdir /var/run/php-fpm
VOLUME [ "/var/run/php-fpm" ]

# RUN echo 'short_open_tag = On' >> /etc/php.ini
# RUN echo 'date.timezone = Asia/Tokyo' >> /etc/php.ini
EXPOSE 9000

ENTRYPOINT /usr/sbin/php-fpm -F

# composerインストール
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN composer self-update

# nodeのインストール
RUN curl -fsSL https://rpm.nodesource.com/setup_20.x | bash - \
  && dnf -y install nodejs \
  && npm install -g npm@latest

# 作成されるファイル権限を777に固定
RUN umask 000

# コンテナのディレクトリ指定
WORKDIR /var/www/html
