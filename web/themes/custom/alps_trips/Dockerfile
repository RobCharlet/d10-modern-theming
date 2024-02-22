### DDEV-injected base Dockerfile contents
ARG BASE_IMAGE
FROM $BASE_IMAGE
SHELL ["/bin/bash", "-c"]

ARG username
ARG uid
ARG gid
ARG DDEV_PHP_VERSION
RUN (groupadd --gid $gid "$username" || groupadd "$username" || true) && (useradd  -l -m -s "/bin/bash" --gid "$username" --comment '' --uid $uid "$username" || useradd  -l -m -s "/bin/bash" --gid "$username" --comment '' "$username" || useradd  -l -m -s "/bin/bash" --gid "$gid" --comment '' "$username" || useradd -l -m -s "/bin/bash" --comment '' $username )

### DDEV-injected composer update
RUN export XDEBUG_MODE=off; composer self-update --stable || composer self-update --stable || true; composer self-update --2 || composer self-update --2 || true

### DDEV-injected extra content

RUN mkdir -p /home/$username && chown $username /home/$username && chmod 600 /home/$username/.pgpass
ENV NVM_DIR=/home/$username/.nvm
RUN npm install -g n
RUN n install 18 && ln -sf /usr/local/bin/node /usr/local/bin/nodejs


### From user Dockerfile /Users/Robin1/Travail/Drupal/Modernizing-Drupal-10-Theme-Development/.ddev/web-build/Dockerfile.ddev-browsersync:
#ddev-generated
RUN npm install -g browser-sync
