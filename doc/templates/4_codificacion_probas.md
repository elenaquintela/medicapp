# Codificación e Probas

## Codificación

Durante a fase de codificación elaborouse a aplicación MedicApp empregando o framework Laravel 12 como base para o backend, e Blade xunto con Tailwind CSS para o frontend. A aplicación estrutúrase en modelos Eloquent, controladores, vistas Blade e rutas, seguindo o patrón MVC.

## Prototipos

Durante o desenvolvemento elaboráronse dous prototipos principais:

### Prototipo 1:

- Autenticación con Laravel Breeze adaptada á táboa usuarios.
- Creación de perfís e tratamentos básicos.
- Vistas iniciais con login, rexistro e dashboard sinxelo.

### Prototipo 2:

- Xestión completa de perfís, tratamentos, medicación e citas.
- Sistema de recordatorios de medicación implementado en DashboardController@index().
- Sincronización con Google Calendar para citas.
- Exportación de informes PDF.
- Adaptación responsive e mellora de estilos con Tailwind.
- Preparación de manuais de instalación e usuario.

## Innovación

A nivel técnico, incorporáronse algunhas tecnoloxías e solucións non vistas en profundidade no ciclo formativo:

- Integración coa API de Google Calendar empregando OAuth 2.0, manexando credenciais e tokens de acceso en .env.
- Despregamento en Railway, configurando contornos de produción con variables de entorno diferenciadas e conexión a base de datos en nube.
- Sistema de recordatorios automáticos implementado sen programador de tarefas externo, executándose directamente no DashboardController@index().
- Exportación de informes PDF con DomPDF, xerando documentos profesionais para o histórico de medicación e tratamentos.

## Probas

As probas realizáronse de forma manual:

- Rexistro e login de usuarios.
- Creación de perfís e tratamentos.
- Rexistro de medicación con xeración de recordatorios.
- Creación e modificación de citas con sincronización en Google Calendar.
- Exportación de informes PDF.
- Probas de eliminación de perfís, tratamentos e medicación con actualización en cascada.
- Visualización e filtrado de citas e medicación en dispositivos móbiles.

**Problemas atopados e solucións:**

- Erro ao conectar coa base de datos en Railway: resolto configurando correctamente as variables DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME e DB_PASSWORD.
- Duplicación de recordatorios: solucionado engadindo validación para evitar crear rexistros repetidos ao recargar o dashboard.
- Erro coa API de Google Calendar (redirect_uri_mismatch): solucionado configurando as URIs de redirección en Google Cloud Console para desenvolvemento e produción.
- Problemas de estilos en móbil: resoltos adaptando clases de Tailwind e reorganizando os compoñentes en columnas en pantallas pequenas.