<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Services\AuthServiceInterface;
use App\Services\UserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $authService,
        protected UserServiceInterface $userService
    ) {}

    public function show(): View
    {
        $user = $this->authService->getCurrentUser();
        
        return view('admin.profile.show', compact('user'));
    }

    public function edit(): View
    {
        $user = $this->authService->getCurrentUser();
        
        return view('admin.profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $this->authService->getCurrentUser();
        
        $updated = $this->userService->updateUser($user->id, $data);
        
        if (!$updated) {
            return back()->withErrors(['error' => 'Gagal mengupdate profil.']);
        }
        
        return redirect()->route('admin.profile.show')
            ->with('success', 'Profil berhasil diupdate.');
    }

    public function destroy(): RedirectResponse
    {
        $user = $this->authService->getCurrentUser();
        
        $deleted = $this->userService->deleteUser($user->id);
        
        if (!$deleted) {
            return back()->withErrors(['error' => 'Gagal menghapus akun.']);
        }
        
        $this->authService->logout();
        
        return redirect()->route('login')
            ->with('success', 'Akun berhasil dihapus.');
    }
}

