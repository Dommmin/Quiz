<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Inertia\Inertia;

class TestController extends Controller
{
    public function __invoke()
    {
        $tests = Test::with(['user', 'quiz'])->withCount('questions')->latest()->paginate()->through(function ($test) {
            return [
                'id'              => $test->id,
                'result'          => $test->result,
                'ip_address'      => $test->ip_address,
                'time_spent'      => intval($test->time_spent / 60) . ':' . gmdate('s', $test->time_spent),
                'username'        => $test->user ? $test->user->name : 'Guest',
                'quiz_id'         => $test->quiz_id,
                'created_at'      => $test->created_at->format('d-m-Y H:i:s'),
                'questions_count' => $test->questions_count,
                'quiz'            => $test->quiz,
            ];
        });

        return Inertia::render('Admin/Tests', compact('tests'));
    }
}
