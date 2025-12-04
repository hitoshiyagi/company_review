new Chart(ctx, {
    type: "radar",
    data: {
        labels: [
            "給料",
            "福利厚生",
            "人間関係",
            "仕事内容",
            "ワークライフバランス",
        ],
        datasets: [
            {
                label: "現職",
                data: [現職の各軸スコア配列],
                borderColor: "rgba(44, 177, 188, 1)",
                backgroundColor: "rgba(44, 177, 188, 0.2)",
            },
            {
                label: "{{ $company->name }}",
                data: [会社の各軸スコア配列],
                borderColor: "rgba(74, 144, 226, 1)",
                backgroundColor: "rgba(74, 144, 226, 0.2)",
            },
        ],
    },
});
