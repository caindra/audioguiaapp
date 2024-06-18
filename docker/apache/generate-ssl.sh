#!/bin/bash

# Crear el directorio para los certificados
mkdir -p /etc/ssl/certs /etc/ssl/private

# Generar un certificado auto-firmado
openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/apache-selfsigned.key -out /etc/ssl/certs/apache-selfsigned.crt -subj "/C=US/ST=State/L=City/O=Organization/OU=Department/CN=localhost"
