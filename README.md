## README - Aplicación de Registro y Gestión de Contactos
### Descripción
Esta aplicación PHP permite a los usuarios registrarse, iniciar sesión, añadir contactos, visualizar la lista de contactos, actualizar información y eliminar contactos. La interfaz se divide en dos secciones, una para el registro y otra para la gestión de contactos.

### Estructura de Archivos
* regid.php: Página de registro e inicio de sesión.
* index.php: Página principal para la gestión de contactos.
* cerrar-sesion.php: Página para cerrar la sesión del usuario.
* actualizar.php: Página para actualizar información de un contacto.
* js/index.js: Archivo JavaScript para manejar eventos de interacción.
* css/style.css: Archivo de estilo que define la apariencia de la aplicación.

### Base de Datos
Se utiliza una base de datos MySQL para almacenar la información de los usuarios y sus contactos.

El archivo database.php contiene la configuración de la conexión a la base de datos.

### Funcionalidades
#### Registro e Inicio de Sesión

* Se valida y procesa la información del formulario de registro.
* Se verifica la existencia del usuario y se inicia sesión.

#### Gestión de Contactos en index.php

* Añadir nuevo contacto
* Visualizar lista de contactos con opciones de actualizar y eliminar.
* Eliminar un contacto específico o borrar toda la agenda.

#### Actualizar contacto

* Permite al usuario modificar la información de un contacto específico.

#### Cerrar Sesión

* Página para cerrar la sesión del usuario.

#### Estilo y Diseño
* Se utiliza Google Fonts
* La interfaz se divide en dos secciones con efectos visuales al interactuar con cada sección

#### Problemas Conocidos

* Responsividad: La aplicación puede tener problemas de visualización en dispositivos de pantalla pequeña debido a la falta de estilos responsivos y media queries


#### Mejoras Futuras
* Implementación de estilos responsivos para mejorar la experiencia en dispositivos móviles
* Validación y sanitización adicional de datos en el lado del servidor
* Mejoras en la seguridad de la autenticación de usuarios

## Licencia

Proyecto elaborado con fines educativos. 
