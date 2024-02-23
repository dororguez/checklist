Sure, I can help you refactor the code to make it more readable and maintainable. Here's a revised version of your Vue.js component:

```javascript
<script setup>
// Imports
import AddTask from "@/Components/Home/AddTask.vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import FilterTask from "@/Components/Home/FilterTask.vue";
import { ref, watch } from "vue";
import route from 'ziggy-js';
import TaskProvider from '@/Helpers/TaskProvider';
import { usePage } from "@inertiajs/vue3";
import draggable from 'vuedraggable';
import VueDatePicker from '@vuepic/vue-datepicker';
import "@vuepic/vue-datepicker/dist/main.css";

// Variable Definitions
const tasks = ref([]);
const selectedTaskItem = ref(null);
const filterOption = ref('all');
const searchItem = ref('');
const csrfToken = ref('');
const taskProvider = ref('');
const tasksInfo = ref('');
const currentPage = ref(1);
const user = ref({});
const filteredData = ref({});
const runFetch = ref();
const newTask = ref('');
const date = ref(null);
const filterDate = ref('');
const isRange = ref(false);
const isButtonActive = ref(false);

// Methods
const doDate = (modelData) => {
  date.value = modelData;
  filterDate.value = modelData ? modelData.toISOString().split('T')[0] : null;
  localStorage.setItem('selectedDate', date.value.toISOString().split('T')[0]);
};

const dateDefault = () => {
  doDate(null);
};

user.value = usePage().props?.auth?.user;
csrfToken.value = usePage().props?.csrf_token;
taskProvider.value = TaskProvider.createTaskProvider(user.value?.id);

watch([currentPage, filteredData, runFetch], async () => {
  tasksInfo.value = await taskProvider.value.get(filteredData.value, currentPage.value);
  tasks.value = tasksInfo.value.data;
}, { immediate: true });

watch([filterOption, filterDate, searchItem], () => {
  filteredData.value = {
    'filter': filterOption.value,
    'date': filterDate.value,
    'search': searchItem.value
  };
});

async function onDraggable(data) {
  const task = data['moved']['element'];
  const newOrder = await taskProvider.value.changeOrder(task, tasks.value);
  task.order = newOrder;
  runFetch.value = new Date();
}

const paginateHandler = (page) => {
  currentPage.value = page;
};

function addTask(data) {
  data.start_date = date.value ? date.value.toISOString().split('T')[0] : new Date().toISOString().split('T')[0];
  tasks.value.unshift(data);
  runFetch.value = new Date();
}

function openDeleteModal(taskItem) {
  selectedTaskItem.value = taskItem;
}

function closeDeleteModal() {
  selectedTaskItem.value = null;
}

async function onDelete() {
  const response = await taskProvider.value.destroy(selectedTaskItem.value.id);
  if (!response) return;
  tasks.value = tasks.value.filter((item) => item.id !== selectedTaskItem.value.id);
  closeDeleteModal();
  runFetch.value = new Date();
}

async function onUpdate(taskItem) {
  taskItem.text = taskItem.text.trim();
  const response = await taskProvider.value.update(taskItem);
  if (!response) return;
  taskItem.inEdit = false;
  runFetch.value = new Date();
}

function onEdit(taskItem) {
  taskItem.inEdit = true;
  taskItem.fomerText = taskItem.text;
}

function onCancel(taskItem) {
  taskItem.inEdit = false;
  taskItem.text = taskItem.fomerText;
}

function doFilter(filter) {
  filterOption.value = filter;
}

async function changeStatus(taskItem) {
  taskItem.completed = !taskItem.completed;
  taskItem.start_date = date.value ? date.value.toISOString().split('T')[0] : new Date().toISOString().split('T')[0];
  await taskProvider.value.update(taskItem);
  runFetch.value = new Date();
}
</script>

<template>
  <!-- Login and Register -->
  <div class="flex justify-end mb-4 space-x-5" v-if="!user?.id">
    <a :href="route('register')" class="text-white hover:text-gray-200 flex items-center bg-opacity-25 bg-white bg-blur rounded-lg p-3">
      <i class="bx bx-user-plus text-[1.18rem] mr-1"></i>
      <span>Register</span>
    </a>
    <a :href="route('login')" class="text-white hover:text-gray-200 flex items-center bg-opacity-25 bg-white bg-blur rounded-lg p-3">
      <i class="bx bx-log-in mr-1"></i>
      <span>Login</span>
    </a>
  </div>

  <!-- Logout -->
  <div class="flex justify-end mb-4" v-if="user?.id">
    <form :action="route('logout')" method="POST">
      <button type="submit" class="text-white hover:text-gray-200 flex items-center bg-opacity-25 bg-white bg-blur rounded-lg p-3">
        <i class="bx bx-log-out mr-1"></i>
        <span>Logout</span>
      </button>
      <input type="hidden" name="_token" :value="csrfToken">
      <div v-if="$page.props?.flash?.expired_message" class="text-red-900 mt-1 mb-2 text-sm">
        {{$page.props.flash.expired_message}}
      </div>
    </form>
  </div>

  <!-- Search by date -->
  <div class="flex justify-between mb-4 items-center">
    <div class="relative flex-grow mr-2">
      <VueDatePicker v-model="date" @update:model-value="doDate" :transitions="false" class="rounded-lg w-full" inputFormat="yyyy-MM-dd"/>
    </div>
    <button @click="dateDefault" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-r-lg focus:outline-none focus:ring-2 ring-inset focus:ring-indigo-400">
      All Task
    </button>
  </div>

  <!-- Search -->
  <div class="flex items-center justify-between mb-4">
    <div class="relative">
      <i class="bx bx-search text-xl text-gray-300 absolute left-1 top-[.43rem]"></i>
      <input v-model="searchItem" type="text" placeholder="Search tasks..." class="flex-1 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"/>
    </div>
    <FilterTask @on-filter="doFilter"/>
  </div>

  <AddTask @add-task="addTask"/>

  <!-- Task list -->
  <draggable class="space-y-4" v-model="tasks" group="people" @start="drag=true" @end="drag=false" item-key="id" @change="onDraggable">
    <!-- Single task item -->
    <template #item="{element}">
      <div :id="element.id" @dblclick="changeStatus(element)">
        <div class="flex items-center justify-between" v-if="element.inEdit">
          <input class="bg-white rounded-l-lg px-4 py-2 w-full focus:outline-none" v-model="element.text" @keydown.enter.prevent="onUpdate(element)" @dblclick.stop>
          <button class="text-green-600 bg-white bg-opacity-50 p-2 hover:text-green-500" @click="onUpdate(element)">
            <i class="bx bx-edit"></i>
          </button>
          <button class="text-red-500 bg-white bg-opacity-50 p-2 hover:text-red-700 rounded-r-lg" @click="onCancel(element)">
            <i class="bx bx-x-circle"></i>
          </button>
        </div>
        <div class="flex items-center justify-between rounded-lg px-4 py-2" v-if="!element.inEdit" :class="element.completed ? 'completed-task' : 'incomplete-task'">
          <span class="flex-1 text-gray-800 break-all select-none" :class="element.completed ? 'line-through' : ''">
            <span @dblclick.stop="onEdit(element)">{{element.text}}</span>
          </span>
          <div class="flex space-x-2">
            <!-- Edit icon -->
            <button class="text-blue-500 hover:text-blue-700" title="Edit" @click="onEdit(element)">
              <i class="bx bx-edit-alt"></i>
            </button>
            <!-- Delete icon -->
            <button class="text-red-500 hover:text-red-700" title="Delete" @click="openDeleteModal(element)">
              <i class="bx bx-trash"></i>
            </button>
            <!-- completed/Uncompleted button -->
            <button class="text-green-500 hover:text-green-700" title="completed" @click="changeStatus(element)">
              <i class="bx bx-check completed-icon" v-if="!element.completed"></i>
              <i class="bx bx-check-double completed-icon" v-if="element.completed"></i>
            </button>
          </div>
        </div>
      </div>
    </template>
  </draggable>

  <div class="flex justify-center mt-5" v-if="tasksInfo.total > tasksInfo.per_page">
    <vue-awesome-paginate
      :total-items="tasksInfo.total"
      :items-per-page="tasksInfo.per_page"
      :max-pages-shown="3"
      v-model="currentPage"
      :on-click="paginateHandler"
    >
      <template #prev-button>
        <i class="bx bx-chevron-left text-[1.3rem] font-bold"></i>
      </template>

      <template #next-button>
        <i class="bx bx-chevron-right text-[1.3rem] font-bold"></i>
      </template>
    </vue-awesome-paginate>
  </div>

  <DeleteModal
    v-if="selectedTaskItem"
    :message="'Are you sure you want to delete this task item?'"
    @confirm="onDelete"
    @close-delete-modal="closeDeleteModal"/>

</template>

<style>
.completed-icon {
  margin-right: -0.5rem;
}

.pagination-container {
  border-radius: 22px;
  overflow: hidden;
}

.paginate-buttons {
  width: 33px;
  height: 33px;
  cursor: pointer;
  border: none;
  border-inline: 1px solid theme('colors.indigo.400')
}

.paginate-buttons {
  @apply bg-indigo-600 text-white flex items-center justify-center
}

.active-page {
  @apply bg-indigo-400 text-white
}

.paginate-buttons:hover {
  @apply bg-indigo-800
}

.active-page:hover {
  @apply bg-indigo-400
}

.back-button {
  border-inline-start: none;
}

.next-button {
  border-inline-end: none;
}

.back-button svg {
  transform: rotate(180deg);
}

.back-button:active,
.next-button:active {
  @apply bg-indigo-800
}

.dp-custom-input {
  box-shadow: 0 0 6px #1976d2;
  color: #1976d2;
}
.dp-custom-input:hover {
  border-color: #1976d2;
}

.completed-task {
  background-color: #a6b9cf;
  opacity: 0.7;
}

.incomplete-task {
  background-color: #cdd9ee;
  opacity: 1;
}
</style>
