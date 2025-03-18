document.addEventListener("DOMContentLoaded", function () {
  fetch("http://localhost:888/trangwebtutien/admin/apistory/get_truyen.php")
    .then((response) => response.json())
    .then((data) => {
      let list = document.getElementById("truyenList"); // ID chính xác trong HTML
      list.innerHTML = ""; // Xóa nội dung cũ

      if (data.status === "success") {
        data.stories.forEach((story) => {
          let item = `
            <div class="col-md-3">
              <div class="card">
                <img src="${story.anh_bia}" class="card-img-top" alt="${story.ten_truyen}">
                <div class="card-body">
                  <h5 class="card-title">${story.ten_truyen}</h5>
                  <p class="card-text">Tác giả: ${story.tac_gia}</p>
                  <a href="story.html?id=${story.id}" class="btn btn-primary">Đọc ngay</a>
                </div>
              </div>
            </div>
          `;
          list.innerHTML += item;
        });
      } else {
        list.innerHTML = `<p class="text-danger">Không có truyện nào để hiển thị.</p>`;
      }
    })
    .catch((error) => console.error("Lỗi khi lấy dữ liệu:", error));
});
