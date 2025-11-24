<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobScore - 転職判断をシンプルに可視化</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        /* --- Base Styles --- */
        :root {
            --primary-color: #102a43;
            /* 深いネイビー（ロゴベース） */
            --secondary-color: #243b53;
            /* 少し明るいネイビー */
            --accent-color: #2cb1bc;
            /* 清潔感のあるシアンブルー（アクセント） */
            --text-dark: #102a43;
            --text-gray: #486581;
            --bg-light: #f0f4f8;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Sans JP', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            background-color: var(--white);
        }

        a {
            text-decoration: none;
        }

        ul {
            list-style: none;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        /* --- Components --- */
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .btn {
            display: inline-block;
            padding: 12px 32px;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: var(--white);
            box-shadow: 0 4px 6px rgba(44, 177, 188, 0.3);
        }

        .btn-primary:hover {
            background-color: #1f8b94;
            transform: translateY(-2px);
        }

        /* ログインボタン（オレンジ） */
        .btn-success {
            background-color: #f39c12;
            /* 視認性の高いオレンジ */
            color: var(--white);
            margin-right: 15px;
            /* 隣のボタンとの隙間 */
            box-shadow: 0 4px 6px rgba(243, 156, 18, 0.4);
            /* オレンジ色の影 */
        }

        .btn-success:hover {
            background-color: #e67e22;
            /* ホバー時は少し濃いオレンジへ */
            transform: translateY(-2px);
        }

        .btn-outline {
            border: 2px solid var(--white);
            color: var(--white);
        }

        .btn-outline:hover {
            background-color: var(--white);
            color: var(--primary-color);
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .section-subtitle {
            text-align: center;
            color: var(--text-gray);
            margin-bottom: 3rem;
            font-size: 1.1rem;
        }

        /* --- Header --- */
        header {
            background-color: var(--white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .logo img {
            height: 60px;
            /* ロゴの高さ調整 */
        }

        /* --- Hero Section --- */
        .hero {
            padding-top: 140px;
            padding-bottom: 100px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .hero-text {
            flex: 1;
            min-width: 300px;
            margin-right: 40px;
        }

        .hero h1 {
            font-size: 2.8rem;
            line-height: 1.3;
            margin-bottom: 20px;
            font-weight: 900;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .hero-image {
            flex: 1;
            min-width: 300px;
            position: relative;
        }

        /* CSSで簡易的なアプリ画面イメージを作成 */
        .app-mockup {
            background: var(--white);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            color: var(--text-dark);
            max-width: 400px;
            margin: 0 auto;
        }

        .mock-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
        }

        .mock-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--bg-light);
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .mock-score {
            font-weight: bold;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .mock-graph {
            height: 100px;
            background: #eef;
            border-radius: 8px;
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 0.8rem;
        }

        /* --- Problem Section --- */
        .problem {
            padding: 80px 0;
            background-color: var(--white);
        }

        .problem-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .problem-card {
            background: var(--bg-light);
            padding: 30px;
            border-radius: 12px;
            text-align: center;
        }

        .problem-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            display: block;
        }

        .problem-card h3 {
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        /* --- Solution Section --- */
        .solution {
            padding: 80px 0;
            background-color: var(--bg-light);
        }

        .solution-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }

        .solution-card {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .solution-card:hover {
            transform: translateY(-5px);
        }

        .solution-content {
            padding: 30px;
        }

        .solution-step {
            display: inline-block;
            background: var(--primary-color);
            color: var(--white);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .solution-card h3 {
            margin-bottom: 15px;
            font-size: 1.4rem;
        }

        .solution-card p {
            color: var(--text-gray);
            font-size: 0.95rem;
        }

        /* --- Message/Comparison Section --- */
        .message {
            padding: 80px 0;
            text-align: center;
        }

        .message h2 {
            font-size: 2.2rem;
            margin-bottom: 40px;
        }

        /* --- CTA Section --- */
        .cta {
            background-color: var(--primary-color);
            padding: 80px 0;
            text-align: center;
            color: var(--white);
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .cta p {
            font-size: 1.2rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        /* --- Footer --- */
        footer {
            background-color: #0b1d2e;
            color: #8ba6c1;
            padding: 40px 0;
            text-align: center;
            font-size: 0.9rem;
        }

        footer p {
            margin-top: 10px;
        }

        /* --- Responsive --- */
        @media (max-width: 768px) {
            .hero {
                padding-top: 100px;
                text-align: center;
            }

            .hero-text {
                margin-right: 0;
                margin-bottom: 40px;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.6rem;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="container header-inner">
            <div class="logo">
                <img src="{{ asset('vendor/adminlte/dist/img/logo.png') }}" alt="Logo">
            </div>
            <nav>
                <a href="{{ route('register') }}" class="btn btn-primary">無料で始める</a>
                <a href="{{ route('login') }}" class="btn btn-success">ログインする</a>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container hero-content">
            <div class="hero-text">
                <h1>あなたの転職判断を<br>シンプルに、視覚化します。</h1>
                <p>複数の企業情報もこれ一つで整理。<br>自分だけの評価軸で、運命の1社をスコアとランキングで導き出します。</p>
                <a href="{{ route('register') }}" class="btn btn-primary" style="background: white; color: var(--primary-color);">今すぐ比較を始める</a>
            </div>
            <div class="hero-image">
                <div class="app-mockup">
                    <div class="mock-header">
                        <span>企業ランキング</span>
                        <span>≡</span>
                    </div>
                    <div class="mock-row">
                        <span>🥇 A株式会社</span>
                        <span class="mock-score">88 pt</span>
                    </div>
                    <div class="mock-row">
                        <span>🥈 Bテック</span>
                        <span class="mock-score">74 pt</span>
                    </div>
                    <div class="mock-row">
                        <span>🥉 C商事</span>
                        <span class="mock-score">65 pt</span>
                    </div>
                    <div class="mock-graph">
                        [ 比較レーダーチャート ]
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="problem">
        <div class="container">
            <h2 class="section-title">転職活動で、こんな「迷い」ありませんか？</h2>
            <p class="section-subtitle">複数の企業と面接が進む中で、判断が難しくなっていませんか。</p>
            <div class="problem-grid">
                <div class="problem-card">
                    <span class="problem-icon">🤔</span>
                    <h3>どの会社が合うか<br>判断しにくい</h3>
                    <p>条件は良いけど社風が…など、あちらを立てればこちらが立たずで混乱する。</p>
                </div>
                <div class="problem-card">
                    <span class="problem-icon">📝</span>
                    <h3>比較管理が<br>とにかく手間</h3>
                    <p>エクセルやノートで情報をまとめるのが面倒で、結局感覚で選んでしまいそう。</p>
                </div>
                <div class="problem-card">
                    <span class="problem-icon">📊</span>
                    <h3>自分の軸と合っているか<br>不安</h3>
                    <p>自分が本当に重視したいポイントが満たされているか、一目で把握できない。</p>
                </div>
            </div>
        </div>
    </section>

    <section class="solution">
        <div class="container">
            <h2 class="section-title">その悩み、JobScoreで解決できます</h2>
            <p class="section-subtitle">自分に合う会社をスコアとランキングで簡単比較</p>
            <div class="solution-grid">
                <div class="solution-card">
                    <div class="solution-content">
                        <span class="solution-step">POINT 01</span>
                        <h3>あなただけの「評価軸」を作成</h3>
                        <p>年収、働きやすさ、スキルアップ…。既存の基準ではなく、あなたが仕事選びで大切にしたいポイントを自由に設定できます。</p>
                    </div>
                </div>
                <div class="solution-card">
                    <div class="solution-content">
                        <span class="solution-step">POINT 02</span>
                        <h3>直感的なスコアリング</h3>
                        <p>会社を登録して、設定した軸に沿って点数を入れるだけ。複雑な計算や管理は不要で、面接後の直感的な感想もすぐに記録できます。</p>
                    </div>
                </div>
                <div class="solution-card">
                    <div class="solution-content">
                        <span class="solution-step">POINT 03</span>
                        <h3>一目でわかる比較・ランキング</h3>
                        <p>総合スコアやランキング形式で表示されるため、どの会社が自分に合っているか、客観的なデータとして一瞬で判断できます。</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="message">
        <div class="container">
            <h2>自分だけの評価軸で、<br>自分にピッタリの会社がすぐわかる。</h2>
            <p>悔いのない転職は、納得のいく「比較」から。<br>あなたの価値観を可視化して、最高の意思決定をサポートします。</p>
        </div>
    </section>

    <section class="cta" id="cta">
        <div class="container">
            <h2>あなたの転職判断をサポートします</h2>
            <p>まずは無料で、気になる企業を登録してみましょう。</p>
            <a href="{{ route('register') }}" class="btn btn-primary" style="background: var(--white); color: var(--primary-color); font-size: 1.2rem; padding: 15px 40px;">無料で比較を始める</a>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="logo">
                <div class="logo">
                    <img src="{{ asset('vendor/adminlte/dist/img/logo_W.png') }}" alt="Logo">
                </div>
            </div>
            <p>&copy; 2025 JobScore. All Rights Reserved.</p>
        </div>
    </footer>

</body>

</html>