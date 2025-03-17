<div x-data="{ isScrolled: false }" 
     x-init="window.addEventListener('scroll', () => isScrolled = window.pageYOffset > 20)">
  <header 
    x-bind:class="isScrolled ? 'bg-white shadow-md' : 'bg-transparent'"
    class="fixed w-full z-20 transition-all duration-300"
  >
    <div class="container mx-auto py-4 px-4">

    </div><!-- Close container -->
  </header>
</div><!-- Close outer x-data -->
