document.addEventListener("DOMContentLoaded", function () {
  const searchForm = document.getElementById("search-form");
  const searchInput = document.getElementById("search-input");
  const searchResults = document.getElementById("search-results");
  const searchResultCount = document.getElementById("search-result-count");

  // Dữ liệu truyện mẫu (có thể thay bằng API hoặc MySQL)
  const truyenData = [
    {
      title: "Phàm Nhân Tu Tiên",
      img: "./accsets/img/truyen (3).webp",
      category: "Huyền Huyễn",
    },
    {
      title: "Đấu La Đại Lục",
      img: "./accsets/img/truyen (2).webp",
      category: "Hành Động",
    },
    {
      title: "One Piece",
      img: "./accsets/img/truyen (1).webp",
      category: "Phiêu Lưu",
    },
    {
      title: "Thám Tử Lừng Danh Conan",
      img: "./accsets/img/truyen (5).webp",
      category: "Trinh Thám",
    },
  ];

  // Xử lý tìm kiếm
  searchForm.addEventListener("submit", function (e) {
    e.preventDefault();
    const query = searchInput.value.toLowerCase().trim();
    searchResults.innerHTML = ""; // Xóa kết quả cũ

    if (query === "") {
      searchResultCount.innerText = "Vui lòng nhập từ khóa!";
      return;
    }

    const filteredTruyen = truyenData.filter((truyen) =>
      truyen.title.toLowerCase().includes(query)
    );

    if (filteredTruyen.length === 0) {
      searchResultCount.innerText = "Không tìm thấy truyện nào.";
    } else {
      searchResultCount.innerText = `Tìm thấy ${filteredTruyen.length} truyện:`;

      filteredTruyen.forEach((truyen) => {
        searchResults.innerHTML += `
                    <div class="col-md-3">
                        <div class="card">
                            <img src="${truyen.img}" class="card-img-top" alt="${truyen.title}">
                            <div class="card-body text-center">
                                <h5 class="card-title">${truyen.title}</h5>
                                <p class="text-muted">${truyen.category}</p>
                                <a href="truyen.html?title=${truyen.title}" class="btn btn-primary">Xem Truyện</a>
                            </div>
                        </div>
                    </div>
                `;
      });
    }
  });
});
