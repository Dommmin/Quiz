<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Quizzes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h6 class="text-xl font-bold text-gray-200">My Results</h6>

                        <table class="mt-4 table w-full table-view">
                            <tbody class="bg-white">
                            <tr class="w-28" v-if="$page.props.auth.user?.is_admin">
                                <th class="border border-solid bg-slate-100 px-6 py-3 text-left text-sm font-semibold uppercase text-slate-600">User</th>
                                <td class="border border-solid px-6 py-3">{{ test.user.name }} ({{ test.user.email }})</td>
                            </tr>
                            <tr class="w-28">
                                <th class="border border-solid bg-slate-100 px-6 py-3 text-left text-sm font-semibold uppercase text-slate-600">Date</th>
                                <td class="border border-solid px-6 py-3">{{ test.created_at }}</td>
                            </tr>
                            <tr class="w-28">
                                <th class="border border-solid bg-slate-100 px-6 py-3 text-left text-sm font-semibold uppercase text-slate-600">Result</th>
                                <td class="border border-solid px-6 py-3">
                                    {{ test.result }} / {{ total_questions }}
                                    <div v-if="test.time_spent">
                                        (time: {{test.time_spent}} minutes)
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h6 class="text-xl font-bold text-gray-200">Question and Answers</h6>

                        <table class="table table-view w-full my-4 bg-white" v-for="(result, index) in results">
                            <tbody class="bg-white">
                            <tr class="bg-slate-100">
                                <td class="w-1/2">Question #{{ index +1 }}</td>
                                <td>{{ result.question.question_text }}</td>
                            </tr>
                            <tr>
                                <td>Options</td>
                                <td>
                                    <li v-for="option in result.question.question_options"
                                        :class="[result.option_id == option.id ? 'underline' : '', option.correct == 1 ? 'font-bold' : '']"
                                    >{{ option.option }}
                                    <span class="italic" v-if="option.correct == 1">(correct answer)</span>
                                    <span class="italic" v-if="result.option_id == option.id">(your answer)</span>
                                    </li>
                                    <span class="font-bold italic" v-if="!result.option_id">Question unanswered.</span>
                                </td>
                            </tr>
                            <tr v-if="result.question.answer_explanation || result.question.more_info_link">
                                <td>Answer Explanation</td>
                                <td>
                                    {{ result.question.answer_explanation }}
                                    <div class="mt-4" v-if="result.question.more_info_link">
                                        Read more:
                                        <Link :href="result.question.more_info_link" class="hover:underline" target="_blank">
                                            {{ result.question.more_info_link }}
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <hr class="my-4 md:min-w-full">
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" v-if="users.length">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h6 class="text-xl font-bold text-gray-200">Leaderboard</h6>

                        <table class="table mt-4 w-full table-view">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="text-gray-200">Username</th>
                                    <th class="text-gray-200">Correct answers</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr :class="[$page.props.auth.user && $page.props.auth.user.name == user.name ? 'bg-slate-100' : '']" v-for="(user, index) in users">
                                    <td class="w-9">{{ index +1 }}</td>
                                    <td class="w-1/2">{{ user.name }}</td>
                                    <td>{{ user.correct }} / {{ total_questions }}
                                        (time: {{ user.time_spent }} minutes)</td>
                                </tr>
                            <tr v-if="!results.length">
                                <td colspan="3">No results</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    test: Object,
    results: Object,
    total_questions: Number,
    users: Object,
})
</script>
