# Prueba ITBF Back

Este proyecto es una API backend desarrollada con Laravel. Sirve como base para pruebas técnicas y desarrollo rápido de aplicaciones modernas utilizando el framework Laravel, reconocido por su sintaxis elegante y herramientas robustas para el desarrollo web.

## Características

- 🚀 Laravel para desarrollo backend eficiente y seguro.
- 🔒 Autenticación y autorización listas para usar.
- 🗄️ ORM Eloquent para manejo intuitivo de bases de datos.
- 📦 Migraciones y seeders para gestión de la base de datos.
- 🧪 Testing integrado.

## Instalación

Sigue estos pasos para instalar y ejecutar el proyecto localmente:

1. **Clona el repositorio:**
   ```bash
   git clone <URL_DEL_REPOSITORIO>
   cd PruebaITBF
   ```

2. **Instala las dependencias de PHP:**
   ```bash
   composer install
   ```

3. **Copia el archivo de entorno y genera la clave de la aplicación:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configura la base de datos** en el archivo `.env` según tus credenciales locales.

5. **Ejecuta las migraciones y seeders:**
   ```bash
   php artisan migrate --seed
   ```

6. **Inicia el servidor de desarrollo:**
   ```bash
   php artisan serve
   ```

7. La API estará disponible en [http://localhost:8000](http://localhost:8000).

## Scripts útiles

- `php artisan serve`: Inicia el servidor de desarrollo.
- `php artisan migrate`: Ejecuta las migraciones de la base de datos.
- `php artisan db:seed`: Ejecuta los seeders para poblar la base de datos.
- `php artisan test`: Ejecuta los tests.

## Requisitos

- PHP >= 8.1
- Composer
- MySQL o cualquier base de datos compatible

## Estructura del proyecto

```
PruebaITBF/
├── app/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
├── routes/
│   └── api.php
├── tests/
├── .env.example
├── artisan
├── composer.json
└── README.md
```

## Notas

- Puedes personalizar la configuración de Laravel según las necesidades de tu equipo.
- Para producción, revisa la documentación oficial de Laravel sobre despliegue y seguridad.
