<template>
    <div class="bg-white h-screen w-screen overflow-hidden flex">
       <!-- Aside bar -->
        <div class="hidden lg:flex flex-col gap-y-8 w-[280px] h-full py-2 md:py-4">
            <!-- Avatar -->
            <Profile :auth-user="authUser" class="mx-2 md:mx-4 flex-shrink-0" />
            <!-- Navigation -->
            <div class="h-full overflow-y-auto space-y-6 px-2 md:px-4">
                    <NavGroup label="Menu Principale">
                        <template #nav-items>
                            <NavItems @click="openResearchModal" as="button">
                                <search class="w-5 h-5" />
                                Recherche
                            </NavItems>
                            <NavItems as="button">
                                <Bell class="w-5 h-5" />
                                Notifications
                            </NavItems>
                            <NavItems @click="openEditProfileModal" as="button">
                                <Settings class="w-5 h-5" />
                                Parametres
                            </NavItems>
                        </template>
                    </NavGroup>
                    <NavGroup label="Kanban">
                        <template #nav-items>
                            <NavKanban v-for="kanban in kanbans"
                                :kanban="kanban" 
                                :active="route().current('kanban.show', { kanban:  kanban.id})"
                                :key="kanban.id"
                                @delete-kanban="openDeleteModal"
                            />
                            <NavItems as="button" @click="openKanbanModal">
                                <Plus class="w-5 h-5" />
                                Creation kanban
                            </NavItems>
                        </template>
                    </NavGroup>
            </div>   
        </div>
        <!-- Page Content -->
        <div class="flex-1 flex flex-col">
            <header class="flex lg:hidden items-center justify-between px-4 py-2 border-b border-neutral-100">
                <button class="space-y-1 w-5 rounded-md" @click="openResponsiveNavModal">
                    <div class="h-0.5  bg-black"></div>
                    <div class="h-0.5  bg-black"></div>
                    <div class="h-0.5  bg-black"></div>
                </button>
                <div class="flex items-center gap-x-3.5">
                    <Button @click="openResearchModal" variant="ghost" size="icon">
                        <Search class="w-5 h-5" />
                    </Button>
                    <Button class="relative" variant="ghost" size="icon">
                        <Bell class="w-5 h-5" />
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-red-400"></span>
                    </Button>
                    <Avatar>
                        <AvatarImage :src="`https://ui-avatars.com/api/?name=${'johndoe'}&background=random`" alt="@unovue" />
                        <AvatarFallback>IV</AvatarFallback>
                    </Avatar>
                </div>
            </header>
            <main class="flex-1 p-2 md:p-4 overflow-y-auto">
                <slot />
            </main>
        </div>
    </div>
    <Teleport to="body">
        <ResponsiveNav 
            :open="openResponsiveNav" 
            @close="closeResponsiveNavModal" 
            @create-kanban="openKanbanModal" 
            @delete-kanban="openDeleteModal"
        />
        <Create :open="openKanban" @close="closeKanbanModal"/>
        <DeleteKanban :open="openDelete" :kanban-id="kanbanId" @close="closeDeleteModal" />
        <EditProfile :open="openEditProfile" @close="closeEditProfileModal"/>
        <FullTextResearch :open="openResearch" @close="closeResearchModal" @open-with-shortcut="openResearchModal" />
    </Teleport>
</template>

<script setup>
import { computed, ref } from 'vue';
import { Search, Bell, Settings, Plus } from 'lucide-vue-next';
import NavGroup from '@/components/NavGroup.vue';
import NavItems from '@/components/NavItems.vue';
import Profile from '@/components/Profile.vue';
import { usePage } from '@inertiajs/vue3';
import ResponsiveNav from '@/components/ResponsiveNav.vue';
import { Button } from '@/components/ui/button';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import NavKanban from '@/components/NavKanban.vue';
import Create from '@/Pages/Kanban/Partials/Create.vue';
import DeleteKanban from '@/Pages/Kanban/Partials/DeleteKanban.vue';
import EditProfile from '@/Partials/EditProfile.vue';
import FullTextResearch from '@/Partials/FullTextResearch.vue';

const page = usePage();

const authUser = computed(() => {
    return page.props.auth.user;
});

const kanbans = computed(() => {
    return page.props.auth.kanbans;
});

const openKanban = ref(false)
const openDelete = ref(false)
const openResponsiveNav = ref(false)
const openEditProfile = ref(false)
const openResearch = ref(false)
const kanbanId = ref(null)

const openKanbanModal = () => {
    openKanban.value = true
}
const closeKanbanModal = () => {
    openKanban.value = false
}


const openDeleteModal = (kanban) => {
    kanbanId.value = kanban
    openDelete.value = true
}
const closeDeleteModal = () => {
    openDelete.value = false
    kanbanId.value = null
}

const openEditProfileModal = () => {
    openEditProfile.value = true
}
const closeEditProfileModal = () => {
    openEditProfile.value = false
}

const openResearchModal = () => {
    openResearch.value = true
}
const closeResearchModal = () => {
    openResearch.value = false
}

const openResponsiveNavModal = () => {
    openResponsiveNav.value = true
}
const closeResponsiveNavModal = () => {
    openResponsiveNav.value = false
}

</script>