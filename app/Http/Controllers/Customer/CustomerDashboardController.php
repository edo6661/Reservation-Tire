<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\AuthServiceInterface;
use App\Services\CustomerServiceInterface;
use App\Services\ReservationServiceInterface;
use Illuminate\View\View;

class CustomerDashboardController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $authService,
        protected CustomerServiceInterface $customerService,
        protected ReservationServiceInterface $reservationService
    ) {}

    public function index(): View
    {
        $user = $this->authService->getCurrentUser();
        $customer = $this->customerService->getCustomerByUserId($user->id);
        
        $reservations = collect();
        if ($customer) {
            $reservations = $this->reservationService->getCustomerReservations($customer->id);
        }
        
        return view('customer.dashboard', compact('user', 'customer', 'reservations'));
    }
}