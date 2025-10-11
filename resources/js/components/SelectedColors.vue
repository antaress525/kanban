<template>
     <div class="grid w-full items-center gap-2">
        <Label for="color">Couleur</Label>
        <div class="flex items-center justify-between">
            <div v-for="color in validColors" @click="changeSelected(color)" class="p-1 rounded-lg border border-transparent hover:border-neutral-200 transition-all cursor-pointer">
                <div class="w-6 h-6 grid place-items-center rounded-full" :style="{background: color}">
                    <Check v-if="selectedColor === color" class="w-4 h-4 text-white" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Label } from "@/components/ui/label"
import { ref } from "vue";
import { Check } from "lucide-vue-next";

const validColors = ref([
    '#E24E4E',
    '#FFC251',
    '#94ED27',
    '#AE673B',
    '#00FF08',
    '#2AD1E4',
    '#066AFF',
    '#844EE2',
    '#FF5EF4',
    '#9846CF',
])
const props = defineProps({
    defaultColor: {
        default: null
    }
})
const emits = defineEmits(['changeColor'])
const selectedColor = ref(props.defaultColor)

const changeSelected = (color) => {
    selectedColor.value = color
    emits('changeColor', color)
}
</script>