# Proxecto de fin de ciclo DAW

## Descrición

**MedicApp** é unha aplicación web deseñada para axudar ás persoas usuarias a levar ao día a súa medicación e as súas citas médicas, sen complicacións, cunha interface clara e manexable con poucos clics. O uso está guiado paso a paso: rexistro de usuario, elección do plan (estándar ou premium), creación dun perfil de doente, definición de tratamentos médicos e incorporación dos medicamentos correspondentes. A partir de aí, o sistema calcula automaticamente as próximas tomas, móstraas na páxina principal e xera unha notificación xusto á hora indicada.

En canto ás citas médicas, o usuario pode rexistralas indicando data, hora, especialidade, lugar e motivo, engadindo tamén observacións se o precisa. Estas citas aparecen igualmente na páxina principal e o sistema lanza unha notificación 30 minutos antes de cada unha.

Existen diferenzas segundo o plan escollido. Tanto o plan estándar como o plan premium permiten crear e xestionar varios perfís de doente. Porén, só co plan premium é posible compartir perfís con familiares ou coidadores a través do correo electrónico, sincronizar citas con Google Calendar para telas no móbil e xerar informes en PDF co histórico completo.

## Instalación

Para executar esta aplicación localmente, recoméndase usar **XAMPP** como contorno de desenvolvemento (inclúe PHP, Apache e MySQL) xunto con **Composer** e **Node.js**.

A continuación detállanse os pasos para poñer en marcha o proxecto:

---

### Requisitos previos

1. **XAMPP** (https://www.apachefriends.org)  
   Inclúe PHP, Apache e MySQL. Instala e inicia os servizos de **Apache** e **MySQL**.

2. **Composer** (https://getcomposer.org/download)  
   Instalador oficial para xestionar dependencias PHP.

3. **Node.js** (https://nodejs.org)  
   Recomendado instalar a versión LTS estable.

---

### Pasos para a instalación

1. **Clonar ou descargar o proxecto**

   Podes clonar o repositorio en calquera carpeta do teu equipo (non é necesario copialo en `htdocs`):

   ```bash
   git clone ssh://git@gitlab.iessanclemente.net:60600/dawdu/a23elenaqb.git
   cd medicapp
   ```

   Pero se se descarga como ZIP, débese copiar a carpeta do proxecto en:

   ```
   C:\xampp\htdocs\medicapp
   ```

2. **Instalar as dependencias de PHP (Laravel)**

   ```bash
   composer install
   ```

3. **Instalar as dependencias de frontend (JavaScript e CSS)**

   ```bash
   npm install
   npm run dev
   ```

4. **Configurar o entorno**

   Renomear o arquivo `.env.example` como `.env`:

   ```bash
   cp .env.example .env
   ```

   E xerar a chave da aplicación:
 
   ```bash
   php artisan key:generate
   ```

5. **Crear a base de datos**

   - Accede a `http://localhost/phpmyadmin`
   - Crea unha base de datos nova chamada `medicapp`
   - Preme sobre a base de datos e vai á pestana **Importar**
   - Selecciona o ficheiro `medicapp.sql` incluído na carpeta do proxecto e preme **Continuar**

6. **Editar o ficheiro `.env`** para engadir os datos da base de datos:

   ```
   DB_DATABASE=medicapp
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. **Iniciar o servidor de Laravel**

   Laravel trae un servidor de desenvolvemento integrado. Para iniciar a aplicación, executa:

   ```bash
   php artisan serve
   ```

   Abre `http://127.0.0.1:8000` no navegador para acceder á aplicación.

---

**Nota**: Se se produce algún erro durante o proceso, comproba que:
- Apache e MySQL están iniciados desde XAMPP.
- Non haxa máis procesos de mysql no Administrador de Tarefas.
- Estás na ruta correcta do proxecto ao executar os comandos.
- As versións de PHP, Node.js e Composer son compatibles con Laravel 12.

## Uso

**MedicApp** está feita para rexistrar tratamentos e citas médicas de forma sinxela, lembrando automaticamente as tomas e avisando con antelación das citas. Todo se amosa nun panel principal claro e accesible. Co plan premium, ademais, pódense compartir perfís, sincronizar citas con Google Calendar e xerar informes en PDF.

## Sobre o autor
> *Tarefa*: Realiza unha breve descrición de quen es desde unha perspectiva profesional, os teus puntos fortes, tecnoloxías que máis dominas e o motivo de por que te decantaches por este proxecto. **Non máis de 200 palabras**. Indica unha forma fiable de contactar contigo no presente e no futuro.

## Licencia

Este proxecto licénciase baixo GNU GPL v3. Consulta o ficheiro [LICENSE](/LICENSE) na raíz do repositorio.

## Guía de contribución

Este proxecto é software libre e as contribucións son sempre benvidas. Pódese colaborar de diferentes xeitos: engadindo novas funcionalidades, corrixindo ou optimizando código existente, propoñendo melloras na interface, desenvolvendo integracións con outros servizos ou achegando tests automatizados que aumenten a calidade do sistema.

Se desexas contribuír:

1. Crea unha *issue* describindo o cambio ou mellora que propoñas.

2. Fai un *fork* do repositorio e desenvolve os cambios nunha rama propia.

3. Envía un *merge request* detallado para a súa revisión.

Lembra manter un estilo de código coherente co resto do proxecto, respectar a licenza GPL v3 e evitar incluír credenciais ou datos persoais.

## Memoria

1. [Estudo preliminar](doc/templates/1_estudo_preliminar.md)
2. [Análise: Requerimentos do sistema](doc/templates/2_analise.md)
3. [Deseño](doc/templates/3_deseno.md)
4. [Codificación e Probas](doc/templates/4_codificacion_probas.md)
5. [Manuais](doc/templates/5_manuais.md)
6. [Defensa](doc/templates/6_defensa_do_proxecto.md)

#### Anexos
1. [Referencias](doc/templates/a1_referencias.md)
1. [Planificación](doc/templates/a2_planificacion.md)
2. [Orzamento](doc/templates/a3_orzamento.md)
