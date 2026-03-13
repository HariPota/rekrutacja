ARG PHP_TAG
FROM wodby/php:${PHP_TAG}

USER root

# Install Node.js, Yarn and SQLite CLI
RUN apk add --no-cache nodejs yarn sqlite

# pdo_sqlite is already compiled into wodby/php core

# Copy SQLite init script
COPY init-db.sh /usr/local/bin/init-db.sh
RUN chmod +x /usr/local/bin/init-db.sh

USER wodby
