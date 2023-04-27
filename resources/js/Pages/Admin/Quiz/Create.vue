<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Quiz Create
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="form.post(route('quizzes.store'))">
                        <div class="p-6 pb-0.5">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title<span class="text-red-500">*</span>:</label>
                            <input v-model="form.title" type="text" id="title" class="block p-2 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div class="pl-6 text-red-600 mt-1">
                            <div v-if="errors.title" class="text-red-600">
                                {{ errors.title }}
                            </div>
                        </div>

                        <div class="p-6 pb-0.5">
                            <label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slug<span class="text-red-500">*</span>:</label>
                            <input v-model="form.slug" type="text" id="slug" class="block p-2 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" :disabled="automaticSlug"
                             :class="[automaticSlug ? 'cursor-not-allowed' : '']">
                        </div>
                        <div class="pl-6 text-red-600 mt-1">
                            <div v-if="errors.slug" class="text-red-600">
                                {{ errors.slug }}
                            </div>
                        </div>

                        <div class="pl-6 pb-2">
                            <input v-model="automaticSlug" id="automaticSlug" type="checkbox" class="rounded w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="automaticSlug" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Automatic Generate Slug</label>
                        </div>

                        <div class="p-6 pb-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description<span class="text-red-500">*</span>:</label>
                            <textarea v-model="form.description" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                        </div>
                        <div class="pl-6 text-red-600 mt-1 mb-2">
                            <div v-if="errors.description" class="text-red-600">
                                {{ errors.description }}
                            </div>
                        </div>

                        <div class="pl-6 pr-6">
                            <label for="questions" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Questions<span class="text-red-500">*</span>:</label>
                            <Multiselect
                                v-model="form.questions"
                                mode="tags"
                                placeholder="Select your characters"
                                :options="questions"
                                id="questions"
                            />
                        </div>
                        <div class="pl-6 text-red-600 mt-1 mb-2">
                            <div v-if="errors.questions" class="text-red-600">
                                {{ errors.questions }}
                            </div>
                        </div>

                        <div class="pl-6 pb-2">
                            <input v-model="form.published" id="published" type="checkbox" class="rounded w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="published" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Published</label>
                        </div>

                        <div class="pl-6 pb-2">
                            <input v-model="form.public" id="public" type="checkbox" class="rounded w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="public" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Public</label>
                        </div>

                        <div class="p-6 pt-1">
                            <button :disabled="isLoading" class="w-full md:w-auto px-24 text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm py-2.5 text-center mr-2 mb-2">
                                <div v-show="isLoading" class="inline-block animate-spin w-4 h-4 mr-2 border-t-2 border-t-white border-r-2 border-r-white border-b-2 border-b-white border-l-2 border-l-indigo-600 rounded-full"></div>
                                <span v-if="isLoading">Loading...</span>
                                <span v-else class="px-2">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {useForm} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import Multiselect from '@vueform/multiselect';

const isLoading = ref(false);

const props = defineProps({
    errors: Object,
    questions: Object,
});

const automaticSlug = ref(true)

const form = useForm({
    title: '',
    slug: '',
    description: '',
    published: false,
    public: false,
    questions: []
});

function generateSlug(title) {
    return title
        .toString() // Cast to string (optional)
        .normalize('NFKD') // The normalize() using NFKD method returns the Unicode Normalization Form of a given string.
        .toLowerCase() // Convert the string to lowercase letters
        .replaceAll('ł', 'l')
        .replaceAll('/', '-')
        .replaceAll('.', '-')
        .replaceAll('\'', '-')
        .replace(/[\u0300-\u036f]/g, '') // Remove all previously split accents
        .trim() // Remove whitespace from both sides of a string
        .replace(/\s+/g, '-') // Replace spaces with -
        .replace(/[^\w-]+/g, '') // Remove all non-word chars
        .replace(/^-+/g, '') // Remove - from start
        .replace(/-+$/g, '') // Remove - from end
        .replace(/--+/g, '-');
}

watch(() => form.title, (newValue) => {
    form.slug = generateSlug(newValue);
});
</script>

<style>
@import '@vueform/multiselect/themes/default.css';
</style>
