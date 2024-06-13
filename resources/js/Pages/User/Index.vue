<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import JetDialogModal from '@/Components/DialogModal.vue';
import { computed, ref } from 'vue';

import VPagination from "@hennge/vue3-pagination"; // Importa VPagination
import "@hennge/vue3-pagination/dist/vue3-pagination.css";

let searchTerm = ref(''); // Agrega esto

const handleSearch = () => {
    Inertia.get(route('user.index', { search: searchTerm.value }));
};

let currentPage = ref(1); // Página actual
const perPage = 5; // Elementos por página

const paginatedUsers = computed(() => {
    const start = (currentPage.value - 1) * perPage;
    const end = start + perPage;
    return props.users.slice(start, end);
});

const onPageChanged = (newPage) => {
    currentPage.value = newPage;
};

const props = defineProps(['users']);
let modalOpen = ref(false);
let selectedUser = ref({});

const destroy = async () => {
    try {
        await Inertia.delete(route('user.destroy', { user: selectedUser.value }));
        modalOpen = false;
    } catch (error) {
        console.error('Error eliminando usuario:', error);
    }
}


</script>

<template>
    <AppLayout title="Hello User">
        <jet-dialog-modal :show="modalOpen">
            <template v-slot:title>
                <h1>Eliminar Usuario</h1>
            </template>
            <template v-slot:content>
                <p v-if="selectedUser">Seguro que quieres eliminar este usuario: <strong>{{ selectedUser.email
                }}</strong>?
                </p>
            </template>
            <template v-slot:footer>
                <button @click="destroy" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Eliminar
                </button>
                <button @click="modalOpen = false"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Cerrar
                </button>

            </template>
        </jet-dialog-modal>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Usuarios
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 ml-2 mt-2 mb-2 rounded"
                            @click="$inertia.visit(route('user.create'))">Crear Usuario</button>
                        <div class="flex items-center justify-between mb-4 ml-2 mr-2">
                            <input v-model="searchTerm"
                                class="mr-4 border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                                type="search" name="search" placeholder="Buscar usuario">
                            <button @click="handleSearch"
                                class="bg-blue-500 text-white px-6 py-2 rounded font-medium">Buscar</button>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Id</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="user in paginatedUsers" :key="user.id">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ user.id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button @click="$inertia.visit(route('user.show', { user: user }))"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-4">Ver</button>
                                        <button @click="$inertia.visit(route('user.edit', { user: user }))"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4">Editar</button>
                                        <button @click="if (user) { modalOpen = true; selectedUser = user; }"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <VPagination v-model="currentPage" :pages="Math.ceil(props.users.length / perPage)" :range-size="1"
                            active-color="#DCEDFF" @update:modelValue="onPageChanged" />
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
