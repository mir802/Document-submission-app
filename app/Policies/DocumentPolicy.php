<?php


namespace App\Policies;

use App\Models\User;
use App\Models\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Document $document)
    {
        // Allow both document owner and admin users
        return $user->id === $document->user_id || $user->is_admin;
    }

   /* public function update(User $user, Document $document)
    {
        return $user->is_admin;
    } */
    public function update(User $user, Document $document)
        {
            return $user->id === $document->user_id || $user->is_admin;
        }
}