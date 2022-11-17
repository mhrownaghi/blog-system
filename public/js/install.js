document.querySelector('#show-password').addEventListener('click', (event) => {
  const password = document.querySelector("#password");
  
  if (password.getAttribute("type") === "password") {
    password.setAttribute("type", "text");
    event.currentTarget.textContent = "پسورد را مخفی کن";
  } else {
    password.setAttribute("type", "password");
    event.currentTarget.textContent = "پسورد را نمایش بده";
  }
})