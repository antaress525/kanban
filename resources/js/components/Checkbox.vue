<template>
    <div class="w-max relative inline-flex items-center justify-center cursor-pointer">
        <input 
            :class="class"
            v-model="model"
            :value="value"
            type="checkbox" 
            class="cursor-pointer peer size-4 appearance-none border border-neutral-400 rounded-sm checked:bg-black checked:border-transparent"
        >
        <Check 
            class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none size-3 text-white opacity-0 peer-checked:opacity-100"
        />
    </div>
</template>

<script setup>
import { Check } from 'lucide-vue-next';

defineProps({
    value: {type: null},
    id: {type: null},
    name: {type: null},
    class: {type: null},
})
const model = defineModel()
</script>