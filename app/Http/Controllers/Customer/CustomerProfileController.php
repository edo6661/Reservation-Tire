<?php


namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Services\AuthServiceInterface;
use App\Services\CustomerServiceInterface;
use App\Services\UserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerProfileController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $authService,
        protected UserServiceInterface $userService,
        protected CustomerServiceInterface $customerService
    ) {}

    public function show(): View
    {
        $user = $this->authService->getCurrentUser();
        $customer = $this->customerService->getCustomerByUserId($user->id);
        
        return view('customer.profile.show', compact('user', 'customer'));
    }

    public function edit(): View
    {
        $user = $this->authService->getCurrentUser();
        $customer = $this->customerService->getCustomerByUserId($user->id);
        
        return view('customer.profile.edit', compact('user', 'customer'));
    }

    public function update(UpdateCustomerRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $this->authService->getCurrentUser();
        
        $userData = $request->only(['name', 'email', 'password']);
        if (empty($userData['password'])) {
            unset($userData['password']);
        }
        
        $userUpdated = $this->userService->updateUser($user->id, $userData);
        
        $customer = $this->customerService->getCustomerByUserId($user->id);
        $customerData = $request->only(['phone_number']);
        
        $customerUpdated = true;
        if ($customer) {
            $customerUpdated = $this->customerService->updateCustomer($customer->id, $customerData);
        } else {
            $customerData['user_id'] = $user->id;
            $this->customerService->createCustomer($customerData);
        }
        
        if (!$userUpdated || !$customerUpdated) {
            return back()->withErrors(['error' => 'Gagal mengupdate profil.']);
        }
        
        return redirect()->route('customer.profile.show')
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