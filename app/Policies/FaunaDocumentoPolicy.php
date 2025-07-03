<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Fauna;

class FaunaDocumentoPolicy
{
    public function view(User $user, Fauna $fauna): bool
    {
        return $this->puedeAcceder($user, $fauna);
    }

    public function create(User $user, Fauna $fauna): bool
    {
        return $this->puedeAcceder($user, $fauna);
    }

    public function delete(User $user, Fauna $fauna): bool
    {
        return $this->puedeAcceder($user, $fauna);
    }

    private function puedeAcceder(User $user, Fauna $fauna): bool
    {
        return $user->institucion_id === $fauna->institucion_id || $user->hasRole('admin');
    }
}
