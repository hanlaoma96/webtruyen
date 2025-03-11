document.addEventListener("DOMContentLoaded", function () {
  const userTable = document.getElementById("user-table");

  // Dữ liệu người dùng mẫu
  let userData = [
    { id: 1, name: "Nguyễn Văn A", email: "user1@gmail.com", role: "User" },
    { id: 2, name: "Trần Thị B", email: "user2@gmail.com", role: "User" },
    { id: 3, name: "Admin C", email: "admin@gmail.com", role: "Admin" },
  ];

  function renderTable() {
    userTable.innerHTML = "";
    userData.forEach((user, index) => {
      userTable.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td><span class="badge ${
                      user.role === "Admin" ? "bg-danger" : "bg-secondary"
                    }">${user.role}</span></td>
                    <td>
                        ${
                          user.role === "User"
                            ? `<button class="btn btn-success btn-sm promote-btn" data-id="${user.id}"><i class="fa-solid fa-user-shield"></i></button>`
                            : ""
                        }
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${
                          user.id
                        }"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            `;
    });

    // Thêm sự kiện xóa người dùng
    document.querySelectorAll(".delete-btn").forEach((btn) => {
      btn.addEventListener("click", function () {
        const id = parseInt(this.getAttribute("data-id"));
        userData = userData.filter((u) => u.id !== id);
        renderTable();
      });
    });

    // Thêm sự kiện cấp quyền Admin
    document.querySelectorAll(".promote-btn").forEach((btn) => {
      btn.addEventListener("click", function () {
        const id = parseInt(this.getAttribute("data-id"));
        userData = userData.map((user) =>
          user.id === id ? { ...user, role: "Admin" } : user
        );
        renderTable();
      });
    });
  }

  // Hiển thị danh sách người dùng ban đầu
  renderTable();
});
