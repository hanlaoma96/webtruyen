document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const category = urlParams.get("type") || "all";

  // Cập nhật tiêu đề trang
  const categoryTitle = document.getElementById("category-title");
  categoryTitle.innerText =
    "Thể Loại: " + (category === "all" ? "Tất Cả" : category.toUpperCase());

  // Dữ liệu truyện mẫu (có thể thay bằng dữ liệu từ database)
  const truyenData = [
    {
      title: "Truyện 1",
      img: "./accsets/img/truyen (9).webp",
      category: "hanhdong",
    },
    {
      title: "Truyện 2",
      img: "./accsets/img/truyen (8).webp",
      category: "phieuluu",
    },
    {
      title: "Truyện 3",
      img: "./accsets/img/truyen (7).webp",
      category: "tinhcam",
    },
    {
      title: "Truyện 4",
      img: "./accsets/img/truyen (6).webp",
      category: "haihuoc",
    },
    {
      title: "Truyện 5",
      img: "./accsets/img/truyen (5).webp",
      category: "kinhdi",
    },
    {
      title: "Truyện 6",
      img: "./accsets/img/truyen (4).webp",
      category: "trinhtham",
    },
  ];

  // Lọc truyện theo thể loại
  const truyenList = document.getElementById("truyen-list");
  truyenList.innerHTML = ""; // Xóa nội dung cũ

  truyenData.forEach((truyen) => {
    if (category === "all" || truyen.category === category) {
      truyenList.innerHTML += `
              <div class="col-md-3">
                  <div class="card">
                      <img src="${truyen.img}" class="card-img-top" alt="${truyen.title}">
                      <div class="card-body text-center">
                          <h5 class="card-title">${truyen.title}</h5>
                          <a href="truyen.html?title=${truyen.title}" class="btn btn-primary">Đọc Ngay</a>
                      </div>
                  </div>
              </div>
          `;
    }
  });
});
