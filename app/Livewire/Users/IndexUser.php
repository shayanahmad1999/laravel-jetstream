<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class IndexUser extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $filterRole = '';

    public $selectedUsers = [];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterRole()
    {
        $this->resetPage();
    }

    public function getSelectableUsersProperty()
    {
        return User::where('id', '!=', auth()->id())->pluck('id')->toArray();
    }

    public function toggleSelectAll()
    {
        $this->selectedUsers = count($this->selectedUsers) === count($this->selectableUsers)
            ? []
            : $this->selectableUsers;
    }

    public function deleteBulk()
    {
        $user = User::whereIn('id', $this->selectedUsers)->where('id', '!=', auth()->id())->delete();
        $this->selectedUsers = [];
        session()->flash('success', 'Selected users deleted successfully!');
        $this->resetPage();
    }

    public function changeRoleBulk($role)
    {
        $users = User::whereIn('id', $this->selectedUsers)
            ->where('id', '!=', auth()->id())
            ->get();

        foreach ($users as $user) {
            $this->authorize('changeRole', $user);
            $user->update(['role' => $role]);
        }

        $this->selectedUsers = [];
        session()->flash('success', 'Roles updated successfully for selected users!');
        $this->resetPage();
    }

    public function changeRole($id, $role)
    {
        if ($id == auth()->id()) return;
        $user = User::findOrFail($id);
        $this->authorize('changeRole', $user);

        $user->update(['role' => $role]);
        session()->flash('success', 'User role updated successfully!');
    }

    public function delete($id)
    {
        if ($id == auth()->id()) return;
        $user = User::findOrFail($id);

        $this->authorize('delete', $user);
        $user->delete();
        session()->flash('success', 'User deleted successfully!');
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();
        $team = $user->currentTeam;

        $query = User::query()
            ->where('id', '!=', auth()->id())
            ->when($this->filterRole, fn($q) => $q->where('role', $this->filterRole))
            ->when($this->search, fn($q) => $q->where(
                fn($query) =>
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
            ));

        if ($user->isAdmin() && $team) {
            $query->whereHas('teams', fn($q) => $q->where('teams.id', $team->id));
        } elseif (! $user->isSuperAdmin()) {
            return view('livewire.users.index-user', [
                'users' => collect(),
            ]);
        }

        return view('livewire.users.index-user', [
            'users' => $query->latest()->paginate(10),
        ]);
    }
}
