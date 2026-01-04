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

    /**
     * ランキング（自分のデータのみに修正）
     */
    public function ranking()
    {
        // auth()->user()->companies() を経由することで、自分のデータのみ取得
        $ranking = auth()->user()->companies()
            ->with('evaluations.criterion')
            ->get()
            ->sortByDesc('total_score')
            ->values();

        $criteria = auth()->user()->criteria;

        return view('companies.ranking', compact('ranking', 'criteria'));
    }

    /**
     * 会社比較（セキュリティ強化と現職取得の修正）
     */
    public function compare(Company $company)
    {
        // 【セキュリティ】比較対象が自分のものでない場合はエラー
        if ($company->user_id !== auth()->id()) {
            abort(403);
        }

        $user = auth()->user();

        // 【重要】自分の会社の中から「現職」を取得
        $currentCompany = $user->companies()->where('type', 'current')->first();

        // 現職が登録されていない場合のハンドリング（エラー回避）
        if (!$currentCompany) {
            return redirect()->route('companies.index')->with('error', '比較には「現職」の登録が必要です。');
        }

        $criteria = $user->criteria;

        // スコア算出（ここはそのままでOKですが、$currentCompanyの取得元が安全になったので正常に動作します）
        $currentScores = $criteria->map(function ($criterion) use ($currentCompany, $user) {
            $score = optional(
                $currentCompany->evaluations
                    ->where('criterion_id', $criterion->id)
                    ->where('user_id', $user->id)
                    ->first()
            )->score ?? 0;
            return $score * $criterion->weight;
        });

        $targetScores = $criteria->map(function ($criterion) use ($company, $user) {
            $score = optional(
                $company->evaluations
                    ->where('criterion_id', $criterion->id)
                    ->where('user_id', $user->id)
                    ->first()
            )->score ?? 0;
            return $score * $criterion->weight;
        });

        $maxScore = max($currentScores->max() ?? 0, $targetScores->max() ?? 0);

        return view('companies.compare', compact(
            'company',
            'currentCompany',
            'criteria',
            'currentScores',
            'targetScores',
            'maxScore'
        ));
    }}