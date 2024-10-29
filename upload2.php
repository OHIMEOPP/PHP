<<<<<<< HEAD
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
=======
<div class="container">
  <!-- 左邊區域，放置五個標籤 -->
  <div id="left-box" class="box">
    <div class="label" onclick="moveLabel(this, 'right')">Label 1</div>
    <div class="label" onclick="moveLabel(this, 'right')">Label 2</div>
    <div class="label" onclick="moveLabel(this, 'right')">Label 3</div>
    <div class="label" onclick="moveLabel(this, 'right')">Label 4</div>
    <div class="label" onclick="moveLabel(this, 'right')">Label 5</div>
  </div>
>>>>>>> 974b282c52aa4b1277bd5c7cdd98f10046152f4f

  <!-- 右邊區域，接收移動的標籤 -->
  <div id="right-box" class="box">
    <!-- 標籤會移動到這個區域，並可以點擊移回去 -->
  </div>
</div>

<style>
 .container {
  display: flex;
  justify-content: space-between;
  width: 600px;
  margin: 50px auto;
}

.box {
  width: 250px;
  height: 300px;
  border: 1px solid #ccc;
  padding: 10px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-around;
  position: relative;
  overflow: hidden;
}

.label {
  background-color: #3498db;
  color: white;
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
  text-align: center;
  transition: transform 0.5s ease, background-color 0.5s ease, opacity 0.5s ease;
}

.label:hover {
  background-color: #2980b9;
}

.fly-right {
  transform: translateX(300px); /* 讓標籤向右飛到右邊的 box */
  opacity: 0;
}

.fly-left {
  transform: translateX(-300px); /* 讓標籤向左飛到左邊的 box */
  opacity: 0;
}

.fade-in {
  opacity: 1;
}

</style>
<script>function moveLabel(element, direction) {
  const targetBox = direction === 'right' ? document.getElementById('right-box') : document.getElementById('left-box');
  
  // 根據方向添加相應的飛行 class，進行動畫
  element.classList.add(direction === 'right' ? 'fly-right' : 'fly-left');
  
  // 在動畫結束後將標籤移動到另一個區域
  setTimeout(function() {
    element.classList.remove('fly-right', 'fly-left'); // 移除飛行的 class
    element.classList.add('fade-in'); // 添加淡入效果
    targetBox.appendChild(element); // 把標籤移到目標區域

    // 更新點擊事件，使它可以來回飛行
    element.setAttribute('onclick', `moveLabel(this, '${direction === 'right' ? 'left' : 'right'}')`);
    
    // 重置淡入效果，確保每次移動後動畫都正常
    setTimeout(() => element.classList.remove('fade-in'), 500);
  }, 500); // 這裡的 500ms 應與 CSS 的 transition 時間一致
}

</script>