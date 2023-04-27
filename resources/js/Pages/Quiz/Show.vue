<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ quiz.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-indigo-500" v-if="!quiz.public && !$page.props.auth.user">
                            <span class="inline-block align-middle mr-8">
                                This test is available only for registered users. Please <Link :href="route('login')" class="hover:underline">Log in</Link> or <Link :href="route('register')" class="hover:underline">Register</Link>
                            </span>
                        </div>
                        <div v-else>
                            <span class="text-bold text-gray-200">Question {{ currentQuestionIndex + 1 }} of {{ questionsCount }}:</span>
                            <h2 class="mb-4 text-2xl text-gray-200">{{ questions[currentQuestionIndex].question_text }}</h2>

                            <pre class="mb-4 border-2 border-solid bg-gray-50 p-2" v-if="questions[currentQuestionIndex].code_snippet">{{questions[currentQuestionIndex].code_snippet}}</pre>

                            <div v-for="option in questions[currentQuestionIndex].question_options">
                                <label :for="option.id">
                                    <input type="radio"
                                           :id="option.id"
                                           v-model="answer"
                                           :name="questions[currentQuestionIndex]"
                                           :value="option.id">
                                    <span class="text-gray-200 ml-2">{{ option.option }}</span>
                                </label>
                            </div>

                            <div class="mt-4" v-if="currentQuestionIndex < questionsCount - 1">
                                    <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" @click="changeQuestion()">Next question</button>
                            </div>
                            <div class="mt-4" v-else>
                                <button @click="submit()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit</button>
                            </div>
                            <div class="mb-2 text-gray-200">
                                Time left for this question: {{ countdown }} sec.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link, router, useForm} from "@inertiajs/vue3";
import {ref} from "vue";

const props = defineProps({
    quiz: Object,
    questions: Object,
    startTimeSeconds: Number,
    questionsCount: Number,
    quizTime: Number,
})

const form = useForm({
    questionsAnswers: [],
    quizId: props.quiz.id,
    startTimeSeconds: props.startTimeSeconds
});

const answer = ref();
const currentQuestionIndex = ref(0);
const countdown = ref(props.quizTime);

setInterval(() => {
    if (countdown.value > 0) {
        countdown.value--;
    } else {
        changeQuestion();
    }
}, 1000);

const changeQuestion = () => {
    form.questionsAnswers.push(answer.value);

    if (currentQuestionIndex.value < props.questionsCount -1) {
        currentQuestionIndex.value++;
        countdown.value = props.quizTime
    }
}

const submit = () => {
    form.questionsAnswers.push(answer.value);

    router.post(route('quiz.store', form));
}
</script>
