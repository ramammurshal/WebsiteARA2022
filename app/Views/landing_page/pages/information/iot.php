<?= $this->extend('landing_page/template/default') ?>

<?= $this->section('custom-css') ?>
<link rel="stylesheet" href="<?= base_url() ?>/css/landing_page/pages/information/detail-event.css">
<?= $this->endSection('') ?>

<?= $this->section('content') ?>
<section class="container row align-items-center mx-auto position-relatve">
    <div class="col-md-6">
        <h1>Internet of Things (IOT)</h1>
        <p class="mt-4">Kompetisi ide inovatif dalam rangkaian acara ARA 2022 menggunakan mekanisme yang hampir serupa dengan Lomba Karya Tulis Ilmiah. Peserta diharapkan dapat menuangkan idenya dalam bentuk karya tulis ilmiah dengan topik utama Internet of Things. Kompetisi ide inovatif IoT ditujukan bagi mahasiswa aktif PTN/PTS se Indonesia.</p>
        <a href="https://drive.google.com/file/d/1fC6lsxBzS4j9fleYrDf_yQrqqtD3ScG_/view?usp=sharing" target="_blank" class="btn btn-primary px-4 py-3 mt-4 me-4 rounded-pill">Download Guide Book</a>
        <a href="<?= base_url() ?>/auth/registrasi_kti" class="btn btn-primary px-4 py-3 mt-4 rounded-pill">Daftar IOT</a>
    </div>
    <div class="col-md-6">
        <img src="<?= base_url() ?>/images/nambang-wifi.svg" alt="" class="ms-auto">
    </div>
</section>
<section>
    <div class="timeline">
        <div class="event kiri">
            <div data-aos="fade-right" class="isi-event">
                <p class="fw-bold">Pendaftaran</p>
                <p>Melalui Web ARA</p>
                <p>1 Maret 2022 - 31 Maret 2022</p>
            </div>
        </div>
        <div class="event kanan mt-5">
            <div data-aos="fade-left" class="isi-event">
                <p class="fw-bold">Pengumpulan Abstrak (Babak 1)</p>
                <p>Melalui Web ARA</p>
                <p>1 Maret 2022 - 31 Maret 2022</p>
            </div>
        </div>

        <div class="event kiri">
            <div data-aos="fade-right" class="isi-event">
                <p class="fw-bold">Seleksi Babak 1</p>
                <p>Dilaksanakan oleh panitia</p>
                <p>31 Maret 2022 - 2 April 2022</p>
            </div>
        </div>
        <div class="event kanan mt-5">
            <div data-aos="fade-left" class="isi-event">
                <p class="fw-bold">Pengumuman Lolos Babak 2</p>
                <p>Melalui Web dan Sosial Media ARA 2022</p>
                <p>2 April 2022</p>
            </div>
        </div>

        <div class="event kiri">
            <div data-aos="fade-right" class="isi-event">
                <p class="fw-bold">Pembayaran Babak 2</p>
                <p>2 April 2022 - 29 April 2022</p>
            </div>
        </div>
        <div class="event kanan mt-5">
            <div data-aos="fade-left" class="isi-event">
                <p class="fw-bold">Pengumpulan KTI (Babak 2)</p>
                <p>Melalui Web ARA</p>
                <p>2 April 2022 - 30 April 2022</p>
            </div>
        </div>

        <div class="event kiri">
            <div data-aos="fade-right" class="isi-event">
                <p class="fw-bold">Seleksi Babak 2</p>
                <p>Dilaksanakan oleh juri</p>
                <p>9 Mei 2022 - 14 Mei 2022</p>
            </div>
        </div>
        <div class="event kanan mt-5">
            <div data-aos="fade-left" class="isi-event">
                <p class="fw-bold">Pengumuman Finalis</p>
                <p>Melalui Web dan Sosial Media ARA 2022</p>
                <p>15 Mei 2022</p>
            </div>
        </div>

        <div class="event kiri">
            <div data-aos="fade-right" class="isi-event">
                <p class="fw-bold">Pembayaran Babak Final</p>
                <p>15 Mei 2022 - 20 Mei 2022</p>
            </div>
        </div>
        <div class="event kanan mt-5">
            <div data-aos="fade-left" class="isi-event">
                <p class="fw-bold">Technical Meeting Babak Final</p>
                <p>18 Mei 2022</p>
            </div>
        </div>

        <div class="event kiri">
            <div data-aos="fade-right" class="isi-event">
                <p class="fw-bold">Babak Final</p>
                <p>Dilakukan secara online</p>
                <p>21 Mei 2022</p>
            </div>
        </div>
        <div class="event kanan mt-5">
            <div data-aos="fade-left" class="isi-event">
                <p class="fw-bold">Pengumuman Pemenang</p>
                <p>Melalui Web dan Sosial Media ARA 2022</p>
            </div>
        </div>

    </div>
</section>

<?= $this->include('landing_page/component/HMIT-card') ?>

<?= $this->include("landing_page/component/sponsor"); ?>

<?= $this->endSection('') ?>