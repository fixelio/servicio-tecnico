## Pasos para ejecutar el proyecto

1. Clona el repositorio y accede a la carpeta del proyecto:

```bash
git clone https://github.com/fixelio/servicio-tecnico.git

cd servicio-tecnico
```

2. Ejecuta el comando <code>composer install</code>

```bash
composer install
```

3. Crea un archivo llamado <code>.env</code> y copia allí el contenido del archivo <code>.env.example</code>

4. Ejecuta <code>npm install</code> y luego <code>npm run build</code> para instalar las dependencias (bootstrap)

5. Ejecuta <code>php artisan key:generate</code>

6. Ejecuta <code>php artisan serve</code>

7. Abre la ubicación <code>localhost:8000</code> en tu navegador