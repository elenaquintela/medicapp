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

Describir con detalle e precisión que operacións se van poder realizar a través da aplicación informática, indicando que actores interveñen en cada caso.

Enumeralas, de maneira que na fase de deseño se poida crear o caso de uso correspondente a cada funcionalidade.

Cada función ten uns datos de entrada e uns datos de saída. Entre os datos de entrada e de saída, realízase un proceso, que debe ser explicado.

Exemplo:

| Acción | Descrición |
|--------|------------|
| Alta cliente | Dar de alta un cliente na base de datos |
| Modificar cliente | Modificar un cliente na base de datos |
| Eliminar cliente | Cliente eliminado da base de datos |

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