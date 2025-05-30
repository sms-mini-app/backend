FROM nginx/unit:1.27.0-php8.1
ARG docker_env
RUN apt-get -y update
RUN apt-get -y install git
RUN apt-get install zip unzip
RUN apt-get install -y supervisor

#install pdo_mysql
# Install Extension PHP Easy Installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN install-php-extensions \
    pdo \
    pdo_mysql \
    http \
    gd \
    zip
#install opcache
RUN if [ "$docker_env" != "dev" ] ; then install-php-extensions opcache ; else echo skip opcache ; fi

#install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#cd /app
WORKDIR /app

ADD composer.lock composer.json /app/
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-plugins --no-scripts && \
    composer clear-cache

ADD --chown=unit:unit yii /app/
ADD --chown=unit:unit web /app/web/
ADD --chown=unit:unit src /app/src/
ADD --chown=unit:unit config /app/config

COPY --chown=unit:unit .env-dist ./.env
COPY unit.conf.json /docker-entrypoint.d/.unit.conf.json

RUN mkdir -p runtime web/assets && \
    chmod -R 775 runtime web/assets && \
    chown -R unit:unit runtime web/assets

CMD ["unitd", "--no-daemon", "--control", "unix:/var/run/control.unit.sock"]
EXPOSE 80
