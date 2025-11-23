<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 会社を全件取得、最新登録順
        $companies = Company::orderBy('created_at', 'desc')->get();

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Company::create($request->only(['name', 'description']));

        return redirect()->route('companies.index')->with('success', '会社を登録しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        // ログインユーザーの評価軸を取得（nullの場合は空コレクション）
        $criteria = auth()->user()->criteria ?? collect();

        // 会社に対する評価を取得（nullの場合は空コレクション）
        $evaluations = $company->evaluations()->where('user_id', auth()->id())->get() ?? collect();

        return view('companies.edit', compact('company', 'criteria', 'evaluations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        // 会社情報のバリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // 会社情報を更新
        $company->update($request->only(['name', 'description']));

        // 評価スコアを更新
        if ($request->has('scores')) {
            foreach ($request->scores as $criterionId => $score) {
                $company->evaluations()->updateOrCreate(
                    ['user_id' => auth()->id(), 'criterion_id' => $criterionId],
                    ['score' => $score]
                );
            }
        }

        return redirect()->route('companies.index')->with('success', '会社情報と評価スコアを更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index')->with('success', '会社を削除しました。');
    }
}
