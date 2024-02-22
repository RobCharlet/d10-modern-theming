ARG BASE_IMAGE=ddev/webserver
FROM $BASE_IMAGE

### DDEV-injected extra content

RUN mkdir -p /home/$username && chown $username /home/$username && chmod 600 /home/$username/.pgpass
ENV NVM_DIR=/home/$username/.nvm
RUN npm install -g n
RUN n install 18 && ln -sf /usr/local/bin/node /usr/local/bin/nodejs
