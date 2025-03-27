# Proxecto DAW DUAL

## Resumo

En liñas xerais, o Módulo de Proxecto pretende complementar o aprendido no conxunto dos módulos do ciclo, poñendo en práctica as competencias adquiridas no contexto dun proxecto de desenvolvemento de software escollido e definido polo alumnado.

En concreto, o que se pretende é contrastar aquelas competencias profesionais relacionadas coas fases de análise, deseño, planificación, xestión e implantación dun proxecto orientado ao desenvolvemento dun produto software. Do mesmo xeito, tamén se pretende facer un achegamento á iniciativa emprendedora, a partires do desenvolvemento dun estudo de necesidades e da elaboración dun modelo de negocio que valore as posibilidades de comercialización do produto.

## Fases

Inicialmente débese decidir en que vai consistir o proxecto a desenvolver.

A documentación que haberá que entregar elaborarase usando como base os documentos "modelo" que están no repositorio, no directorio "templates". Eses "modelos inclúen todos os apartados dos documentos a cubrir e as fases a seguir para o desenvolvemento do proxecto.

No repositorio, no directorio "doc/material_axuda" hai documentos que poden orientar na realización do proxecto.

## Aspectos técnicos

Está creado un documento no repositorio como modelo base para cada apartado do proxecto.

A modo de axuda e organización, pódese utilizar o taboleiro do proxecto, indicando o seu estado: en desenvolvemento ou finalizado.

Pódese consultar información máis detallada nos "README.md" do repositorio. Este arquivo hai que cubrilo ao final ou a medida que se vai realizando o proxecto.

## Requisitos

Para acadar unha avaliación positiva do proxecto, deben cubrirse os seguintes requisitos:

### Requisitos mínimos

* Frontend
  * Linguaxes: [HTML5](https://developer.mozilla.org/en-US/docs/Web/Guide/HTML/HTML5), [CSS3](https://developer.mozilla.org/en-US/docs/Web/CSS), [JavaScript](https://developer.mozilla.org/en-US/docs/Web/javascript).
  * [Responsive design](https://developers.google.com/web/fundamentals/design-and-ux/responsive/).
  * Comunicación asíncrona: [AJAX](https://developer.mozilla.org/en-US/docs/Web/Guide/AJAX).
  * Uso de librerías e/ou frameworks JavaScript: [jQuery](https://jquery.com/), [ReactJS](https://reactjs.org/), [VueJS](https://vuejs.org/), [AngularJS](https://angularjs.org/), etc.
  * Validación de formularios.
* Backend
  * Linguaxes (escoller): [PHP](https://www.php.net/), [NodeJS](https://nodejs.org/), [Ruby](https://www.ruby-lang.org/en/)
, etc.
  * Uso da programación orientada a obxectos.
Utilización de bases de datos SQL e/ou NonSQL: [MySQL](https://www.mysql.com/)
, [MariaDB](https://mariadb.com/), [PostgreSQL](https://www.postgresql.org/), [MongoDB](https://www.mongodb.com/), [Redis](https://redis.io/)
, etc.
  * Seguridade: validación de datos, [control de inxección SQL](https://es.wikipedia.org/wiki/Inyecci%C3%B3n_SQL) e/ou [NonSQL](https://ckarande.gitbooks.io/owasp-nodegoat-tutorial/content/tutorial/a1_-_sql_and_nosql_injection.html), [Cross Site Scripting (XSS)](https://es.wikipedia.org/wiki/Cross-site_scripting).

### Requisitos opcionais

Algúns dos requisitos que se nomean a continuación axudan a conseguir unha mellor cualificación final no proxecto:

* Frontend
  * Comunicación asíncrona: [WebSockets](https://developer.mozilla.org/en-US/docs/Web/API/WebSockets_API), [WebRTC](https://developer.mozilla.org/en-US/docs/Web/API/WebRTC_API).
  * Uso de framework CSS: [Bootstrap](https://getbootstrap.com/), [Foundation](https://get.foundation/), [Pure](https://purecss.io/), [UIkit](https://getuikit.com/), etc.
  * Uso dun preprocesador CSS: [LESS](http://lesscss.org/), [SASS](https://sass-lang.com/), [Stylus](https://stylus-lang.com/), etc.
* Backend
  * Implementación dunha API [REST](https://en.wikipedia.org/wiki/Representational_state_transfer).
  * Implementación de [OAuth](https://en.wikipedia.org/wiki/OAuth).
  * Envío de arquivos ao servidor.
  * Integración con bots: [Telegram](https://core.telegram.org/bots), [Facebook Messenger](https://developers.facebook.com/docs/messenger-platform), [Google](https://developers.google.com/hangouts/chat/concepts/bots), [Discord](https://discordapp.com/developers/docs/intro), [Slack](https://api.slack.com/bot-users), etc.
  * Integración con API's externas.
  * Integración de servicios de mapas: [OpenStreetMaps](https://www.openstreetmap.org/), [Google Maps](https://maps.google.com/), etc.

## Software desenvolvido

Debe proporcionarse algunha forma de probar o software desenvolvido. Para isto existen dúas posibilidades:

* Servidor externo (recomendado): ter a aplicación desenvolvida nun servidor accesible desde internet. Neste caso, unicamente se debe indicar a URL da aplicación na documentación do proxecto.
* Máquina virtual: entregar a máquina virtual con todo o sistema funcionando. Deben adxuntarse unhas instruccións para poder realizar as probas sobre a máquina virtual.

Independientemente de cal foi a maneira de proporcionar o software desenvolvido, a entrega do código fonte debe realizarse a través de [GitLab](https://gitlab.iessanclemente.net).

## Criterios de avaliación mínimos

Os seguintes criterios deben ser cumpridos para poder entregar e defender o proxecto:

* O proxecto debe alcanzar os obxectivos marcados na programación ou anteproxecto (non se entregarán cousas “a medio facer”).
* O proxecto debe ser orixinal e elaborado exclusivamente polo alumnado que o presenta. Debe quedar moi claro (por medio de citas ou contido na propia documentación) as partes realizadas por terceiros e a súa licenza de uso.
* En caso de realizar un proxecto orientado á creación dun entregable, este debe executarse correctamente e debe incluír unha descrición detallada da súa posta en marcha.
* Na presentación e defensa do proxecto non se poderá incluír ningún tipo de material que non figure na documentación ou entregables finais entregados ata a data límite de entrega do proxecto.
* Deben cumprirse os prazos de entrega establecidos das diferentes fases.

## Calendario de entregas

* Estudo preliminar: semana 1.
* Análise: requirimentos do sistema: semana 2.
* Deseño: semana 3.
* Codificación e probas: semanas 4-13.
* Manuais do proxecto: semana 14.
* Entrega da documentación e do software desenvolvido.
* Defensa do proxecto.