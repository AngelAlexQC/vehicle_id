# Vehicle Identifier
API para administrar información de vehículos y conductores.
## Arquitectura

![Arquitectura](/docs/img/arquitectura.jpg)
La arquitectura del sistema se basa en un servidor central donde se aloja la base de datos, panel de administrador, base de datos y aplicación web que sirve como API para los diferentes cliente, éstos se comunican con datos en formato JSON para consultar información de conductores y vehículos.

## Diagrama Físico
![Diagrama Físico](docs/img/Diagrama%20BD.png)

# Documentación
<!-- ## Desplegar en servidor compartido -->

## Montar con Docker y WSL:

Ejecutar estos comandos en la terminal.

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate:fresh --seed
```

## Iniciar Sesión y obtener token con usuario y contraseña:

```javascript
axios({
    method: "post",
    url: "/api/login",
    headers: {
        Accept: "application/json",
    },
    body:{
        email:'email@ejemplo.com',
        password:'contraseñaSegura123'
    }
});
```
Se obtiene una respuesta JSON:
```json
/* Datos Incorrectos */
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "Estas credenciales no coinciden con nuestros registros."
        ]
    }
}
/* Inicio de sesión exitoso */
{
    "status": "success",
    "message": null,
    "data": {
        "id": 1,
        "dni": "0987654321",
        "name": "Administrador",
        "email": "admin@admin.com",
        "email_verified_at": null,
        "created_at": "2021-06-22T02:18:49.000000Z",
        "updated_at": "2021-06-22T02:18:49.000000Z",
        "deleted_at": null,
        "token": "1|3dvCwq7NH3OHUmLsbc1z9WtjRuhko8sxON9noty0"
    }
}
```

## Buscar Usuario por Cédula:

```javascript
axios({
    method: "get",
    url: "/api/find/{cedula}",
    headers: {
        Authorization: "Bearer ***TOKEN***",
        Accept: "application/json",
    },
});
```

Se obtiene una respuesta JSON:
```json
/* No Autenticado */
{
    "message": "Unauthenticated."
}
/* Autenticado */
{
    "status": "success",
    "message": null,
    "data": {
        "id": 1,
        "dni": "0850539479",
        "name": "Jesús Alexander",
        "surname": "Chilán García",
        "email": "admin@admin.com",
        "phone": "0998887776",
        "created_at": "2021-06-22T02:18:54.000000Z",
        "updated_at": "2021-06-22T02:18:54.000000Z",
        "deleted_at": null,
        "vehicles": [
            {
                "id": 1,
                "plate": "MBF-5630",
                "brand": "Chevrolet",
                "registration": "EC1234567890X",
                "owner_id": 1,
                "model": "Impala 67",
                "created_at": "2021-06-22T02:18:54.000000Z",
                "updated_at": "2021-06-22T02:18:54.000000Z",
            }
        ]
    }
}
```
