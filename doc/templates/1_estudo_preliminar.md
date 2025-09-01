# Estudo preliminar

## 1. Descrición do proxecto

Esta aplicación web  ten como obxectivo principal simplificar a xestión da medicación e das citas médicas para persoas que deben seguir tratamentos complexos, minimizando así o risco de erros e mellorando o seguimento xeral da súa saúde. 

### 1.1. Xustificación do proxecto

A idea do proxecto está inspirada na miña experiencia persoal, xa que debido á situación médica da miña nai, xurdiu no ámbito familiar a necesidade de xestionar múltiples tratamentos, medicamentos, citas médicas e demais xestións.
Como ela, moitos doentes crónicos teñen dificultades para recordar cando e como tomar os seus medicamentos, e tamén para organizar as súas citas médicas. Isto pode xerar un estrés innecesario e, no peor dos casos, dar lugar a erros que poidan prexudicar a saúde.
Dito o anterior, este proxecto espera poder contribuír a cumprir mellor co tratamento médico, facilitar a comunicación cos profesionais da saúde e ofrecer un seguimento continuo e detallado da saúde xeral do usuario.

### 1.2. Funcionalidades do proxecto

**Funcionalidades básicas**
* Xestión de tratamentos/medicación:
    - Rexistro de tratamentos (motivo, data de inicio).
    - En cada tratamento, rexistro de fármacos consumidos (nome, dose, instrucións do médico, prospecto).
    - Alertas e recordatorios para a toma de cada medicamento, para a renovación dalgunha receita ou para recoller a medicación na farmacia cando se está a acabar.
    - Rexistro histórico de cambios (por exemplo, cando se substitúe un medicamento por outro).

* Xestión de citas médicas:
    - Rexistro de citas (motivo, data, lugar, nome do médico, especialidade).
    - Apartados opcionais para anotar síntomas, observacións ou preguntas a realizar durante a consulta.

**Funcionalidades avanzadas:**
* Sincronización con calendarios externos como Google Calendar.
* Seguimento de síntomas e efectos secundarios para xerar informes que se poidan compartir co médico.
* Alerta de posibles interaccións medicamentosas se se introducen dous ou máis fármacos con risco coñecido.
* Soporte multiusuario para facilitar a xestión centralizada dos tratamentos, no caso de que tamén a usen familiares ou coidadores.

### 1.3. Estudo de necesidades

Actualmente, existen diversas aplicacións que se encargan da xestión da medicación e as citas médicas, como por exemplo, Mediasafe ou MyTherapy. Aínda así, son aplicacións móbiles para iOs e Android e non teñen versión web.

En cambio, na contorna web podemos atopar aplicacións como MyChart (desenvolta por EPIC) e HealtheLife (de Cerner). Ambas están orientadas a contornas profesionais, como clínicas e hospitais, cos que ditas empresas de desenvolvemento de software establecen acordos para xestionar centralizadamente a información médica dos doentes,  ofrecéndolles a estes acceso aos seus datos e historial e tamén facilitándolles a comunicación e xestión de citas. Ao estar orientadas a centros sanitarios, sobre todo de Estados Unidos, a maioría dos usuarios destas aplicacións son de dito país, o que limita bastante o seu alcance. Ademais, non contan cun servizo de xestión de medicación, nin outras tantas funcionalidades que ofrecerá este proxecto, xa que se trata de algo similar ás ferramentas E-Saúde ou Telea, ambas do Sergas.

Dado que non existen aplicacións web similares á aquí exposta, tomaremos as aplicacións móbiles Medisafe e MyTherapy para establecer comparacións, determinando as súas fortalezas e carencias.

Medisafe céntrase na xestión de medicación e é unha das aplicacións de saúde líderes no seu sector, xa que conta con millóns de descargas e unha elevada valoración media dos usuarios. Destacan elementos como os recordatorios e alarmas, as súas opcións de personalización e unha interfaz bastante intuitiva. Pola contra, MyTherapy, a pesar de non contar con tanto recoñecemento, ten un enfoque máis global, xa que tamén incorpora: seguimento dos síntomas, rexistro de parámetros  (presión arterial, peso, etc...), un diario de saúde para anotar eventos relevantes, informes e estatísticas sobre a evolución da saúde do usuario, e funcións adicionais para planificar actividades relacionadas co coidado persoal.

