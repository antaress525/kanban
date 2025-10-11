<template>
    <div class="flex flex-col items-center gap-4">
        <Button as-child class="w-full" variant="outline">
            <a :href="route('social.redirect', 'google')">
                <Google />
                Google
            </a>
        </Button>
        <Button as-child class="w-full" variant="outline">
            <a :href="route('social.redirect', 'github')">
                <Github />
                Github
            </a>
        </Button>
    </div>
</template>

<script setup>
import { Button } from '@/components/ui/button';
import Google from '@/Icons/Google.vue';
import Github from '@/Icons/Github.vue';
</script>