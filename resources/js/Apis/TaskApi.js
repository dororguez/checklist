import route from 'ziggy-js';
import TaskOrder from "@/Helpers/TaskOrder.js";

class TaskApi {
  async get(filteredData, page = 1, perPage = 10) {
    try {
      const response = await axios.get(route('task.get'), {params: {page, perPage, filteredData}});
      return response.data;
    } catch (error) {
      console.error('Error getting task:', error);
      return false
    }
  }

  async store(data) {
    try {
      const response = await axios.post(route('task.store'), data);
      return response.data;
    } catch (error) {
      console.error('Error adding task:', error);
      return false
    }
  }

  async destroy(id) {
    try {
      await axios.delete(route('task.destroy', { task: id }));
      return true;
    } catch (error) {
      console.error('Error deleting task:', error);
      return false
    }
  }

  async update(data) {
    try {
      const response = await axios.put(route('task.update', { task: data.id }), data);
      return response.data;
    } catch (error) {
      console.error('Error updating task:', error);
      return false
    }
  }

  async changeOrder(task, tasks) {
    try {
      const newOrder = TaskOrder.newOrder(task, tasks)
      await axios.put(route('task.order', {task: task.id}), {newOrder})
      return newOrder;
    } catch (error) {
      console.error('Error changing task order:', error);
      return false
    }
  }
}

export default TaskApi;
