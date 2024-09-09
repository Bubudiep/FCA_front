<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="/assets/css/app.css">
  <link rel="stylesheet" href="/assets/lib/font/css/all.min.css">
  <script src="/assets/js/app.js"></script>
  <script src="/assets/lib/jquery-3.7.1.min.js"></script>
</head>
<body>
  <div class="left-container">
    <div class="menu-fixed"></div>
    <div class="menu-box"></div>
  </div>
  <div class="right-container">
    <div class="top-container">
      <div class="routes">
        <div class="items"><i class="fa-regular fa-house"></i></div>
        <div class="split"><i class="fa-solid fa-angle-right"></i></div>
        <div class="items">Tổng quan</div>
      </div>
      <div class="right-tools">
        <div class="tools-list">
          <div class="itemc">
            <input type="text" placeholder="Search...">
          </div>
        </div>
        <div class="tools-list">
          <div class="itemc"><i class="fa-solid fa-wifi"></i> 265ms</div>
        </div>
        <div class="tools-list">
          <div class="itemx"><i class="fa-sharp fa-regular fa-question"></i> Hỗ trợ</div>
          <div class="itemx"><i class="fa-light fa-book"></i> Tài liệu</div>
          <div class="itemx"><i class="fa-light fa-bug"></i> Báo lỗi</div>
        </div>
        <div class="tools-list pd3 g5">
          <div class="items app-hide"><i class="fa-solid fa-minus"></i></div>
          <div class="items app-expland"><i class="fa-solid fa-expand"></i></div>
          <div class="items app-close"><i class="fa-solid fa-xmark"></i></div>
        </div>
      </div>
    </div>
    <div class="main-container"></div>
  </div>
</body>
<script type="text/javascript">
  $(document).ready(function(){
    var ipc=null;
    if (window.electron){
      ipc=window.electron;
    }
    $(".app-hide").click(()=>{
      ipc.send("minimize");
    });
    $(".app-expland").click(()=>{
      ipc.send("maximize");
    });
    $(".app-close").click(()=>{
      ipc.send("exit");
    });
    try {
      window.electron.receive("message-from-main", (message) => {
        console.log(message);
        if (message["type"]) {
          if (message.type == "error") {
            app.error(message.message);
          }
          if (message.type == "downloaded") {
            var old = parseInt(
              $("#filesCount")
                .html()
                .replace('<num><i class="fa-solid fa-circle-arrow-down"></i>', "")
                .replace("</num>", "")
            );
            var newNum = 1;
            if (!isNaN(old)) {
              newNum = old + 1;
            }
            console.log(newNum, old);
            $("#filesCount").html(
              '<num><i class="fa-solid fa-circle-arrow-down"></i>' +
                newNum +
                "</num>"
            );
          }
          return false;
        }
        var savedDataString = localStorage.getItem("savedData");
        if (savedDataString) {
          var savedData = JSON.parse(savedDataString);
          savedData.push(message);
          localStorage.setItem("savedData", JSON.stringify(savedData));
        } else {
          localStorage.setItem("savedData", JSON.stringify([message]));
        }
      });
    } catch (e) {}
  });
</script>
</html>