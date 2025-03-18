document.addEventListener("DOMContentLoaded", function () {
  const userTable = document.getElementById("user-table");

  function fetchUsers() {
    fetch("../backend/api/get_users.php")
      .then((response) => response.json())
      .then((data) => {
        renderTable(data);
      });
  }

  function renderTable(users) {
    userTable.innerHTML = "";
    users.forEach((user, index) => {
      userTable.innerHTML += `
        <tr>
          <td>${index + 1}</td>
          <td>${user.username}</td>
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

    // Add event listeners to delete buttons
    document.querySelectorAll(".delete-btn").forEach((btn) => {
      btn.addEventListener("click", function () {
        const id = this.getAttribute("data-id");
        fetch(`../backend/api/delete_user.php?id=${id}`, {
          method: "DELETE",
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              fetchUsers();
            } else {
              alert("Xóa người dùng thất bại");
            }
          });
      });
    });

    // Add event listeners to promote buttons
    document.querySelectorAll(".promote-btn").forEach((btn) => {
      btn.addEventListener("click", function () {
        const id = this.getAttribute("data-id");
        fetch(`../backend/api/promote_user.php?id=${id}`, {
          method: "POST",
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              fetchUsers();
            } else {
              alert("Cấp quyền Admin thất bại");
            }
          });
      });
    });
  }

  // Fetch and display users on page load
  fetchUsers();
});
