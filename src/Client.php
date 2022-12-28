<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Contracts\ClientRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class Client extends Controller
{
    public function __construct(protected  readonly ClientRepositoryInterface $repository)
    {
    }

    public function index(): Renderable
    {
        $clients = $this->repository->getReservationForClients();

        return view('backend.domain.clients.index', compact('clients'));
    }

    public function show(int $key): Factory|View|Application
    {
        $client = $this->repository->showReservationForClient(key: $key);

        return view('backend.domain.clients.show', compact('client'));
    }
}
