<template>
<AuthenticatedLayout>
    <Head :title="kanban.title"></Head>
    <div class="space-y-6">
        <!-- Cover image -->
        <div class="relative overflow-hidden rounded-xl h-[120px] md:h-[160px] bg-cover bg-center" :style="`background-image: url(${kanban.cover_image ? kanban.cover_image : defaultCoverImage})`">
            <!-- <img :src="defaultCoverImage" alt=""> -->
            <div class="flex items-center gap-x-2 absolute top-2 right-2">
                <FileUpload 
                    class="w-28"
                    label="Change la cover"
                    id="cover-image" 
                    :processing="form.processing" 
                    @change="handleFileChange"
                />
                <Button class="w-28" @click="handleDeleteCover" variant="destructive" size="xs">
                    <span v-if="!deleteCoverFrom.processing">Supprimer la cover</span>
                    <Spinner v-else class="14px" />
                </Button>
            </div>
        </div>
        <!-- Title + Search -->
        <div class="flex items-center justify-between flex-wrap gap-y-3">
            <h2 class="font-semibold text-xl sm:text-2xl">{{ kanban.title }}</h2>
            <div class="relative w-full sm:max-w-[260px] items-center">
                <Input id="search" type="text" placeholder="Search..." class="pl-10 shadow-none rounded-lg" />
                <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
                    <Search class="size-5 text-muted-foreground" />
                </span>
            </div>
        </div>
        <!-- Invite + Filter -->
        <div class="flex items-center justify-between">
            <!-- Button -->
            <div class="flex-1 flex justify-end items-center gap-x-2">
                <Button variant="outline" class="shadow-none rounded-lg">
                    <UserPlus class="size-5"/>
                    Inviter
                </Button>
                <Button variant="outline" class="shadow-none rounded-lg">
                    <Settings2 class="size-5"/>
                    Filtrer
                </Button>
            </div>
        </div>
        <!-- Kanban -->
        <div class="h-[500px] flex gap-x-6 overflow-x-scroll snap-x snap-mandatory md:flex-row md:overflow-x-auto md:snap-none">
            
            <TaskContainer 
                name="todo" 
                title="A faire" 
                header-color="blue" 
                :tasks="allTasks.todo.data" 
                :task-count="allTasks.todo.data.length" 
                @create-task="openCreateTaskModal"
                @task-moved="handleTaskMoved"
                class="w-80 flex-shrink-0 snap-center md:flex-1 md:w-auto"
            >
                <template #task-item="{ task }">
                    <TaskItem 
                        :key="task.id" :task="task"
                        v-model="selectedTaskIds"
                        @edit-task="openEditTaskModal" 
                        @delete-task="openDeleteTaskModal"
                    />
                </template>
            </TaskContainer>
            
            <TaskContainer 
                name="in_progress" 
                title="En cours" 
                header-color="amber" 
                :tasks="allTasks.in_progress.data"
                :task-count="allTasks.in_progress.data.length" 
                @create-task="openCreateTaskModal"
                @task-moved="handleTaskMoved"
                class="w-80 flex-shrink-0 snap-center md:flex-1 md:w-auto"
            >
                <template #task-item="{ task }">
                    <TaskItem v-model="selectedTaskIds"   :task="task" @edit-task="openEditTaskModal" @delete-task="openDeleteTaskModal"/>
                </template>
            </TaskContainer>
            
            <TaskContainer 
                name="done" 
                title="Fait" 
                header-color="green" 
                :tasks="allTasks.done.data"
                :task-count="allTasks.done.data.length" 
                @create-task="openCreateTaskModal"
                @task-moved="handleTaskMoved"
                class="w-80 flex-shrink-0 snap-center md:flex-1 md:w-auto"
            >
                <template #task-item="{ task }">
                    <TaskItem v-model="selectedTaskIds" :task="task" @edit-task="openEditTaskModal" @delete-task="openDeleteTaskModal"/>
                </template>
            </TaskContainer>
        </div>
    </div>
    <Teleport to="body">
        <CreateTask :open="openCreateTask" :kanban-id="kanban.id" :status="statusCreateTask" @close="closeCreateTaskModal"/>
        <EditTask :open="openEditTask" :task="taskSelected" @close="closeEditTaskModal"/>
        <!-- only delete -->
        <ConfirmDelete
            :open="!!taskToDeleteId" 
            :delete-url="deleteUrl"
            :data="{
                taskId: taskToDeleteId
            }"
            title="Êtes-vous certain de vouloir supprimer cette tâche ?"
            @close="closeDeleteTaskModal"
        />
        <!-- bulk delete -->
        <ConfirmDelete
            :open="openBulkDeleteTask" 
            :delete-url="route('task.bulk-destroy')"
            :title="bulkTitle"
            :data="{
                taskIds: selectedTaskIds
            }"
            description="La suppression est définitive et vous ne pourrez pas restaurer ces taches."
            @close="closeBulkDeleteTaskModal"
            @success="resetselectedTaskIds"
        />
        <BulkActionContainer :count-selected="selectedTaskIds.length">
            <BulkButton @click="resetselectedTaskIds">
                <XCircle/>
                Annuler
            </BulkButton>
            <BulkSeparator/>
            <BulkButton @click="openBulkDeleteTaskModal" variant="destructive">
                <Trash2 />
                Supprimer
            </BulkButton>
        </BulkActionContainer>
    </Teleport>
