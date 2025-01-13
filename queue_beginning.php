<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrian Awal</title>
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=8ru1Fbxp"></script>    <style>
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
            position: relative;
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
            flex-wrap: wrap;
            padding-top: 20px;
        }

        .butt {
            padding: 15px 30px;
            font-size: 1.1rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: bold;
            width: 180px;
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
                width: 150px;
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
    <h2>Antrian Dimulai Dari Awal</h2>
    <table border="1" id="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pesan</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data tabel akan diisi dengan JavaScript -->
        </tbody>
    </table>

    <!-- Button Container -->
    <div class="buttons">
        <!-- Button untuk memutar pesan terbaru -->
        <button class="butt" onclick="speakLatestMessage()" type="button">Play Latest Message</button>

        <!-- Button untuk melanjutkan ke antrian berikutnya -->
        <button class="butt" onclick="nextMessage()" type="button" id="nextButton">Next Message</button>

        <!-- Button untuk mundur ke pesan sebelumnya -->
        <button class="butt" onclick="previousMessage()" type="button">Previous Message</button>

        <!-- Button untuk membuka tab baru dengan pesan besar -->
        <button class="butt" onclick="openNewTabWithMessage()" type="button">Open New Tab with Message</button>
    </div>
</div>

<script>
    let currentMessageId = 0; // Variabel untuk menyimpan ID pesan yang sedang ditampilkan
    let largeMessageWindow = null; // Menyimpan referensi ke jendela tab baru

    // Fungsi untuk memutar suara pesan menggunakan ResponsiveVoice
    function speakLatestMessage() {
        const latestMessage = document.getElementById('latestMessage').innerText; // Ambil pesan terbaru dari tabel
        if (latestMessage) {
            responsiveVoice.speak(latestMessage, "Indonesian Female"); // Memanggil ResponsiveVoice
        } else {
            console.warn("Tidak ada pesan untuk diputar.");
        }
    }

    // Fungsi untuk melanjutkan ke pesan berikutnya
    async function nextMessage() {
        try {
            const response = await fetch('next_message.php?id=' + currentMessageId); // Endpoint untuk mengambil pesan berikutnya
            const data = await response.json();

            if (data && data.id !== undefined && data.message !== undefined && data.created_at !== undefined) {
                updateTable(data);
                document.getElementById('nextButton').disabled = false; // Enable the Next button
                updateTabMessage(data); // Update the message in the new tab
            } else {
                console.log("Tidak ada pesan berikutnya.");
                document.getElementById('nextButton').disabled = true; // Disable the Next button
                alert("Tidak ada pesan berikutnya.");
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Fungsi untuk mundur ke pesan sebelumnya
    async function previousMessage() {
        try {
            const response = await fetch('previous_message.php?id=' + currentMessageId); // Endpoint untuk mengambil pesan sebelumnya
            const data = await response.json();

            if (data && data.id !== undefined && data.message !== undefined && data.created_at !== undefined) {
                updateTable(data);
                document.getElementById('nextButton').disabled = false; // Enable the Next button
                updateTabMessage(data); // Update the message in the new tab
            } else {
                alert("Tidak ada pesan sebelumnya.");
                console.log("Tidak ada pesan sebelumnya.");
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Fungsi untuk memperbarui tabel dengan data terbaru
    function updateTable(data) {
        if (data && data.id !== undefined && data.message !== undefined && data.created_at !== undefined) {
            const tbody = document.getElementById('data-table').getElementsByTagName('tbody')[0];
            tbody.innerHTML = ` 
                <tr>
                    <td>${data.id}</td>
                    <td id="latestMessage">Antrian ke: ${data.message}</td>
                    <td>${data.created_at}</td>
                </tr>
            `;
            currentMessageId = data.id; // Update ID pesan yang sedang ditampilkan
            document.title = "Pesan ID: " + data.id;
        } else {
            console.warn("Data tidak lengkap, tidak dapat memperbarui tabel.");
        }
    }

    // Fungsi untuk membuka tab baru dengan pesan besar
    function openNewTabWithMessage() {
        if (!largeMessageWindow || largeMessageWindow.closed) {
            largeMessageWindow = window.open('', '_blank', 'width=800,height=600');
            largeMessageWindow.document.write(`
                <html>
                <head>
                    <title>Pesan Besar</title>
                    <style>
                        body {
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            height: 100vh;
                            margin: 0;
                            background-color: #f4f4f9;
                        }
                        .large-message {
                            font-size: 150px;
                            font-weight: bold;
                            color: #333;
                            text-align: center;
                        }
                    </style>
                </head>
                <body>
                    <div class="large-message" id="largeMessage">Loading...</div>
                </body>
                </html>
            `);
            largeMessageWindow.document.close();
        }

        // Update the message in the new tab
        const message = document.getElementById('latestMessage').innerText;
        if (largeMessageWindow && largeMessageWindow.document) {
            largeMessageWindow.document.getElementById('largeMessage').innerText = message;
        }
    }

    // Memanggil nextMessage() saat halaman dimuat
    window.onload = nextMessage;
</script>

</body>
</html>
