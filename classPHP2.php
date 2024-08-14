<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>可縮放框框示範</title>
<style>
  .container {
    width: 300px;
    margin: 0 auto;
    text-align: center;
    margin-top: 50px;
    cursor:pointer;
  }
  .box {
    width: 200px;
    height: 200px;
    border: 1px solid #ccc;
    resize: both;
    overflow: auto;
    padding: 20px;
    position: pointer;
  }
  .resize-handle {
    width: 10px;
    height: 10px;
    background-color: #000;
    position: absolute;
  }
  .resize-handle.top-left {
    top: -5px;
    left: -5px;
    /* cursor: nwse-resize; */
  }
  .resize-handle.top-right {
    top: -5px;
    right: -5px;
    /* cursor: nesw-resize; */
  }
  .resize-handle.bottom-left {
    bottom: -5px;
    left: -5px;
    /* cursor: nesw-resize; */
  }
  .resize-handle.bottom-right {
    bottom: -5px;
    right: -5px;
    /* cursor: nwse-resize; */
  }
</style>
</head>
<body>
  
  <div class="box" id="box">
    <div class="resize-handle top-left" style="display: none;"></div>
    <div class="resize-handle top-right" style="display: none;"></div>
    <div class="resize-handle bottom-left" style="display: none;"></div>
    <div class="resize-handle bottom-right" style="display: none;"></div>
  </div>

<script>
  let isResizing = false;
  let originalMouseX = 0;
  let originalMouseY = 0;
  let originalWidth = 0;
  let originalHeight = 0;

  const box = document.getElementById('box');
  const topLeftHandle = box.querySelector('.top-left');
  const topRightHandle = box.querySelector('.top-right');
  const bottomLeftHandle = box.querySelector('.bottom-left');
  const bottomRightHandle = box.querySelector('.bottom-right');

  topLeftHandle.addEventListener('mousedown', startResize);
  topRightHandle.addEventListener('mousedown', startResize);
  bottomLeftHandle.addEventListener('mousedown', startResize);
  bottomRightHandle.addEventListener('mousedown', startResize);

  function startResize(event) {
    isResizing = true;
    originalMouseX = event.clientX;
    originalMouseY = event.clientY;
    originalWidth = parseFloat(getComputedStyle(box, null).getPropertyValue('width'));
    originalHeight = parseFloat(getComputedStyle(box, null).getPropertyValue('height'));
    document.addEventListener('mousemove', resize);
    document.addEventListener('mouseup', stopResize);
  }

  function resize(event) {
    if (isResizing) {
      const deltaX = event.clientX - originalMouseX;
      const deltaY = event.clientY - originalMouseY;
      let newWidth = originalWidth + deltaX;
      let newHeight = originalHeight + deltaY;
      // 最小寬度和最小高度
      newWidth = Math.max(newWidth, 50);
      newHeight = Math.max(newHeight, 50);

      if (event.target === topLeftHandle || event.target === topRightHandle) {
        box.style.width = newWidth + 'px';
      }

      if (event.target === topLeftHandle || event.target === bottomLeftHandle) {
        box.style.height = newHeight + 'px';
      }
    }
  }

  function stopResize() {
    isResizing = false;
    document.removeEventListener('mousemove', resize);
    document.removeEventListener('mouseup', stopResize);
  }
</script>

</body>
</html>
