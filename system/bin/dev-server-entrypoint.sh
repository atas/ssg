#!/bin/bash

# Check if php-fpm is running
if ! pgrep "php-fpm" > /dev/null; then
    php-fpm -D
fi

# Check if nginx is running
if ! pgrep "nginx" > /dev/null; then
    service nginx start
fi

echo "Dev server should be running at http://localhost:8001 or any other port if you changed the default."

tail -f /dev/null
