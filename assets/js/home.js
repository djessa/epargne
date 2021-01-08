const contact_btn = document.querySelector("#contact_btn");

const contact_content = document.getElementById('contact');

contact_btn.addEventListener('click', (event) => {
    contact_content.style.display = 'block';
    contact_btn.style.display = 'none';
});
contact_content.addEventListener('click', (event) => {
    contact_content.style.display = 'none';
    contact_btn.style.display = 'block';
});