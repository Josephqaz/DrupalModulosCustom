Módulo de Integración de Boletines de Noticias
Descripción
El módulo de integración de boletines de noticias facilita la integración con servicios de correo electrónico como MailChimp o Sendinblue. Permite la suscripción de usuarios, la gestión de listas de correo y la personalización de plantillas de correo electrónico.

Requisitos
Drupal 10
Composer
Cuenta en MailChimp con una lista creada (puedes adaptar el módulo para usar Sendinblue).


Instalación
1. Descargar e Instalar el Módulo
Copia el módulo en el directorio modules/custom de tu instalación de Drupal.

2. Instalar Dependencias
Desde la raíz de tu proyecto Drupal, ejecuta el siguiente comando para instalar el SDK de MailChimp:

composer require drewm/mailchimp-api

3. Habilitar el Módulo
Ve a Extensiones en la interfaz de administración de Drupal y habilita el módulo Newsletters Integration. Alternativamente, puedes usar Drush para habilitar el módulo:

drush en newsletters_integration

Configuración del Módulo

Configuración de la API

Navega a Configuración > Sistema > Newsletters Integration Settings o visita /admin/config/system/newsletters-integration.
Ingresa tu clave API de MailChimp y el ID de la lista a la que quieres suscribir a los usuarios.
Guarda la configuración.

Resumen de Funcionalidades y Rutas

Suscribirse a un Boletín
Descripción: Permite a los usuarios suscribirse al boletín ingresando su dirección de correo electrónico.
URL: http://localhost/drupal/newsletter/subscribe

Configuración del Módulo
Descripción: Permite a los administradores configurar las claves API de MailChimp y el ID de la lista.
URL: http://localhost/drupal/admin/config/system/newsletters-integration

Pasos Adicionales
Asignar Permisos
Asegúrate de que los permisos adecuados estén asignados a los roles de usuario para acceder a estas rutas y funcionalidades. Puedes hacerlo en la página de permisos de Drupal en /admin/people/permissions.