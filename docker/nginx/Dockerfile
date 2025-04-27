FROM nginx:alpine
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY /src /var/www

CMD ["nginx", "-g", "daemon off;"]