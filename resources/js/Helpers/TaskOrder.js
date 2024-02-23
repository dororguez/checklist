class TaskOrder {
  static newOrder(task, tasks) {
    const index = tasks.findIndex((item) => item.id === task['id'])
    const previousItem = tasks[index - 1];
    const secondItem = tasks[1];
    const lastItem = tasks[tasks.length - 1];
    let newOrder = (previousItem) ? previousItem.order : secondItem.order + 1
    newOrder = (newOrder === lastItem.order) ? newOrder - 1 : newOrder
    return newOrder
  }
}

export default TaskOrder
