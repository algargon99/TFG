<template>
    <div class="image-container">
        <img src="../../public/banner.jpg" height="700" class="w-100" alt="Imagen">
        <div class="button-container">
            <div>
                <span id="eslogan" class="text-white"><b>Gaudeamus igitur, <br>Chorus advenit</b></span>
            </div>
            <div class="d-flex justify-content-center">
                <div v-if="this.$store.state.isAuthenticated == false" class="mx-4">
                    <router-link :to="{ path: '/login' }" class='btn bg-white p-3'>
                        Inicia sesi&oacute;n
                    </router-link>
                </div>
                <div>
                    <router-link :to="{ path: '/coros' }" class='btn btn-info p-3'>
                        Con&oacute;cenos
                    </router-link>
                </div>
            </div>
        </div>
    </div>
    <div>
        <p class="m-4">
            Bienvenido a Chorus, la plataforma perfecta para todos los amantes de la m&uacute;sica coral. &iquest;Te
            apasiona
            el canto en coros y buscas una manera de conectarte con otros entusiastas como t&uacute;? &iexcl;No busques
            m&aacute;s! Chorus te ofrece una experiencia &uacute;nica para descubrir y unirte a diversos coros en tu
            &aacute;rea y m&aacute;s all&aacute;. Con nuestra intuitiva aplicaci&oacute;n, podr&aacute;s explorar una amplia
            gama de coros, desde aquellos que se centran en cl&aacute;sicos atemporales hasta los que celebran la
            m&uacute;sica contempor&aacute;nea. &iexcl;La comunidad coral te espera con los brazos abiertos y estamos
            emocionados de que te unas a nosotros en este emocionante viaje musical!
        </p>
    </div>
</template>