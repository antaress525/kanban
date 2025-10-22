<template>
    <FadeIntDown>
    <div v-if="open" @click.self="close" class="fixed inset-0 bg-black/10 flex justify-center pt-14 sm:pt-28">
        <div class="w-full flex flex-col sm:max-w-xl overflow-hidden bg-white border border-neutral-200 rounded-xl" :class="{'max-h-56': !results.length, 'max-h-80': results.length}">
            <!-- Input -->
            <div class="relative flex items-center bg-blue-200 border-b border-neutral-200">
                <div class="absolute ml-2 text-neutral-400">
                    <Spinner v-if="processing" />
                    <Search v-else class="size-5" />
                </div>
                <input class="w-full h-11 px-9 focus:outline-none" type="text" v-model="search" placeholder="Recherche kanban"/>
                <button v-if="search" @click="cleanInput" class="absolute right-0 mr-2 p-1 rounded-full bg-neutral-100">
                    <X class="size-3.5"/>
                </button>
            </div>
            <!-- Content -->
            <div class="flex-1 p-4 overflow-y-auto">
                <!-- Not research -->
                <div v-if="!search" class="h-full flex flex-col justify-center items-center gap-y-3.5">
                    <p class="text-neutral-400">Aucune recherche</p>
                </div>
                <!-- Empty state -->
                <div v-if="results.length <= 0 && search" class="h-full flex flex-col justify-center items-center gap-y-3.5">
                    <div class="p-1.5 border border-neutral-100 rounded-md bg-white">
                        <Search class="size-5" />
                    </div>
                    <div class="text-center text-neutral-400">
                        <p>Aucun Kanban trouvé</p>
                        <p class="text-sm">Aucun tableau ne correspond à ta recherche.</p>
                    </div>
                </div>
                <!-- Fill state -->
                <div v-else-if="results.length > 0 && search" class="space-y-2">
                    <NavItem2 v-for="result in results" :key="result.id" :kanban="result" />
                </div>
            </div>
        </div>
    </div>
    </FadeIntDown>
</template>

<script setup>
import axios from 'axios'
import { Search, X } from 'lucide-vue-next'
import { onMounted, onUnmounted, ref, watch } from 'vue'
import NavItem2 from '@/components/NavItem2.vue'
import { debounce } from 'lodash'
import FadeIntDown from '@/Transitions/FadeIntDown.vue'
import Spinner from '@/components/Spinner.vue'

const props = defineProps({
    open: {
        type: Boolean,
        default: false
    }
})
const emits = defineEmits(['close', 'open'])
const results = ref([])
const search = ref('')
const processing = ref(false)
const close = () => {
    emits('close')
    search.value = ''
}
const cleanInput = () => {
    search.value = ''
}

watch(search, debounce(
    (value) => {
        if(search.value.trim() === '') {
            results.value = []
            return
        }
        processing.value = true
        axios.get(route('kanban.search'), 
            {
                params: {q: value}
            })
            .then(r => {
                r.status === 200 ? results.value = r.data : null
            })
            .finally(() => {
                processing.value = false
            })
    },500)
)

const openWithShortcut = (e) => {
    if (e.ctrlKey && e.key.toLowerCase() === 'k') {
        if(!props.open) {
            emits('openWithShortcut')
        }
    }
}
const closeOnEscape = (e) => {
    if (e.key === 'Escape') {
        e.preventDefault();

        if (props.open) {
            close();
        }
    }
}

onMounted(() => {
    document.addEventListener('keydown', openWithShortcut)
    document.addEventListener('keydown', closeOnEscape)
})

onUnmounted(() => {
    document.removeEventListener('keydown', openWithShortcut)
    document.removeEventListener('keydown', closeOnEscape);
})

</script>