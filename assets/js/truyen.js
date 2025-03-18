document.addEventListener("DOMContentLoaded", function () {
  // Lấy dữ liệu từ URL (ví dụ: truyen.html?id=1)
  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get("id");

  fetch(`backend/truyen.php?id=${id}`)
    .then((response) => response.json())
    .then((truyen) => {
      document.getElementById("truyen-title").innerText = truyen.ten_truyen;
      document.getElementById("truyen-img").src = truyen.anh_bia;
      document.getElementById("truyen-author").innerText = truyen.tac_gia;
      document.getElementById("truyen-category").innerText = truyen.the_loai;
      document.getElementById("truyen-views").innerText = truyen.luot_xem;
      document.getElementById("truyen-desc").innerText = truyen.mo_ta;

      // Fetch danh sách chương
      fetch(`backend/chuong.php?truyen_id=${id}`)
        .then((response) => response.json())
        .then((chapters) => {
          const chapterList = document.getElementById("chapter-list");
          chapters.forEach((chapter) => {
            const li = document.createElement("li");
            li.className = "list-group-item";
            li.innerHTML = `<a href="chuong.html?id=${chapter.id}">${chapter.ten_chuong}</a>`;
            chapterList.appendChild(li);
          });
        });
    });
});
