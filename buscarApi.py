import requests
import json

apiURL = 'http://vehicle.test/api/login'
findDriverURL = 'http://vehicle.test/api/drivers/find/'
parking_id = 1  # ID del Parqueadero
tipo = 'Entrada'  # Entrada o Salida

# Request para obtener el token
print('Obteniendo token...')
login = requests.post(
    apiURL, data={'email': 'juan@bonilla.com', 'password': 'juanbonilla'})
token = login.json()['data']['token']
# Guardar el token para usarlo en las siguientes peticiones
headers = {'Authorization': 'Bearer ' + token}
# Prevenir cierre del programa
while True:
    # Ingresar cédula por teclado
    cedula = input('Para salir ingrese "0"\nIngrese la cédula: ')
    if cedula == '0':
        break
    # cedula = '075109844'  # Prueba
    # Request para buscar el conductor con parametros
    try:
        print('Buscando conductor...')
        response = requests.get(
            findDriverURL + cedula,
            headers={
                'Authorization': 'Bearer ' + token
            },
            params={
                'parking_id': parking_id, 'type': tipo
            })
        # Prevenir error de que no se encuentre el conductor
        if response.status_code == 404:
            print('No se encontro conductor con esos datos')
        else:
            print('Conductor encontrado')
            # Imprimir JSON de respuesta bonito a la vista
            print(json.dumps(response.json(), indent=4))
    except Exception as e:
        print(e)
