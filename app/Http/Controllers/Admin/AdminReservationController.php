<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReservationServiceInterface;
use App\Services\UserServiceInterface;
use App\Enums\UserRole;
use App\Http\Requests\Reservation\CreateReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminReservationController extends Controller
{
    public function __construct(
        protected ReservationServiceInterface $reservationService,
        protected UserServiceInterface $userService
    ) {}
    public function index(): View
    {
        $reservations = $this->reservationService->getPaginatedReservations(15);
        
        return view('admin.reservations.index', compact('reservations'));
    }

    public function create()
    {
        
        $customers = $this->userService->getUsersByRole(UserRole::CUSTOMER, 999);
        
        return view('admin.reservations.create', compact('customers'));
    }

    public function store(CreateReservationRequest $request)
    {
        try {
            $validatedData = $request->validated();
            
            if (empty($validatedData['customer_id'])) {
                unset($validatedData['customer_id']);
            }
            
            $reservation = $this->reservationService->createReservation($validatedData);
            
            return redirect()
                ->route('admin.reservations.show', $reservation->id)
                ->with('success', 'Reservasi berhasil dibuat.');
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $reservation = $this->reservationService->getReservationById($id);
            
            
            $customers = $this->userService->getUsersByRole(UserRole::CUSTOMER, 999);
            
            return view('admin.reservations.edit', compact('reservation', 'customers'));
            
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.reservations.index')
                ->with('error', $e->getMessage());
        }
    }

    public function update(UpdateReservationRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            
            $reservation = $this->reservationService->updateReservation($id, $validatedData);
            
            return redirect()
                ->route('admin.reservations.show', $reservation->id)
                ->with('success', 'Reservasi berhasil diperbarui.');
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
     
    public function show(int $id): View
    {
        $reservation = $this->reservationService->getReservationById($id);
        
        return view('admin.reservations.show', compact('reservation'));
    }


    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->reservationService->delete($id);
            
            return redirect()->route('admin.reservations.index')
                ->with('success', 'Reservasi berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function confirm(int $id): RedirectResponse
    {
        try {
            $this->reservationService->confirmReservation($id);
            
            return redirect()->route('admin.reservations.index')
                ->with('success', 'Reservasi berhasil dikonfirmasi.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function reject(int $id): RedirectResponse
    {
        try {
            $this->reservationService->rejectReservation($id);
            
            return redirect()->route('admin.reservations.index')
                ->with('success', 'Reservasi berhasil ditolak.');
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