// Hàm tính Fibonacci
function calculateFibonacci(n) {
    if (n <= 1) return n;
    return calculateFibonacci(n - 1) + calculateFibonacci(n - 2);
}

// Lắng nghe message từ main thread
self.addEventListener('message', function(e) {
    const number = e.data;

    // Bắt đầu tính toán
    const startTime = performance.now();
    const result = calculateFibonacci(number);
    const endTime = performance.now();

    // Gửi kết quả về main thread
    self.postMessage({
        number: number,
        result: result,
        timeSpent: endTime - startTime
    });
});
