<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\Users\UserForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class CreateUser extends Component
{
    public UserForm $form;

    public function store()
    {
        $this->form->store();
    }
    public function render()
    {
        return view('livewire.users.create-user');
    }
}
