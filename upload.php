<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>html</title>
</head>

<body>
    <div style="margin-bottom: 10px">
        上传图片：<input type="file" onchange="onChange(this.files[0])">
    </div>
    <canvas id="cvs"></canvas>
    <canvas id="clipCvs"></canvas>
    <button id="download">下载图片</button>
</body>
<script>
    //拿到HTML的元素
    const cvs = document.getElementById('cvs')
    const clipCvs = document.getElementById('clipCvs')
    const download = document.getElementById('download')

    //獲取兩個畫布的2d渲染對象,提供繪圖的方法與屬性
    const ctx = cvs.getContext('2d')
    const clipCtx = clipCvs.getContext('2d')

    const img = new Image()
    let size = 300
    let maxW = 800
    const p = {
        left: 0,
        top: 0,
        stepX: 0,
        stepY: 0
    }
    const onChange = (file) => {
        onInit(URL.createObjectURL(file))
    }
    // 加载图片，并初始化裁剪功能
    const onInit = (src) => {
        //最初還沒上傳圖片的裁剪框的長與寬為300
        clipCvs.width = clipCvs.height = size
        //開頭已經上傳的圖片被傳進來的scr 給予 img
        img.src = src
        img.onload = () => {
            //把傳進來的圖片的長寬附值
            let width = img.width
            let height = img.height

            //如果寬度大於先前設好的maxW(300)
            if (width > maxW) {
                //就將調整長度跟寬度
                height = maxW / width * height
                width = maxW
            }

            //將重設好得長寬給予裝圖片的畫布 並渲染
            cvs.width = width
            cvs.height = height
            render(width, height)
        }
    }
    // 渲染裁剪前canvas
    const render = (left = 0, top = 0) => {
        //清除畫布 從左上角的x=0,y=0的地方開始清除 寬高為  cvs.width, cvs.height
        ctx.clearRect(0, 0, cvs.width, cvs.height)
        //繪製圖片 img 從左上角的x=0,y=0的地方開始繪製 寬高為  cvs.width, cvs.height
        ctx.drawImage(img, 0, 0, cvs.width, cvs.height)
        //限定裁剪區在圖片內
        if (left < 0) {
            left = 0
        }
        if (left > cvs.width - size) {
            left = cvs.width - size
        }
        if (top < 0) {
            top = 0
        }
        if (top > cvs.height - size) {
            top = cvs.height - size
        }
        clipPic(ctx.getImageData(left, top, size, size)) //裁剪图片，并显示在右侧
        ctx.beginPath()
        ctx.fillStyle = 'rgba(0, 0, 0, 0.5)'
        ctx.fillRect(left, top, size, size)
        p.left = left
        p.top = top
    }
    // 裁剪图片，并显示在右侧
    const clipPic = (data) => {
        clipCtx.clearRect(0, 0, clipCvs.width, clipCvs.height)
        clipCtx.putImageData(data, 0, 0)
    }
    
    let isMoving = false
    cvs.onmousedown = (e) => {
        p.stepX = e.pageX - p.left
        p.stepY = e.pageY - p.top
        isMoving = true
    }
    cvs.onmousemove = (e) => {
        if (isMoving) {
            render(e.pageX - p.stepX, e.pageY - p.stepY)
        }
    }
    document.onmouseup = () => {
        isMoving = false
    }
    download.onclick = async () => {
        const res = await fetch(clipCvs.toDataURL('image/png'))
        const blob = await res.blob()
        const a = document.createElement('a')
        a.setAttribute('download', 'clip.png')
        a.href = URL.createObjectURL(blob)
        a.click()
    }
    onInit('./images/girl.png')
</script>
</html>