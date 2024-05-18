<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-vue3';

// Usando usePage para obtener las propiedades de Ziggy
const { props } = usePage();
const route = window.route; // Ziggy debería exponer la función `route` globalmente

const name = ref("Jaime");
const email = ref("jaime@gmail.com");
const password = ref("jaime");

const submitForm = async () => {
  try {
    await Inertia.post(route('user.store'), {
      name: name.value,
      email: email.value,
      password: password.value
    });
  } catch (error) {
    console.error(error);
  }
}
</script>



<template>
    <AppLayout title="Hello User">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Usuarios
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <form @submit.prevent="submitForm">
                            <label for="name">Nombre</label>
                            <input type="text" v-model="name" />
                            <label for="email">Correo</label>
                            <input type="text" v-model="email" />
                            <label for="password">Contraseña</label>
                            <input type="password" v-model="password" />

                            <button type="submit">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
