# Author: Markurion

# Pull the base image
FROM node:18.3.0-alpine3.14 as build-stage

# Set working dir
WORKDIR /app

# Copy package.json and json-lock.json
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy all files
COPY . .

# Build app
RUN npm run build && npm run generate

# nginex for content serving
FROM nginx:1.21.1-alpine as production-stage

# remove default nginex config
RUN  rm -rf /usr/share/nginx/html*

# Copy nginx config
COPY nginx/default.conf /etc/nginx/conf.d

# Copy static files from build stage
COPY --from=build-stage /app/dist /usr/share/nginx/html

EXPOSE 80

CMD [ "nginx", "-g", "daemon off;" ]