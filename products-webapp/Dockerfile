# Usa la imagen oficial de Node.js
FROM node:20.12.1

# Establece el directorio de trabajo
WORKDIR /app

# Copia todo el proyecto al contenedor
COPY . .

# Instala las dependencias del proyecto
RUN npm install --force

# Expone el puerto 9000 para el servidor de desarrollo
EXPOSE 9000 9060

# Comando para iniciar el servidor de desarrollo
CMD ["npm", "start"]
