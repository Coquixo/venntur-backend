# ventuur-backends


# Configuración y carga de base de datos local

Este documento describe los pasos para crear la base de datos local, ejecutar migraciones, cargar datos de prueba y verificar las tablas.

---
## 0. Prerrequisitos

- PHP >= 8.x instalado  
- MySQL o MariaDB instalado y corriendo  
- Composer instalado (https://getcomposer.org/)  
- [Opcional pero recomendado] Symfony CLI instalado para facilitar comandos de servidor local  
  - Instalar Symfony CLI: https://symfony.com/download

---

## 1. Instalación de dependencias
Para instalar las dependencias del proyecto, asegúrate de estar en el directorio raíz del proyecto y ejecuta el siguiente comando:

```bash
composer install
```

## 2. Configurar el archivo .env

Asegúrate de que tu archivo `.env` esté configurado correctamente para conectarse a la base de datos que acabas de crear. Busca las siguientes líneas y actualiza los valores según sea necesario:

```
DATABASE_URL="mysql://username:password@127.0.0.1:3306/mi_base?serverVersion=9.3.0"
```

Reemplaza `username`, `password` y `mi_base` con tus propios valores.
Por ejemplo:
 - DATABASE_URL="mysql://root:@127.0.0.1:3306/ventuur?serverVersion=9.3.0" 

## 3. Crear la base de datos

###  Crear la base de datos automáticamente con Symfony

Si tienes permisos adecuados, el método recomendado es usar el siguiente comando:

```bash
php bin/console doctrine:database:create
```



## 4. Ejecutar migraciones - creación de tablas
Para aplicar las migraciones y crear las tablas necesarias en la base de datos, ejecuta el siguiente comando:

```bash
php bin/console doctrine:migrations:migrate
```
## 5. Cargar datos de prueba - seeders
Para cargar datos de prueba en la base de datos, puedes usar el siguiente comando:

```bash
php bin/console doctrine:fixtures:load --no-interaction
```

## 6. Verificar las tablas

Para verificar que las tablas se hayan creado correctamente, puedes conectarte a la base de datos y listar las tablas:

```bash
php bin/console doctrine:schema:validate
```

## 7. Levantar el servidor
Este paso requiere que tengas instalado Composer y Symfony CLI.
Para instalar Composer, puedes seguir las instrucciones en su [sitio oficial](https://getcomposer.org/download/).
Para instalar Symfony CLI, puedes seguir las instrucciones en su [sitio oficial](https://symfony.com/download).
Una vez que tengas Composer y Symfony CLI instalados, puedes proceder a levantar el servidor.

Para levantar el servidor y verificar que todo esté funcionando correctamente, utiliza el siguiente comando:

```bash
composer serve
```
Esto script lanzará `symfony server:start` en segundo plano.
# O si prefieres podemos levantarlo con php directamente:
```bash
php -S 127.0.0.1:8080 -t public
```
El servidor estará disponible en `http://127.0.0.1:8080`.
Puedes modificar el puerto en caso de ser neceesario. El puerto que se use será importante ya que deberás apuntar a el en el proyecto de frontend.
