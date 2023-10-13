#!/bin/bash

echo "Creating symbolic link /workspace to $(pwd)"
ln -s "$(pwd)" /workspace

# Check if php-fpm is running
if ! pgrep "php-fpm" > /dev/null; then
    php-fpm -D
fi

# Check if nginx is running
if ! pgrep "nginx" > /dev/null; then
    service nginx start
fi

hostname=$(jq -r '.hostname' config.json)

if ! grep -qF "$hostname" "/etc/hosts"; then
    echo "$hostname" >> "/etc/hosts"
fi

echo 127.0.0.1 "$hostname" >> /etc/hosts

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

curl_and_save "https://$hostname/" "html/index.html"

#region Building HTML files
rm -rf html
mkdir -p html

# pages/*.md HTML BUilding
for file in pages/*.md; do
  filename=$(basename "$file" .md)
  curl_and_save "https://$hostname/$filename" "html/$filename.html"
done

# posts/*.md HTML Building
mkdir -p html/p
for file in posts/*.md; do
  filename=$(basename "$file" .md)
  slug=$(awk -F': ' '/^slug:|^[ \t]*"slug":/ {gsub(/["\r]/, "", $2); print $2}' $file)
  curl_and_save "https://$hostname/p/$slug" "html/p/$slug.html"
done

# **/*.php Any php file HTML Building
find . -name "*.php" ! -path "./system/*" | while read -r file; do
    if [[ "$file" == "index.php" || "$file" == "page.php" || "$file" != "post.php" ]]; then
      continue;
    fi

    without_extension="${file%.*}"
    # Replace the .php extension with .txt
    html_file="html/${file%.php}.html"

    # Create the directory structure if it doesn't exist
    mkdir -p "$(dirname "$html_file")"

    filename=$(basename "$file" .php)
    curl_and_save "https://$hostname/$without_extension" "$html_file"
done

#endregion

# ./assets/* copying to ./html
cp -R assets html/assets
# Build CSS
lessc html/assets/styles/style.less html/assets/styles/style.css
# Remove .less as .css file is built
rm -f html/assets/styles/*.less
# Robots.txt is good to have
cp robots.txt html/
