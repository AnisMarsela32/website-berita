
<?php
class database
{

	var $host = "localhost";
	var $username = "root";
	var $password = "";
	var $database = "blog";
	var $koneksi = "";

	function __construct()
	{
		$this->koneksi = mysqli_connect($this->host, $this->username, $this->password, $this->database);

		if (mysqli_connect_errno()) {
			echo "Koneksi database gagal : " . mysqli_connect_error();
		}
	}

	function tampil_data()
{
    $hasil = array(); // Inisialisasi array hasil
    $data = mysqli_query($this->koneksi, "SELECT post.*, kategori.nama AS nama_kategori, post.gambar, DATE_FORMAT(post.create_at, '%d %b %Y') AS tanggal_terbit FROM post JOIN kategori ON post.kategori_id = kategori.id ORDER BY post.create_at DESC");

    while ($row = mysqli_fetch_array($data)) {
        // Memecah judul menjadi kata-kata terpisah
        $kataKunciJudul = explode(' ', $row['judul']);

        // Mengambil sejumlah kata yang diinginkan untuk judul (maksimal 6 kata)
        $potonganJudul = implode(' ', array_slice($kataKunciJudul, 0, 6));

        // Jika judul lebih panjang dari 6 kata, tambahkan elipsis (...)
        if (count($kataKunciJudul) > 6) {
            $potonganJudul .= '...';
        }

        // Ganti judul dengan potongan judul yang sudah dibatasi
        $row['judul'] = $potonganJudul;

        // Memecah ringkas menjadi kata-kata terpisah
        $kataKunciRingkas = explode(' ', $row['ringkas']);

        // Mengambil sejumlah kata yang diinginkan untuk ringkas (maksimal 10 kata)
        $potonganRingkas = implode(' ', array_slice($kataKunciRingkas, 0, 8));

        // Jika ringkas lebih panjang dari 10 kata, tambahkan elipsis (...)
        if (count($kataKunciRingkas) > 10) {
            $potonganRingkas .= '...';
        }

        // Ganti ringkas dengan potongan ringkas yang sudah dibatasi
        $row['ringkas'] = $potonganRingkas;

        $hasil[] = $row;
    }

    return $hasil;
}





	public function tampil_post($post)
{
    // Pastikan sesi sudah dimulai
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Periksa apakah pengguna belum login sebagai user atau admin
    // if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    //     // Jika pengguna belum login, alihkan ke halaman login
    //     header("Location: login.php");
    //     exit;
    // }

    // Selanjutnya, Anda dapat melanjutkan pengambilan data post seperti yang Anda lakukan sebelumnya.
    $data = mysqli_query($this->koneksi, "SELECT post.*, kategori.nama AS nama_kategori,kategori.slug AS kategori_slug, DATE_FORMAT(post.create_at, '%d %M %Y') AS tanggal_terbit FROM post JOIN kategori ON post.kategori_id = kategori.id WHERE post.slug='$post' ORDER BY post.create_at DESC");

    $hasil = array(); // Inisialisasi array hasil
    // Periksa apakah ada hasil yang ditemukan
    while ($row = mysqli_fetch_array($data)) {
        $hasil[] = $row;
    }
    return $hasil;
}



	function tampil_kategori()
	{
		$data = mysqli_query($this->koneksi, "SELECT * FROM kategori ORDER BY create_at DESC LIMIT 9");
		while ($row = mysqli_fetch_array($data)) {
			$hasil[] = $row;
		}
		return $hasil;
	}

	function tampil_post_kategori($koneksi, $slug)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Periksa apakah pengguna belum login sebagai user atau admin
    // if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    //     // Jika pengguna belum login, alihkan ke halaman login
    //     header("Location: login.php");
    //     exit;
    // }

    $data = mysqli_query($koneksi, "SELECT post.*, kategori.nama AS nama_kategori, DATE_FORMAT(post.create_at, '%d %b %Y') AS tanggal_terbit 
                                      FROM post 
                                      JOIN kategori ON post.kategori_id = kategori.id 
                                      WHERE kategori.slug = '$slug' ORDER BY post.create_at DESC");

    $hasil = array(); // Inisialisasi array hasil

    // Periksa apakah ada hasil yang ditemukan
    while ($row = mysqli_fetch_array($data)) {
        // Batasi teks dalam kolom "judul" menjadi 6 kata
        $judul = $row['judul'];
        $judulArray = explode(' ', $judul);
        $judulLimited = implode(' ', array_slice($judulArray, 0, 6));

        // Tambahkan elipsis jika judul asli lebih dari 6 kata
        if (count($judulArray) > 6) {
            $judulLimited .= '...';
        }

        // Menambahkan kolom "judul" yang telah dibatasi ke dalam hasil
        $row['judul'] = $judulLimited;

        // Batasi teks dalam kolom "ringkas" menjadi 10 kata
        $ringkas = $row['ringkas'];
        $ringkasArray = explode(' ', $ringkas);
        $ringkasLimited = implode(' ', array_slice($ringkasArray, 0, 17));

        // Tambahkan elipsis jika ringkas asli lebih dari 10 kata
        if (count($ringkasArray) > 8) {
            $ringkasLimited .= '...';
        }

        // Menambahkan kolom "ringkas" yang telah dibatasi ke dalam hasil
        $row['ringkas'] = $ringkasLimited;

        $hasil[] = $row;
    }

    return $hasil;
}

}

$fulldomain = "http://localhost/coba%20loop/";
?>