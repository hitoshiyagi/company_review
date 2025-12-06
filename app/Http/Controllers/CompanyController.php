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
        $companies = auth()->user()
            ->companies()
            ->with('evaluations')
            ->orderBy('created_at', 'desc')
            ->get();

        $criteria = auth()->user()->criteria;
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
        $company = auth()->user()->companies()->create(
            $request->only(['name', 'description', 'type'])
        );

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
        if ($company->user_id !== auth()->id()) {
            abort(403);
        }

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
        if ($company->user_id !== auth()->id()) {
            abort(403);
        }
        $criteria = auth()->user()->criteria()->orderBy('created_at', 'desc')->get();
        $evaluations = $company->evaluations()->where('user_id', auth()->id())->get()->keyBy('criterion_id');

        return view('companies.edit', compact('company', 'criteria', 'evaluations'));
    }

    /**
     * 更新（会社情報 + 評価スコア）
     */
    public function update(Request $request, Company $company)
    {
        if ($company->user_id !== auth()->id()) {
            abort(403);
        }

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
        if ($company->user_id !== auth()->id()) {
            abort(403);
        }
        $company->delete();
        return redirect()->route('companies.index')->with('success', '会社を削除しました。');
    }

    public function ranking()
    {
        $ranking = Company::with('evaluations.criterion')
            ->get()
            ->sortByDesc('total_score')
            ->values();

        $criteria = auth()->user()->criteria;

        return view('companies.ranking', compact('ranking', 'criteria'));
    }
    public function compare(Company $company)
    {
        $user = auth()->user();

        // 現職を取得
        $currentCompany = Company::where('type', 'current')->first() ?? $company;


        $criteria = $user->criteria;

        // 各会社のスコアを配列化
        $currentScores = $criteria->map(function ($criterion) use ($currentCompany, $user) {
            return optional(
                $currentCompany->evaluations
                    ->where('criterion_id', $criterion->id)
                    ->where('user_id', $user->id)
                    ->first()
            )->score ?? 0;
        });

        $targetScores = $criteria->map(function ($criterion) use ($company, $user) {
            return optional(
                $company->evaluations
                    ->where('criterion_id', $criterion->id)
                    ->where('user_id', $user->id)
                    ->first()
            )->score ?? 0;
        });

        return view('companies.compare', compact(
            'company',
            'currentCompany',
            'criteria',
            'currentScores',
            'targetScores'
        ));
    }
}
