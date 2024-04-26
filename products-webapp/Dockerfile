# Usar la imagen oficial de Node.js como base
FROM node:18-alpine as build

# Configurar el directorio de trabajo
WORKDIR /app

# Copiar los archivos del proyecto al contenedor
COPY . .

# Instalar las dependencias
RUN npm install --force

# Compilar la aplicación para producción
RUN npm run build

# Configurar Nginx
FROM nginx:stable-alpine

# Copiar el resultado de la compilación de Vue.js al directorio de Nginx
COPY --from=build /app/target/build /usr/share/nginx/html

RUN rm /etc/nginx/conf.d/default.conf
COPY docker/config/nginx/webapp.conf /etc/nginx/conf.d

# Exponer el puerto 80
EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
