<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use Illuminate\Http\Request;

class CriterionController extends Controller
{
    public function index()
    {
        $criteria = auth()->user()->criteria()->orderBy('created_at', 'desc')->get();
        return view('criteria.index', compact('criteria'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->criteria()->count() >= 5) {
            return redirect()->route('criteria.index')
                ->with('error', '評価軸は1ユーザーあたり最大5個までです。');
        }

        $request->validate([
            'name'   => 'required|string|max:255',
            'weight' => 'required|integer|min:0|max:10'
        ]);

        auth()->user()->criteria()->create([
            'name'   => $request->name,
            'weight' => $request->weight
        ]);


        return redirect()->route('criteria.index')->with('success', '評価軸を登録しました。');
    }

    public function edit(Criterion $criterion)
    {
        return view('criteria.edit', compact('criterion'));
    }

    public function update(Request $request, Criterion $criterion)
    {
        $request->validate([
            'weight' => 'required|numeric|min:0'
        ]);

        $criterion->update([
            'weight' => $request->weight
        ]);

        return redirect()->route('criteria.index');
    }

    public function destroy(Criterion $criterion)
    {
        $criterion->delete();
        return redirect()->route('criteria.index')->with('success', '評価軸を削除しました。');
    }
}
