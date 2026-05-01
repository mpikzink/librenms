<?php
namespace App\Http\Controllers;

use App\Models\Eventlog;
use App\Models\Port;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventlogController extends Controller
{
    public function index(Request $request, string $vars = ''): View
    {
        return view('eventlog', [
            'events' => Eventlog::query()
                ->orderByDesc('datetime')
                ->limit(100)
                ->get(),
        ]);
    }
}
