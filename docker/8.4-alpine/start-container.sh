#!/usr/bin/env bash

# READ .env
APP_ENV=$(grep APP_ENV /app/.env | cut -d '=' -f2)

# EDIT PHP.INI
if [ "$APP_ENV" = "production" ]; then
    echo "Config OPcache: produção"
    sed -i 's/^opcache.validate_timestamps=.*/opcache.validate_timestamps=0/' /etc/php84/php.ini || echo "opcache.validate_timestamps=0" >> /etc/php84/php.ini
else
    echo "Config OPcache: desenvolvimento"
    sed -i 's/^opcache.validate_timestamps=.*/opcache.validate_timestamps=1/' /etc/php84/php.ini || echo "opcache.validate_timestamps=1" >> /etc/php84/php.ini
    sed -i 's/^opcache.revalidate_freq=.*/opcache.revalidate_freq=0/' /etc/php84/php.ini || echo "opcache.revalidate_freq=0" >> /etc/php84/php.ini
fi

# ADD FTP USER
if ! id "$FTP_USER" >/dev/null 2>&1; then
    echo "[vsftpd] Criando usuário $FTP_USER..."
    adduser -D -h "$FTP_HOME" -s /sbin/nologin "$FTP_USER"
    echo "$FTP_USER:$FTP_PASS" | chpasswd
    chown -R "$FTP_USER:$FTP_USER" "$FTP_HOME"
    rm -rf /etc/vsftpd/user_list
    echo "$FTP_USER" > /etc/vsftpd/user_list
    chmod 755 -R /etc/vsftpd/user_list
else
    echo "[vsftpd] Usuário $FTP_USER já existe."
fi

composer install --working-dir=/app
chmod 777 -R /app/storage/app/public
chmod 777 -R /app/storage/framework
chmod 777 -R /app/storage/logs
chmod 777 -R /app/bootstrap/cache

/usr/bin/php /app/artisan migrate --force
/usr/bin/php /app/artisan optimize:clear

sleep 5
/usr/bin/supervisord -c /etc/supervisor/supervisord.conf
