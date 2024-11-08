// Toggle Sidebar
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const nowPlaying = document.querySelector('.now-playing');
    const searchBar = document.querySelector('.search-bar'); // Asumsikan elemen pencarian memiliki kelas 'search-bar'
    const arrow = document.querySelector('.arrow'); // Asumsikan elemen arrow memiliki kelas 'arrow'
    const logo = document.querySelector('.logo');
    const iconTexts = document.querySelectorAll('.icon-text');
    const myMusicText = document.querySelector('.sidebar-down h3');

    sidebar.classList.toggle('expanded'); // Toggle kelas expanded

    if (sidebar.classList.contains('expanded')) {
        nowPlaying.style.width = 'calc(100% - 270px)'; // Lebar penuh dikurangi lebar sidebar yang melebar
        searchBar.style.width = 'calc (100% - 270px)'; // Pindahkan search bar ke kanan
        arrow.style.marginLeft = '240px'; // Pindahkan arrow ke kanan
        logo.style.width = '200px'; // Perbesar logo
        iconTexts.forEach(text => text.style.display = 'inline'); // Tampilkan teks keterangan
        myMusicText.style.display = 'block'; // Tampilkan "My Music"
    } else {
        nowPlaying.style.width = 'calc(100% - 120px)'; // Lebar penuh dikurangi lebar sidebar normal
        searchBar.style.width = '100%'; // Kembalikan search bar ke posisi semula
        arrow.style.marginLeft = '0'; // Kembalikan arrow ke posisi semula
        logo.style.width = '50px'; // Kembalikan ukuran logo ke semula
        iconTexts.forEach(text => text.style.display = 'none'); // Sembunyikan teks keterangan
        myMusicText.style.display = 'none'; // Sembunyikan "My Music"
    }

}

// Menandai tombol aktif berdasarkan halaman
function setActiveButton(buttonClass) {
    // Hapus kelas 'active' dari semua tombol
    document.querySelectorAll('.icon-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Tambah kelas 'active' pada tombol yang sesuai
    const activeButton = document.querySelector(`.${buttonClass}`);
    if (activeButton) {
        activeButton.classList.add('active');
    }
}

// Contoh penggunaan: Panggil fungsi ini saat halaman dimuat untuk halaman home
setActiveButton('home-btn'); // Ganti 'home-btn' sesuai dengan tombol halaman aktif

  // Fungsi untuk menampilkan nama file sampul
  function showFileNameSampul(input) {
    const fileNameSampul = input.files[0] ? input.files[0].name : "Tidak ada file dipilih";
    document.querySelector(".file-name-sampul").textContent = fileNameSampul;
}

// Fungsi untuk menampilkan nama file lagu
function showFileNameLagu(input) {
    const fileNameLagu = input.files[0] ? input.files[0].name : "Tidak ada file dipilih";
    document.querySelector(".file-name-lagu").textContent = fileNameLagu;
}

// Fungsi untuk menampilkan nama file sampul album
function showFileName(input) {
    const fileName = input.files[0] ? input.files[0].name : "Tidak ada file dipilih";
    document.querySelector(".file-name").textContent = fileName;
}



let progress = document.getElementById('progress');
            let song = document.getElementById('song');
            let contr = document.getElementById('contr');

            song.onloadedmetadata = function(){
                progress.max = song.duration;
                progress.value = song.currentTime;                 
            }
            function playPause(){
                if(contr.classList.contains("fa-pause")){
                    song.pause();
                    contr.classList.remove("fa-pause");
                    contr.classList.add("fa-play");
                }else{
                    song.play();
                    contr.classList.add("fa-pause");
                    contr.classList.remove("fa-play");
                }
            }

            if(song.play()){
                setInterval(()=>{
                    progress.value = song.currentTime;
                },500);
            }
            progress.onchange = function(){
                song.play();
                song.currentTime = progress.value;
                contr.classList.add("fa-pause");
                contr.classList.remove("fa-play");
            }