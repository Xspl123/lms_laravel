#use an official PHP runtime as a parent image
FROM php:7.3-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html/lms_laravel

# Copy the Laravel application files into the container
#COPY /var/www/html/lms_laravel
COPY . .


# Install any dependencies your application requires
#RUN yum update
# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel dependencies
RUN composer install --no-interaction --no-scripts --no-plugins

# Set permissions
#RUN chown -R www-data:www-data storage bootstrap/cache

# Set the Apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Enable Apache rewrite module
RUN a2enmod rewrite

# Expose port 80 for the web server
EXPOSE 80

# Run any additional commands your application requires
RUN composer dump-autoload

# Start the web server
CMD ["apache2-foreground"]

