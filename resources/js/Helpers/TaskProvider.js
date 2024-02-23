import TaskApi from '@/Apis/TaskApi';
import TaskLocalStorage from '@/Services/TaskLocalStorage';

class TaskProvider {
  static createTaskProvider(loggedIn) {
    return loggedIn ? new TaskApi() : new TaskLocalStorage();
  }
}

export default TaskProvider
