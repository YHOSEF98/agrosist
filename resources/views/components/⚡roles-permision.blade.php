<?php

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

new class extends Component
{
    public ?Role $role = null;
    public $rolName = '';
    public $selectedPermissions = [];
    public $permissions = [];

    public function mount(?Role $role = null)
    {
        $this->permissions = \Spatie\Permission\Models\Permission::all();
        if ($role) {
        $this->rolName = $role->name;
        $this->selectedPermissions = $role->permissions
            ->pluck('name')
            ->toArray();
    }
    }

    public function createRole(){
        $this->validate(['rolName' => ['required', 'string', 'max:255', 'unique:roles,name'],]);

        $rol = Role::create(['name' => $this->rolName]);
        $rol->syncPermissions($this->selectedPermissions);

        $this->reset(['rolName', 'selectedPermissions']);
        session()->flash('success', 'Rol creado exitosamente.');
        return redirect()->route('roles.index', [
            'current_team' => request()->route('current_team'),
        ]);
    }

     protected function updateRole()
    {
        $this->validate([
            'rolName' => 'required|string|max:255|unique:roles,name,' . $this->role->id,
        ]);

        $this->role->update([
            'name' => $this->rolName,
        ]);

        $this->role->syncPermissions($this->selectedPermissions);

        session()->flash('success', 'Rol actualizado exitosamente.');
        return redirect()->route('roles.index', [
            'current_team' => request()->route('current_team'),
        ]);
    }

    public function save()
    {
        if ($this->role) {
            $this->updateRole();
        } else {
            $this->createRole();
        }
    }

    
};
?>

<div class="p-4 border border-neutral-200 dark:border-neutral-700 rounded-xl">
    {{ $role ? 'Editar Rol' : 'Crear Rol' }}

    <!-- Input para nombre del rol -->
    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Nombre del Rol</label>
        <input type="text" wire:model="rolName"
               class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-500">
    </div>

    <!-- Lista de permisos -->
    <div class="mb-4">
        <h4 class="text-sm font-semibold mb-2">Permisos disponibles</h4>
        <div class="grid grid-cols-2 gap-2">
            @foreach($permissions as $permission)
                <label class="flex items-center space-x-2">
                    <input type="checkbox" wire:model="selectedPermissions"
                           value="{{ $permission->name }}"
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span>{{ $permission->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <!-- Botón para crear rol -->
    <flux:button variant="filled" href="{{ route('roles.index') }}">Volver</flux:button>    
    <flux:button variant="primary" class="btn-create" icon:trailing="plus" wire:click="save">{{ $role ? 'Actualizar rol' : 'Crear rol' }}</flux:button>

    <!-- Mensaje de confirmación -->
    @if (session()->has('message'))
        <div class="mt-4 text-green-600 font-medium">
            {{ session('message') }}
        </div>
    @endif
</div>