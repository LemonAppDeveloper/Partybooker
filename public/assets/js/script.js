/*edit profile dropdown*/
$(document).ready(function () {
  $('.js-edit, .js-save').on('click', function () {
    var $form = $(this).closest('form');
    $form.toggleClass('is-readonly is-editing');
    var isReadonly = $form.hasClass('is-readonly');
    $form.find('input,textarea').prop('disabled', isReadonly);
  });
});

$(".clearname").click(function () {
  $(".cname").val("");
});
$(".clearemail").click(function () {
  $(".cemail").val("");
});
$(".clearpassword").click(function () {
  $(".cpassword").val("");
});


$().ready(function () {
  if ($('.slick-carousel').length > 0) {
    $('.slick-carousel').slick({
      arrows: false,
      centerPadding: "0px",
      dots: false,
      infinite: true,
      slidesToShow: 5,
      centerMode: true,
      responsive: [
        {
          breakpoint: 1440,
          settings: {
            slidesToShow: 5,
          }
        },
        {
          breakpoint: 1367,
          settings: {
            slidesToShow: 4,
          }
        },
        {
          breakpoint: 769,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 540,
          settings: {
            slidesToShow: 2,
          }
        }
      ]
    });
  }
});


if ($('#showPassword').length > 0) {
  var password = document.getElementById('showPassword');
  var toggler = document.getElementById('toggler');

  showHidePassword = () => {
    if (password.type == 'password') {
      password.setAttribute('type', 'text');
      toggler.classList.add('la-eye-slash');
    } else {
      toggler.classList.remove('la-eye-slash');
      password.setAttribute('type', 'password');
    }
  };

  toggler.addEventListener('click', showHidePassword);
}

if ($('#showPassword1').length > 0) {
  var password1 = document.getElementById('showPassword1');
  var toggler1 = document.getElementById('toggler1');

  showHidePassword = () => {
    if (password1.type == 'password') {
      password1.setAttribute('type', 'text');
      toggler1.classList.add('la-eye-slash');
    } else {
      toggler1.classList.remove('la-eye-slash');
      password1.setAttribute('type', 'password');
    }
  };

  toggler1.addEventListener('click', showHidePassword);
}