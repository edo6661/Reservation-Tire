<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\AnswerContactRequest;
use App\Services\ContactServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminContactController extends Controller
{
    public function __construct(
        protected ContactServiceInterface $contactService
    ) {}

    public function index(): View
    {
        $contacts = $this->contactService->getPaginatedContacts(15);
        $unansweredContacts = $this->contactService->getUnansweredContacts(15);
        
        return view('admin.contacts.index', compact('contacts', 'unansweredContacts'));
    }

    public function show(int $id): View
    {
        $contact = $this->contactService->getContactById($id);
        
        return view('admin.contacts.show', compact('contact'));
    }

    public function answer(AnswerContactRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();
        
        $this->contactService->answerContact($id, $data);
        
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan berhasil dijawab.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $deleted = $this->contactService->deleteContact($id);
        
        if (!$deleted) {
            return back()->withErrors(['error' => 'Gagal menghapus pesan.']);
        }
        
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}

