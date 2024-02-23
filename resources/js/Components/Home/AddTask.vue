<script setup>
// Imports
import { ref, defineEmits, onMounted } from "vue";
import TaskApi from "@/Apis/TaskApi.js";
import TaskLocalStorage from "@/Services/TaskLocalStorage.js";
import { usePage } from "@inertiajs/vue3";
import TaskProvider from "@/Helpers/TaskProvider.js";

// Define event emitter
const emit = defineEmits(['addTask'])

// Define reactive variables
const newTask = ref('')
const taskProvider = ref('')

// On component mounted
onMounted(() => {
  // Get user from page props
  const user = usePage().props?.auth?.user

  // Create task provider
  taskProvider.value = TaskProvider.createTaskProvider(user)
})

// Function to add a task
async function addTask() {
  // Trim new task value and return if empty
  if (!newTask.value.trim()) return

  // Get selected date from local storage
  const selectedDate = localStorage.getItem('selectedDate');

  // Define data for new task
  const data = { text: newTask.value, completed: false, start_date: selectedDate }

  // Store new task using task provider and return if response is empty
  const response = await taskProvider.value.store(data)
  if (!response) return

  // Emit 'addTask' event with response
  emit('addTask', response)

  // Clear new task value
  newTask.value = ''
}
</script>

<template>
  <!-- Add task item -->
  <div class="flex mb-4">
    <input
      @keydown.enter.prevent="addTask"
      v-model="newTask"
      type="text"
      placeholder="Add a new task"
      class="flex-1 rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
      autofocus
    />
    <button
      @click="addTask"
      class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-r-lg focus:outline-none focus:ring-2 ring-inset focus:ring-indigo-400"
    >
      Add
    </button>
  </div>
</template>