Analizando as reseñas destas dúas aplicacións en Google Play e Apple App Store, atopámonos con varios aspectos que botan en falta os usuarios e que se poderían superar con este proxecto:
* **Maior personalización**  
Aos usuarios gustaríalles que os recordatorios e notificacións puidesen personalizarse máis e ter a posibilidade de elixir entre distintos tons e formatos de alerta axustados ás súas rutinas persoais. Tamén resaltan a falta de recomendacións de saúde e estilo de vida personalizadas segundo a súa situación médica.
* **Interfaz adaptada a usuarios da terceira idade**  
A interface destas aplicacións, malia ser amigable, presenta dificultades de navegación para os usuarios de avanzada idade. Probablemente un deseño máis simple solucionaría este problema. 
* **Un seguimento máis detallado**   
Aos usuarios gustaríalles incluír funcionalidades coas que poidan rexistrar máis información e ter un historial máis completo da súa saúde, como por exemplo: cambios na medicación, efectos secundarios e notas persoais para compartir co seu médico. Ademais, suxiren que toda esta información se presente de xeito visual, con resumos sinxelos, para facilitar a súa comprensión.

En resumo, atopámonos con aplicacións existentes como Medisafe e MyTherapy que non cobren completamente as necesidades dos usuarios. Polo tanto, o noso obxectivo é desenvolver unha aplicación web (tamén adaptada a tablet e móbil) que ofreza unha experiencia mellorada, centrándonos especialmente na personalización, accesibilidade e funcionalidades de seguimento.

### 1.4. Persoas destinatarias

**Público obxectivo principal:** Persoas con enfermidades ou condicións crónicas, principalmente de idade avanzada, que requiren xestionar múltiples medicamentos e citas e levar un seguimento regular debido á complexidade do seu tratamento.

**Outros destinatarios:**
* Familiares e coidadores dos doentes que axudan na administración e control de da medicación e das citas médicas.
* Empresas do sector sanitario e profesionais da saúde en xeral que poidan usar a aplicación para monitorizar o tratamento dos doentes.

### 1.5. Modelo de negocio

O modelo de pago que considero máis axeitado para este proxecto é o modelo freemium. Concretamente, isto implica permitir o acceso de balde ás funcionalidades básicas, tales como o rexistro de citas e medicación e os recordatorios, pero cobrando mediante unha subscrición mensual servizos adicionais, entre os que se inclúen o soporte multiusuario, as alertas avanzadas ou a integración con calendarios externos e outras plataformas como Health Connect (Google Fit).

Por outra banda, este modelo complementaríase con opcións de licenciamento para centros de saúde ou residencias xeriátricas, as cales poderán usar esta ferramenta para a súa xestión interna e contar con soporte técnico e certa personalización. 

Deste xeito, garántense as funcionalidades esenciais sen custo para o usuario, mentres que as funcionalidades premium e os servizos máis individualizados e adaptados poden xerar ingresos para que o negocio evolucione.

## 2. Requirimentos

Tecnoloxías e ferramentas necesarias:

**Desenvolvemento frontend:**
* HTML5
* CSS con Tailwind
* JavaScript (vanilla)
* Blade (motor de plantillas de Laravel)

**Desenvolvemento backend:**

* PHP 8.2 con Laravel 10 (framework principal)
* Laravel Breeze (sistema de autenticación) 
* Barryvdh/laravel-dompdf (libraría para xeración de informes en PDF)
* Google API Client para PHP (libraría para integración con Google Calendar)

**Base de datos:**
* XAMPP con MariaDB (en local)
* MySQL Workbench (para exportar en despregamento)

**Ferramentas de desenvolvemento e despregamento:**
* IDE: Visual Studio Code
* Control de versións: GitLab, e Github (integración con Railway)
* Servidor web: Apache, incluído en XAMPP (en local)
* Railway (despregamento de contenedores)
* Google Cloud Console (xestión das credenciais OAuth 2.0 para a sincronización con Google Calendar)