<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Questions
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-4">
                            <Link :href="route('questions.create')"
                               class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                                Create Question
                            </Link>
                        </div>

                        <div class="mb-4 min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                            <table class="min-w-full border divide-y divide-gray-200">
                                <thead>
                                <tr>
                                    <th class="w-16 bg-gray-50 px-6 py-3 text-left">
                                    </th>
                                    <th class="bg-gray-50 px-6 py-3 text-left">
                                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Question text</span>
                                    </th>
                                    <th class="w-40 bg-gray-50 px-6 py-3 text-left">
                                    </th>
                                </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                <tr class="bg-white" v-if="questions.data.length" v-for="question in questions.data">
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ question.id }}
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ question.question_text }}
                                    </td>
                                    <td>
                                        <Link :href="route('questions.edit', question.id)" class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                                            Edit
                                        </Link>
                                        <a type="button" href="#" @click="destroy(question.id)" class="rounded-md border border-transparent bg-red-200 px-4 py-2 text-xs uppercase text-red-500 hover:bg-red-300 hover:text-red-700">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td colspan="3" class="px-6 py-4 text-center leading-5 text-gray-900 whitespace-no-wrap">
                                        No questions were found.
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :links="questions.links" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link, router} from "@inertiajs/vue3";
import Pagination from "@/Shared/Pagination.vue";

const props = defineProps({
    questions: Object,
});

const destroy = (id) => {
    if (confirm('Are you sure?')) {
        router.delete(route('questions.destroy', id), {
            preserveScroll: true
        });
    }
};
</script>
