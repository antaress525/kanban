<template>
<AuthenticatedLayout>
    <Head :title="kanban.title"></Head>
    <div class="space-y-6">
        <!-- Cover image -->
        <div class="relative overflow-hidden rounded-xl h-[120px] md:h-[160px] bg-cover bg-center" :style="`background-image: url(${defaultCoverImage})`">
            <!-- <img :src="defaultCoverImage" alt=""> -->
            <div class="flex items-center absolute">
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
        <div class="h-[500px] flex gap-x-6">
            <TaskContainer name="todo" title="A faire" header-color="blue" :task-count="tasks.todo.total" @create-task="openCreateTaskModal">
                <template #list-task>
                    <TaskItem v-for="task in tasks.todo.data" :task="task" @edit-task="openEditTaskModal"/>
                </template>
            </TaskContainer>
            <TaskContainer name="in_progress" title="En cours" header-color="amber" :task-count="tasks.in_progress.total" @create-task="openCreateTaskModal">
                <template #list-task>
                    <TaskItem v-for="task in tasks.in_progress.data" :task="task" @edit-task="openEditTaskModal"/>
                </template>
            </TaskContainer>
            <TaskContainer name="done" title="Fait" header-color="green" :task-count="tasks.done.total" @create-task="openCreateTaskModal">
                <template #list-task>
                    <TaskItem v-for="task in tasks.done.data" :task="task" @edit-task="openEditTaskModal"/>
                </template>
            </TaskContainer>
        </div>
    </div>
    <Teleport to="body">
        <CreateTask :open="openCreateTask" :kanban-id="kanban.id" :status="statusCreateTask" @close="closeCreateTaskModal"/>
        <EditTask :open="openEditTask" :task="taskSelected" @close="closeEditTaskModal"/>
    </Teleport>
</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Input } from "@/components/ui/input"
import { Search, UserPlus, Settings2, Circle, Plus } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import defaultCoverImage from '@img/default_cover_image.jpg'
import TaskContainer from '@/components/TaskContainer.vue';
import TaskItem from '@/components/TaskItem.vue';
import CreateTask from './Partials/CreateTask.vue';
import EditTask from './Partials/EditTask.vue';
import { ref } from 'vue';

defineProps({
    kanban: {
        type: Object,
    },
    tasks: {
        type: Object
    }
})

const openCreateTask = ref(false)
const openEditTask = ref(false)
const statusCreateTask = ref('')
const taskSelected = ref(null)

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
</script>