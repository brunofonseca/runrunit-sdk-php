<?php

namespace Devlau\Runrunit\Actions;

use Devlau\Runrunit\Resources\Task;

trait ManagesTasks
{
    /**
     * Get all tasks.
     *
     * @return array
     */
    public function tasks(array $query = null)
    {
        return $this->transformCollection(
            $this->get('tasks', ['query' => $query]),
            Task::class
        );
    }

    /**
     * Find task by id.
     *
     * @param int $id
     *
     * @return Task
     */
    public function task($id)
    {
        $task = $this->get("tasks/{$id}");

        return new Task($task, $this);
    }

    /**
     * Change a Task status to another
     *
     * @param int $id  Task ID
     * @param int $taskStatusId  Task Status ID
     *
     * @return Task
     */
    public function changeTaskStatus($id, $taskStatusId)
    {
        $task = $this->post("tasks/{$id}/change_status", [
            'json' => [
                'task_status_id' => $taskStatusId,
            ]
        ]);

        return new Task($task, $this);
    }

    /**
     * Create new task.
     *
     * @param array $data
     *
     * @return Task
     */

    public function createTask(array $data)
    {
        $task = $this->post('tasks', [
            'json' => [
                'task' => $data
            ]
        ]);

        return new Task($task, $this);
    }

    /**
     * Set Prerequisites
     *
     * Custom Methods from Green Signal
     *
     * @param array $data
     *
     * @return Task
     */

    public function setPreRequisite($taskId, $prerequisiteId)
    {
        $task = $this->post("tasks/{$taskId}/prerequisites", [
            'json' => [
                'prerequisite' => [
                    "id" => $prerequisiteId
                ],
            ]
        ]);

        return new Task($task, $this);
    }

    /**
     * Task Description
     *
     * Custom Methods from Green Signal
     *
     * @param array $data
     *
     * @return Task
     */

    public function tasksDescription($id)
    {
        $task = $this->get("tasks/{$id}/description");

        return $task;
    }

    /**
     * Set tag
     *
     * Custom Methods from Green Signal
     *
     * @param array $data
     *
     * @return Task
     */

     public function setTag($taskId,$tag){
        $task = $this->put("tasks/{$taskId}", [
            'json' => [
                'task' => [
                    "tags_data" => [
                        [
                            "name" => "{$tag}"
                        ]
                    ],
                    "delay_after_hooks" => true
                ],
            ]
        ]);

        return new Task($task, $this);
     }

}
