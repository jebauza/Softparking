<?php

namespace App\Http\Livewire\Types;

use App\Type;
use Livewire\Component;
use Livewire\WithPagination;

class TypeComponent extends Component
{
    use WithPagination;

    //Public Properties
    public $description; // Types table fields
    public $selected_id, $search;
    public $action = 'index'; // Allows us to move between the form ['index', 'create', 'edit']

    private $pagination = 5;

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    /**
     * Method mount is the first one that is executed when the component is started.
     *
     * @return void
     */
    public function mount()
    {
        // Initialize variables or data
    }

    /**
     * Method render runs after mount
     *
     * @return View
     */
    public function render()
    {
        if (strlen($this->search) > 0) {
            $paginateTypes = Type::where('description', 'like', "%$this->search%")
                            ->orderBy('description')
                            ->paginate($this->pagination);
        } else {
            $paginateTypes = Type::orderBy('description')
                            ->paginate($this->pagination);
        }

        return view('livewire.types.type-component', compact('paginateTypes'));
    }

    /**
     * Method updatingSearch for searches with pagination
     *
     * @return void
     */
    public function updatingSearch()
    {
        $this->gotoPage(1);
    }

    /**
     * Method doAction
     *
     * @param String $action [explicite description]
     *
     * @return void
     */
    public function doAction($action)
    {
        if (in_array($action, ['index', 'create', 'edit'])) {
            $this->resetInput();

            $this->action = $action;
        }
    }

    /**
     * Method resetInput clean properties
     *
     * @return void
     */
    public function resetInput()
    {
        $this->description = '';
        $this->selected_id = null;
        $this->action = 'index';
        $this->search = '';
    }

    /**
     * Method edit
     *
     * @param $type_id $type_id [explicite description]
     *
     * @return void
     */
    public function edit($type_id)
    {
        $type = Type::findOrfail($type_id);

        $this->description = $type->description;
        $this->selected_id = $type->id;
        $this->action = 'edit';
    }

    /**
     * Method storeOrUpdate
     *
     * @return void
     */
    public function storeOrUpdate()
    {
        $this->validate([
            'description' => "required|min:4|max:255|unique:types,description,$this->selected_id,id"
        ]);

        // Update
        if ($this->selected_id) {
            $type = Type::findOrfail($this->selected_id);
            $type->fill([
                'description' => $this->description,
            ])
            ->save();

            session()->flash('message', 'Tipo Actualizado');

        // Store
        } else {
            $type = Type::create([
                'description' => $this->description,
            ]);

            session()->flash('message', 'Tipo Creado');
        }

        $this->resetInput();
    }

    /**
     * Method destroy
     *
     * @param $type_id $type_id [explicite description]
     *
     * @return void
     */
    public function destroy($type_id)
    {
        $type = Type::findOrfail($type_id);
        $type->delete();

        $this->resetInput();
        session()->flash('message', 'Tipo Eliminado');
    }
}
