# Proxecto de fin de ciclo DAW

> *Tarefa*: Este documento será a páxina de inicio do teu proxecto. Será o primero que vexan os que se interesen por el. Coida a súa redacción e ortografía. Elimina todas as liñas "*Tarefa*" cando teñas a redacción de todo o proxecto completada.
> Podes acompañar a redacción deste ficheiros con imaxes ou GIFs, pero non abuses deles. 


## Descrición
> *Tarefa*: Realiza unha breve descrición do proxecto (entre 100 e 300 palabras). Resalta o fundamental **coas túas palabras**. Utiliza unha linguaxe correcta, pero natural, que o entenda todo o mundo, incluso e en especial, as persoas que non teñan un coñecemento técnico avanzado. Pode ser un estrato ou resumo dos apartados que se contemplan na memoria.

## Instalación
> *Tarefa*: Neste apartado describe con toda precisión e, a poder ser, coa maior simplicidade/facilidade posible, como poñer en marcha a túa aplicación para probala (nun entorno local). Valorarase moi positivamente que este proceso sexa o máis fácil posible, cunha simple instrución (por exemplo, un script de instalación).

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
   git clone https://gitlab.com/usuario/medicapp.git
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
   npm run build
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
   - Selecciona o ficheiro `medicapp.sql` incluído na carpeta do proxecto e pulsa en **Continuar**

6. **Editar o ficheiro `.env`** para engadir os datos da base de datos:

   ```
   DB_DATABASE=medicapp
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. **Executar migracións**

   ```bash
   php artisan migrate
   ```

8. **Iniciar o servidor de Laravel**

   Laravel trae un servidor de desenvolvemento integrado. Para iniciar a aplicación, executa:

   ```bash
   php artisan serve
   ```

   Abre `http://localhost:8000` no navegador para acceder á aplicación.

---

**Nota**: Se se produce algún erro durante o proceso, comproba que:
- Apache e MySQL están iniciados desde XAMPP.
- Estás na ruta correcta do proxecto ao executar os comandos.
- As versións de PHP, Node.js e Composer son compatibles con Laravel 10.


## Uso
> *Tarefa*: Neste apartado, describe brevemente como se usará o software. Se ten unha interfaz de terminal, describe aquí a súa sintaxe. Se ten unha interfaz gráfica de usuario, describe aquí **só o uso** (a modo de sumario) **dos aspectos máis relevantes do seu funcionamento** (máxima brevidade, como se fose un anuncio reclamo ou comercial).

## Sobre el autor
> *Tarefa*: Realiza unha breve descrición de quen es desde unha perspectiva profesional, os teus puntos fortes, tecnoloxías que máis dominas e o motivo de por que te decantaches por este proxecto. **Non máis de 200 palabras**. Indica unha forma fiable de contactar contigo no presente e no futuro.

## Licencia
> *Tarefa*: É requisito INDISPENSABLE licenciar explicitamente o proxecto. Crea un ficheiro `LICENSE` na raíz do repositorio.

## Guía de contribución
> *Tarefa*: Se o teu proxecto se trata de software libre, é importante que expoñas como se pode contribuir a el. Algúns exemplos disto son realizar novas funcionalidades, corrección e/ou optimización de código, realización de tests automatizados, novas interfaces de integración, desenvolvemento de plugins, etc. Intenta dar unha mensaxe concisa.


## Memoria

> *Tarefa*: Indexa de forma ordenada a memoria do teu proxecto.
> Durante a redacción da memoria, debes ir completando progresivamente o anexo de Referencias.

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
