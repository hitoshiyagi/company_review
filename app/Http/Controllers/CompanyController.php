<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Criterion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    /**
     * 会社一覧
     */
    public function index()
    {
        $companies = Company::with('evaluations')->orderBy('created_at', 'desc')->get();
        $criteria = Criterion::all(); // 合計点数計算などで必要なら
        return view('companies.index', compact('companies', 'criteria'));
    }

    /**
     * 新規会社登録（モーダルからPOST）
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(Company::TYPES)],
        ]);

        // 会社作成
        $company = Company::create($request->only(['name', 'description', 'type']));

        // 評価スコア保存
        if ($request->has('scores')) {
            foreach ($request->scores as $criterionId => $score) {
                $company->evaluations()->create([
                    'user_id' => auth()->id(),
                    'criterion_id' => $criterionId,
                    'score' => $score,
                ]);
            }
        }

        return redirect()->route('companies.index')->with('success', '会社を登録しました。');
    }


    /**
     * 詳細画面
     */
    public function show(Company $company)
    {
        // ログインユーザーの評価を取得
        $evaluations = $company->evaluations()->where('user_id', auth()->id())->get()->keyBy('criterion_id');
        $criteria = auth()->user()->criteria;

        return view('companies.show', compact('company', 'evaluations', 'criteria'));
    }

    /**
     * 編集画面
     */
    public function edit(Company $company)
    {
        $criteria = auth()->user()->criteria()->orderBy('created_at', 'desc')->get();
        $evaluations = $company->evaluations()->where('user_id', auth()->id())->get()->keyBy('criterion_id');

        return view('companies.edit', compact('company', 'criteria', 'evaluations'));
    }

    /**
     * 更新（会社情報 + 評価スコア）
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(Company::TYPES)],
        ]);

        // 会社情報更新
        $company->update($request->only(['name', 'description', 'type']));

        // 評価スコア更新
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
     * 削除
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success', '会社を削除しました。');
    }

    public function ranking()
    {
        // 会社を全取得 → evaluations を一緒に読み込む
        $companies = Company::with('evaluations')->get();

        // 合計スコアを計算して並び替え
        $ranking = $companies->map(function ($company) {
            $company->total_score = $company->evaluations->sum('score');
            return $company;
        })->sortByDesc('total_score')->values(); // 順位を振り直すために values()

        return view('companies.ranking', compact('ranking'));
    }
}
