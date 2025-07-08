<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function __construct(
        protected UserServiceInterface $userService
    ) {}

    public function index(): View
    {
        $users = $this->userService->getAllUsers(15);
        
        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(CreateUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        $this->userService->createUser($data);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dibuat.');
    }

    public function show(int $id): View
    {
        $user = $this->userService->getUserById($id);
        
        if (!$user) {
            abort(404, 'User tidak ditemukan.');
        }
        
        return view('admin.users.show', compact('user'));
    }

    public function edit(int $id): View
    {
        $user = $this->userService->getUserById($id);
        
        if (!$user) {
            abort(404, 'User tidak ditemukan.');
        }
        
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();
        
        $updated = $this->userService->updateUser($id, $data);
        
        if (!$updated) {
            return back()->withErrors(['error' => 'Gagal mengupdate user.']);
        }
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $deleted = $this->userService->deleteUser($id);
        
        if (!$deleted) {
            return back()->withErrors(['error' => 'Gagal menghapus user.']);
        }
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}