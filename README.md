# Sistema-de-votacion
El código proporcionado es un formulario de votación web creado con tecnologías como PHP, MySQL y Bootstrap. Este formulario permite a los usuarios enviar sus votos para candidatos, seleccionar una región y una comuna, y proporcionar información personal, como nombre, alias, RUT, email y cómo se enteraron del proceso de votación. A continuación, una descripción más detallada de las características del código:

Conexión a la Base de Datos:
Se establece una conexión a una base de datos MySQL utilizando las credenciales proporcionadas (servidor, usuario, contraseña y base de datos). Si la conexión falla, se muestra un mensaje de error.

Carga de Opciones de Regiones:
Se ejecuta una consulta SQL para cargar opciones de regiones activas desde la base de datos. Estas opciones se muestran en un menú desplegable en el formulario, permitiendo a los usuarios seleccionar una región.

Carga de Opciones de Comunas:
Aunque el código no proporciona la consulta exacta, se incluye un área para cargar opciones de comunas basadas en la región seleccionada. Esta funcionalidad utiliza JavaScript para modificar dinámicamente el menú desplegable de comunas según la región elegida.

Carga de Opciones de Candidatos:
Se ejecuta una consulta SQL para cargar opciones de candidatos desde la base de datos. Los usuarios pueden seleccionar un candidato de un menú desplegable en el formulario.

Validación de Datos:
El formulario realiza validaciones en tiempo real utilizando JavaScript para garantizar que los datos ingresados sean válidos. Por ejemplo, se valida el RUT chileno, se verifica la longitud y contenido del alias, y se requiere que se seleccionen al menos dos opciones para "¿Cómo se enteró de nosotros?".

Interfaz de Usuario:
Se utiliza Bootstrap para dar estilo a la interfaz del formulario, lo que garantiza una apariencia atractiva y responsive en diferentes dispositivos y tamaños de pantalla.

Procesamiento de Votos:
El formulario envía los datos ingresados por el usuario a un archivo llamado "procesar_voto.php" utilizando el método POST. Sin embargo, el código de procesamiento real no se proporciona aquí y debería existir en el archivo mencionado. En este archivo se llevaría a cabo el procesamiento de los datos, como almacenar el voto en la base de datos.

En resumen, este código crea un formulario de votación interactivo y atractivo que permite a los usuarios emitir votos para candidatos, proporcionar detalles personales y seleccionar cómo se enteraron del proceso de votación. La estructura y estilo del formulario se benefician de Bootstrap, y se utilizan técnicas de validación de datos para garantizar la integridad de la información ingresada.
[![Screenshot-1.png](https://i.postimg.cc/yYGKsG2t/Screenshot-1.png)](https://postimg.cc/dLGp95sj)
