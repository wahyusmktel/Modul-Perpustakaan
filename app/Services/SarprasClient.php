<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class SarprasClient
{
    protected string $base;
    protected array $headers;
    protected int $timeout;
    protected int $retry;
    protected int $retryDelay;

    public function __construct()
    {
        $this->base   = rtrim(config('sarpras.base_url'), '/');
        $token        = config('sarpras.token');
        $this->timeout = (int) config('sarpras.timeout');
        $this->retry   = (int) config('sarpras.retry');
        $this->retryDelay = (int) config('sarpras.retry_delay');

        $this->headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];
    }

    protected function client()
    {
        return Http::withHeaders($this->headers)
            ->timeout($this->timeout)
            ->retry($this->retry, $this->retryDelay);
    }

    // ===== CRUD Buku (proxy ke Sarpras) =====
    public function listBooks(array $query = []): array
    {
        $res = $this->client()->get("{$this->base}/books", $query);
        $res->throw();
        return $res->json(); // paginated resource
    }

    public function getBook(int $id): array
    {
        $res = $this->client()->get("{$this->base}/books/{$id}");
        $res->throw();
        return $res->json();
    }

    public function createBook(array $payload): array
    {
        $res = $this->client()->post("{$this->base}/books", $payload);
        $res->throw();
        return $res->json();
    }

    public function updateBook(int $id, array $payload): array
    {
        $res = $this->client()->patch("{$this->base}/books/{$id}", $payload);
        $res->throw();
        return $res->json();
    }

    public function deleteBook(int $id): bool
    {
        $res = $this->client()->delete("{$this->base}/books/{$id}");
        if ($res->status() === 204) return true;
        $res->throw();
        return false;
    }
}
