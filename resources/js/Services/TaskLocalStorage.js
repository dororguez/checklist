// Importing TaskOrder helper
import TaskOrder from "@/Helpers/TaskOrder.js";

// Class for handling tasks in local storage
class TaskLocalStorage {
  // Fetch tasks from local storage with filters and pagination
  async get(filteredData, page = 1, perPage = 10) {
    let tasks = this._getTasks();

    // Apply filters
    tasks = this._applyFilters(tasks, filteredData);

    // Calculate pagination
    const paginatedTasks = this._paginate(tasks, page, perPage);

    return Promise.resolve(paginatedTasks);
  }

  // Store a new task in local storage
  async store(data) {
    const tasks = await this._getTasks();
    const lastOrder = tasks.length > 0 ? tasks[0]?.order : 0;
    const newTask = { 
      id: this._generateUniqueId(), 
      text: data.text, 
      completed: data.completed, 
      start_date: data.start_date, 
      order: lastOrder + 1 
    };
    tasks.unshift(newTask);
    localStorage.setItem('tasks', JSON.stringify(tasks));
    return Promise.resolve(newTask);
  }

  // Remove a task from local storage
  async destroy(id) {
    const tasks = await this._getTasks();
    const updatedTasks = tasks.filter(task => task.id !== id);
    localStorage.setItem('tasks', JSON.stringify(updatedTasks));
    return Promise.resolve(true);
  }

  // Update a task in local storage
  async update(data) {
    const tasks = await this._getTasks();
    const updatedTask = { 
      id: data.id, 
      text: data.text, 
      completed: data.completed, 
      start_date: data.start_date, 
      order: data.order 
    };
    const updatedTasks = tasks.map(task => (task.id === data.id ? updatedTask : task));
    localStorage.setItem('tasks', JSON.stringify(updatedTasks));
    return Promise.resolve(data);
  }

  // Change the order of tasks in local storage
  async changeOrder(task, tasks) {
    const newOrder = TaskOrder.newOrder(task, tasks);
    const allTasks = await this._getTasks();
    const updatedTasks = allTasks.map(item => {
      if (item.id === task.id) item.order = newOrder;
      if (item.order >= newOrder && item.id !== task.id) item.order++;
      return item;
    });
    localStorage.setItem('tasks', JSON.stringify(updatedTasks));
    return Promise.resolve(newOrder);
  }

  // Generate a unique ID for a task
  _generateUniqueId() {
    return Date.now().toString(36) + Math.random().toString(36).substring(2, 12).padStart(12, 0);
  }

  // Fetch tasks from local storage
  _getTasks() {
    let tasks = localStorage.getItem('tasks');
    tasks = tasks ? JSON.parse(tasks) : [];
    tasks.sort((a, b) => a.order - b.order).reverse();
    return tasks;
  }

  // Apply filters to tasks
  _applyFilters(tasks, filteredData) {
    if (filteredData.filter === 'active') {
      tasks = tasks.filter(task => !task.completed);
    } else if (filteredData.filter === 'completed') {
      tasks = tasks.filter(task => task.completed);
    }  

    // Apply date filter
    if (filteredData.date) {
      const filterDate = new Date(filteredData.date);
      tasks = tasks.filter(task => new Date(task.start_date).toDateString() === filterDate.toDateString());
    }    

    // Apply search
    if (filteredData.search) {
      const searchTerm = filteredData.search.toLowerCase();
      tasks = tasks.filter(task => task.text.toLowerCase().includes(searchTerm));
    }

    return tasks;
  }

  // Apply pagination to tasks
  _paginate(tasks, page, perPage) {
    const startIndex = (page - 1) * perPage;
    const endIndex = startIndex + perPage;
    const paginatedTasks = tasks.slice(startIndex, endIndex);

    // Simulate response structure similar to Laravel pagination
    const totalPages = Math.ceil(tasks.length / perPage);
    const currentPage = page;
    const from = startIndex + 1;
    const to = Math.min(endIndex, tasks.length);
    const total = tasks.length;

    return {
      current_page: currentPage,
      data: paginatedTasks,
      from,
      to,
      per_page: perPage,
      total,
      total_pages: totalPages,
    };
  }
}

export default TaskLocalStorage;
