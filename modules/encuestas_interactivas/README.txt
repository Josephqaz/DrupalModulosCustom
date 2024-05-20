Crear una Encuesta
Visita http://localhost/drupal/encuestas-interactivas/nueva para crear una nueva encuesta.

Participar en la Encuesta
Visita la URL http://localhost/drupal/encuestas-interactivas/participar/{encuesta_id} para participar en la encuesta.

Incrustar el Bloque de Encuestas
Ve a la página de administración de bloques /admin/structure/block y añade el bloque Encuesta Block a una región en tu tema.

Visualizar Resultados de Encuesta
Visita la URL http://localhost/drupal/encuestas/resultados/{encuesta_id} para ver los resultados de la encuesta.

Resumen de Funcionalidades y Rutas
Crear una Encuesta:

Descripción: Permite a los usuarios crear una nueva encuesta.
URL: http://localhost/drupal/encuestas-interactivas/nueva
Participar en la Encuesta:

Descripción: Permite a los usuarios participar en una encuesta específica.
URL: http://localhost/drupal/encuestas-interactivas/participar/{encuesta_id}
Reemplaza {encuesta_id} con el ID de la encuesta en la que quieres participar.
Incrustar el Bloque de Encuestas:

Descripción: Añade el bloque de encuestas a una región en tu tema.
URL: Ve a la página de administración de bloques /admin/structure/block y añade el bloque Encuesta Block a una región en tu tema.
Visualizar Resultados de Encuesta:

Descripción: Permite a los usuarios ver los resultados de una encuesta específica.
URL: http://localhost/drupal/encuestas/resultados/{encuesta_id}
Reemplaza {encuesta_id} con el ID de la encuesta cuyos resultados quieres ver.
Pasos Adicionales
Asignar Permisos:

Asegúrate de que los permisos adecuados estén asignados a los roles de usuario para acceder a estas rutas y funcionalidades. Puedes hacerlo en la página de permisos de Drupal en /admin/people/permissions.
Personalizar Rutas y Funcionalidades:

Si necesitas personalizar más las rutas o añadir nuevas funcionalidades, puedes actualizar los archivos de configuración y código del módulo.