<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ question.question_text }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="form.put(route('questions.update', question))">
                        <div class="p-6 pb-2">
                            <label for="question" class="block mb-4 text-sm font-medium text-gray-900 dark:text-white">Question text</label>
                            <textarea v-model="form.question_text" id="question" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                        </div>
                        <div class="text-red-600 mt-1">
                            <div v-if="errors.question_text" class="text-red-600">
                                {{ errors.question_text }}
                            </div>
                        </div>

                        <label for="question-options" class="text-gray-50 ml-6">Question Options</label>
                        <div id="question-options">
                            <div class="p-6 pb-0.5 flex justify-between items-center" v-for="(input, index) in form.question_options" :key="index">
                                <input v-model="form.question_options[index].option" type="text" class="block p-2 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <div class="flex justify-items-center ml-2">
                                    <input v-model="form.question_options[index].correct" :id="index" type="checkbox" :value="input" name="default-radio" class="rounded w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label :for="index" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Correct</label>
                                </div>
                                <button @click="removeInput(index)" type="button" class="ml-2 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
                            </div>
                            <button @click="addInput" type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 m-6 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Add</button>
                        </div>

                        <div class="p-6 pt-2 pb-2">
                            <label for="snippet" class="block mb-4 text-sm font-medium text-gray-900 dark:text-white">Code snippet</label>
                            <textarea v-model="form.code_snippet" id="snippet" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                        </div>
                        <div class="text-red-600 mt-1">
                            <div v-if="errors.code_snippet" class="text-red-600">
                                {{ errors.code_snippet }}
                            </div>
                        </div>

                        <div class="p-6 pt-2 pb-2">
                            <label for="answer" class="block mb-4 text-sm font-medium text-gray-900 dark:text-white">Answer explanation</label>
                            <textarea v-model="form.answer_explanation" id="answer" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                        </div>
                        <div class="text-red-600 mt-1">
                            <div v-if="errors.answer_explanation" class="text-red-600">
                                {{ errors.answer_explanation }}
                            </div>
                        </div>

                        <div class="p-6 pt-2">
                            <label for="info" class="block mb-4 text-sm font-medium text-gray-900 dark:text-white">More info link</label>
                            <input v-model="form.more_info_link" type="url" id="info" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div class="text-red-600 mt-1 pl-6">
                            <div v-if="errors.more_info_link" class="text-red-600">
                                {{ errors.more_info_link }}
                            </div>
                        </div>

                        <div class="p-6 pt-1">
                            <button :disabled="isLoading" class="w-full md:w-auto px-24 text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm py-2.5 text-center mr-2 mb-2">
                                <div v-show="isLoading" class="inline-block animate-spin w-4 h-4 mr-2 border-t-2 border-t-white border-r-2 border-r-white border-b-2 border-b-white border-l-2 border-l-indigo-600 rounded-full"></div>
                                <span v-if="isLoading">Loading...</span>
                                <span v-else class="px-2">Update</span>
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
import {ref} from "vue";

const isLoading = ref(false);

const props = defineProps({
    errors: Object,
    question: Object,
});

const form = useForm(props.question);

const addInput = () => {
    form.question_options.push({option: '', correct: false});
};

const removeInput = (index) => {
    form.question_options.splice(index, 1);
};
</script>
