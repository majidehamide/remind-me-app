FROM node:latest
WORKDIR /app
COPY package.json /app/package.json
RUN npm install 
COPY . .
EXPOSE 3000
RUN npm run build
CMD ["npm", "run", "dev", "--","--host"]