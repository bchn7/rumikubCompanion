#!/bin/sh
set -e

# Change to the application directory
cd /var/www/html

# Optionally check if vendor and node_modules exist to avoid reinstalling unnecessarily
if [ ! -d vendor ]; then
  echo "Running Composer install..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

if [ ! -d node_modules ]; then
  echo "Running npm install..."
  npm install
fi

# Start asset building in watch mode.
# Ensure your package.json defines "dev" as a watcher (e.g., using Webpack Encore or Tailwind's CLI with --watch)
echo "Starting asset watcher (npm run dev)..."
npm run dev &

# Optionally, if you have a Symfony command for Tailwind build in watch mode, you could do:
# php bin/console tailwind:build --watch &

# Start PHP-FPM (this will be the main foreground process)
echo "Starting PHP-FPM..."
exec php-fpm
