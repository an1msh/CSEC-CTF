FROM php:7.4-apache

# Expose ports for external access
EXPOSE 80

# Install the MySQL Server
RUN apt-get update
RUN apt-get install -y mariadb-server
RUN docker-php-ext-install mysqli

#Install the wkhtmltopdf
RUN apt-get install -y wkhtmltopdf

# Copy the public folder into the apache folder
ADD public /var/www/html/

#Sudo permission to wkhtmltopdf
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html
RUN echo "www-data ALL=(ALL:ALL) ALL" >> /etc/sudoers

#Mysql tings
#ADD mysql_startup.sh /usr/local/bin/
#RUN chmod +x /usr/local/bin/mysql_startup.sh

# Set the entrypoint of the docker container to start mariadb and run apache
COPY entrypoint.sh /
RUN chmod +x /entrypoint.sh
COPY sqlInitialise.sql /
ENTRYPOINT ["/bin/bash", "/entrypoint.sh"]
