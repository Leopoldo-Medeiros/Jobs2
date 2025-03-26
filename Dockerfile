FROM php:8.3-fpm AS base

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libicu-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd
RUN docker-php-ext-install intl

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# Add user for application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

############################################
# Development Image
############################################
FROM base AS development

# Copy existing application directory contents
COPY . /var/www/html

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/html

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

############################################
# Production Image with New Relic
############################################
FROM base AS production

ARG NEW_RELIC_AGENT_VERSION=10.11.0.3
ARG NEW_RELIC_LICENSE_KEY
ARG NEW_RELIC_APPNAME="Laravel Application"

# Install New Relic PHP agent
RUN curl -L https://download.newrelic.com/php_agent/archive/${NEW_RELIC_AGENT_VERSION}/newrelic-php5-${NEW_RELIC_AGENT_VERSION}-linux.tar.gz | tar -C /tmp -zx \
    && export NR_INSTALL_USE_CP_NOT_LN=1 \
    && export NR_INSTALL_SILENT=1 \
    && /tmp/newrelic-php5-${NEW_RELIC_AGENT_VERSION}-linux/newrelic-install install \
    && rm -rf /tmp/newrelic-php5-* /tmp/nrinstall*

# Configure New Relic
RUN sed -i \
  -e "s/newrelic.license[[:space:]]*=[[:space:]]*.*/newrelic.license = ${NEW_RELIC_LICENSE_KEY}/" \
  -e "s/newrelic.appname[[:space:]]*=[[:space:]]*.*/newrelic.appname = ${NEW_RELIC_APPNAME}/" \
  -e "\$a newrelic.daemon.address=newrelic-php-daemon:31339" \
  /usr/local/etc/php/conf.d/newrelic.ini

# Configure New Relic logging
RUN echo "newrelic.application_logging.enabled = true" >> /usr/local/etc/php/conf.d/newrelic.ini
RUN echo "newrelic.application_logging.metrics.enabled = true" >> /usr/local/etc/php/conf.d/newrelic.ini
RUN echo "newrelic.application_logging.forwarding.enabled = true" >> /usr/local/etc/php/conf.d/newrelic.ini
RUN echo 'newrelic.application_logging.forwarding.log_level = "INFO"' >> /usr/local/etc/php/conf.d/newrelic.ini
RUN echo "newrelic.application_logging.forwarding.format_messages = false" >> /usr/local/etc/php/conf.d/newrelic.ini
RUN echo "newrelic.application_logging.forwarding.raw_data = true" >> /usr/local/etc/php/conf.d/newrelic.ini
RUN echo "newrelic.application_logging.forwarding.context_data.enabled = true" >> /usr/local/etc/php/conf.d/newrelic.ini
RUN echo "newrelic.application_logging.local_decorating.enabled = false" >> /usr/local/etc/php/conf.d/newrelic.ini
RUN echo "newrelic.distributed_tracing_enabled = true" >> /usr/local/etc/php/conf.d/newrelic.ini

# Optional but helpful if logs still need more debugging
RUN echo "newrelic.loglevel = info" >> /usr/local/etc/php/conf.d/newrelic.ini

# Create log directory for New Relic
RUN mkdir -p /var/log/newrelic
RUN chown www:www -R /var/log/newrelic

# Copy application files
COPY --chown=www:www . /var/www/html

# Install dependencies
USER www
RUN composer install --no-dev --optimize-autoloader

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"] 