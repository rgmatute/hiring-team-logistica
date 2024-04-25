# Usar la imagen oficial de Node.js como base
FROM node:14-alpine as build

# Configurar el directorio de trabajo
WORKDIR /app

# Copiar los archivos del proyecto al contenedor
COPY . .

# Instalar las dependencias
RUN npm install

# Compilar la aplicación para producción
RUN npm run build

# Configurar Nginx
FROM nginx:alpine

# Copiar el resultado de la compilación de Vue.js al directorio de Nginx
COPY --from=build /app/dist /usr/share/nginx/html

# Exponer el puerto 80
EXPOSE 80
