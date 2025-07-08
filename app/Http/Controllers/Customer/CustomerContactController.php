<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\CreateContactRequest;
use App\Services\ContactServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerContactController extends Controller
{
    public function __construct(
        protected ContactServiceInterface $contactService
    ) {}

    public function index(): View
    {
        // buat customer yang login, tampilin kontak mereka ya bang
        $contacts = $this->contactService->getPaginatedContacts(15);
        
        return view('customer.contacts.index', compact('contacts'));
    }

    public function create(): View
    {
        return view('customer.contacts.create');
    }

    public function store(CreateContactRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        $this->contactService->createContact($data);
        
        if (auth()->check()) {
            return redirect()->route('customer.contacts.index')
                ->with('success', 'Pesan berhasil dikirim.');
        }
        
        return redirect()->route('contact.create')
            ->with('success', 'Pesan berhasil dikirim. Terima kasih!');
    }

    public function show(int $id): View
    {
        $contact = $this->contactService->getContactById($id);
        
        return view('customer.contacts.show', compact('contact'));
    }
}