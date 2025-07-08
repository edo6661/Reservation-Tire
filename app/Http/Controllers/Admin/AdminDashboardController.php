<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContactServiceInterface;
use App\Services\CustomerServiceInterface;
use App\Services\ReservationServiceInterface;
use App\Services\UserServiceInterface;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __construct(
        protected UserServiceInterface $userService,
        protected ReservationServiceInterface $reservationService,
        protected ContactServiceInterface $contactService,
        protected CustomerServiceInterface $customerService
    ) {}

    public function index(): View
    {
        $totalUsers = $this->userService->getAllUsers(1)->total();
        $totalReservations = $this->reservationService->getPaginatedReservations(1)->total();
        $unansweredContacts = $this->contactService->getUnansweredContacts(1)->total();
        $totalCustomers = $this->customerService->getPaginatedCustomers(1)->total();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalReservations', 
            'unansweredContacts',
            'totalCustomers'
        ));
    }
}
