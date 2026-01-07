# =============================================================================
# PHP 8.4 + Apache + Xdebug Dockerfile
# Optimiert für Apple Silicon (M4)
# =============================================================================

FROM php:8.4-apache

# -----------------------------------------------------------------------------
# System-Pakete installieren
# -----------------------------------------------------------------------------
RUN apt-get update && apt-get install -y --no-install-recommends \
    # Für PHP-Erweiterungen
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    # Nützliche Tools
    git \
    unzip \
    curl \
    vim \
    && rm -rf /var/lib/apt/lists/*

# -----------------------------------------------------------------------------
# PHP-Erweiterungen konfigurieren und installieren
# -----------------------------------------------------------------------------

# GD-Bibliothek mit allen Bildformaten
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp

# Standard PHP-Erweiterungen
RUN docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    mysqli \
    gd \
    zip \
    mbstring \
    xml \
    curl \
    intl \
    opcache \
    bcmath

# -----------------------------------------------------------------------------
# Xdebug installieren
# -----------------------------------------------------------------------------
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# -----------------------------------------------------------------------------
# Composer installieren
# -----------------------------------------------------------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Composer als root erlauben (nur für Entwicklung!)
ENV COMPOSER_ALLOW_SUPERUSER=1

# -----------------------------------------------------------------------------
# Apache konfigurieren
# -----------------------------------------------------------------------------

# mod_rewrite für .htaccess aktivieren
RUN a2enmod rewrite

# Document Root auf /httpdocs setzen
ENV APACHE_DOCUMENT_ROOT=/httpdocs

# Apache Virtual Host Konfiguration
COPY .docker/config/apache-vhost.conf /etc/apache2/sites-available/000-default.conf

# -----------------------------------------------------------------------------
# Arbeitsverzeichnis setzen
# -----------------------------------------------------------------------------
WORKDIR /httpdocs

# -----------------------------------------------------------------------------
# Container starten
# -----------------------------------------------------------------------------
EXPOSE 80

CMD ["apache2-foreground"]
