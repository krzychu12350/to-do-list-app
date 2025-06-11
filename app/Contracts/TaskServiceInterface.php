<?php

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Task;
use Illuminate\Http\Request;

interface TaskServiceInterface
{
    public function list(Request $request): Collection|LengthAwarePaginator;
    public function create(array $data): Task;
    public function get(Task $task): Task;
    public function update(Task $task, array $data): Task;
    public function delete(Task $task): void;
}
