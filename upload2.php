<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Image Download</title>
</head>
<body>
    <img id="image" src="https://example.com/path-to-your-image.jpg" alt="Example Image" style="width:300px;">
    <button id="downloadBtn">Download Image</button>
    <div></div>

    <script>
        document.getElementById("downloadBtn").addEventListener("click", function () {
            const link = document.createElement("a");
            link.href = document.getElementById("image").src;  // 获取图片的 URL
            link.download = "downloaded_image.jpg";  // 设置下载的文件名
            link.click();  // 程序化点击触发下载
        });
    </script>
</body>
</html>
