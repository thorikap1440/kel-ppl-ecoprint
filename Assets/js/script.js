const navbar = document.getElementsByTagName("nav")[0];
window.addEventListener("scroll", function () {
  console.log(window.scrollY);
  if (window.scrollY > 1) {
    navbar.classList.add("nav-color", "shadow-sm");
  } else if (this.window.scrollY <= 0) {
    navbar.classList.replace("shadow-sm", "nav-color");
  }
});

// Fungsi untuk pindah halaman pada select option kategori
function changePage() {
  var selectedValue = document.getElementById("pageSelect").value;

  // Mengarahkan ke halaman yang dipilih
  if (selectedValue) {
    window.location.href = selectedValue + ".html";
  }
}

// Fungsi menu navbar aktif sesuai dengan yang diklik
function setActive(page) {
  // Menghapus kelas 'active' dari semua elemen navbar
  var navItems = document.querySelectorAll(".nav-item");
  navItems.forEach(function (item) {
    item.classList.remove("active");
  });

  // Menambahkan kelas 'active' ke elemen yang diklik
  var activeItem = document.querySelector(
    ".nav-link[onclick=\"setActive('" + page + "')\"]"
  );
  activeItem.parentNode.classList.add("active");
  // Mengarahkan ke halaman terkait
  window.location.href = activeItem.getAttribute("href");
}

// Fungsi Baca Selengkapknya
// document.addEventListener("DOMContentLoaded", function () {
//   var cards = document.querySelectorAll(".card");
//   var showMoreBtn = document.getElementById("showMoreBtn");
//   var currentIndex = 5; // Menunjukkan card yang ditampilkan hingga saat ini

//   // Menampilkan lima card pertama secara default
//   for (var i = 0; i < 5; i++) {
//     cards[i].style.display = "block";
//   }

//   showMoreBtn.addEventListener("click", function () {
//     // Menampilkan lima card berikutnya ketika tombol diklik
//     for (var i = currentIndex; i < currentIndex + 5 && i < cards.length; i++) {
//       cards[i].style.display = "block";
//     }

//     // Memperbarui indeks saat ini
//     currentIndex += 5;

//     // Menyembunyikan tombol jika semua card sudah ditampilkan
//     if (currentIndex >= cards.length) {
//       showMoreBtn.style.display = "none";
//     }
//   });

//   // Menyembunyikan tombol jika semua card sudah ditampilkan saat halaman dimuat
//   if (currentIndex >= cards.length) {
//     showMoreBtn.style.display = "none";
//   }
// });

// BAGIAN BUTTON ACKTIVE SEMUA KATEGORI
function toggleCategory(category) {
  // Mendapatkan semua elemen <a> di dalam #categoryMenu
  var categoryLinks = document.querySelectorAll(
    "#categoryMenu .card-sub-kategori"
  );

  // Menghapus class "active" dari semua elemen <a>
  categoryLinks.forEach(function (link) {
    link.classList.remove("active");
  });

  // Menambahkan class "active" pada elemen yang diklik
  event.target.classList.add("active");
}

// PAGINATION CARD PRODUK PADA HALAMAN KATEGORI
document.addEventListener("DOMContentLoaded", function () {
  var cards = document.querySelectorAll(".card-produk-kategori");
  var paginationList = document.getElementById("paginationList");
  var prevPageBtn = document.getElementById("prevPageBtn");
  var nextPageBtn = document.getElementById("nextPageBtn");
  var cardsPerPage = 6; // Ubah sesuai dengan jumlah card yang ingin ditampilkan per halaman
  var totalPages = Math.ceil(cards.length / cardsPerPage);
  var currentPage = 1;

  function showPage(pageNumber) {
    // Sembunyikan semua Card
    cards.forEach(function (card) {
      card.style.display = "none";
    });

    // Hitung indeks awal dan akhir untuk halaman saat ini
    var startIndex = (pageNumber - 1) * cardsPerPage;
    var endIndex = startIndex + cardsPerPage;

    // Tampilkan card untuk halaman saat ini
    for (var i = startIndex; i < endIndex && i < cards.length; i++) {
      cards[i].style.display = "block";
    }
  }

  // Fungsi Pagination Number
  function createPaginationButtons() {
    for (var i = 1; i <= totalPages; i++) {
      var li = document.createElement("li");
      li.classList.add("page-item");
      li.innerText = i;
      li.addEventListener("click", function () {
        var pageNumber = parseInt(this.innerText);
        showPage(pageNumber);
        currentPage = pageNumber;
        updateActivePaginationButton(pageNumber);
      });
      paginationList.insertBefore(li, nextPageBtn);
    }
  }

  function updateActivePaginationButton(activePage) {
    var paginationButtons = document.querySelectorAll("#paginationList li");
    paginationButtons.forEach(function (button) {
      button.classList.remove("active");
      if (parseInt(button.innerText) === activePage) {
        button.classList.add("active");
      }
    });

    // Nonaktifkan atau aktifkan tombol sebelumnya dan berikutnya berdasarkan halaman saat ini
    prevPageBtn.classList.toggle("disabled", currentPage === 1);
    nextPageBtn.classList.toggle("disabled", currentPage === totalPages);
  }

  function showPreviousPage() {
    if (currentPage > 1) {
      showPage(currentPage - 1);
      currentPage--;
      updateActivePaginationButton(currentPage);
    }
  }

  function showNextPage() {
    if (currentPage < totalPages) {
      showPage(currentPage + 1);
      currentPage++;
      updateActivePaginationButton(currentPage);
    }
  }

  // Batasi kartu yang ditampilkan di halaman pertama
  showPage(1);

  // Buat tombol pagination
  createPaginationButtons();

  // Highlight penomoran halaman pertama sebagai aktif
  updateActivePaginationButton(1);

  // event listeners untuk tombol sebelumnya dan berikutnya
  prevPageBtn.addEventListener("click", showPreviousPage);
  nextPageBtn.addEventListener("click", showNextPage);
});
