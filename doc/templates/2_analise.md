# Análise: Requirimentos do sistema

Este documento describe os requirimentos do proxecto especificando que funcionalidade ofrecerá e de que xeito.

## Descrición xeral

Este proxecto trátase dunha aplicación web responsiva, adaptada tamén a tablet e móbil, destinada a simplificar e optimizar a xestión da medicación e das citas médicas para doentes con enfermidades crónicas e adultos maiores. 
A aplicación realizará as seguintes funcións xerais:

1.	Autenticación e xestión de perfís de usuario e pacientes.
2.	Rexistro, modificación e eliminación de tratamentos, medicacións e citas.
3.	Alertas e recordatorios configurables para tomas e renovacións de medicamentos, e citas médicas.
4.	Visualización de históricos 
5.	Substitucións de fármacos.
6.	Xeración de reportes personalizados sobre a evolución do tratamento.
7.	Administración de permisos para coidadores e familiares.

O usuario autenticado accederá a un panel inicial onde seleccionará ou creará un perfil de paciente, desde o cal poderá consultar e xestionar toda a información relacionada cos seus tratamentos e citas médicas.


## Funcionalidades

### 1.	Rexistro de usuario e creación de perfil
    * Actores: Usuario Estándar, Usuario Premium,  Usuario Invitado, Administrador.
    * Datos de entrada: nome, correo electrónico e contrasinal do usuario, datos persoais do paciente (nome, data de nacemento, sexo,   etc.), datos do tratamento inicial (causa/condición, data de inicio, unha ou varias medicacións: nome, dose, pauta, causa específica), datos de pago (se selecciona o plan Premium).
    * Proceso:
-	Usuarios Estándar e Premium:
1.	O usuario completa o formulario de rexistro cos seus datos (nome, correo electrónico, contrasinal)
2.	O usuario selecciona o plan de pago.
3.	O usuario crea o perfil cos datos do doente e un tratamento ca/s súa/s medicación/s asociada/s.
4.	O sistema valida e garda a conta, o perfil, o tratamento e a/s medicación/s, vinculándoas ao usuario como creador.  
-	Usuarios Invitados: este tipo de usuario rexístrase mediante unha invitación dun Usuario Premium ao correo electrónico (Ver 3. Envío e xestión de invitacións a perfís).
o	Datos de saída: confirmación de rexistro, token de sesión e acceso ao panel de perfís.

### 2.	Autenticación de usuario
o	Actores: Usuario Estándar, Usuario Premium, Usuario Invitado, Administrador.
o	Datos de entrada: credenciais do usuario (correo electrónico e contrasinal).
o	Proceso:
1.	O sistema valida as credenciais e xera un token de sesión. 
o	Datos de saída: token de sesión e acceso ás funcionalidades permitidas.

### 3.	Envío e xestión de invitacións a perfís
o	Actores: Usuario Premium, Administrador.
o	Datos de entrada: correo electrónico do usuario invitado.
o	Proceso:
1.	O creador introduce o correo electrónico do usuario invitado.
2.	O sistema envía un enlace de invitación por email.
3.	O invitado fai clic no enlace e completa un breve rexistro co seu nome e contrasinal (o correo electrónico non fará falta porque xa se gardou ao acceder mediante a invitación).
4.	O sistema asigna automaticamente o perfil compartido ao invitado.
o	Datos de saída: notificación de envío de invitación; perfil accesible na conta do invitado.

### 4.	Cancelación de invitacións
o	Actores: Usuario Premium, Administrador.
o	Datos de entrada: correo electrónico do invitado.
o	Proceso:
1.	O creador accede ao xestor de invitacións e selecciona “Cancelar”.
2.	O sistema invalida o enlace pendente.
o	Datos de saída: confirmación de cancelación.

### 5.	Xestión de perfís adicionais
o	Actores: Usuario Estándar, Usuario Premium, Usuario Invitado, Administrador.
o	Datos de entrada: datos persoais do paciente para o novo perfil (nome, data de nacemento, sexo, etc.), datos do tratamento inicial (causa/condición, data de inicio, unha ou varias medicacións: nome, dose, pauta, causa específica).
o	Proceso:
1.	Crear: O usuario accede á sección de perfís e selecciona “Crear novo” e introduce datos; o sistema valida e garda o perfil, tratamento inicial e medicacións.
2.	Editar: o usuario modifica datos do perfil; o sistema actualiza a información.
3.	Eliminar: o usuario elimina o perfil e anula os accesos aos invitados.
o	Datos de saída: actualización da lista de perfís dispoñibles e confirmación.

### 6.	Xestión de tratamentos
o	Actores: Usuario Estándar, Usuario Premium, Administrador.
o	Datos de entrada: perfil asociado, motivo do tratamento (condición ou enfermidade), data de inicio, unha ou varias medicacións (nome, dose, pauta, causa específica)
o	Proceso:
1.	Creación: o usuario engade os datos do tratamento.
2.	Edición: o usuario modifica campos existentes.
3.	Eliminación: o usuario marca o tratamento como finalizado e arquívao para histórico.
o	Datos de saída: listaxe actualizada de tratamentos dentro do perfil e mensaxe de confirmación.

### 7.	Xestión de medicación e substitucións
o	Actores: Usuario Estándar, Usuario Premium, Administrador.
o	Datos de entrada: nome do fármaco, dose, instrucións, tratamento asociado.
o	Proceso:
1.	Engadir/Editar/Eliminar: o usuario xestiona entradas de medicación.
2.	Substitución: ao configurar un substituto, o sistema documenta o cambio no historial de tratamentos.
o	Datos de saída: cronoloxía visual de medicacións e notificación de substitución realizada.

