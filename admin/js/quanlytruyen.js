document.addEventListener("DOMContentLoaded", function () {
  const truyenTable = document.getElementById("truyen-table");
  const addTruyenForm = document.getElementById("addTruyenForm");

  // Dữ liệu truyện mẫu
  let truyenData = [
    {
      id: 1,
      title: "Phàm Nhân Tu Tiên",
      category: "Huyền Huyễn",
      img: "./img/truyen1.jpg",
    },
    {
      id: 2,
      title: "Đấu La Đại Lục",
      category: "Hành Động",
      img: "./img/truyen2.jpg",
    },
  ];

  function renderTable() {
    truyenTable.innerHTML = "";
    truyenData.forEach((truyen, index) => {
      truyenTable.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td><img src="${truyen.img}" width="50"></td>
                    <td>${truyen.title}</td>
                    <td>${truyen.category}</td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-btn" data-id="${
                          truyen.id
                        }"><i class="fa-solid fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${
                          truyen.id
                        }"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            `;
    });

    // Thêm sự kiện xóa
    document.querySelectorAll(".delete-btn").forEach((btn) => {
      btn.addEventListener("click", function () {
        const id = parseInt(this.getAttribute("data-id"));
        truyenData = truyenData.filter((t) => t.id !== id);
        renderTable();
      });
    });
  }

  // Xử lý thêm truyện
  addTruyenForm.addEventListener("submit", function (e) {
    e.preventDefault();
    const title = document.getElementById("truyen-name").value;
    const category = document.getElementById("truyen-category").value;
    const img = document.getElementById("truyen-img").value;
    const newTruyen = { id: truyenData.length + 1, title, category, img };
    truyenData.push(newTruyen);
    renderTable();
    document.getElementById("addTruyenForm").reset();
    new bootstrap.Modal(document.getElementById("addTruyenModal")).hide();
  });

  // Hiển thị danh sách truyện ban đầu
  renderTable();
});
