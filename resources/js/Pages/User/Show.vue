<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps(['user']);

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
                        <div class="p-6">
                            <div class="mb-5">
                                <label class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
                                <p class="bg-gray-50 border border-gray-300 rounded-lg p-2.5">{{ user.name }}</p>
                            </div>
                            <div class="mb-5">
                                <label class="block mb-2 text-sm font-medium text-gray-900">Correo</label>
                                <p class="bg-gray-50 border border-gray-300 rounded-lg p-2.5">{{ user.email }}</p>
                            </div>
                            <div class="mb-5">
                                <label class="block mb-2 text-sm font-medium text-gray-900">Fecha de Creación</label>
                                <p class="bg-gray-50 border border-gray-300 rounded-lg p-2.5">{{ user.created_at }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