### 8.	Xestión de citas médicas
o	Actores: Usuario Estándar, Usuario Premium, Administrador.
o	Datos de entrada: data, hora, lugar, nome do médico, especialidade, notas opcionais
o	Proceso:
1.	Engadir: o usuario crea unha nova cita.
2.	Editar: o usuario modifica detalles da cita.
3.	Eliminar: o usuario cancela unha cita.
4.	Configuración de recordatorios personalizados.
o	Datos de saída: calendario actualizado de citas e confirmación de programación de recordatorios.

### 9.	Alertas e recordatorios
o	Actores: Usuario Estándar, Usuario Premium, Administrador.
o	Datos de entrada: perfil, configuración de alertas (tomas, renovacións, citas)
o	Proceso:
1.	O sistema programa notificacións en base aos intervalos definidos.
2.	Envíase un email a tódolos usuarios vinculados ao perfil do paciente co recordatorio.
o	Datos de saída: entrega de recordatorios e rexistro de eventos de alerta.

### 10.	Visualización de históricos
o	Actores: Usuario Estándar, Usuario Premium, Administrador.
o	Datos de entrada: selección de perfil, intervalo de datas, tipo de historial (tratamentos, medicacións, substitucións)
o	Proceso:
1.	O sistema recupera datos históricos pertinentes.
2.	Agrúpanse e preséntanse en táboas ou gráficos sinxelos.
o	Datos de saída: visualización descargable e consultable do historial.

### 11.	Xeración de reportes personalizados
o	Actores: Usuario Premium, Administrador.
o	Datos de entrada: perfís, tratamentos, intervalo de datas
o	Proceso:
1.	O sistema agrega os datos seleccionados.
2.	Xera un ficheiro PDF.
o	Datos de saída: enlace de descarga do reporte personalizado.

### 12.	Eliminación de conta
o	Actores: Usuario Estándar, Usuario Premium, Administrador.
o	Datos de entrada: confirmación de usuario e credenciais.
o	Proceso:
1.	O usuario solicita eliminación de conta.
2.	O sistema elimina perfil de usuario, perfís, tratamentos, medicacións e datos asociados.
o	Datos de saída: mensaxe de confirmación de conta eliminada e saída da sesión.


## Tipos de usuarios

### Usuario Novo
Usuario que se acaba de rexistrar na aplicación por primeira vez, pero aínda non completou a verificación (por exemplo, a través da confirmación do correo electrónico). Sen acceso ata que se verifique a súa identidade.

### Usuario Estándar
Usuario rexistrado e verificado que accede co plan gratuíto. Poderá acceder ás funcionalidades básicas, como a xestión de tratamentos, citas, medicamentos e recordatorios simples.
Se este usuario quixera usar a versión de pago, deberá actualizar a súa subscrición.

### Usuario Premium
Usuario rexistrado, verificado e que adquiriu a subscrición premium (de pago). Terá acceso completo a tódalas funcionalidades da aplicación,  tanto básicas como avanzadas (multiusuario, alertas avanzadas, sincronización con Google Calendar...).

### Usuario Invitado
Trátase daquel que foi invitado por un usuario Premium para xestionar un mesmo perfil, xa que so estes poden acceder á funcionalidade avanzada de multiusuario. Este tipo de usuario é igual ao Usuario Estándar, excepto cando se trata de roles de perfís, como por exemplo no caso de eliminación da conta. Cando un Usuario Invitado borra a súa conta, anúlanse os seus accesos aos perfís aos que foi invitado, pero non o perfil do doente nin os datos asociados a el. Pero se un usuario deste tipo creou un perfil, este eliminarase coma se se tratara dun Usuario Estándar.

### Usuario Bloqueado
Usuario coa conta desactivada, xa sexa por problemas de seguridade, incumprimentos ou verificación fallida. Non terá acceso ata que poida reactivar a conta.

### Administrador
Usuario con privilexios especiais para a xestión global e administración do sistema.


## Normativa

Investigarase que normativa vixente afecta ao desenvolvemento do proxecto e de que maneira. O proxecto debe adaptarse ás esixencias legais dos territorios onde vai operar.

Pola natureza dos sistema de información, unha lei que se vai a ter que mencionar de forma obrigatoria é la [Ley Orgánica 3/2018, de 5 de diciembre, de Protección de Datos Personales y garantía de los derechos digitales (LOPDPGDD)](https://www.boe.es/buscar/act.php?id=BOE-A-2018-16673). O ámbito da LOPDPGDD é nacional. Se a aplicación está pensada para operar a nivel europeo, tamén se debe facer referencia á [General Data Protection Regulation (GDPR)](https://eur-lex.europa.eu/eli/reg/2016/679/oj). Na documentación debe afirmarse que o proxecto cumpre coa normativa vixente.

Para cumplir a LOPDPGDD e/ou GDPR debe ter un apartado na web onde se indique quen é a persoa responsable do tratamento dos datos e para que fins se van utilizar. Habitualmente esta información estructúrase nos seguintes apartados:

* Aviso legal.
* Política de privacidade.
* Política de cookies.

**Deben explicarse os diferentes mecanismos utilizados para cumprir a lexislación relativa á protección de datos.**

> Completa tamén os documentos: [planificación](doc/templates/a2_planificacion.md) e [orzamento](doc/templates/a3_orzamento.md).