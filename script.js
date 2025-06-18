print("Hello World");
        window.onload = function () {
    const totalAmount = getCookie('num') || 0;
    document.getElementById('num').innerText = totalAmount > 0 ? totalAmount : 0;
};
function getCookie(name) {
    const cookies = document.cookie.split('; ');
    for (let cookie of cookies) {
        const [key, value] = cookie.split('=');
        if (key === name) {
            return value;
        }
    }
    return null;
}
       window.onload = function () {
    const totalAmount = getCookie('num') || 0;
    document.getElementById('num').textContent = totalAmount;
};

let i = 0;
let totaalprijs = 0;

function counter(button) {
    i++;
    document.getElementById("num").innerHTML = i;
    document.cookie = `num=${i}; expires=Fri, 31 Dec 2025 23:59:59 GMT; path=/`;

    console.log(`numm: ${i}`);

    const productDiv = button.parentElement;
    const prijsElement = productDiv.querySelector('p[name="prijs"]');
    const prijs = prijsElement.textContent.trim();

    const cast = Number(prijs);
    totaalprijs += cast;

    document.cookie = `totalAmount=${totaalprijs}; expires=Fri, 31 Dec 2025 23:59:59 GMT; path=/`;

    console.log(`Totaalprijs: ${totaalprijs}`);
}
