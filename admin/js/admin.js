document.addEventListener("DOMContentLoaded", function () {
  // Dữ liệu mẫu (có thể thay bằng API hoặc MySQL)
  const totalTruyen = 50;
  const totalUser = 1200;
  const totalViews = 7890;

  document.getElementById("total-truyen").innerText = totalTruyen;
  document.getElementById("total-user").innerText = totalUser;
  document.getElementById("total-views").innerText = totalViews;
});
