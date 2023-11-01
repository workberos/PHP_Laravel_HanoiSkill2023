const showDiv = (value) => {
    document.getElementById('inputAmount').parentNode.style.display = 'none';
    document.getElementById('inputValidTill').parentNode.style.display = 'none';

    // Hiển thị div tương ứng với lựa chọn
    if (value == 'amount') {
        document.getElementById('inputAmount').parentNode.style.display = 'block';
    } else if (value == 'date') {
        document.getElementById('inputValidTill').parentNode.style.display = 'block';
    }
}