document.addEventListener("DOMContentLoaded", function () {
  // Lấy thông tin chương từ URL (vd: chapter.html?ch=1)
  const urlParams = new URLSearchParams(window.location.search);
  const chapterNumber = urlParams.get("ch") || 1;

  // Dữ liệu chương truyện mẫu (thay thế bằng API hoặc MySQL nếu cần)
  const storyData = {
    title: "Phàm Nhân Tu Tiên",
    chapters: {
      1: {
        title: "Chương 1: Nhập môn tu tiên",
        content: "Nội dung chương 1...",
      },
      2: {
        title: "Chương 2: Luyện đan thuật",
        content: "Nội dung chương 2...",
      },
      3: {
        title: "Chương 3: Đột phá Trúc Cơ",
        content: "Nội dung chương 3...",
      },
    },
  };

  // Cập nhật tiêu đề & nội dung chương
  const chapterData = storyData.chapters[chapterNumber] || {
    title: "Chương không tồn tại",
    content: "Không tìm thấy nội dung chương này.",
  };
  document.getElementById("chapter-title").innerText = chapterData.title;
  document.getElementById("story-title").innerText = storyData.title;
  document.getElementById(
    "story-title"
  ).href = `truyen.html?title=${storyData.title}`;
  document.getElementById("chapter-content").innerText = chapterData.content;

  // Điều hướng chương trước / chương sau
  const prevChapter = document.getElementById("prev-chapter");
  const nextChapter = document.getElementById("next-chapter");

  if (storyData.chapters[chapterNumber - 1]) {
    prevChapter.href = `chapter.html?ch=${chapterNumber - 1}`;
    prevChapter.style.display = "inline-block";
  } else {
    prevChapter.style.display = "none";
  }

  if (storyData.chapters[parseInt(chapterNumber) + 1]) {
    nextChapter.href = `chapter.html?ch=${parseInt(chapterNumber) + 1}`;
    nextChapter.style.display = "inline-block";
  } else {
    nextChapter.style.display = "none";
  }

  // Hiển thị danh sách chương
  const chapterList = document.getElementById("chapter-list");
  for (let ch in storyData.chapters) {
    const li = document.createElement("li");
    li.className = "list-group-item";
    li.innerHTML = `<a href="chapter.html?ch=${ch}">${storyData.chapters[ch].title}</a>`;
    chapterList.appendChild(li);
  }
});
