#!/bin/bash

echo "Creating symbolic link /workspace to $(pwd)"
ln -s "$(pwd)" /workspace

php-fpm -D
service nginx start

host=$(jq -r '.hostname' config.json)

if ! grep -qF "$host" "/etc/hosts"; then
    echo "$host" >> "/etc/hosts"
fi

echo 127.0.0.1 "$host" >> /etc/hosts

rm -rf html
mkdir -p html

function curl_and_save() {
  echo Hitting URL "$1"
  curl -k "$1" > "$2"

  # Check if the file exists and is not zero bytes
  if [[ ! -s $2 ]]; then
      echo "Error: The file does not exist or is zero bytes."
      exit 1
  fi

  # Check if the file is missing the specific text string
  if ! grep -q "<!-- Built with Ata's SSG https://www.github.com/atas/ssg -->" "$2"; then
      echo "Error: The file does not contain the attribution HTML comment OR something else is wrong in the output. As the MIT license requirement, please do not remove it to help other fellow developers discover this neat tool."
      exit 1
  fi
}

curl_and_save "https://$host/" "html/index.html"

# generate html from all md files at pages directory
for file in pages/*.md; do
  filename=$(basename "$file" .md)
  curl_and_save "https://$host/$filename" "html/$filename.html"
done

# generate html from all php files at home directory except index.php, page.php and post.php
for file in *.php; do
  if [[ "$file" != "index.php" && "$file" != "page.php" && "$file" != "post.php" ]]; then
    filename=$(basename "$file" .php)
    curl_and_save "https://$host/$filename" "html/$filename.html"
  fi
done

# generate html from all md files at posts directory
mkdir -p html/p
for file in posts/*.md; do
  filename=$(basename "$file" .md)
  slug=$(awk -F': ' '/^slug:|^[ \t]*"slug":/ {gsub(/["\r]/, "", $2); print $2}' $file)
  curl_and_save "https://$host/p/$slug" "html/p/$slug.html"
done

cp -R assets html/assets
lessc html/assets/styles/style.less html/assets/styles/style.css

rm -f html/assets/styles/*.less

cp robots.txt html/
