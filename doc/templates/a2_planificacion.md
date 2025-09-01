# Planificación

## Metodoloxía prevista

Xa que este proxecto se presentou en fases fixas e secuenciales, decidiuse seguir a metodoloxía en cascada. Esta metodoloxía de desenvolvemento de software consiste en realizar cada fase por completo antes de pasar á seguinte. De todas formas, sempre haberá marxe para pequenos axustes a medida que surxan dificultades ou novas ideas interesantes para implementar.

## Fases planificadas

### Fase 1: Estudo preliminar

**Tarefas a realizar:**
- Redacción da descrición do proxecto e xustificación da idea.
- Estudo do público obxectivo e da posible relevancia social.
- Estudo de produtos similares, das súas valoracións e carencias.
- Definicion de funcionalidades básicas e avanzadas.
- Definición do modelo de negocio.
- Selección das tecnoloxías a empregar.

**Duración estimada total:** 6 horas

**Recursos necesarios:** ordenador portátil, conexión a Internet.

### Fase 2: Análise

**Tarefas a realizar:**

- Redacción detallada das funcionalidades.
- Estimación dos casos de uso. 
- Definición de tipos de usuario e permisos.
- Investigación sobre a normativa a ter en conta.
- Investigación sobre mecanismos para cumprir a normativa.


**Duración estimada total:** 16 horas

**Recursos necesarios:** ordenador portátil, conexión a Internet.

### Fase 3: Deseño

**Tarefas a realizar:**

- Definición dos diagramas concretos que se deseñarán para este proxecto.
- Investigación sobre como elaborar un diagrama de capas.
- Elaboración do diagrama de capas da aplicación.
- Creación da base de datos en phpMyAdmin para obter o diagrama da base de datos.
- Creación dun nome, un logo e unha paleta de cores para a aplicación.
- Estimación das interfaces a deseñar.
- Deseño das interfaces:
    - Interfaz de Login
    - Interfaz de rexistro de usuario
    - Interfaz de rexistro de perfil e tratamento
    - Interfaz de rexistro de medicación
    - Interfaz de rexistro de cita médica
    - Interfaz de plans de pago
    - Interfaz principal para Usuario Estándar
    - Interfaz de Axustes
    - Interfaz de Informes


**Duración estimada total:** 28 horas

**Recursos necesarios:** ordenador portátil, conexión a Internet.

### Fase 4: Codificación e probas

**Configuración inicial**

- Instalar PHP
- Instalar Composer
- Instalar Laravel
- Crear proxecto
- Crear a clave da aplicación (APP_KEY)
- Configurar o entorno no arquivo .env
- Instalar Laravel Breeze
- Instalar dependencias frontend e compilar frontend
- Executar as migracións de base de datos

**Backend**

- Adaptar a migración de Breeze á base de datos.
- Elaborar os modelos Eloquent de Perfil, Tratamento, Medicamento e Cita.
- Implementar controladores para a xestión de perfís, tratamentos, medicación e citas.
- Control de acceso por plan: empregar rol_global en rutas e vistas para redirixir/amosar opcións segundo plan.
- Desenvolver a lóxica de recordatorios automáticos de tomas de medicación e citas.
- Xerar informes en PDF co histórico de tratamentos e medicación empregando DomPDF.
- Crear un sistema de notificacións para avisar de cada toma de medicación e cita.
- Engadir sincronización con Google Calendar para citas médicas mediante API oficial.

**Frontend**

- Facer a vista principal / de Login.
- Deseñar e implementar vistas con Blade e Tailwind CSS para:
    - Rexistro de usuario e elección de plan.
    - Creación de perfís de doente.
    - Rexistro de tratamentos, medicación e citas.
    - Dashboard con pestanas de tratamentos e citas.
    - Xestión de perfís (editar, eliminar, compartir no plan premium).
    - Vista de informes descargables en PDF.
    - Vista de axustes de conta con eliminación de usuario mediante modal de confirmación.
- Adaptar as vistas a dispositivos móbiles (responsive design).

**Probas**

- Probas manuais de cada fluxo principal:
    - Rexistro/login.
    - Creación de perfil, tratamento, medicación e citas.
    - Xeración e marcaxe de recordatorios.
    - Sincronización con Google Calendar.
    - Exportación de informes a PDF.
- Corrección de erros e axuste de estilos.
- Validación final de requisitos e comprobación de datos en phpMyAdmin.

**Despregamento**

- Rexistrarse en Railway 
- Facer un mirroring repository en Github para integralo con Railway.
- Importar a base de datos a MySQL Workbench.
- Crear un novo proxecto en Railway, conectalo co repositorio de Github e engadir a base de datos ó proxecto.
- Configurar as variables de entorno para producción.
- Asegurarse de que as varibles de entorno do servizo de base de datos coincidan cas da aplicación.
- Despregar o contenedor cando todo estea configurado, establecendo os comandos necesarios na configuración.

**Duración estimada total:** 120 horas.

**Recursos necesarios:** ordenador con XAMPP, Composer, Node.js e PHP 8.2, conexión a Internet, conta en Railway e Google Cloud Console, IDE (Visual Studio Code ou similar).

### Fase 5: Manuais do proxecto

- Redacción do manual técnico (instalación, configuración, despregue) e do manual de usuario (guías paso a paso das funcións), 
- Corrección de erros detectados durante a revisión de manuais.  

**Duración estimada total:** 12 horas.

**Recursos necesarios:** ordenador portátil, conexión a Internet.


## Calendario

| Fase | Accións principais | Duración | Datas |
|------|-------------------|----------|-------|
| Fase 1: Estudo preliminar | Xustificación, público obxectivo, tecnoloxías | 6 h | Maio 2025, semana 1 |
| Fase 2: Análise | Funcionalidades, casos de uso, normativa | 16 h | Maio 2025, semanas 2–3 |
| Fase 3: Deseño | Diagramas, BD, interfaces | 28 h | Maio 2025, semanas 4–5 |
| Fase 4: Codificación e probas | Configuración inicial, backend, frontend, recordatorios, Google Calendar, informes PDF, probas e despregue | 120 h | Xuño–Agosto 2025 (ata finais de mes) |
| Fase 5: Manuais | Redacción manual técnico e manual de usuario, revisión final | 20 h | Agosto–Setembro 2025 (ata esta semana) |


