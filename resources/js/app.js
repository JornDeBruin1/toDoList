import { createApp } from "vue";
import ToDoList from "./components/TodoList.vue";

const app = createApp({});

app.component("todolist", ToDoList);
document.addEventListener("DOMContentLoaded", () => {
    app.mount("#app");
});
