// $(document).ready(function() {
//     $('.aplay_code').load('komponen/code_other.html', function() {
//     adjustElementSize();
//     });
// });

// sidebar
// $(document).ready(function () {
//   $("#sec_sidebar").load("komponen/side_nav.html", function () {
//     $("#sec_sidebar").on("click", ".list_subdata", function (event) {
//       event.preventDefault();
//       $(".list_subdata").not(this).removeClass("active");
//       $(this).toggleClass("active");
//     });

//     $("#sec_sidebar").on("input", "#searchTabel", function () {
//       var searchText = $(this).val().toLowerCase();
//       $(".nav_title1, .sub_title1").each(function () {
//         var titleText = $(this).text().toLowerCase();
//         var $parentData = $(this).closest(".data_sidejsx");
//         var $parentSubData = $(this).closest(".sub_data_sidejsx");

//         if (searchText === "") {
//           $(this).show();
//           $parentData.show();
//           $parentSubData.hide();
//           $parentData.removeClass("active");
//           $parentSubData.removeClass("active");
//         } else if (
//           titleText.includes(searchText) ||
//           $parentSubData
//             .find(".sub_title1")
//             .text()
//             .toLowerCase()
//             .includes(searchText)
//         ) {
//           $(this).show();
//           $parentData.show();
//           $parentSubData.show();
//           $parentData.addClass("active");
//           $parentSubData.addClass("active");
//         } else {
//           $(this).hide();
//           $parentData.hide();
//           $parentSubData.hide();
//           $parentData.removeClass("active");
//           $parentSubData.removeClass("active");
//         }
//       });
//     });
//   });
// });

// top navbar
$(document).ready(function () {
  //   $(".sec_top_navbar").load("komponen/top_nav.html");
  $(document).on("click", ".profile_nav", function () {
    $(".list_menu_profile").slideToggle("fast");
  });
  $(document).on("click", function (event) {
    if (!$(event.target).closest(".list_menu_profile, .profile_nav").length) {
      $(".list_menu_profile").slideUp("fast");
    }
  });
});

// dashboard
// $(document).ready(function () {
//   $(".aplay_code").load("komponen/dashboard.html");
// });

// component
$(document).on("click", "#codeDashboardLink", function (event) {
  event.preventDefault();
  $(".aplay_code").load("komponen/dashboard.html", function () {
    adjustElementSize();
    localStorage.setItem("lastPage", "komponen/dashboard.html");
  });
});

$(document).on("click", "#codeBoxLink", function (event) {
  event.preventDefault();
  $(".aplay_code").load("komponen/code_box.html", function () {
    adjustElementSize();
    localStorage.setItem("lastPage", "komponen/code_box.html");
  });
});

$(document).on("click", "#codeTableLink", function (event) {
  event.preventDefault();
  $(".aplay_code").load("komponen/code_table.html", function () {
    adjustElementSize();
    localStorage.setItem("lastPage", "komponen/code_table.html");
  });
});

$(document).on("click", "#codeFormLink", function (event) {
  event.preventDefault();
  $(".aplay_code").load("komponen/code_form.html", function () {
    adjustElementSize();
    localStorage.setItem("lastPage", "komponen/code_form.html");
  });
});

$(document).on("click", "#codeModalLink", function (event) {
  event.preventDefault();
  $(".aplay_code").load("komponen/code_modal.html", function () {
    adjustElementSize();
    localStorage.setItem("lastPage", "komponen/code_modal.html");
  });
});

$(document).on("click", "#codeButtonLink", function (event) {
  event.preventDefault();
  $(".aplay_code").load("komponen/code_button.html", function () {
    adjustElementSize();
    localStorage.setItem("lastPage", "komponen/code_button.html");
  });
});

$(document).on("click", "#codeCardLink", function (event) {
  event.preventDefault();
  $(".aplay_code").load("komponen/code_card.html", function () {
    adjustElementSize();
    localStorage.setItem("lastPage", "komponen/code_card.html");
  });
});

$(document).on("click", "#codeOtherLink", function (event) {
  event.preventDefault();
  $(".aplay_code").load("komponen/code_other.html", function () {
    adjustElementSize();
    localStorage.setItem("lastPage", "komponen/code_other.html");
  });
});
