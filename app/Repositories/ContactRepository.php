<?php

namespace App\Repositories;
use App\Models\Contact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Enums\ContactSituation;

interface ContactRepositoryInterface
{
    public function findById(int $id): ?Contact;
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;
    public function getUnansweredPaginated(int $perPage = 15): LengthAwarePaginator;
    public function create(array $data): Contact;
    public function update(Contact $contact, array $data): bool;
    public function delete(Contact $contact): bool;
}
class ContactRepository implements ContactRepositoryInterface
{
    public function __construct(protected Contact $model) {}

    public function findById(int $id): ?Contact
    {
        return $this->model->with(['reception'])->find($id);
    }

    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
{
    return $this->model->with(['reception'])
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);
}

    public function getByStatusPaginated(string $status, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with(['reception'])
            ->where('situation', $status)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
    public function getUnansweredPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with(['reception'])
            ->where('situation', ContactSituation::UNANSWERED)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function create(array $data): Contact
    {
        return $this->model->create($data);
    }

    public function update(Contact $contact, array $data): bool
    {
        return $contact->update($data);
    }

    public function delete(Contact $contact): bool
    {
        return $contact->delete();
    }
}