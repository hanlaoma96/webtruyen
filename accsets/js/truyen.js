document.addEventListener("DOMContentLoaded", function () {
  // Lấy dữ liệu từ URL (ví dụ: truyen.html?title=truyen1)
  const urlParams = new URLSearchParams(window.location.search);
  const title = urlParams.get("title") || "Truyện Không Tồn Tại";

  // Dữ liệu truyện mẫu (có thể thay bằng API hoặc MySQL)
  const truyenData = {
    truyen1: {
      title: "Phàm Nhân Tu Tiên",
      img: "./accsets/img/truyen (3).webp",
      author: "Vong Ngữ",
      category: "Huyền Huyễn",
      views: "1,200,000",
      desc: "Câu chuyện về một phàm nhân cố gắng tu tiên giữa thế giới đầy rẫy nguy hiểm.",
      chapters: [
        { name: "Chương 1: Nhập môn tu tiên", link: "chapter.html?ch=1" },
        { name: "Chương 2: Luyện đan thuật", link: "chapter.html?ch=2" },
        { name: "Chương 3: Đột phá Trúc Cơ", link: "chapter.html?ch=3" },
      ],
    },
  };

  // Hiển thị dữ liệu truyện nếu có
  if (truyenData[title]) {
    const truyen = truyenData[title];
    document.getElementById("truyen-title").innerText = truyen.title;
    document.getElementById("truyen-img").src = truyen.img;
    document.getElementById("truyen-author").innerText = truyen.author;
    document.getElementById("truyen-category").innerText = truyen.category;
    document.getElementById("truyen-views").innerText = truyen.views;
    document.getElementById("truyen-desc").innerText = truyen.desc;

    // Hiển thị danh sách chương
    const chapterList = document.getElementById("chapter-list");
    truyen.chapters.forEach((chap) => {
      const li = document.createElement("li");
      li.className = "list-group-item";
      li.innerHTML = `<a href="${chap.link}">${chap.name}</a>`;
      chapterList.appendChild(li);
    });
  } else {
    document.getElementById("truyen-title").innerText = "Truyện Không Tồn Tại";
    document.getElementById("truyen-desc").innerText =
      "Truyện này không có dữ liệu.";
  }
});
