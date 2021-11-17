<!--
*** Thanks for checking out the Best-README-Template. If you have a suggestion
*** that would make this better, please fork the repo and create a pull request
*** or simply open an issue with the tag "enhancement".
*** Thanks again! Now go create something AMAZING! :D
-->



<!-- PROJECT SHIELDS -->
<!--
*** I'm using markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->
[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]



<!-- PROJECT LOGO -->
<br />
<p align="center">
  <a href="https://github.com/godgodwinter/README-TEMPLATE-laravel">
    <img src="images/logo.png" alt="Logo" width="80" height="80">
  </a>

  <h3 align="center">Sistem Treatment PreAlpha 1.0.21.11.16</h3>

  <p align="center">
   Sistem Treatment Klinik kecantikan Scincare
    <br />
    <a href="https://github.com/godgodwinter/laravel-treatment"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="https://treatment.baemon.web.id/">View Demo</a>
    ·
    <a href="https://twitter.com/kakadlz">Report Bug</a>
    ·
    <a href="https://twitter.com/kakadlz">Request Feature</a>
  </p>
</p>



<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

[![Product Name Screen Shot][product-screenshot-ss0]](https://github.com/godgodwinter/laravel-treatment)
[![Product Name Screen Shot][product-screenshot-ss2]](https://github.com/godgodwinter/laravel-treatment)
[![Product Name Screen Shot][product-screenshot-ss3]](https://github.com/godgodwinter/laravel-treatment)
[![Product Name Screen Shot][product-screenshot-ss4]](https://github.com/godgodwinter/laravel-treatment)
[![Product Name Screen Shot][product-screenshot-ss1]](https://github.com/godgodwinter/laravel-treatment)
<!-- [![Product Name Screen Shot][product-classdiagram1]](https://github.com/godgodwinter/laravel-treatment) -->

Sistem Treatment Klinik kecantikan Scincare

### Built With

This section should list any major frameworks that you built your project using. Leave any add-ons/plugins for the acknowledgements section. Here are a few examples.
<!-- * [Bootstrap](https://getbootstrap.com) -->
<!-- * [JQuery](https://jquery.com) -->
Tools and Framework
* [Laravel 8](https://laravel.com)
* [PHP 7.4+](https://php.net)
* [gitbash](https://git-scm.com/downloads)
* [composer](https://getcomposer.org/)


Alternatif (tidak perlu diinstall)
* [docker](https://www.docker.com/)
* [Nodejs](https://node.js)

Library/Plugin
* [Auth:Fortify](#)
* [Auth:Jetstream](#)
* [Bootstrap 4](https://getbootstrap.com/docs/4.0/getting-started/introduction/)
* [Stisla](https://github.com/stisla/stisla)


Fitur Utama
* [Menejemen Data Produk dan Treatment](#)
* [Menejemen Dokter](#)
* [Menejemen Member dan Penjadwalan Perawatan](#)
* [Pengingat SMS gateway](#)


Docker
* [mysql dan settings database](#)
* [phpmyadmin](#)


<!-- GETTING STARTED -->
## Getting Started

Siapkan terlebih dahulu peralatan perangnya.

<!-- ### Prerequisites

This is an example of how to list things you need to use the software and how to install them.
* npm
  ```sh
  npm install npm@latest -g
  ``` -->

### Installation

<!-- 1. Get a free API Key at [https://example.com](https://example.com) -->
1. Clone the repo
   ```sh
   git clone https://github.com/godgodwinter/laravel-treatment.git
   ```
2. Install menggunakan composer
   ```sh
   composer install
   ```
3. Buat file .env atau copy dan edit file .env_copy kemudian sesuaikan dengan database anda
   ```sh
   cp .env_example .env 
   ```
   Gunakan editor kesukaan anda. Jika mengedit menggunakan nano lakukan langkah berikut:

   ```sh
   nano .env //ubah database user dan password database di perangkat anda
   ```

4. jalankan server Laravel
   ```sh
   php artisan serve
   ```
5. lakukan migrasi database
   ```sh
   php artisan migrate
   ```
   atau migrate:fresh jika ingin dari data kosong
   ```sh
   php artisan migrate:fresh
   ```
6. Jika ingin menggunakan data palsu untuk testing lanjutkan langkah 6 ini
   ```sh
   php artisan db:seed --class=oneseeder  //untuk meload data user admin@gmail.com pass 12345678
   ```
   

   

Buka browser dan tulis alamat berikut
   
   ```sh
   http://127.0.0.1:8000/
   ```



### Docker Installation

<!-- 1. Get a free API Key at [https://example.com](https://example.com) -->
1. Compose
   ```sh
   docker-compose up
   ```
2. ctrl+c kemudian jalankan container dengan cara berikut :
   ```sh
   docker-compose start
   ```
3. Akses projek dengan link port :3000
   ```sh
   http://127.0.0.1:3000/
   ```

4. Akses phpmyadmin dengan port :8081
   ```sh
   http://127.0.0.1:8081/
   ```
5. Untuk menggunakan artisan dapat menggunakan perintah berikut : 
   ```sh
   docker-compose exec baemon-treatment php artisan db:seed
   ```
   atau migrate:fresh jika ingin dari data kosong
   ```sh
   docker-compose exec baemon-treatment php artisan list
   ```


<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE` for more information.



<!-- CONTACT -->
## Contact

Kukuh Setya Nugraha - [@kakadlz](https://twitter.com/kakadlz) 
Kukuh Setya Nugraha - [@kukuh.sn](https://www.instagram.com/kukuh.sn/) 

Project Link: [https://github.com/godgodwinter/laravel-treatment](https://github.com/godgodwinter/laravel-treatment)






<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/godgodwinter/laravel-treatment.svg?style=for-the-badge
[contributors-url]: https://github.com/godgodwinter/laravel-treatment/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/godgodwinter/laravel-treatment.svg?style=for-the-badge
[forks-url]: https://github.com/godgodwinter/laravel-treatment/network/members
[stars-shield]: https://img.shields.io/github/stars/godgodwinter/laravel-treatment.svg?style=for-the-badge
[stars-url]: https://github.com/godgodwinter/laravel-treatment/stargazers
[issues-shield]: https://img.shields.io/github/issues/godgodwinter/laravel-treatment.svg?style=for-the-badge
[issues-url]: https://github.com/godgodwinter/laravel-treatment/issues
[license-shield]: https://img.shields.io/github/license/godgodwinter/laravel-treatment.svg?style=for-the-badge
[license-url]: https://github.com/godgodwinter/laravel-treatment/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://www.instagram.com/kukuh.sn/
[product-screenshot-ss0]: images/landing_index.png
[product-screenshot-ss1]: images/chating.png
[product-screenshot-ss2]: images/jawaltreadment.png
[product-screenshot-ss3]: images/reminder.png
[product-screenshot-ss4]: images/transaksicart.png
