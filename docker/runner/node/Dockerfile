FROM node

COPY docker/runner/node/entrypoint.sh /entrypoint.sh

USER node

WORKDIR /var/www

EXPOSE 4200

ENTRYPOINT ["/bin/bash", "/entrypoint.sh"]
