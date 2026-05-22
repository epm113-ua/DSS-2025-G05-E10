# NutriPlan

**NutriPlan** es una aplicación web desarrollada con **Laravel 12** para la gestión de un entorno nutricional con **pacientes, nutricionistas y administración**.  
El proyecto combina una parte pública y otra privada, autenticación de usuarios, control por roles y funcionalidades como seguimiento, planificación, mensajes y gestión de recursos del sistema.

---

## Índice

- [Descripción](#descripción)
- [Funcionalidades principales](#funcionalidades-principales)
- [Últimos cambios](#últimos-cambios)
- [Tecnologías utilizadas](#tecnologías-utilizadas)
- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Comandos útiles](#comandos-útiles)
- [Estructura general](#estructura-general)
- [Notas importantes](#notas-importantes)
- [Autoría](#autoría)
- [Licencia](#licencia)

---

## Descripción

NutriPlan es un sistema orientado a la **gestión nutricional**. Permite trabajar con distintos perfiles de usuario y organizar la información necesaria para el seguimiento de pacientes, la comunicación con el nutricionista y la administración de la plataforma.

La entrega se ha preparado siguiendo los requisitos de la asignatura, incluyendo gestión del proyecto, modelo de dominio, mockups, desarrollo funcional y un README adaptado al proyecto.

---

## Funcionalidades principales

- **Parte pública** con páginas informativas.
- **Registro, login y recuperación de contraseña**.
- **Panel por roles**:
  - **Paciente**
  - **Nutricionista**
  - **Administrador**
- **Gestión de citas**.
- **Plan semanal** y seguimiento de progreso.
- **Mensajería entre paciente y nutricionista**.
- **Gestión de recetas, ingredientes, ofertas y tiendas**.
- **Gestión de mediciones, facturas y pagos**.
- **Panel administrativo** para la gestión de usuarios.
- **Interfaz responsive**.
- **Protección de rutas privadas** mediante middleware de autenticación y rol.

---

## Últimos cambios

En la última modificación se corrigieron y mejoraron varios puntos importantes del proyecto:

- Se resolvió el problema de las fotos de perfil mediante `php artisan storage:link`.
- Se añadió un componente reutilizable para mostrar avatar con foto o iniciales.
- Se mejoró el panel de mensajes del nutricionista para abrir chat directo con pacientes asignados.
- Se habilitó la creación automática de conversaciones cuando todavía no existen.
- Se corrigió la visualización de conversaciones en el panel de administración.
- Se ajustó la compatibilidad del sistema de recuperación de contraseña con Laravel 12.
- Se añadió una migración para permitir conversaciones sin cita asociada y mensajes más largos.

---

## Tecnologías utilizadas

- **PHP 8.2+**
- **Laravel 12**
- **Blade**
- **Bootstrap**
- **Vite**
- **Tailwind CSS 4**
- **MySQL / MariaDB**
- **Composer**
- **Node.js / npm**

---

## Requisitos

Antes de instalar el proyecto, asegúrate de tener:

- PHP 8.2 o superior
- Composer
- Node.js y npm
- MySQL o MariaDB
- Servidor web o entorno local para Laravel

---

## Instalación

1. **Descomprime el proyecto** o clona el repositorio.
2. Entra en la carpeta raíz del proyecto.
3. Instala dependencias de PHP:

```bash
composer install
```

4. Instala dependencias de frontend:

```bash
npm install
```

5. Copia el archivo de entorno:

```bash
cp .env.example .env
```

6. Genera la clave de aplicación:

```bash
php artisan key:generate
```

7. Configura la base de datos en el archivo `.env`.
8. Ejecuta las migraciones:

```bash
php artisan migrate
```

9. Crea el enlace simbólico para los archivos públicos:

```bash
php artisan storage:link
```

10. Compila los recursos del frontend:

```bash
npm run build
```

11. Arranca el servidor local:

```bash
php artisan serve
```

---

## Comandos útiles

Estos son los comandos que más uso para trabajar con el proyecto:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

php artisan storage:link

php artisan serve
```

Si necesitas limpiar y refrescar todo después de cambios grandes, también suele ayudar:

```bash
php artisan optimize:clear
```

---

## Estructura general

La aplicación está organizada en torno a varios módulos principales:

- **Autenticación y usuarios**
- **Pacientes**
- **Nutricionistas**
- **Citas**
- **Conversaciones y mensajes**
- **Planes semanales**
- **Mediciones**
- **Recetas**
- **Ingredientes**
- **Facturas y pagos**
- **Tiendas**
- **Ofertas de ingredientes**
- **Panel de administración**

---

## Notas importantes

- Después de descomprimir el proyecto, es recomendable ejecutar `php artisan storage:link` para que se muestren correctamente las imágenes almacenadas.
- La entrega está pensada para funcionar como aplicación web completa con parte pública y privada.
- La versión del repositorio corresponde a la etiqueta **`entrega-03`**.
- Si trabajas en local y cambias rutas, vistas o configuración, limpia la caché con los comandos de arriba.

---

## Autoría

Proyecto desarrollado como parte de la asignatura **Diseño de Sistemas Software**.  
Puedes añadir aquí los nombres del equipo, grupo y curso si quieres dejar el README totalmente listo para entrega en GitHub.

---

## Licencia

Proyecto académico. Si tu repositorio usa una licencia concreta, añádela aquí.
