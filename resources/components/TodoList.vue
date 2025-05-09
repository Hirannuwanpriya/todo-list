<template>
  <div class="flex h-screen p-8 bg-gray-100">
    <!-- Add Task Form -->
    <div class="w-1/3 pr-8">
      <h2 class="text-lg font-semibold mb-4">Add a Task</h2>
      <input v-model="newTask.title" type="text" placeholder="Title" class="w-full mb-3 p-2 border rounded" />
      <textarea v-model="newTask.description" placeholder="Description" class="w-full mb-3 p-2 border rounded"></textarea>
      <button @click="addTask" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add</button>
      <p v-if="validationError" class="text-red-500 text-sm mb-3">{{ validationError }}</p>
    </div>

    <!-- Divider -->
    <div class="w-px bg-gray-300 mx-4"></div>

    <!-- Task List -->
    <div class="w-2/3">
      <div v-for="(task, index) in tasks" :key="index" class="bg-gray-200 p-4 rounded-lg flex justify-between items-start mb-4">
        <div>
          <h3 class="font-semibold text-lg">{{ task.title }}</h3>
          <p class="text-sm text-gray-700">{{ task.description }}</p>
        </div>
        <button @click="markDone(index)" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">Done</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue'
import axios from 'axios'

const newTask = reactive({
  title: '',
  description: ''
})

const tasks = reactive([])
const validationError = ref('')

async function fetchTasks() {
  try {
    const response = await axios.get(`${import.meta.env.VITE_API_URL}/tasks`)
    tasks.push(...response.data.payload) // Populate tasks with API response
  } catch (error) {
    console.error('Error fetching tasks:', error)
  }
}

async function addTask() {
  if (!newTask.title.trim()) {
    validationError.value = 'Title is required.'
    return
  }
  if (newTask.title.length < 3) {
    validationError.value = 'Title must be at least 3 characters long.'
    return
  }

  validationError.value = '' // Clear any previous errors

  try {
    const response = await axios.post(`${import.meta.env.VITE_API_URL}/tasks`, {
      title: newTask.title,
      description: newTask.description
    })

    tasks.push(response.data.payload) // Add the saved task to the list
    newTask.title = ''
    newTask.description = ''
  } catch (error) {
    console.error('Error saving task:', error)
    validationError.value = 'Failed to save the task. Please try again.'
  }
}

async function markDone(index) {
  const task = tasks[index]

  try {
    // Send a request to update the task's status using the task's id
    await axios.patch(`${import.meta.env.VITE_API_URL}/tasks/${task.id}/complete`, {
      id: task.id,
      status: 1
    })

    // Remove the task from the list after marking it as done
    tasks.splice(index, 1)
  } catch (error) {
    console.error('Error marking task as done:', error)
  }
}

// Fetch tasks when the component is mounted
onMounted(fetchTasks)
</script>
