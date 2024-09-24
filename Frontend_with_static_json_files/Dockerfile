# Author: Markurion
# https://markus.oberlehner.net/blog/running-nuxt-3-in-a-docker-container/

ARG PORT=3000
ARG NODE_VERSION=18.14.2

# Build stage
FROM node:${NODE_VERSION}-slim AS build
ENV NODE_ENV=production

# Set working dir
WORKDIR /src

# Copy package.json and package-lock.json
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy all files
COPY . .

# Build app
RUN npm run build

# Run stage
FROM node:${NODE_VERSION}-slim AS base
ENV NODE_ENV=production

# Set working dir
WORKDIR /src

# Copy built files from build stage
COPY --from=build /src/.output /src/.output
# Optional, only needed if you rely on unbundled dependencies
# COPY --from=build /src/node_modules /src/node_modules

ENV PORT=$PORT
CMD [ "node", ".output/server/index.mjs" ]

# # Copy package.json and json-lock.json
# COPY package*.json ./

# # Install dependencies
# RUN npm install

# # Copy all files
# COPY . .

# # Build app
# RUN npm run build && npm run generate

# # nginex for content serving
# FROM nginx:1.21.1-alpine as production-stage

# # remove default nginex config
# RUN  rm -rf /usr/share/nginx/html*

# # Copy nginx config
# COPY nginx/default.conf /etc/nginx/conf.d

# # Copy static files from build stage
# COPY --from=build-stage /app/dist /usr/share/nginx/html

# EXPOSE 80

# CMD [ "nginx", "-g", "daemon off;" ]