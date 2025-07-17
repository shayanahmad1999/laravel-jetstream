<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\Users\UserForm;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class EditUser extends Component
{
    public UserForm $form;

    public function mount(User $user)
    {
        $this->form->setUser($user);
    }

    public function update()
    {
        $this->form->update();
        return $this->redirect(route('users.index'), navigate: true);
    }
    public function render()
    {
        return view('livewire.users.edit-user');
    }
}
