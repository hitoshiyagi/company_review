<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use Illuminate\Http\Request;

class CriterionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $criteria = auth()->user()->criteria()->orderBy('created_at', 'desc')->get();
        return view('criteria.index', compact('criteria'));
    }
    public function store(Request $request)
    {
        // 評価軸は1ユーザーあたり最大5個
        if (auth()->user()->criteria()->count() >= 5) {
            return redirect()->route('criteria.index')
                ->with('error', '評価軸は1ユーザーあたり最大5個までです。');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            // 'weight' => 'required|integer|min:1|max:100', // これを削除
        ]);

        // 作成（weightは10で固定）
        auth()->user()->criteria()->create([
            'name' => $request->name,
            'weight' => 10,
        ]);

        return redirect()->route('criteria.index')->with('success', '評価軸を登録しました。');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Criterion $criterion)
    {
        return view('criteria.edit', compact('criterion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Criterion $criterion)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|integer|min:1|max:100',
        ]);

        $criterion->update($request->only(['name', 'weight']));

        return redirect()->route('criteria.index')->with('success', '評価軸を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Criterion $criterion)
    {
        $criterion->delete();
        return redirect()->route('criteria.index')->with('success', '評価軸を削除しました。');
    }
}
