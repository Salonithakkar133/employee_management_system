<!-- JS Scripts -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/plugins/simplebar.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/plugins/popper.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/icon/custom-icon.js"></script>
<script src="<?= BASE_URL ?>/assets/js/plugins/feather.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/component.js"></script>
<script src="<?= BASE_URL ?>/assets/js/theme.js"></script>
<script src="<?= BASE_URL ?>/assets/js/script.js"></script>
<script src="<?= BASE_URL ?>/assets/js/plugins/wow.min.js"></script>

<script>
  // Scroll-based navbar effects
  let ost = 0;
  document.addEventListener('scroll', function () {
    let cOst = document.documentElement.scrollTop;
    const navbar = document.querySelector('.navbar');
    if (!navbar) return;

    if (cOst === 0) {
      navbar.classList.add('!bg-transparent');
    } else if (cOst > ost) {
      navbar.classList.add('top-nav-collapse');
      navbar.classList.remove('default', '!bg-transparent');
    } else {
      navbar.classList.add('default');
      navbar.classList.remove('top-nav-collapse', '!bg-transparent');
    }
    ost = cOst;
  });

  // Initialize WOW animations
  var wow = new WOW({
    animateClass: 'animate__animated'
  });
  wow.init();
</script>

</body>
</html>
