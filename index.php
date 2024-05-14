<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar</title>
    <style>
        .center {
            text-align: center;
        }

        .container {
            padding: 20px;
        }

        .checkbox-container {
            display: block;
            margin-right: 10px;
        }

        .checkbox-container input[type="checkbox"] {
            width: 25px;
            height: 25px;
            margin-right: 5px;
            vertical-align: middle;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            background-color: whitesmoke;
        }

        th {
            background-color: grey;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body style="background-color: #cce7e8;">
    <h2 class="center">Sistem Pakar Penyakit THT</h2>

    <div class="container">
        <div class="row">
            <div class="col">
                <h2>Daftar Gejala</h2>
                <input type="text" id="searchInput" placeholder="Cari gejala..." class="mb-3">
                <form id="checkboxForm">
                    <?php
                    $gejala = array(
                        1 =>  "1. Demam",
                        2 => "2. Sakit Kepala",
                        3 =>  "3. Nyeri saat bicara atau menelan",
                        4 => "4. Batuk",
                        5 =>  "5. Hidung tersumbat",
                        6 =>  "6. Nyeri telinga",
                        7 =>  "7. Nyeri tenggorakan",
                        8 => "8. Hidung meler",
                        9 => "9. Letih dan lesu",
                        10 => "10. Mual dan muntah",
                        11 =>  "11. Selaput lendir merah dan bengkak",
                        12 => "12. Ada benjolan di leher",
                        13 => "13. Nyeri leher",
                        14 => "14. Pembengkakan kelenjar getah bening",
                        15 =>  "15. Pendarahan hidung",
                        16 =>  "16. Suara serak",
                        17 => "17. Bola mata bergerak tanpa sadar",
                        18 =>  "18. Dahi sakit",
                        19 =>  "19. Leher bengkak",
                        20 => "20. Tuli",
                        21 => "21. Ada yang tumbuh di mulut",
                        22 =>  "22. Air liur menetes",
                        23 =>  "23. Berat badan turun",
                        24 =>  "24. Bunyi nafas abnormal",
                        25 =>  "25. Infeksi sinus",
                        26 => "26. Nyeri antara mata",
                        27 =>  "27. Nyeri pinggir hidung",
                        28 =>  "28. Nyeri pipi dibawah mata",
                        29 =>  "29. Nyeri wajah",
                        30 =>  "30. Perubahan kulit",
                        31 =>  "31. Perubahan suara",
                        32 => "32. Radang gendang telinga",
                        33 => "33. Sakit gigi",
                        34 => "34. Serangan vertigo",
                        35 => "35. Telinga berdenging",
                        36 => "36. Telinga terasa penuh",
                        37 => "37. Tenggorokan gatal",
                        38 => "38. Tubuh tak seimbang"
                    );

                    foreach ($gejala as $key => $value) {
                        echo "<div class='checkbox-container'>
                            <input type='checkbox' id='gejala$key' name='gejala[]' value='$key'>
                            <label for='gejala$key'>$value</label><br>
                        </div>";
                    }
                    ?>

                    <input type="text" id="name" name="name" placeholder="Masukan Nama" class="mt-4 mb-4" autocomplete="name"><br>
                    <input type="button" id="cariPenyakit" value="Temukan Nama Penyakit" class="btn btn-primary mt-3">
                </form>
                <h2 class="mt-5">Nama Penyakit yang diderita adalah :</h2>
                <div id="hasilPenyakit" class="mt-3 mb-5"></div>
            </div>

            <div class="col">
                <div id="dataPasien" class="mt-2"></div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("searchInput").addEventListener("input", function() {
            var searchText = this.value.trim().toLowerCase();
            document.querySelectorAll("#checkboxForm .checkbox-container").forEach(function(container) {
                container.style.display = container.querySelector('label').textContent.trim().toLowerCase().includes(searchText) ? 'block' : 'none';
            });
        });

        document.getElementById('cariPenyakit').addEventListener('click', function() {
            var penyakitId = [...document.querySelectorAll('input[name="gejala[]"]:checked')].map(checkbox => parseInt(checkbox.value));
            var dataPenyakit = {
                "CONTRACT ULCERS": [3, 16],
                "ABAES PARAFARINGEAL": [3, 19],
                "ABAES PERITONAILER": [1, 2, 7, 14, 16, 22],
                "BAROTITIS MEDIAL": [2, 6],
                "DEVIASI SEPTUM": [1, 5, 6, 15, 25, 29],
                "FARINGITIS": [1, 3, 7, 13, 14],
                "KANKER LARING": [3, 4, 7, 13, 16, 23, 24],
                "KANKER LEHER DAN KEPALA": [3, 12, 15, 21, 30, 31],
                "KANKER LEHER METASTATIK": [12],
                "KANKER NASOFARING": [5, 15],
                "KANKER TONSIL": [7, 12],
                "LARINGITIS": [1, 3, 14, 19, 37],
                "NEURONITIS VESTIBULARIS": [10, 17],
                "OSTEOSKLEROSIS": [20, 35],
                "OTITIS MEDIA AKUT": [1, 6, 10, 32],
                "MENIERE": [6, 10, 34, 36],
                "TONSILITIS": [1, 2, 3, 4, 7, 10],
                "TUMOR SYARAF PENDENGARAN": [2, 20, 38],
                "VERTIGO POSTULAR": [17],
                "SINUSITIS MAKSILARIS": [1, 2, 4, 5, 8, 9, 11, 28, 33],
                "SINUSITIS FRONTALIS": [1, 2, 4, 5, 8, 9, 11, 18],
                "SINUSITIS ETMOIDALIS": [1, 2, 4, 5, 8, 9, 11, 18, 26, 27],
                "SINUSITIS SFENOIDALIS": [1, 2, 4, 5, 6, 8, 9, 11, 12],
                "PERUT": [1, 2, 3, 4]
            };

            var hasilPenyakit = Object.keys(dataPenyakit).find(penyakit => penyakitId.length === dataPenyakit[penyakit].length && penyakitId.every(id => dataPenyakit[penyakit].includes(id)));

            var namaInput = document.getElementById('name').value;
            var hasilPenyakitElement = document.getElementById('hasilPenyakit');

            hasilPenyakitElement.innerHTML = hasilPenyakit ?
                "Pasien dengan Nama : <strong>" + namaInput + "</strong> berdasarkan hasil diagnosa dengan nama penyakit : <strong>" + hasilPenyakit + "</strong>" :
                "Pasien dengan Nama : <strong>" + namaInput + "</strong> tidak ditemukan penyakit yang sesuai.";


            var data = {
                nama: namaInput,
                penyakit: hasilPenyakit || "Tidak Ditemukan"
            };
            var existingData = JSON.parse(localStorage.getItem('data') || '[]');
            existingData.push(data);
            localStorage.setItem('data', JSON.stringify(existingData));

            var tableHTML = '<table>';
            tableHTML += '<tr><th>No</th><th>Nama</th><th>Penyakit</th><th>Aksi</th></tr>';
            existingData.forEach((item, index) => tableHTML += `<tr><td>${index + 1}.</td><td>${item.nama}</td><td>${item.penyakit}</td><td><button class="btn-hapus" data-index="${index}">Hapus</button></td></tr>`);
            tableHTML += '</table>';
            document.getElementById('dataPasien').innerHTML = tableHTML;
        });

        window.addEventListener('load', function() {
            var existingData = JSON.parse(localStorage.getItem('data') || '[]');
            var tableHTML = existingData.length > 0 ? '<table><tr><th>No</th><th>Nama</th><th>Penyakit</th><th>Aksi</th></tr>' : '';
            existingData.forEach((item, index) => tableHTML += `<tr><td>${index + 1}.</td><td>${item.nama}</td><td>${item.penyakit}</td><td><button class="btn-hapus" data-index="${index}">Hapus</button></td></tr>`);
            tableHTML += existingData.length > 0 ? '</table>' : '';
            document.getElementById('dataPasien').innerHTML = tableHTML;
        });

        document.getElementById('dataPasien').addEventListener('click', function(event) {
            event.target.classList.contains('btn-hapus') &&
                (() => {
                    var index = event.target.getAttribute('data-index');
                    var existingData = JSON.parse(localStorage.getItem('data') || '[]');
                    existingData.splice(index, 1);
                    localStorage.setItem('data', JSON.stringify(existingData));
                    var tableHTML = existingData.length > 0 ? '<table><tr><th>No</th><th>Nama</th><th>Penyakit</th><th>Aksi</th></tr>' : '';
                    existingData.forEach((item, index) => tableHTML += `<tr><td>${index + 1}.</td><td>${item.nama}</td><td>${item.penyakit}</td><td><button class="btn-hapus" data-index="${index}">Hapus</button></td></tr>`);
                    tableHTML += existingData.length > 0 ? '</table>' : '';
                    document.getElementById('dataPasien').innerHTML = tableHTML;
                })();
        });
    </script>

</body>

</html>
