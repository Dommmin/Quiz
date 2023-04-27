<template>
    <div class="mt-6">
        <template v-for="link in links">
            <Link
                v-if="link.url"
                :href="link.url"
                v-html="link.label"
                class="mb-1 mr-1 px-4 py-3 focus:text-indigo-500 text-sm leading-4 hover:bg-white border focus:border-indigo-500 rounded"
                :class="link.active ? 'font-bold border border-2 border-indigo-500 bg-indigo-50' : ''"
            />
            <span
                v-else
                v-html="link.label"
                :class="link.url ? '' : 'text-gray-500'"
                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
            />
        </template>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
	links: Array,
});

</script>
