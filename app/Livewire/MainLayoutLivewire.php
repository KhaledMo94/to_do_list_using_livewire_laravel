<?php

namespace App\Livewire;
use App\Models\Task;
use Livewire\Component;

class MainLayoutLivewire extends Component
{
    public $filter = 'all';

    public $id = '';

    public $name = '';

    public $description = '';

    public $selected = 'all';

    public function setFilter($filter){
        $this->filter = $filter;
    }

    public function getTasksProperty()
    {
        switch ($this->filter) {
            case 'done':
                $this->selected = 'done';
                return Task::where('done', true)->get();
            case 'not_completed':
                $this->selected = 'not_completed';
                return Task::where('done', false)->get();
            default:
                $this->selected = 'all';
                return Task::all();
        }
    }

    public function checkDone($id){
        Task::where('id',$id)->update([
            'done'          =>true,
        ]);
    }

    public function createNewTask(){
        Task::create([
            'name'                  =>$this->name,
            'description'           =>$this->description,
        ]);

        $this->reset(['name','description']);
        session()->flash('success', 'Task has been added successfully!');
    }

    public function deleteTask($id){
        Task::where('id',$id)->delete();
        session()->flash('danger','Task has been deleted');
    }

    public function render()
    {
        return view('livewire.main-layout-livewire',[
            'tasks'                 =>$this->tasks
        ]);
    }
}
