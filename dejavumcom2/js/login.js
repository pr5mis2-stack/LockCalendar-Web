    var is_login_ing = false;

    $(document).ready(function () {

    	$(".i_label").click(function () {
    		hideIdLabel();
		});

    	$(".i_label2").click(function () {
    		hidePwLabel();
		});

    	$("#user_email").focus(function () {
    		$(".i_label").hide();
    	});

    	$("#user_email").blur(function () {
    		toggleIdLabel();
    	});
    	
    	$("#user_passwd").focus(function () {
    		$(".i_label2").hide();
    	});

    	$("#user_passwd").blur(function () {
    		togglePwLabel();
    	});
    	
    });

    /**
     * login id label toggle
     */
    function toggleIdLabel() {
		if ($("#user_email").val() == "")
			$(".i_label").show();
		else
			$(".i_label").hide();
    }

    /**
     * login id label hide
     */
    function hideIdLabel() {
		$(".i_label").hide();
		$("#user_email").focus()
	}
    
    /**
     * login pw label toggle
     */
    function togglePwLabel() {
		if ($("#user_passwd").val() == "")
			$(".i_label2").show();
		else
			$(".i_label2").hide();
    }

    /**
     * login pw label hide
     */
    function hidePwLabel() {
		$(".i_label2").hide();
		$("#user_passwd").focus()
    }
    
    /**
     * login post
     */
    function logIn() {
        var user_email = $("#user_email").val().trim();
        var user_passwd = $("#user_passwd").val().trim();
        var ret_url = $("#ret_url").val();
        if (ret_url == "")
            ret_url = "/maker/main.php";

        if (is_login_ing) {
            alert("로그인 진행중 입니다.");
        }

        if (user_email.length == 0 || user_passwd.length == 0 || user_email == "아이디" || user_passwd == "비밀번호") {
            alert("아이디와 비밀번호를 입력해주세요.");
        }

        var goUrl = "/member/login.php";
        var param = "user_email=" + user_email + "&user_passwd=" + user_passwd;

        is_login_ing = true;

        $.ajax({
            type: 'post'
                      , async: true
                      , url: goUrl
                      , data: param
                      , beforeSend: function () { }
                      , success: function (data) {
                          is_login_ing = false;

                          var result = data.trim();

                          if (result == "100")
                              location.href = ret_url;
                          else if (result == "200")
                              alert('로그인 정보가 없습니다.');
                          else if (result == "300")
                              alert('정보가 일치하지 않습니다.다시 확인해 주세요.');
                          else
                              alert('로그인중 오류가 발생되었습니다.');
                      }
                      , error: function (data, status, err) { }
                      , complete: function () { }
        });
    }