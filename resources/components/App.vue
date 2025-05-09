<template>
  <div>
    <TodoList />
  </div>
</template>

<script>
import TodoList from './TodoList.vue';

export default {
  name: 'App',
  components: {
    TodoList,
  },
};
</script>
