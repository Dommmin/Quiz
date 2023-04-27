<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Leaderboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-4 min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                            <select class="p-3 w-full text-sm leading-5 rounded border-0 shadow text-slate-600" v-model="quizId">
                                <option value="0">--- all quizzes ---</option>
                                <option v-for="quiz in quizzes" :value="quiz.id">{{ quiz.title }}</option>
                            </select>

                            <table class="table mt-4 w-full table-view">
                                <thead>
                                <tr>
                                    <th class="bg-gray-50 px-6 py-3 text-left w-9"></th>
                                    <th class="bg-gray-50 px-6 py-3 text-left w-1/2">
                                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Username</span>
                                    </th>
                                    <th class="bg-gray-50 px-6 py-3 text-left">
                                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Correct answers</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="!users.length">
                                    <td colspan="3">No results.</td>
                                </tr>
                                <tr v-else v-for="(user, index) in users" :class="[$page.props.auth.user && $page.props.auth.user.name === user.name ? 'bg-slate-100' : '']">
                                <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                    {{ index +1 }}
                                </td>
                                <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                    {{ user.name }}
                                </td>
                                <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                    {{ user.correct }} / {{ total_questions }}
                                    (time: minutes)
                                </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
import debounce from 'lodash/debounce';

const props = defineProps({
    users: Object,
    total_questions: Number,
    filters: Object,
    quizzes: Object,
})

let quizId = ref(props.filters.quizId);
quizId.value = '0';

watch(quizId, debounce(function (value) {
    router.get(route('leaderboard.index'), { quizId: value }, {
        preserveState: true,
        replace: true
    });
}, 300));
</script>
