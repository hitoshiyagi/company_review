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
        // ログインユーザーが作成した評価軸のみ取得
        $criteria = auth()->user()->criteria()->orderBy('created_at', 'desc')->get();

        return view('criteria.index', compact('criteria'));
    }

    /**
     * Show the form for creating a new resource.
     * 今回はモーダルで対応するので空でもOK
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|integer|min:1',
        ]);

        auth()->user()->criteria()->create($request->only(['name', 'weight']));

        return redirect()->route('criteria.index')->with('success', '評価軸を登録しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Criterion $criterion)
    {
        // 今回は詳細画面不要なら省略可
        return view('criteria.show', compact('criterion'));
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
            'weight' => 'required|integer|min:1',
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
