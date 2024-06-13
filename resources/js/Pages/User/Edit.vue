<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['user']);

const form = ref({
    name: props.user.name,
    email: props.user.email,
    password: props.user.password,
})


const submitForm = async () => {
    try {
        // Construye la URL con el identificador del usuario
        const url = route('user.update', { user: props.user.id });
        await Inertia.put(url, form.value);
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
                        <form @submit.prevent="submitForm" class="bg-gray-50 border border-gray-300 rounded-lg p-6">
                            <div class="mb-5">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
                                <input type="text" v-model="form.name" id="name" placeholder="Escribe tu Nombre"
                                    class="w-full p-2.5 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    required />
                                <div v-if="$page.props.errors.name" class="text-red-500">
                                    {{ $page.props.errors.name }}
                                </div>
                            </div>
                            <div class="mb-5">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Correo</label>
                                <input type="email" v-model="form.email" id="email"
                                    placeholder="Escribe tu Correo Electronico"
                                    class="w-full p-2.5 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    required />
                                <div v-if="$page.props.errors.email" class="text-red-500">
                                    {{ $page.props.errors.email }}
                                </div>
                            </div>
                            <div class="mb-5">
                                <label for="password"
                                    class="block mb-2 text-sm font-medium text-gray-900">Contraseña</label>
                                <input type="password" v-model="form.password" id="password"
                                    class="w-full p-2.5 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" />
                                <small class="text-gray-600">Deje en blanco si no desea cambiar la contraseña</small>
                                <div v-if="$page.props.errors.password" class="text-red-500">
                                    {{ $page.props.errors.password }}
                                </div>
                            </div>
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 
                                focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full 
                                sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Eviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
