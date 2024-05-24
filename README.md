<!-- [Software Halloween Disfraces.pdf](https://github.com/agusaenz/halloween-disfraces/files/15396779/Software.Halloween.Disfraces.1.pdf) -->

# Software Halloween Disfraces

Este repositorio contiene el software para la gestión de alquileres de disfraces de Halloween. A continuación, se detallan las características, funciones y medidas de seguridad implementadas en el sistema.

## Seguridad

- **Iniciar sesión**: Los usuarios deben autenticarse para acceder al sistema.
- **Distintos perfiles**: El sistema permite la creación de diferentes perfiles de usuario.
- **Distintos permisos**: Cada perfil de usuario tiene permisos específicos para acceder a distintas funcionalidades del sistema.

## Características

### Cliente

Cada cliente registrado en el sistema deberá tener los siguientes campos obligatorios, con la opción de ignorar algún campo mediante una checkbox:

- Apellidos
- Nombres
- DNI
- Domicilio
- Teléfono
- Correo electrónico

### Alquiler

Los alquileres incluirán la información del cliente junto con los siguientes datos:

- Fecha de alquiler
- Fecha (o rango) de devolución
- Disfraz/disfraces alquilados
- Artículos adicionales
- Forma de pago
- Precio total
- Depósito
- Cantidad de bolsas

## Funciones

El software permite realizar las siguientes acciones:

- **Agregar cliente**: Registrar un nuevo cliente en el sistema.
- **Eliminar cliente**: Borrar un cliente existente del sistema.
- **Editar cliente**: Modificar los datos de un cliente existente.
- **Hacer alquiler**: Registrar un nuevo alquiler con toda la información necesaria.
- **Imprimir alquiler**: Generar un comprobante de alquiler utilizando una plantilla de Excel.
- **Buscador y registro de clientes**: Buscar y gestionar los registros de los clientes.
- **Buscador y registro de alquileres**: Buscar y gestionar los registros de los alquileres.
- **Ver alquileres asociados a un cliente**: Consultar todos los alquileres realizados por un cliente específico.
- **Estados de alquiler**: Indicar si un alquiler ha sido devuelto o no.
- **Ver ganancias y depósitos**: Consultar las ganancias generadas y los depósitos recibidos.

## Cómo empezar

Para utilizar este software, sigue los siguientes pasos:

1. Clona este repositorio a tu máquina local:
    ```sh
    git clone https://github.com/tu-usuario/tu-repositorio.git
    ```
2. Instala las dependencias necesarias:
    ```sh
    npm install
    ```
3. Configura las variables de entorno necesarias (ver `example.env`).
4. Inicia el servidor:
    ```sh
    npm start
    ```

## Contribuciones

Las contribuciones son bienvenidas. Por favor, sigue los siguientes pasos:

1. Haz un fork de este repositorio.
2. Crea una nueva rama con tu funcionalidad: `git checkout -b mi-nueva-funcionalidad`.
3. Realiza los cambios y haz commit de los mismos: `git commit -m 'Agregar nueva funcionalidad'`.
4. Haz push a la rama: `git push origin mi-nueva-funcionalidad`.
5. Abre un Pull Request.

## Licencia

Este proyecto está bajo la licencia MIT. Consulta el archivo `LICENSE` para más detalles.

---

¡Gracias por utilizar nuestro software de alquiler de disfraces de Halloween! Si tienes alguna pregunta o sugerencia, no dudes en contactarnos.
