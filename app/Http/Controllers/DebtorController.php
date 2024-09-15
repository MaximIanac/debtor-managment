<?php

namespace App\Http\Controllers;

use App\Models\Debtor;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DebtorController extends Controller
{
    public function index(Request $request)
    {
        $query = Debtor::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('total_debt', 'LIKE', "%{$search}%");
        }

        $debtors = $query->orderBy('created_at', 'desc')->get();

        if ($request->ajax()) {
            return view('debtors.partials.debtors-list', compact('debtors'))->render();
        }

        return view('debtors.index', compact('debtors'));
    }

    public function get()
    {
        dd($this->calcSum("3 5 2 8 7 5 2"));
    }

    public function calcSum($str)
    {
        $numbers = collect(explode(" ", $str))
            ->map(
                fn($item) => intval($item)
            );

        return $numbers->sortDesc()->unique()->values()->toArray();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
        ]);

        $debtor = Debtor::create([
            'name' => $request->name,
            'total_debt' => $request->amount,
            'user_id' => auth()->id(),
        ]);

        Payment::create([
            'debtor_id' => $debtor->id,
            'user_id' => auth()->id(),
            'amount' => $request->amount,
        ]);

        return redirect()->route('debtors')->with('success', 'Должник добавлен.');
    }

}
