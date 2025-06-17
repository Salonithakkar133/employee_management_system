<?php include_once(__DIR__ . '/../../../config/config.php'); ?>

 <header id="home" class="flex items-center flex-col justify-center overflow-hidden relative pt-[100px] sm:pt-[180px] pb-0 bg-theme-sidebarbg dark:bg-dark-500">
    <!-- [ Nav ] start -->
    <nav
      class="navbar group bg-theme-sidebarbg dark:bg-themedark-cardbg fixed top-0 z-50 w-full backdrop-blur shadow-[0_0_24px_rgba(27,46,94,.05)] dark:shadow-[0_0_24px_rgba(27,46,94,.05)] !bg-transparent">
      <div class="container">
        <div class="static flex py-4 items-center justify-between sm:relative">
          <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-between">
            <div class="flex flex-shrink-0 items-center justify-between">
              <a href="#">
                <img class="w-[130px]" src="assets/images/logo-white.svg" alt="Your Company" />
              </a>
            </div>
            <div class="grow">
              <div class="justify-end flex flex-row space-x-2 p-0 me-3">
                <a href="dashboard/index.html" target="_blank"
                  class="hidden sm:inline-block text-white/60 hover:text-white rounded-md px-3 py-2 text-base font-medium transition-all">Live
                  Preview</a>
                <a href="#" type="button" target="_blank"
                  class="flex sm:hidden items-center justify-center bg-gray-200 text-gray-900 hover:bg-gray-900 hover:text-white focus:ring-white focus:ring-offset-gray-800 h-10 w-10 rounded-full p-1 focus:outline-none focus:ring-2 focus:ring-offset-2">
                  <i class="ti ti-file-text"></i>
                </a>
                <a href="dashboard/index.html" type="button" target="_blank"
                  class="flex sm:hidden items-center justify-center bg-gray-200 text-gray-900 hover:bg-gray-900 hover:text-white focus:ring-white focus:ring-offset-gray-800 h-10 w-10 rounded-full p-1 focus:outline-none focus:ring-2 focus:ring-offset-2">
                  <i class="ti ti-dashboard"></i>
                </a>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </nav>
    <!-- [ Nav ] end -->
    <div class="container relative z-10">
      <div class="w-full md:w-10/12 text-center mx-auto">
        <h1 class="text-white text-[22px] md:text-[36px] lg:text-[48px] leading-[1.2] mb-5 wow animate__fadeInUp"
          data-wow-delay="0.2s">
          Explore One of the
          <span
            class="text-transparent font-semibold bg-clip-text bg-gradient-to-r from-[rgb(37,161,244)] via-[rgb(249,31,169)] to-[rgb(37,161,244)] bg-[length:400%_100%] bg-left-top animate-[move-bg_24s_infinite_linear]">Featured
            Dashboard</span>
          Template in CodedThemes
        </h1>
        <div class="wow animate__fadeInUp" data-wow-delay="0.3s">
          <div class="sm:w-8/12 mx-auto">
            <p class="text-white/80 text-[14px] sm:text-[16px] mb-0">
              Datta able is the one of the Featured admin dashboard template in CodedThemes, with over 25K+ global users across various technologies.
            </p>
          </div>
        </div>
        <div class="my-5 sm:my-12 wow animate__fadeInUp" data-wow-delay="0.4s">
          <a href="dashboard/index.html"
            class="btn rounded-full border border-white bg-white text-dark-500 hover:opacity-70 active:opacity-70 focus:opacity-70 mr-2 mt-1">Live
            Preview</a>
        </div>
        <div class="mt8 sm:mt-10 wow animate__fadeInUp" data-wow-delay="1s">
          <img src="assets/images/landing/img-header-main.jpg" alt="images"
            class="img-fluid img-header rounded-[14px_14px_0_0] border-4 border-white shadow-[0px_-6px_10px_0px_rgba(12,21,70,0.03)]" />
        </div>
      </div>
    </div>
    <img src="assets/images/landing/img-wave.svg" alt="images"
      class="img-wave absolute inset-x -bottom-px z-10 drop-shadow-[0px_-6px_10px_rgba(12,21,70,0.05)] dark:brightness-[0.1]" />
    <div class="absolute inset-0 bg-[linear-gradient(0deg,rgba(0,0,0,0.5019607843),transparent)] z-[1]"></div>
  </header>