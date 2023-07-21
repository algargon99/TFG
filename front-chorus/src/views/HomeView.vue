<template>
  <div class="gradiente">
    <img :src="logoUrl" alt="Chorus">
  </div>
  <div class="col-lg-8 offset-lg-2">
    <div class="bg-white borde" id="fondo">
      <h1 class="m-3">Bienvenido a la Gestión de Coros</h1>
      <p class="m-4">
        Diseñada para coros de todas las magnitudes, Chorus permite a los
        usuarios administrar de manera eficiente y efectiva todos los aspectos relacionados con sus coros y las obras
        interpretadas.
      </p>
      <p class="m-4">
        Con Chorus, puedes crear y gestionar perfiles de usuarios personalizados para cantores y directores,
        asign&aacute;ndoles los roles y permisos correspondientes. Cada coro tiene su propio espacio dedicado, donde
        puedes almacenar y organizar las partituras de las obras interpretadas. Adem&aacute;s, Chorus facilita la
        asociaci&oacute;n de v&iacute;deos o audios a cada partitura, permiti&eacute;ndote mantener un archivo completo de
        las interpretaciones.
      </p>
      <p class="m-4">
        La aplicaci&oacute;n Chorus est&aacute; impulsada por una robusta base de datos MariaDB, que garantiza la
        seguridad y la eficiencia en el almacenamiento de todos los datos relacionados con los coros, los usuarios, las
        partituras y los archivos multimedia asociados. Adem&aacute;s, el uso de Docker como entorno de
        contenedorizaci&oacute;n asegura una f&aacute;cil implementaci&oacute;n y escalabilidad del proyecto.
      </p>
      <p class="m-4">
        Ya sea que administres un peque&ntilde;o coro local o una gran organizaci&oacute;n coral, Chorus te proporciona
        las herramientas necesarias para optimizar la gesti&oacute;n de tus coros, las obras interpretadas y el material
        multimedia asociado. Descubre la experiencia de Chorus y lleva tu experiencia coral al siguiente nivel.
      </p>
      <p class="m-4">
        Para cualquier consulta, sugerencia o asistencia relacionada con el funcionamiento de esta p&aacute;gina, nuestro
        equipo de administraci&oacute;n est&aacute; siempre dispuesto a ayudarte. No dudes en hacer uso del bot&oacute;n
        de contacto que se encuentra a continuaci&oacute;n para comunicarte con nosotros. Estamos comprometidos en
        brindarte el mejor apoyo posible para que puedas potenciar tu experiencia musical y alcanzar nuevos niveles de
        armon&iacute;a y entusiasmo en tus coros.
      </p>
      <div class="d-flex justify-content-center">
        <router-link to="/contacto" class="btn btn-info">Contacto</router-link>
      </div>
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