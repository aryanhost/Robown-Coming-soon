Install Apache2 HTTP Server:
	sudo apt install apache2
	sudo sed -i "s/Options Indexes FollowSymLinks/Options FollowSymLinks/" /etc/apache2/apache2.conf
	sudo systemctl stop apache2.service
	sudo systemctl start apache2.service
	sudo systemctl enable apache2.service
Install MariaDB Server:
	sudo apt-get install mariadb-server mariadb-client -y
	sudo systemctl stop mariadb.service
	sudo systemctl start mariadb.service
	sudo systemctl enable mariadb.service
Secure MariaDB server:
	sudo mysql_secure_installation
	sudo systemctl restart mariadb.service
Install PHP and Related Modules:
	sudo apt-get install software-properties-common -y
	sudo add-apt-repository ppa:ondrej/php
	sudo apt update
	sudo apt install php7.4 libapache2-mod-php7.4 php7.4-common php7.4-mbstring php7.4-xmlrpc php7.4-soap 	php7.4-apcu php7.4-smbclient php7.4-ldap php7.4-redis php7.4-gd php7.4-xml php7.4-intl php7.4-json php	7.4-imagick php7.4-mysql php7.4-cli php7.4-mcrypt php7.4-ldap php7.4-zip php7.4-curl -y
Create OwnCloud Database:
	sudo mysql -u root -p
	CREATE DATABASE owncloud;
	CREATE USER 'ownclouduser'@'localhost' IDENTIFIED BY 'password_here';
	GRANT ALL ON owncloud.* TO 'ownclouduser'@'localhost' IDENTIFIED BY 'password_here' WITH GRANT OPTION;
	FLUSH PRIVILEGES;
	EXIT;
Download Latest OwnCloud Release:
	cd /tmp && wget https://download.owncloud.org/community/owncloud-10.0.8.zip
	unzip owncloud-10.0.8.zip
	sudo mv owncloud /var/www/html/owncloud/
Permissions for OwnCloud to function:
	sudo chown -R www-data:www-data /var/www/html/owncloud/
	sudo chmod -R 755 /var/www/html/owncloud/
Configure Apache2:
	sudo nano /etc/apache2/sites-available/owncloud.conf
	<VirtualHost *:80>
     ServerAdmin admin@example.com
     DocumentRoot /var/www/html/owncloud/
     ServerName avoiderrors.com
     ServerAlias www.avoiderrors.com
  
     Alias /owncloud "/var/www/html/owncloud/"

     <Directory /var/www/html/owncloud/>
        Options +FollowSymlinks
        AllowOverride All
        Require all granted
          <IfModule mod_dav.c>
            Dav off
          </IfModule>
        SetEnv HOME /var/www/html/owncloud
        SetEnv HTTP_HOME /var/www/html/owncloud
     </Directory>

     ErrorLog ${APACHE_LOG_DIR}/error.log
     CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>

Enable the OwnCloud and Rewrite Module:
	sudo a2ensite owncloud.conf
	sudo a2enmod rewrite
	sudo a2enmod headers
	sudo a2enmod env
	sudo a2enmod dir
	sudo a2enmod mime
Restart Apache2:
	sudo systemctl restart apache2.service
Access Owncloud from the LAN:
	http://LANIP/owncloud
        
