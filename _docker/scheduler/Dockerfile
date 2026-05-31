FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
      cron \
      libpq-dev \
      libzip-dev \
      zip unzip && \
      docker-php-ext-install pdo pdo_pgsql pgsql bcmath zip && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

RUN echo "* * * * * root cd /var/www/html && /usr/local/bin/php artisan schedule:run >> /var/log/cron.log 2>&1" \
    > /etc/cron.d/laravel-scheduler

RUN chmod 0644 /etc/cron.d/laravel-scheduler && \
    crontab /etc/cron.d/laravel-scheduler

RUN touch /var/log/cron.log

CMD ["cron", "-f"]
