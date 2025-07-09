<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\CreateReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Services\AuthServiceInterface;
use App\Services\CustomerServiceInterface;
use App\Services\ReservationServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerReservationController extends Controller
{
    public function __construct(
        protected ReservationServiceInterface $reservationService,
        protected AuthServiceInterface $authService,
        protected CustomerServiceInterface $customerService
    ) {}

    public function index(): View
    {
        $user = $this->authService->getCurrentUser();
        $customer = $this->customerService->getCustomerByUserId($user->id);
        
        $reservations = collect();
        if ($customer) {
            $reservations = $this->reservationService->getCustomerReservations($customer->id);
        }
        
        return view('customer.reservations.index', compact('reservations'));
    }

    public function create(): View
    {
        return view('customer.reservations.create');
    }

    public function store(CreateReservationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        $user = $this->authService->getCurrentUser();
        $customer = $this->customerService->getCustomerByUserId($user->id);
        
        if (!$customer) {
            return back()->withErrors(['error' => 'Profil customer tidak ditemukan.']);
        }
        
        $data['customer_id'] = $customer->id;
        
        try {
            $this->reservationService->createReservation($data);
            
            return redirect()->route('customer.reservations.index')
                ->with('success', 'Reservasi berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(int $id): View
    {
        $reservation = $this->reservationService->getReservationById($id);
        
        // Check if reservation belongs to current customer
        $user = $this->authService->getCurrentUser();
        $customer = $this->customerService->getCustomerByUserId($user->id);
        
        if (!$customer || $reservation->customer_id !== $customer->id) {
            abort(403, 'Anda tidak memiliki akses ke reservasi ini.');
        }
        
        return view('customer.reservations.show', compact('reservation'));
    }

    public function edit(int $id): View
    {
        $reservation = $this->reservationService->getReservationById($id);
        
        // Check if reservation belongs to current customer
        $user = $this->authService->getCurrentUser();
        $customer = $this->customerService->getCustomerByUserId($user->id);
        
        if (!$customer || $reservation->customer_id !== $customer->id) {
            abort(403, 'Anda tidak memiliki akses ke reservasi ini.');
        }
        
        return view('customer.reservations.edit', compact('reservation'));
    }

    public function update(UpdateReservationRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();
        
        // Check if reservation belongs to current customer
        $reservation = $this->reservationService->getReservationById($id);
        $user = $this->authService->getCurrentUser();
        $customer = $this->customerService->getCustomerByUserId($user->id);
        
        if (!$customer || $reservation->customer_id !== $customer->id) {
            abort(403, 'Anda tidak memiliki akses ke reservasi ini.');
        }
        
        try {
            $this->reservationService->updateReservation($id, $data);
            
            return redirect()->route('customer.reservations.index')
                ->with('success', 'Reservasi berhasil diupdate.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function cancel(int $id): RedirectResponse
    {
        // Check if reservation belongs to current customer
        $reservation = $this->reservationService->getReservationById($id);
        $user = $this->authService->getCurrentUser();
        $customer = $this->customerService->getCustomerByUserId($user->id);
        
        if (!$customer || $reservation->customer_id !== $customer->id) {
            abort(403, 'Anda tidak memiliki akses ke reservasi ini.');
        }
        
        try {
            $this->reservationService->cancelReservation($id);
            
            return redirect()->route('customer.reservations.index')
                ->with('success', 'Reservasi berhasil dibatalkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function checkAvailability(Request $request)
    {
        $date = $request->input('date');
        $time = $request->input('time');
        
        $isAvailable = $this->reservationService->checkAvailability($date, $time);
        
        return response()->json(['available' => $isAvailable]);
    }

    public function getAvailableSlots(string $date)
    {
        $slots = $this->reservationService->getAvailableSlots($date);
        
        return response()->json(['slots' => $slots]);
    }
}