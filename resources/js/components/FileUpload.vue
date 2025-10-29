<template>
    <input
        :disabled="processing"
        :id="id"
        type="file" 
        class="hidden peer" 
        @change="handleChange"
        accept="image/*"
        :multiple="multiple"
    />
    <label 
        :for="id" 
        class="cursor-pointer select-none justify-center text-xs font-medium px-2 flex items-center gap-x-2 rounded-md bg-white h-7 peer-disabled:bg-neutral-50"
        :class="class"
    >
        <Spinner size="14px" v-if="processing" color="black" />
        <span v-else>{{ label }}</span>
    </label>
</template>

<script setup>
import Spinner from './Spinner.vue'
defineProps({
    processing: {
        type: Boolean,
        default: false
    },
    id: {
        type: null,
        required: true
    },
    label: {
        type: String
    },
    multiple: {
        type: Boolean,
        default: false
    },
    class: {
        type: String
    }

})

const emits = defineEmits(['change'])

const handleChange = (e) => {
    emits('change', e)
}
</script>