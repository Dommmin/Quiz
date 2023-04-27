<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    public: Object,
    registered: Object,
})
</script>

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
                        <h6 class="text-xl font-bold text-gray-200">Public quizzes</h6>

                        <div class="mt-2 text-gray-200" v-if="public.length === 0">No public quizzes found.</div>
                        <div class="px-4 py-2 w-full lg:w-6/12 xl:w-3/12" v-else v-for="quiz in public">
                            <div class="flex relative flex-col mb-6 min-w-0 break-words bg-white rounded shadow-lg xl:mb-0">
                                <div class="flex-auto p-4">
                                    <Link :href="route('quiz.show', quiz.slug)">{{ quiz.title }}</Link>
                                    <p class="text-sm">Questions: <span>{{ quiz.questions_count }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h6 class="text-xl font-bold text-gray-200">Quizzes for Registered Users</h6>

                        <div class="mt-2 text-gray-200" v-if="registered.length === 0">No quizzes for registered users found.</div>
                        <div class="px-4 py-2 w-full lg:w-6/12 xl:w-3/12" v-else v-for="quiz in registered">
                            <div class="flex relative flex-col mb-6 min-w-0 break-words bg-white rounded shadow-lg xl:mb-0">
                                <div class="flex-auto p-4">
                                    <Link :href="route('quiz.show', quiz.slug)">{{ quiz.title }}</Link>
                                    <p class="text-sm">Questions: <span>{{ quiz.questions_count }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
