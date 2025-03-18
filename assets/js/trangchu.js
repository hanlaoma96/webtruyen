document.addEventListener("DOMContentLoaded", function () {
  // Add search functionality
  var searchForm = document.querySelector("form.d-flex");
  searchForm.addEventListener("submit", function (event) {
    event.preventDefault();
    var query = searchForm.querySelector('input[type="search"]').value;
    alert("Tìm kiếm: " + query);
  });

  // Enable touch scrolling for "Truyện Đề Cử"
  var truyenDeCu = document.querySelector(".truyen-de-cu");
  var isDown = false;
  var startX;
  var scrollLeft;

  truyenDeCu.addEventListener("mousedown", (e) => {
    isDown = true;
    truyenDeCu.classList.add("active");
    startX = e.pageX - truyenDeCu.offsetLeft;
    scrollLeft = truyenDeCu.scrollLeft;
  });

  truyenDeCu.addEventListener("mouseleave", () => {
    isDown = false;
    truyenDeCu.classList.remove("active");
  });

  truyenDeCu.addEventListener("mouseup", () => {
    isDown = false;
    truyenDeCu.classList.remove("active");
  });

  truyenDeCu.addEventListener("mousemove", (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - truyenDeCu.offsetLeft;
    const walk = (x - startX) * 3; //scroll-fast
    truyenDeCu.scrollLeft = scrollLeft - walk;
  });
});
