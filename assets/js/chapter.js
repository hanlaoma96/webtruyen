document.addEventListener("DOMContentLoaded", function () {
  // Lấy thông tin chương từ URL (vd: chapter.html?ch=1)
  const urlParams = new URLSearchParams(window.location.search);
  const chapterNumber = urlParams.get("ch") || 1;

  // Hàm lấy dữ liệu chương từ API
  async function fetchChapterData(chapterNumber) {
    try {
      const response = await fetch(
        `https://nettruyenx.com/api/chapters/${chapterNumber}`
      );
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error("Fetch error: ", error);
      return {
        title: "Chương không tồn tại",
        content: "Không tìm thấy nội dung chương này.",
      };
    }
  }

  // Hàm cập nhật giao diện với dữ liệu chương
  async function updateChapterContent(chapterNumber) {
    const chapterData = await fetchChapterData(chapterNumber);
    document.getElementById("chapter-title").innerText = chapterData.title;
    document.getElementById("story-title").innerText = chapterData.storyTitle;
    document.getElementById(
      "story-title"
    ).href = `truyen.html?title=${chapterData.storyTitle}`;
    document.getElementById("chapter-content").innerText = chapterData.content;

    // Điều hướng chương trước / chương sau
    const prevChapter = document.getElementById("prev-chapter");
    const nextChapter = document.getElementById("next-chapter");

    if (chapterData.prevChapter) {
      prevChapter.href = `chapter.html?ch=${chapterData.prevChapter}`;
      prevChapter.style.display = "inline-block";
    } else {
      prevChapter.style.display = "none";
    }

    if (chapterData.nextChapter) {
      nextChapter.href = `chapter.html?ch=${chapterData.nextChapter}`;
      nextChapter.style.display = "inline-block";
    } else {
      nextChapter.style.display = "none";
    }

    // Hiển thị danh sách chương
    const chapterList = document.getElementById("chapter-list");
    chapterList.innerHTML = ""; // Xóa danh sách cũ
    chapterData.chapterList.forEach((ch) => {
      const li = document.createElement("li");
      li.className = "list-group-item";
      li.innerHTML = `<a href="chapter.html?ch=${ch.number}">${ch.title}</a>`;
      chapterList.appendChild(li);
    });
  }

  // Cập nhật nội dung chương khi tải trang
  updateChapterContent(chapterNumber);
});
