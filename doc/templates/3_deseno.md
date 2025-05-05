# Deseño

Este documento inclúe os diferentes diagramas, esquemas e deseños que axuden a describir mellor o proxecto detallando os seus compoñentes, funcionalidades, bases de datos e interface.

O documento a elaborar debería incluír os seguintes apartados:

## Diagrama da arquitectura

### Diagrama de arquitectura lóxica / de capas

!["Diagrama de capas"](/doc/img/diagrama_capas2.png)

### Diagrama de casos de uso

!["Diagrama de casos de uso"](/doc/img/diagramaCasosUso.png)

## Diagrama de Base de Datos

!["Modelo relacional"](/doc/img/diagrama_bd.PNG)

## Deseño de interface de usuarios

### Interfaz de Login

!["Vista login"](/doc/img/vistaLogin.png)

### Interface de Rexistro de Usuario

!["Vista registro usuario"](/doc/img/vistaRegistro.png)

### Interface de Rexistro de Perfil e Tratamento

!["Vista rexistro perfil"](/doc/img/vistaPerfil.png)

### Interface de Rexistro de Medicación

!["Vista rexistro medicación"](/doc/img/vistaMedicacion.png)

### Interface de Planes de pago

!["Vista de plans de pago"](/doc/img/vistaPlanes.png)

### Interface principal do Usuario Estándar

- **Menú despregable superior dereita:** Opcións de usuario
- **Icona de campá**: Notificacións
- **Botón despregable co nome do doente/perfil** para seleccionar outro perfil que poida estar xestionando o usuario autenticado e ver a súa interface.
- **Menú despregable lateral:** para acceder ás interfaces de xestión de tratamentos, citas médicas, perfís, informes (desactivada no plan Estándar). Tamén cunha opción para pechar sesión.

!["Vista principal Usuario Estándar"](/doc/img/vistaEstandar1.png)

!["Vista principal Usuario Estándar menú lateral"](/doc/img/vistaEstandar2.png)

### Interface principal do Usuario Premium

!["Vista principal Usuario Premium"](/doc/img/vistaPremium.png)

### Interface de axustes de Usuario Estándar
No menú despregable na esquina superior dereita haberá dúas opcións:

- Axustes (de usuario)
- Pechar sesión

(O input para invitacións a outros usuarios estará desactivadada no plan Estándar)

!["Vista axustes usuario"](/doc/img/vistaAxustesUsuario.png)

### Interface de axustes de Usuario Premium

!["Vista axustes usuario"](/doc/img/vistaAxustesUsuarioPremium.png)

### Interface de tratamentos

Na táboa, os tratamentos arquivados aparecerán ao final, e os activos más novos aparecerán de primeiros.

!["Vista xestión de tratamentos"](/doc/img/vistaTratamento.png)

### Interface de detalles de tratamento

!["Vista detalles tratamento"](/doc/img/vistaDetallesTratamento.png)

### Interface citas médicas para Usuario Estándar (invitado)

O botón verde co "+" levaranos á interface de creación de citas.
A versión para Usuario Estándar será totalmente igual pero sen a columna "Creado por", xa que non tería sentido se so xestiona unha persoa ese perfil.

!["Vista citas médicas Usuario Estándar"](/doc/img/vistaCitasEstandar.png)

### Interface citas médicas para Usuario Premium

Co Usuario Premium poderanse sincronizar as citas médicas con Google Calendar individualmente ou en conxunto.  

!["Vista citas médicas Usuario Premium"](/doc/img/vistaCitasPremium.png)

### Interface de rexistro de cita médica 

!["Vista rexistro cita médica"](/doc/img/vistaRexistroCita.png)


### Interface de xestión de perfís para Usuario Premium

!["Vista perfís Usuario Premium"](/doc/img/vistaXestionPerfilPremium.png)

!["Vista perfís Usuario Premium desplegable"](/doc/img/vistaXestionPerfilPremium2.png)


### Interface de xestión de perfís para Usuario Invitado

!["Vista perfís Usuario invitado desplegable"](/doc/img/vistaXestionPerfilInvitado.png)


### Interface de xestión de perfís para Usuario Estándar creador

!["Vista perfís Usuario Estándar creador"](/doc/img/vistaXestionPerfilEstandar.png)


### Interface de informes

Só dispoñible para Usuarios Premium.
A vista previa xeneraráse nesta mesma páxina entre o xenerador e o histórico de informes.

!["Vista informes personalizados"](/doc/img/vistaInformes.png)
