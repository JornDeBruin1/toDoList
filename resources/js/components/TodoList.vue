<template>
    <div class="flex justify-center bg-gray-200 p-4 m-0">
        <h1 class="font-bold text-2xl">To-Do List</h1>
    </div>
    <div class="flex justify-center p-4 m-0">
        <input
            v-model="newTask"
            type="text"
            class="w-1/2 bg-gray-100 p-2"
            placeholder="Voeg een nieuwe taak toe"
        />
        <button
            v-if="!editingTask"
            @click="addTask"
            class="bg-green-500 text-white p-2"
        >
            Toevoegen
        </button>
        <button v-else @click="updateTask" class="bg-orange-400 text-white p-2">
            Wijzigen
        </button>
    </div>
    <div class="flex justify-center p-4">
        <div class="w-1/2 p-4">
            <ul>
                <li
                    :class="{ hidden: task.voltooid }"
                    v-for="task in tasks"
                    :key="task.id"
                    class="flex justify-between p-3 m-2"
                >
                    <input
                        type="checkbox"
                        :checked="task.voltooid"
                        @change="toggleTaskCompletion(task)"
                    />
                    <span class="p-4">{{ task.ToDoItem }}</span>
                    <button
                        @click="editTask(task)"
                        class="bg-orange-400 text-white p-2"
                    >
                        Wijzig
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const newTask = ref("");
const tasks = ref([]);
const editingTask = ref("");

const fetchTasks = async () => {
    try {
        const response = await axios.get("/api/tasks");
        tasks.value = response.data;
    } catch (error) {
        console.error("Error fetching tasks:", error);
    }
};

const addTask = async () => {
    if (newTask.value.trim() === "") return;

    try {
        const response = await axios.post("/api/tasks", {
            ToDoItem: newTask.value,
        });
        tasks.value.push(response.data);
        newTask.value = "";
    } catch (error) {
        console.error("Error adding task:", error);
    }
};

const updateTask = async () => {
    if (newTask.value.trim() === "") return;

    try {
        const response = await axios.put(`/api/tasks/${editingTask.value.id}`, {
            ToDoItem: newTask.value,
        });
        const index = tasks.value.findIndex(
            (task) => task.id === editingTask.value.id
        );
        tasks.value[index] = response.data;
        editingTask.value = null;
        newTask.value = "";
    } catch (error) {
        console.error("Error updating task:", error);
    }
};
const editTask = (task) => {
    newTask.value = task.ToDoItem;
    editingTask.value = task;
};
const toggleTaskCompletion = async (task) => {
    try {
        const response = await axios.put(`/api/tasks/${task.id}`, {
            voltooid: !task.voltooid,
        });
        const index = tasks.value.findIndex((t) => t.id === task.id);
        tasks.value[index] = response.data;
    } catch (error) {
        console.error("Error toggling task completion:", error);
    }
};

onMounted(fetchTasks);
</script>
