# Guía de Instalación de XAMPP

## Requisitos del Sistema

- **Windows**: Windows 10, 8, 7 (32 o 64 bits)
- **Linux**: Distribuciones basadas en Debian o Red Hat
- **macOS**: macOS 10.13 o superior

## Pasos de Instalación

### 1. Descargar XAMPP

1. Visita la página oficial de XAMPP.
2. Selecciona tu sistema operativo (Windows, Linux, macOS).
3. Descarga la última versión de XAMPP.

### 2. Instalar XAMPP en Windows

1. Ejecuta el archivo descargado (`xampp-windows-x64-x.x.x-installer.exe`).
2. Sigue las instrucciones del instalador:
    - Selecciona los componentes que deseas instalar (Apache, MySQL, PHP, etc.).
    - Elige la carpeta de destino (por defecto es `C:\xampp`).
3. Haz clic en `Next` y luego en `Install`.
4. Una vez completada la instalación, haz clic en `Finish` para abrir el Panel de Control de XAMPP.

### 3. Instalar XAMPP en Linux

1. Abre una terminal y navega hasta el directorio donde descargaste el archivo (`xampp-linux-x64-x.x.x-installer.run`).
2. Haz el archivo ejecutable:
    ```bash
    chmod +x xampp-linux-x64-x.x.x-installer.run
    ```
3. Ejecuta el instalador:
    ```bash
    sudo ./xampp-linux-x64-x.x.x-installer.run
    ```
4. Sigue las instrucciones del instalador gráfico.

### 4. Instalar XAMPP en macOS

1. Abre el archivo descargado (`xampp-osx-x.x.x-installer.dmg`).
2. Arrastra el icono de XAMPP a la carpeta `Applications`.
3. Abre XAMPP desde la carpeta `Applications`.

## Uso del Panel de Control de XAMPP

1. Abre el Panel de Control de XAMPP.
2. Inicia los servicios necesarios (Apache, MySQL, etc.) haciendo clic en `Start`.
3. Accede a tu servidor local abriendo un navegador web y navegando a `http://localhost`.

## Solución de Problemas Comunes

- **Puerto 80 en uso**: Cambia el puerto de Apache en el archivo `httpd.conf`.
- **MySQL no inicia**: Verifica que no haya otro servicio usando el puerto 3306.

## Desinstalación de XAMPP

### Windows

1. Abre el Panel de Control de XAMPP.
2. Haz clic en `Uninstall`.

### Linux

1. Ejecuta el desinstalador:
    ```bash
    sudo /opt/lampp/uninstall
    ```

### macOS

1. Elimina la carpeta `XAMPP` de `Applications`.

---

¡Listo! Ahora tienes XAMPP instalado y funcionando en tu sistema. Si tienes alguna pregunta o necesitas más ayuda, no dudes en preguntar.
