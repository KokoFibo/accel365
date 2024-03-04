<script setup>
import Navbar from "@/Components/Navbar.vue";
import Modal from "@/Components/Modal.vue";
import Role from "@/Components/Role.vue";
import { Head, useForm } from "@inertiajs/vue3";

import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
    users: Object,
    data_edit: Object,
    units: Object,
});

const is_add = ref(false);
const is_edit = ref(false);
const is_delete = ref(false);
const msg = ref("");

const form = useForm({
    name: "",
    email: "",
    level: "",
    kode_agent: "",
    unit: "",
});

const editUser = (user) => {
    is_edit.value = true;
    // formValues.value = user;
    form.name = user.name;
    form.email = user.email;
    form.level = user.level;
    form.kode_agent = user.kode_agent;
    form.unit = user.unit;
    form.id = user.id;
};

const deleteUser = (user) => {
    form.id = user.id;
    form.name = user.name;
    // console.log(formValues.value.id);
    is_delete.value = true;
};
</script>

<template>
    <Head title="Registration" />
    <Navbar />
    <div v-if="msg">
        <p class="text-green-500">{{ msg }}</p>
    </div>

    <!-- Header -->
    <h1 class="text-blue-500 m-10 text-3xl font-semibold text-center">
        Registration {{ is_add_close }}
    </h1>

    <!-- Table -->
    <div
        class="w-full lg:w-4/5 mx-auto p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
    >
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Level</th>
                        <th scope="col" class="px-6 py-3">Role</th>
                        <th scope="col" class="px-6 py-3">Unit</th>
                        <th scope="col" class="px-6 py-3">Location</th>
                        <th scope="col" class="px-6 py-3">
                            <button
                                @click="is_add = true"
                                class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                            >
                                New Registration
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                        v-for="user in users.data"
                        :key="user.id"
                    >
                        <td class="px-6 py-4">{{ user.id }}</td>
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            {{ user.name }}
                        </th>
                        <td class="px-6 py-4">{{ user.email }}</td>

                        <td class="px-6 py-4">{{ user.level }}</td>
                        <td class="px-6 py-4"><Role :role="user.role" /></td>
                        <td class="px-6 py-4">{{ user.unit }}</td>
                        <td class="px-6 py-4">
                            {{ user.location_name }}
                        </td>
                        <td class="px-6 py-4">
                            <button
                                @click="editUser(user)"
                                class="font-medium px-3 py-2 rounded shadow mx-2 bg-orange-500 text-white dark:text-orange-500 hover:underline"
                            >
                                Edit
                            </button>
                            <button
                                @click="deleteUser(user)"
                                class="font-medium px-3 py-2 rounded shadow mx-2 bg-red-500 text-white dark:text-red-500 hover:underline"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Paginator -->
        <div class="mt-6 flex gap-5">
            <div>
                <template v-for="link in users.links" :key="link.url">
                    <Link
                        :class="
                            link.active
                                ? 'items-center justify-center px-4 py-2 h-8 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white'
                                : 'items-center justify-center px-4 py-2 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'
                        "
                        v-if="link.url"
                        :href="link.url"
                        ><span v-html="link.label"></span
                    ></Link>
                    <span
                        :class="
                            link.url
                                ? ''
                                : 'items-center justify-center px-4 py-2 h-8 leading-tight text-gray-300 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'
                        "
                        v-else
                        v-html="link.label"
                    ></span>
                </template>
            </div>
            <!-- <div> -->
            <h5 class="mt-1">
                Showing page {{ users.current_page }} of
                {{ users.last_page }}
            </h5>
            <h5 class="mt-1">
                Data {{ users.from }} to {{ users.to }} of
                {{ users.total }}
            </h5>
            <!-- </div> -->
        </div>
    </div>

    <Modal :show="is_add">
        <h1 class="mt-5 text-center text-2xl">Add New Data</h1>
        <form
            @submit.prevent="
                form.post(route('user.store'), {
                    onSuccess: () => {
                        form.reset();
                        is_add = false;
                    },
                })
            "
            method="POST"
            :initial-values="formValues"
        >
            <!-- Name -->
            <div class="mt-5 py-2 px-5">
                <label
                    for="name"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Name</label
                >
                <input
                    v-model="form.name"
                    type="text"
                    id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                />
                <span v-if="$page.props.errors.name" class="text-red-500">{{
                    $page.props.errors.name
                }}</span>
            </div>
            <!-- Email -->
            <div class="py-2 px-5">
                <label
                    for="email"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Email</label
                >
                <input
                    v-model="form.email"
                    type="email"
                    id="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                />
                <span v-if="$page.props.errors.email" class="text-red-500">{{
                    $page.props.errors.email
                }}</span>
            </div>
            <!-- Level -->
            <div class="py-2 px-5">
                <label
                    for="level"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Level</label
                >
                <select
                    v-model="form.level"
                    id="level"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                    <option value=" ">Pilih level</option>
                    <option value="Agent">Agent</option>
                    <option value="AAD">AAD</option>
                    <option value="AD">AD</option>
                </select>
                <span v-if="$page.props.errors.level" class="text-red-500">{{
                    $page.props.errors.level
                }}</span>
            </div>

            <!-- kode_agent -->
            <div class="py-2 px-5">
                <label
                    for="kode_agent"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Kode Agent</label
                >
                <input
                    v-model="form.kode_agent"
                    type="text"
                    id="kode_agent"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                />
                <span
                    v-if="$page.props.errors.kode_agent"
                    class="text-red-500"
                    >{{ $page.props.errors.kode_agent }}</span
                >
            </div>
            <!-- Unit -->
            <div class="py-2 px-5">
                <label
                    for="unit"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Pilih unit</label
                >
                <select
                    v-model="form.unit"
                    id="countries"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                    <option value=" ">Pilih unit</option>
                    <option
                        v-for="unit in units"
                        :key="unit.id"
                        :value="unit.id"
                    >
                        {{ unit.name }}
                    </option>
                </select>
                <span v-if="$page.props.errors.unit" class="text-red-500">{{
                    $page.props.errors.unit
                }}</span>
            </div>

            <div class="my-5 py-2 px-5 flex justify-between">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                >
                    Save
                </button>
                <button
                    @click="is_add = false"
                    type="button"
                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                >
                    Cancel
                </button>
            </div>
        </form>
    </Modal>

    <Modal :show="is_edit">
        <h1 class="mt-5 text-center text-2xl">Edit Data</h1>
        <form
            @submit.prevent="
                form.put(route('user.update', form.id), {
                    onSuccess: () => {
                        form.reset();
                        is_edit = false;
                    },
                })
            "
            method="PUT"
        >
            <!-- Name -->
            <div class="mt-5 py-2 px-5">
                <label
                    for="name"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Name</label
                >
                <input
                    v-model="form.name"
                    type="text"
                    id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                />
                <span v-if="$page.props.errors.name" class="text-red-500">{{
                    $page.props.errors.name
                }}</span>
            </div>
            <!-- Email -->
            <div class="py-2 px-5">
                <label
                    for="email"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Email</label
                >
                <input
                    v-model="form.email"
                    type="email"
                    id="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                />
                <span v-if="$page.props.errors.email" class="text-red-500">{{
                    $page.props.errors.email
                }}</span>
            </div>
            <!-- Level -->
            <div class="py-2 px-5">
                <label
                    for="level"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Level</label
                >
                <select
                    v-model="form.level"
                    id="level"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                    <option value=" ">Pilih level</option>
                    <option value="Agent">Agent</option>
                    <option value="AAD">AAD</option>
                    <option value="AD">AD</option>
                </select>
                <span v-if="$page.props.errors.level" class="text-red-500">{{
                    $page.props.errors.level
                }}</span>
            </div>

            <!-- kode_agent -->
            <div class="py-2 px-5">
                <label
                    for="kode_agent"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Kode Agent</label
                >
                <input
                    v-model="form.kode_agent"
                    type="text"
                    id="kode_agent"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                />
                <span
                    v-if="$page.props.errors.kode_agent"
                    class="text-red-500"
                    >{{ $page.props.errors.kode_agent }}</span
                >
            </div>
            <!-- Unit -->
            <div class="py-2 px-5">
                <label
                    for="unit"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Pilih unit</label
                >
                <select
                    v-model="form.unit"
                    id="countries"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                    <option value=" ">Pilih unit</option>
                    <option
                        v-for="unit in units"
                        :key="unit.id"
                        :value="unit.id"
                    >
                        {{ unit.name }}
                    </option>
                </select>
                <span v-if="$page.props.errors.unit" class="text-red-500">{{
                    $page.props.errors.unit
                }}</span>
            </div>

            <div class="my-5 py-2 px-5 flex justify-between">
                <button
                    type="submit"
                    class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                >
                    Update
                </button>
                <button
                    @click="is_edit = false"
                    type="button"
                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                >
                    Cancel
                </button>
            </div>
        </form>
    </Modal>

    <Modal :show="is_delete">
        <form
            @submit.prevent="
                form.delete(route('user.destroy', form.id), {
                    onSuccess: () => {
                        form.reset();
                        is_delete = false;
                    },
                })
            "
            method="DELETE"
        >
            <h1 class="text-2xl text-center my-5">
                Are you sure to delete "{{ form.name }}" data?
            </h1>
            <div class="my-5 py-2 px-5 flex justify-evenly">
                <button
                    type="submit"
                    class="text-white bg-red-500 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                >
                    Yes
                </button>
                <button
                    @click="is_delete = false"
                    type="button"
                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                >
                    Cancel
                </button>
            </div>
        </form>
    </Modal>
</template>

<style></style>
