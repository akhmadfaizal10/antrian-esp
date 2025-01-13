<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Terbaru Antrian</title>
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=8ru1Fbxp"></script>
        <style>
/* General body styling */
/* Global Styles */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f4f9;
    color: #333;
    display: flex; 
    justify-content: center;
    align-items: center;
    height: 100vh;
    overflow: hidden;
}

.container {
    background: #fff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    width: 90%;
    max-width: 800px;
    text-align: center;
    
    animation: fadeIn 1s ease-out;
}

h2 {
    font-size: 2.5rem;
    color: #007bff;
    margin-bottom: 20px;
    font-weight: bold;
    text-transform: uppercase;
}

/* Table Styling */
#data-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

#data-table th, #data-table td {
    padding: 15px 20px;
    text-align: center;
    border: 1px solid #ddd;
}

#data-table th {
    background-color: #007bff;
    color: white;
    font-size: 1.1rem;
    font-weight: 600;
}

#data-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

#data-table tr:hover {
    background-color: #f1f1f1;
}

/* Button Styles */
.buttons {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 20px;
}

.butt {
    margin: 10px;
    padding: 15px 30px;
    font-size: 1.1rem;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: bold;
}

.butt:hover {
    background-color: #0056b3;
    transform: translateY(-3px);
}

.butt:active {
    background-color: #003d80;
    transform: translateY(3px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        padding: 20px;
        width: 95%;
    }

    h2 {
        font-size: 2rem;
    }

    .butt {
        font-size: 1rem;
    }
}

/* Animation */
@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateY(50px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>
</head>
<body>

<div class="container">

    <h2>Data Terbaru Antrian</h2>
    <table border="1" id="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pesan</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Konfigurasi koneksi ke database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "antrian";

            // Membuat koneksi ke database
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Cek koneksi
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query untuk mendapatkan satu data terbaru dari tabel messages
            $sql = "SELECT id, message, created_at FROM messages ORDER BY id DESC LIMIT 1";
            $result = $conn->query($sql);
            $latestMessage = "";

            if ($result->num_rows > 0) {
                // Ambil baris pertama
                $row = $result->fetch_assoc();
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td id='latestMessage'>" . $row["message"] . "</td>";
                echo "<td>" . $row["created_at"] . "</td>";
                echo "</tr>";
                $latestMessage = $row["message"];
            } else {
                echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
            }

            // Menutup koneksi database
            $conn->close();
            ?>
       </tbody>
       
</table>
<button class="butt" onclick="speakLatestMessage()" type="button">Play Latest Message</button> 

<button class="butt" onclick="startQueueFromBeginning()" type="button">Start Queue From Beginning</button> 

</div>

</body>
<script>
    // Fungsi untuk memutar suara pesan terbaru menggunakan ResponsiveVoice
    function speakLatestMessage() {
        const latestMessage = document.getElementById('latestMessage').innerText; // Ambil pesan terbaru dari tabel
        if (latestMessage) {
            responsiveVoice.speak(latestMessage, "Indonesian Female"); // Memanggil ResponsiveVoice
        } else {
            console.warn("Tidak ada pesan untuk diputar.");
        }
    }

    // Fungsi untuk memulai antrian dari awal
    function startQueueFromBeginning() {
        window.location.href = "queue_beginning.php"; // Pindah ke halaman antrian awal
    }

    // Set interval untuk memeriksa data terbaru setiap 5 detik
    setInterval(async function() {
        try {
            // Kirim request untuk mendapatkan pesan terbaru
            const response = await fetch('latest_message.php'); // Endpoint untuk mendapatkan pesan terbaru
            const data = await response.json();

            // Jika pesan baru berbeda dari yang sekarang
            const latestMessageElement = document.getElementById('latestMessage');
            if (data.message !== latestMessageElement.innerText) {
                // Perbarui tabel dengan data terbaru
                const tbody = document.getElementById('data-table').getElementsByTagName('tbody')[0];
                tbody.innerHTML = `
                    <tr>
                        <td>${data.id}</td>
                        <td id="latestMessage">${data.message}</td>
                        <td>${data.created_at}</td>
                    </tr>
                `;
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }, 5000); // Setiap 5 detik
</script>

</body>
</html>
