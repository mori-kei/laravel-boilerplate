FROM node:18.13.0

WORKDIR /frontend

COPY package.json ./
COPY yarn.lock ./

RUN yarn install

COPY ./ ./

EXPOSE 8080
CMD ["yarn", "serve"]