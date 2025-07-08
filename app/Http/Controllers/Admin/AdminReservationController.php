<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\CreateReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Services\ReservationServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminReservationController extends Controller
{
    public function __construct(
        protected ReservationServiceInterface $reservationService
    ) {}

    public function index(): View
    {
        $reservations = $this->reservationService->getPaginatedReservations(15);
        
        return view('admin.reservations.index', compact('reservations'));
    }

    public function create(): View
    {
        return view('admin.reservations.create');
    }

    public function store(CreateReservationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        try {
            $this->reservationService->createReservation($data);
            
            return redirect()->route('admin.reservations.index')
                ->with('success', 'Reservasi berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(int $id): View
    {
        $reservation = $this->reservationService->getReservationById($id);
        
        return view('admin.reservations.show', compact('reservation'));
    }

    public function edit(int $id): View
    {
        $reservation = $this->reservationService->getReservationById($id);
        
        return view('admin.reservations.edit', compact('reservation'));
    }

    public function update(UpdateReservationRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();
        
        try {
            $this->reservationService->updateReservation($id, $data);
            
            return redirect()->route('admin.reservations.index')
                ->with('success', 'Reservasi berhasil diupdate.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->reservationService->cancelReservation($id);
            
            return redirect()->route('admin.reservations.index')
                ->with('success', 'Reservasi berhasil dibatalkan.');
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