</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Input } from "@/components/ui/input"
import { Search, UserPlus, Settings2 } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import defaultCoverImage from '@img/default_cover_image.jpg'
import TaskContainer from '@/components/TaskContainer.vue'
import TaskItem from '@/components/TaskItem.vue'
import CreateTask from './Partials/CreateTask.vue'
import EditTask from './Partials/EditTask.vue'
import { ref, watch, computed } from 'vue'
import { router, Head, useForm } from '@inertiajs/vue3'
import ConfirmDelete from '@/components/ConfirmDelete.vue'
import BulkActionContainer from '@/components/BulkAction/BulkActionContainer.vue'
import BulkButton from '@/components/BulkAction/BulkButton.vue'
import BulkSeparator from '@/components/BulkAction/BulkSeparator.vue'
import { XCircle, Trash2 } from 'lucide-vue-next'
import FileUpload from '@/components/FileUpload.vue'
import Spinner from '@/components/Spinner.vue'

const props = defineProps({
    kanban: {
        type: Object,
    },
    tasks: {
        type: Object
    }
})

const allTasks = ref({
    todo: { data: props.tasks.todo.data, total: props.tasks.todo.total },
    in_progress: { data: props.tasks.in_progress.data, total: props.tasks.in_progress.total },
    done: { data: props.tasks.done.data, total: props.tasks.done.total },
});

watch(() => props.tasks, (newTasks) => {
    allTasks.value.todo.data = newTasks.todo.data;
    allTasks.value.todo.total = newTasks.todo.total;
    
    allTasks.value.in_progress.data = newTasks.in_progress.data;
    allTasks.value.in_progress.total = newTasks.in_progress.total;
    
    allTasks.value.done.data = newTasks.done.data;
    allTasks.value.done.total = newTasks.done.total;

}, { deep: true });


const openCreateTask = ref(false)
const openEditTask = ref(false)
const statusCreateTask = ref('')
const taskSelected = ref(null)
const taskToDeleteId = ref(null)
const openBulkDeleteTask = ref(false)
const selectedTaskIds = ref([])
const form = useForm({
    cover_image: null,
})
const deleteCoverFrom = useForm({});

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.cover_image = file;
        console.log(`Fichier sélectionné: ${form.cover_image}`);
        submitCoverImage();
    }
};

const submitCoverImage = () => {
    if (!form.cover_image) {
        alert("Veuillez sélectionner une image.");
        return;
    }

    form.post(route('kanban.update_cover', props.kanban.id), {  
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        },
        onError: (errors) => {
            console.error("Erreur d'upload:", errors);
        }
    });
};

const handleDeleteCover = () => {
    deleteCoverFrom.delete(route('kanban.delete_cover', props.kanban.id), {
        preserveScroll: true,
    })
}

const deleteUrl = computed(() => {
    return taskToDeleteId.value ? route('task.destroy', taskToDeleteId.value) : null;
});

const bulkTitle = computed(() => {
    return `Êtes-vous certain de vouloir supprimer les ${selectedTaskIds.value.length} tâches ?`
})

const openCreateTaskModal = (name) => {
    statusCreateTask.value = name
    openCreateTask.value = true
}
const closeCreateTaskModal = () => {
    openCreateTask.value = false
    statusCreateTask.value = null
}
const openEditTaskModal = (task) => {
    taskSelected.value = task
    openEditTask.value = true
}
const closeEditTaskModal = () => {
   openEditTask.value = false 
   taskSelected.value = null
}

const openDeleteTaskModal = (taskId) => {
    taskToDeleteId.value = taskId;
}

const closeDeleteTaskModal = () => {
    clearselectedTaskIds(taskToDeleteId.value)
    taskToDeleteId.value = null;
}

const openBulkDeleteTaskModal = () => {
    openBulkDeleteTask.value = true
}
const closeBulkDeleteTaskModal = () => {
    openBulkDeleteTask.value = false
}

const resetselectedTaskIds = () => {
    selectedTaskIds.value = []
}
const clearselectedTaskIds = (taskId) => {
    selectedTaskIds.value = selectedTaskIds.value.filter((id) => {
        return id !== taskId
    })
}

/**
 * Gère l'événement de déplacement émis par TaskContainer et envoie la requête Inertia.
 * @param {Object} payload - { status, tasks, event }
 */
const handleTaskMoved = (payload) => {
    let movedTask;
    let sourceStatus = null;

    if (payload.event.moved) {
        movedTask = payload.tasks[payload.event.moved.newIndex];

    } else if (payload.event.added) {
        movedTask = payload.tasks[payload.event.added.newIndex];
        
        movedTask.status = payload.status; 
    }

    if (!movedTask) return;

    allTasks.value[payload.status].total = payload.tasks.length;

    const newOrder = payload.tasks.map(t => t.id);

    router.put(route('task.reorder', movedTask.id), {
        status: movedTask.status,
        task_order: newOrder,
    }, {
        preserveScroll: true,
        preserveState: true,
        onFinish: () => {
             
        }
    });
}
</script>