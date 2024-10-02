## PRUEBA PARA PASANTÍA

Este sistema ha sido creado con el fin de gestionar proyectos y sus respectivas tareas. Tiene la siguientes funcionalidades:
- Crear, editar, eliminar y ver proyectos.
- Crear, editar y eliminar tareas de un proyecto.

![PROYECTO](https://i.ibb.co/7Cc2YzS/imagen-2024-10-01-213950072.png)

## Instalar el sistema en local
### Requisitos Previos
Antes de comenzar, asegúrese de tener instalado lo siguiente en su sistema:

- [Node.js](https://nodejs.org/) versión ^18.16.0
- [php](https://www.php.net) verisón ^8.2.4
- [Composser](https://getcomposer.org) versión ^2.7.8
- [XAMPP](https://www.apachefriends.org/index.html) versión ^3.0.0

## Paso a Paso

1. **Clonar el repositorio**

   Abra una terminal y ejecute el siguiente comando para clonar el repositorio:

   ```git clone https://github.com/codecastlesv/laravelpasantiakatherinetest.git```

   Ingrese al directorio del proyecto creado.
   
2. **Instalar composer**

    Una vez dentro del directorio del proyecto, ejecute el siguiente comando:

   ```composer install```

   Esto permitirá que se descarguen todas las dependencias del proyecto.

2. **Instalar npm**

    Ahora jecute el siguiente comando:

   ```npm install```

4. **Configurar el archivo ```.env```**

    Copie el archivo ```env.example``` y renombre la copia como ```.env```

    Luego, en el archivo ```.env``` debe modificar las siguientes variables:
    ```APP_NAME=CODECASTLE-TEST
    APP_ENV=local
    APP_KEY=
    APP_DEBUG=true
    APP_TIMEZONE=UTC
    APP_URL=http://localhost:8000
    FRONTEND_URL=http://localhost:3000
    
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=codetest
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    Y agregar la siguiente varible:
    ```SCOUT_DRIVER=database```

5. **Crear la base de datos en MySQL**

    Asegúrese de crear la base de datos con el nobre dado en la variable DB_DATABASE=```codetest```

6. **Ejecutar las migraciones**

    En la terminal, sobre el directorio del proyecto se debe ejecutar el comando ```php artisan migrate```
    
    Con este comando se crearán las tablas en la base de datos.

7. **Generar la llave de la aplicación**

    Se debe generar la llave con el comando ```php artisan key:generate```.
    
    Asegúrese de que la variable ```APP_KEY=``` ya no esté vacía.

8. **Compilar los archivos del fronted**

    Debe estar en el directorio del proyecto.
    
    Para que los archivos del fronted se visualicen mejor se debe ejecutar el comando ```npm run dev```

9. **Levantar el servidor**

    En otra terminal, debe ejecutar el comando ```php artisan serve```

    Ya puede ingresar a la aplicación.

##  Paquetes utilizados
Se utilizaron paquetes de laravel como:
- [Breeze](https://laravel.com/docs/11.x/starter-kits#breeze-and-blade): Auténticación de usuarios.
- [Scout](https://laravel.com/docs/11.x/scout): Buscador de registros.
- [Notify](https://github.com/mckenziearts/laravel-notify): Personalizar notificaciones tipo toast.
- [Tailwind](https://tailwindcss.com/): Framework para manejar el CSS.
- [JQuery](https://api.jquery.com/jQuery.ajax/): Manejo de interacción AJAX.

## Consideraciones extras
Al utilizar Xampp se tiene acceso a la base de datos y php. 
Está versión trabaja con PHP 8.2.4, y en la base de datos con [MySQL]() versión ^5.6.17 ó MariaDB versión ^10.4.28.

PHP exige que algunas extensiones estén habilitadas. Este proyecto se realizó con las siguientes extensiones habilitadas por defecto:
- ext-dom
- ext-zip
- ext-bcmath
- ext-curl
- ext-gd
- ext-intl
- ext-xml
- ext-mbstring

Considere que estás extensiones se habilitan en el archivo php.ini quitando ';' al inicio del nombre de las extensiones.

Este paso puede ser omitido si no presenta errores, pero en ocasiones, suele generar problemas.

