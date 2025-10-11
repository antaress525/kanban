<template>
    <div class="relative w-full max-w-sm items-center">
        <Input v-model="model" :type="visiblePassword? 'text': 'password'" placeholder="Mot de passe" class="pr-10" />
        <button @click="toggleVisiblePassword" type="button" class="absolute text-neutral-400 end-0 inset-y-0 flex items-center justify-center px-2">
            <Eye v-if="visiblePassword" class="h-5 w-5" />
            <EyeOff v-else="visiblePassword" class="h-5 w-5" />
        </button>
  </div>
</template>

<script setup>
import Input from '@/components/ui/input/Input.vue';
import { Eye, EyeOff } from 'lucide-vue-next';
import { ref } from 'vue';

const visiblePassword = ref(false)
const model = defineModel()
const toggleVisiblePassword = () => {
    visiblePassword.value = !visiblePassword.value
}
</script>