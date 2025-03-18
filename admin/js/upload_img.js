document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("addTruyenForm");
  const titleInput = document.getElementById("title");
  const descriptionInput = document.getElementById("description");
  const authorInput = document.getElementById("author");
  const coverInput = document.getElementById("cover");
  const messageBox = document.getElementById("messageBox");

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const title = titleInput.value.trim();
    const description = descriptionInput.value.trim();
    const author = authorInput.value.trim();
    const file = coverInput.files[0];

    if (!title || !description || !author || !file) {
      showMessage("Vui lòng điền đầy đủ thông tin và chọn ảnh!", "error");
      return;
    }

    try {
      showMessage("Đang tải ảnh lên...", "info");
      const imageUrl = await uploadImage(file);

      showMessage("Đang thêm truyện...", "info");
      const result = await addTruyen(title, description, author, imageUrl);

      if (result.status === "success") {
        showMessage("Thêm truyện thành công!", "success");
        form.reset();
      } else {
        showMessage("Lỗi: " + result.message, "error");
      }
    } catch (error) {
      showMessage("Lỗi: " + error.message, "error");
    }
  });

  async function uploadImage(file) {
    let formData = new FormData();
    formData.append("anh_bia", file);

    let response = await fetch(
      "http://localhost:888/trangwebtutien/admin/apistory/upload_image.php",
      {
        method: "POST",
        body: formData,
      }
    );

    let result = await response.json();
    if (result.status === "success") {
      return result.image_url;
    } else {
      throw new Error(result.message);
    }
  }

  async function addTruyen(title, description, author, imageUrl) {
    let response = await fetch(
      "http://localhost:888/trangwebtutien/admin/apistory/add_truyen.php",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Authorization: "Bearer YOUR_TOKEN_HERE",
        },
        body: JSON.stringify({
          ten_truyen: title,
          mo_ta: description,
          tac_gia: author,
          anh_bia: imageUrl,
        }),
      }
    );

    return await response.json();
  }

  function showMessage(message, type) {
    messageBox.innerText = message;
    messageBox.className = `message ${type}`;
  }
});
