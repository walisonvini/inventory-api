<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Clients;

use App\Exceptions\ModelNotFoundException;

class ClientService
{
    public function all(): array
    {
        return Clients::find()->toArray();
    }

    public function find(int $id): Clients
    {
        $client = Clients::findFirst([
            'conditions' => 'id = :id:',
            'bind'       => [
                'id' => $id,
            ],
        ]);

        if(!$client) {
            throw new ModelNotFoundException('Client not found');
        }

        return $client;
    }

    public function create(array $data): Clients
    {
        $client = new Clients();

        $client->assign($data, [
            'full_name',
            'email',
            'phone',
            'document',
        ]);

        $client->save();

        $client->refresh();

        return $client;
    }

    public function update(int $id, array $data): Clients
    {
        $client = $this->find($id);

        $client->assign($data, [
            'full_name',
            'email',
            'phone',
            'document',
        ]);

        $client->save();

        $client->refresh();

        return $client;
    }

    public function delete(int $id): bool
    {
        $client = $this->find($id);
        $client->delete();

        return true;
    }
}
