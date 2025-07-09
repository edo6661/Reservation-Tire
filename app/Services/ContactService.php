<?php

namespace App\Services;
use App\Models\Contact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Enums\ContactSituation;
use App\Exceptions\Contact\ContactNotFoundException;
use App\Repositories\ContactRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
interface ContactServiceInterface
{
    public function getPaginatedContacts(int $perPage = 15): LengthAwarePaginator;
    public function getUnansweredContacts(int $perPage = 15): LengthAwarePaginator;
    public function getContactById(int $id): ?Contact;
    public function createContact(array $data): Contact;
    public function answerContact(int $id, array $data): Contact;
    public function deleteContact(int $id): bool;
}
class ContactService implements ContactServiceInterface
{
    public function __construct(protected ContactRepositoryInterface $contactRepository) {}

    public function getPaginatedContacts(int $perPage = 15): LengthAwarePaginator
    {
        return $this->contactRepository->getAllPaginated($perPage);
    }

    public function getUnansweredContacts(int $perPage = 15): LengthAwarePaginator
    {
        return $this->contactRepository->getUnansweredPaginated($perPage);
    }
    public function getAnsweredContacts(int $perPage = 15): LengthAwarePaginator
    {
        return $this->contactRepository->getByStatusPaginated(ContactSituation::ANSWERED, $perPage);
    }

    public function getContactById(int $id): ?Contact
    {
        $contact = $this->contactRepository->findById($id);
        if (!$contact) {
            throw new ContactNotFoundException("Contact dengan ID {$id} tidak ditemukan.");
        }
        return $contact;
    }

    public function createContact(array $data): Contact
    {
        return DB::transaction(function () use ($data) {
            $data['situation'] = ContactSituation::UNANSWERED;
            $contact = $this->contactRepository->create($data);
            
            // Send email notification to admin (implementation depends on your mail setup)
            // Mail::to(config('mail.admin_email'))->send(new NewContactMail($contact));
            
            return $contact;
        });
    }

    public function answerContact(int $id, array $data): Contact
    {
        return DB::transaction(function () use ($id, $data) {
            $contact = $this->getContactById($id);
            
            $updateData = [
                'answer_title' => $data['answer_title'],
                'answer_text' => $data['answer_text'],
                'situation' => ContactSituation::ANSWERED,
            ];
            
            $this->contactRepository->update($contact, $updateData);
            
            // Send email response to customer (implementation depends on your mail setup)
            // Mail::to($contact->sender)->send(new ContactResponseMail($contact));
            
            return $contact->fresh();
        });
    }

    public function deleteContact(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $contact = $this->getContactById($id);
            return $this->contactRepository->delete($contact);
        });
    }
}