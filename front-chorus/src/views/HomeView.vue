<template>
  <div class="gradiente">
    <img :src="logoUrl" alt="Chorus">
  </div>
  <div class="col-lg-8 offset-lg-2">
    <div class="bg-white borde" id="fondo">
      <h1>Bienvenido a la Gestión de Coros</h1>
      <p>
        Diseñada para coros de todas las magnitudes, Chorus permite a los
        usuarios administrar de manera eficiente y efectiva todos los aspectos relacionados con sus coros y las obras
        interpretadas.
      </p>
      <p>
        Con Chorus, puedes crear y gestionar perfiles de usuarios personalizados para cantores y directores,
        asignándoles los roles y permisos correspondientes. Cada coro tiene su propio espacio dedicado, donde puedes
        almacenar y organizar las partituras de las obras interpretadas. Además, Chorus facilita la asociación de
        videos
        o audios a cada partitura, permitiéndote mantener un archivo completo de las interpretaciones.
      </p>
      <p>
        La aplicación Chorus está impulsada por una robusta base de datos MariaDB, que garantiza la seguridad y la
        eficiencia en el almacenamiento de todos los datos relacionados con los coros, los usuarios, las partituras y
        los archivos multimedia asociados. Además, el uso de Docker como entorno de contenedorización asegura una
        fácil
        implementación y escalabilidad del proyecto.
      </p>
      <p>
        Ya sea que administres un pequeño coro local o una gran organización coral, Chorus te proporciona las
        herramientas
        necesarias para optimizar la gestión de tus coros, las obras interpretadas y el material multimedia asociado.
        Descubre la experiencia de Chorus y lleva tu experiencia coral al siguiente nivel.
      </p>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      logoUrl: process.env.BASE_URL + 'logoBlanco.png'
    };
  },
  mounted() {
    document.title = "Chorus - Inicio";
  },
};
</script>

<style>
#fondo {
  padding: 30px;
}
</style>