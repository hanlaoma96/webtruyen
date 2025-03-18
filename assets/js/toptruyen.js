document.addEventListener("DOMContentLoaded", function () {
  const topTabs = document.querySelectorAll(".nav-link");
  const topTruyenList = document.getElementById("top-truyen-list");

  // Dữ liệu truyện mẫu (thay bằng API hoặc MySQL nếu có)
  const truyenData = {
    "top-read": [
      {
        title: "Phàm Nhân Tu Tiên",
        img: "./accsets/img/truyen (3).webp",
        views: "1.2M",
      },
      {
        title: "Đấu La Đại Lục",
        img: "./accsets/img/truyen (2).webp",
        views: "980K",
      },
      {
        title: "One Piece",
        img: "./accsets/img/truyen(1).webp",
        views: "850K",
      },
    ],
    "top-new": [
      {
        title: "Thám Tử Lừng Danh Conan",
        img: "./accsets/img/truyen (5).webp",
        views: "320K",
      },
      {
        title: "Tuyệt Thế Vô Song",
        img: "./accsets/img/truyen (4).webp",
        views: "290K",
      },
      {
        title: "Tái Sinh Thành Hào Môn",
        img: "./accsets/img/truyen (6).webp",
        views: "275K",
      },
    ],
    "top-favorite": [
      {
        title: "Thần Võ Thiên Tôn",
        img: "./accsets/img/truyen (7).webp",
        views: "1.1M",
      },
      {
        title: "Thế Giới Hoàn Mỹ",
        img: "./accsets/img/truyen (8).webp",
        views: "995K",
      },
      {
        title: "Linh Vũ Thiên Hạ",
        img: "./accsets/img/truyen (9).webp",
        views: "900K",
      },
    ],
  };

  function loadTopTruyen(category) {
    topTruyenList.innerHTML = "";
    truyenData[category].forEach((truyen) => {
      topTruyenList.innerHTML += `
                <div class="col-md-4">
                    <div class="card">
                        <img src="${truyen.img}" class="card-img-top" alt="${truyen.title}">
                        <div class="card-body text-center">
                            <h5 class="card-title">${truyen.title}</h5>
                            <p class="text-muted">${truyen.views} lượt đọc</p>
                            <a href="truyen.html?title=${truyen.title}" class="btn btn-primary">Xem Truyện</a>
                        </div>
                    </div>
                </div>
            `;
    });
  }

  // Load danh sách đầu tiên
  loadTopTruyen("top-read");

  // Chuyển đổi giữa các tab
  topTabs.forEach((tab) => {
    tab.addEventListener("click", function (e) {
      e.preventDefault();
      document.querySelector(".nav-link.active").classList.remove("active");
      this.classList.add("active");
      loadTopTruyen(this.getAttribute("data-category"));
    });
  });
});
