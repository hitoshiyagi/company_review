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
            'name' => 'required|string|max:255',
        ]);

        auth()->user()->criteria()->create([
            'name' => $request->name,
            'weight' => 5, // 固定値 あとで修正
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
            'name' => 'required|string|max:255',
        ]);

        $criterion->update([
            'name' => $request->name,
        ]);

        return redirect()->route('criteria.index')->with('success', '評価軸を更新しました。');
    }

    public function destroy(Criterion $criterion)
    {
        $criterion->delete();
        return redirect()->route('criteria.index')->with('success', '評価軸を削除しました。');
    }
}
