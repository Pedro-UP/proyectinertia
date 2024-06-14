<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['user']);

const form = ref({
    name: props.user.name,
    email: props.user.email,
    password: props.user.password,
    avatar: null,
})


const submitForm = async () => {
    try {
        const url = route('user.update', { user: props.user.id });
        const formData = { ...form.value };
        delete formData.password || !formData.password;
        await Inertia.post(url, { ...formData, _method: 'PUT' }, {
            preserveScroll: true,
            onStart: () => form.processing = true,
            onProgress: (event) => form.progress = event.percent,
            onFinish: () => form.processing = false,
        });
    } catch (error) {
        console.error(error);
    }
};

const deleteAvatar = async () => {
    try {
        const url = route('user.deleteAvatar', { user: props.user.id });
        await Inertia.delete(url);
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
                            <div class="mb-5">
                                <label for="avatar" class="block mb-2 text-sm font-medium text-gray-900">Avatar</label>
                                <input type="file" id="avatar" @change="form.avatar = $event.target.files[0]"
                                    class="w-full p-2.5 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" />
                                <div v-if="$page.props.errors.avatar" class="text-red-500">
                                    {{ $page.props.errors.avatar }}
                                </div>
                            </div>
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 
                                focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full 
                                sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Eviar</button>
                            <div v-if="user.profile_photo_path">
                                <img :src="user.profile_photo_url" :alt="user.name"
                                    class="rounded-full border-2 border-gray-200 w-32 h-32 m-auto" />
                                <div class="flex justify-center"> <span class="ml-2 text-gray-800">{{ user.name }}</span>
                                </div>
                            </div>
                        </form>
                        <div v-if="user.profile_photo_path">
                            <form @submit.prevent="deleteAvatar" method="post">
                                <button type="submit"
                                    class="mt-2 text-white bg-red-500 hover:bg-red-600 rounded-lg px-4 py-2">Eliminar
                                    avatar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
