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
  <div class="login-page">
    <div class="video-container"></div>
    <div class="login-container">
      <div class="login-box">
        <div class="header">Đăng nhập</div>
        <div class="hi">Chào mừng bạn quay trờ lại!</div>
        <div class="form">
          <div class="items">
            <div class="name">Tài khoản</div>
            <div class="value"><input id="username" type="text" placeholder="tên đăng nhập..."></div>
          </div>
          <div class="items">
            <div class="name">Mật khẩu</div>
            <div class="value"><input id="password" type="password" placeholder="mật khẩu..."></div>
          </div>
        </div>
        <div class="login-btn"><button id="login-btn">Đăng nhập</button></div>
        <div class="with-zalo"><button>Đăng nhập bằng Zalo</button></div>
        <div class="fc g4">
          <div class="flex register">Đăng ký tài khoản mới</div>
          <div class="flex forget-pass">Quên mật khẩu?</div>
          <div class="flex exit">Thoát</div>
        </div>
      </div>
    </div>
  </div>
</body>
<script type="text/javascript">
  $(document).ready(function() {
    if (app.getLocal("username")) {
      $("#username").val(app.getLocal("username"));
    }
    if (app.getLocal("username")) {
      $("#password").val(app.getLocal("password"));
    }
    $("#login-btn").click(async function() {
      try {
        var data = {
          username: $("#username").val(),
          password: $("#password").val()
        }
        var login = await app.post("/login", data);
        app.setLocal("username", data.username);
        app.setLocal("password", data.password);
        console.log(data);
      } catch (e) {

      }
    });
    var ipc = null;
    if (window.electron) {
      ipc = window.electron;
    }
    $(".exit").click(() => {
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