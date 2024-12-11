<!DOCTYPE html>
<html>
<head>
    <title>Fibonacci Calculator (No Worker)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .calculator {
            max-width: 500px;
            margin: 2rem auto;
            padding: 1rem;
        }

        .input-group {
            margin-bottom: 1rem;
        }

        .form-input {
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            background-color: #3490dc;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .progress {
            width: 100%;
            height: 4px;
            background-color: #eee;
            border-radius: 2px;
            margin-top: 1rem;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background-color: #3490dc;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .result {
            margin-top: 1rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .time {
            font-size: 0.875rem;
            color: #666;
        }

        /* Thêm style cho UI freeze warning */
        .warning {
            background-color: #fff3cd;
            color: #856404;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            border: 1px solid #ffeeba;
        }

        /* Style cho counter để demo UI blocking */
        .counter {
            position: fixed;
            top: 1rem;
            right: 1rem;
            background: #3490dc;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <h2>Fibonacci Calculator (No Worker)</h2>

        <div class="warning">
            Note: UI will freeze during calculation of large numbers because this version doesn't use Web Workers
        </div>

        <!-- Counter để demo UI blocking -->
        <div class="counter" id="counter">
            Counter: 0
        </div>

        <div class="input-group">
            <input
                type="number"
                id="fibNumber"
                class="form-input"
                placeholder="Enter a number"
            >
            <button
                id="calculateBtn"
                class="btn"
            >
                Calculate
            </button>
        </div>

        <div id="progress" class="progress" style="display: none;">
            <div class="progress-bar"></div>
        </div>

        <div id="result" class="result" style="display: none;">
            <p id="fibResult"></p>
            <p id="timeSpent" class="time"></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('fibNumber');
            const button = document.getElementById('calculateBtn');
            const progress = document.getElementById('progress');
            const resultDiv = document.getElementById('result');
            const fibResult = document.getElementById('fibResult');
            const timeSpent = document.getElementById('timeSpent');
            const counterElement = document.getElementById('counter');

            let calculating = false;
            let counter = 0;

            // Counter để demo UI blocking
            setInterval(() => {
                counter++;
                counterElement.textContent = `Counter: ${counter}`;
            }, 100);

            // Hàm tính Fibonacci (chạy trực tiếp trên main thread)
            function calculateFibonacci(n) {
                if (n <= 1) return n;
                return calculateFibonacci(n - 1) + calculateFibonacci(n - 2);
            }

            // Xử lý click button
            button.addEventListener('click', function() {
                const number = parseInt(input.value);

                if (isNaN(number) || calculating) return;

                calculating = true;
                button.textContent = 'Calculating...';
                button.disabled = true;
                input.disabled = true;
                resultDiv.style.display = 'none';
                progress.style.display = 'block';

                // Thêm setTimeout để cho phép UI update trước khi bắt đầu tính toán
                setTimeout(() => {
                    const startTime = performance.now();

                    // Tính toán trực tiếp trên main thread
                    const result = calculateFibonacci(number);

                    const endTime = performance.now();
                    const timeElapsed = endTime - startTime;

                    // Update UI
                    fibResult.textContent = `Fibonacci(${number}) = ${result}`;
                    timeSpent.textContent = `Calculation time: ${timeElapsed.toFixed(2)}ms`;

                    progress.style.display = 'none';
                    resultDiv.style.display = 'block';
                    calculating = false;
                    button.textContent = 'Calculate';
                    button.disabled = false;
                    input.disabled = false;
                }, 100);
            });
        });
    </script>
</body>
</html>
