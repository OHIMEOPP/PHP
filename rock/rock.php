<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <script src="listt.js"></script>
    <style>
        <?php require_once 'mission.css'  ?>
    </style>
    <title>坐車聽最對味</title>
</head>

<body class="rock">
    <header>
        <h1>坐車聽最對味</h1>
        <section class="intro">
            <p>
                這是我製作的歌單，名稱是：坐車聽最對味，裡面的歌曲曲風偏輕快，
                也有節奏感較強的歌，分享給你，希望你會喜歡^v^
            </p>
        </section>
        <div>
            <p>
            <h2>歌曲名稱</h2>
            </p>
            <p>
            <h2>作者</h2>
            </p>
        </div>
    </header>
    <main>
        <div class="list">
            <section class="list1">
                <?php
                ##Track Name,Artist Name(s),Release Date
                $filename = 'C:\guitar\坐車聽最對味.csv';
                $file = fopen($filename, 'r');
                if ($file) {
                    while (($line = fgets($file)) !== false) {
                        $line = iconv('BIG5', 'UTF-8', $line);
                        echo "<div class=\"l\"><p>$line</p></div>";
                    }
                    fclose($file);
                } else {
                    echo "無法開啟CSV檔案。";
                }
                ?>
            </section>
            <section class="artist1">
                <?php
                $filename = 'C:\guitar\坐車聽最對味 創作者.csv';
                $file = fopen($filename, 'r');
                if ($file) {
                    while (($line = fgets($file)) !== false) {
                        $line = iconv('BIG5', 'UTF-8', $line);
                        echo "<div class=\"r\"><p>$line</p></div>";
                    }
                    fclose($file);
                } else {
                    echo "無法開啟CSV檔案。";
                }
                ?>
            </section>

        </div>
        <audio id="audioPlayerr" controls>
            <source src="rock/[音樂] 宇宙人 藍色的你 歌詞 (影集版 比悲傷更悲傷的故事 插曲).mp3" type="audio/mp3" id="audioSource">
        </audio>
    </main>
    <footer class="rock">
        <div class="playlist">
            <button class="previous" id="previous"></button>
            <button class="pause" id="pause"></button>
            <button class="next" id="next"></button>
        </div>
    </footer>
</body>

</html>