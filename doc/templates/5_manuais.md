# Manuais

## Manual técnico do proxecto

### Instalación

Neste apartado describiranse todos os pasos necesarios para que calquera persoa poida descargar o código do proxecto e continuar o seu desenvolvemento.

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

6. **Asegurarse de que no ficheiro `.env`** estánr os datos da base de datos:

   ```
   DB_DATABASE=medicapp
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. **Limpiar os cachés**

   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   php artisan view:clear
   php artisan optimize:clear
   ```

8. **Iniciar o servidor de Laravel**

   Laravel trae un servidor de desenvolvemento integrado. Para iniciar a aplicación, executa:

   ```bash
   php artisan serve
   ```

   Abre `http://127.0.0.1:8000` no navegador para acceder á aplicación.

    **Credenciais de proba para usuario rexistrado**

    - Usuario: proba@medicapp.com
    - Contrasinal: abc123..

---

**Nota**: Se se produce algún erro durante o proceso, comproba que:
- Apache e MySQL están iniciados desde XAMPP.
- Non haxa máis procesos de mysql no Administrador de Tarefas.
- Estás na ruta correcta do proxecto ao executar os comandos.
- As versións de PHP, Node.js e Composer son compatibles con Laravel 12.

## Melloras futuras

* Integración da API CIMA (https://sede.aemps.gob.es/docs/CIMA-REST-API_1_19.pdf)
* Sincronización de tomas de medicamentos con Google Calendar (usuarios premium)
* Notificacións de modificacións de usuarios en perfís colaborativos
* Seguimento de síntomas e efectos secundarios para xerar informes que se poidan compartir co médico.
* Alerta de posibles interaccións medicamentosas se se introducen dous ou máis fármacos con risco coñecido.