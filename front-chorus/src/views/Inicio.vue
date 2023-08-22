<template>
    <div class="image-container">
        <img src="../../public/banner.jpg" height="600" class="w-100 mt-3" alt="Imagen">
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
            <div class="d-flex justify-content-center">
                <img src="../../public/logoBlanco.png" width="300" alt="Logo">
            </div>
        </div>
    </div>
</template>