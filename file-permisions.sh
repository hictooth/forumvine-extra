sudo chmod 666 config.php
sudo find . -type d -exec chmod 755 {} \;
sudo find . -type f -exec chmod 644 {} \;
sudo chmod 777 files cache store images/avatars/upload
sudo chown -R www-data:www-data .
